# Stage 1: Build assets (Vite/NPM)
FROM node:20-alpine AS assets
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# Stage 2: Install PHP dependencies
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --ignore-platform-req=php

# Stage 3: Final runtime image
FROM php:8.2-apache

# Install system dependencies & PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql bcmath gd zip

# Enable Apache mod_rewrite for Laravel
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy application code
COPY . .
# Copy built assets from Stage 1
COPY --from=assets /app/public/build ./public/build
# Copy vendors from Stage 2
COPY --from=vendor /app/vendor ./vendor

# Install composer in final stage to run dump-autoload
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set permissions for Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Set Apache Document Root to /public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's#\/var\/www\/html#${APACHE_DOCUMENT_ROOT}#g' /etc/apache2/sites-available/000-default.conf
RUN sed -ri -e 's#\/var\/www\/html#${APACHE_DOCUMENT_ROOT}#g' /etc/apache2/apache2.conf

# Generate autoloader dasar SAJA (--no-scripts) saat build. Ini tidak butuh .env
# atau APP_KEY sama sekali, jadi aman dijalankan tanpa konteks aplikasi penuh.
# Optimisasi penuh (--optimize) dan hook Laravel (package:discover, config:cache,
# dst.) dijalankan oleh docker-entrypoint.sh saat container START, bukan saat
# build — di titik itu .env produksi sudah ter-inject oleh platform deploy.
RUN composer dump-autoload --no-scripts

# Copy & siapkan entrypoint script.
# sed menghapus carriage return (\r) untuk berjaga-jaga kalau file ini
# tersimpan dengan line-ending CRLF (umum terjadi di editor/Git Windows),
# karena #!/bin/sh akan gagal parse kalau ada \r tersisa di shebang line.
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN sed -i 's/\r$//' /usr/local/bin/docker-entrypoint.sh \
    && chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 80

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["apache2-foreground"]
