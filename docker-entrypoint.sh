#!/bin/sh
set -e

# Entrypoint ini berjalan setiap kali container start (bukan saat image build),
# di titik ini .env / environment variables produksi sudah ter-inject oleh
# platform deploy, sehingga aman menjalankan command yang butuh APP_KEY & config.

cd /var/www/html

# Pastikan direktori runtime storage ada SEBELUM command apa pun yang meng-compile
# view / meng-cache config. Subfolder framework di-exclude oleh .dockerignore
# (tidak ikut ke image) dan volume storage yang kosong bisa menutupinya, sehingga
# Blade gagal dengan "Please provide a valid cache path". Dibuat ulang di sini
# (entrypoint berjalan setelah volume ter-mount) agar selalu tersedia & writable.
mkdir -p \
    storage/framework/views \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/logs \
    bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Pastikan APP_KEY tersedia, baik lewat environment variable container
# maupun lewat file .env (kalau platform deploy memakai cara itu).
# Kalau dua-duanya kosong, generate satu secara otomatis supaya container
# tidak crash -- tapi sebaiknya tetap set APP_KEY secara eksplisit di
# environment variable platform deploy agar konsisten antar restart/scaling.
if [ -z "$APP_KEY" ]; then
    if [ -f .env ] && grep -q "^APP_KEY=.\+" .env; then
        : # APP_KEY sudah ada di file .env, tidak perlu generate
    else
        echo "APP_KEY belum diset, generate otomatis..."
        php artisan key:generate --force
    fi
fi

# Buat symlink public/storage -> storage/app/public agar file yang diunggah
# (gambar barber/layanan/produk/galeri) dapat diakses lewat URL /storage/*.
# Idempoten: hanya dibuat jika symlink belum ada, supaya aman di-restart.
if [ ! -L public/storage ]; then
    php artisan storage:link
fi

# Daftarkan ulang package discovery & optimisasi autoloader dengan konteks
# environment yang sudah lengkap (ini yang gagal kalau dijalankan saat build).
composer dump-autoload --optimize --no-interaction

# Cache config, route, dan view untuk performa produksi.
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Tunggu database siap sebelum migrate (maksimal ~30 detik).
# Berguna untuk orkestrasi (docker-compose/K8s) di mana container app bisa
# start lebih cepat daripada container/service database-nya.
echo "Menunggu koneksi database..."
DB_READY=0
for i in $(seq 1 15); do
    if php -r '$dsn="mysql:host=".getenv("DB_HOST").";port=".(getenv("DB_PORT")?:"3306").";dbname=".getenv("DB_DATABASE"); new PDO($dsn, getenv("DB_USERNAME"), getenv("DB_PASSWORD"));' > /dev/null 2>&1; then
        DB_READY=1
        break
    fi
    echo "Database belum siap, mencoba lagi ($i/15)..."
    sleep 2
done

if [ "$DB_READY" -eq 1 ]; then
    echo "Database siap, menjalankan migration..."
    php artisan migrate --force
else
    echo "PERINGATAN: Database tidak dapat dijangkau setelah 30 detik."
    echo "Migration dilewati. Aplikasi tetap dijalankan, jalankan migrate manual jika perlu."
fi

# Lanjutkan ke command utama container (CMD di Dockerfile / docker-compose).
exec "$@"
