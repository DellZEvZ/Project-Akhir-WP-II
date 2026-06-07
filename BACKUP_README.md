# Backup Website - Project Akhir (CAREXIS)

## Informasi Backup

**Tanggal Backup:** 17 Desember 2025

### File Backup Tersedia:

1. **Backup Lite (Rekomendasi)**
   - **Nama File:** `backup_project_akhir_20251217_230125.tar.gz`
   - **Ukuran:** 59 MB
   - **Isi:** Source code + database (tanpa vendor & node_modules)
   - **Kegunaan:** Lebih cepat untuk transfer, ukuran kecil

2. **Backup Complete**
   - **Nama File:** `backup_project_akhir_COMPLETE_20251217_230809.tar.gz`
   - **Ukuran:** 154 MB (17,476 files)
   - **Isi:** Semua file termasuk vendor & node_modules
   - **Kegunaan:** Restore langsung tanpa perlu install dependencies

**Database:** `database_backup.sql` (57 KB)

## Isi Backup

Backup ini mencakup:
- ✅ Semua source code aplikasi Laravel
- ✅ File konfigurasi (.env, .env.example)
- ✅ Database export (database_backup.sql)
- ✅ Folder public (assets, images, uploads)
- ✅ Dokumentasi (file .md)
- ✅ Migrations dan seeders
- ❌ node_modules (dikecualikan - dapat diinstall ulang dengan `npm install`)
- ❌ vendor (dikecualikan - dapat diinstall ulang dengan `composer install`)

## Cara Restore Backup

### 1. Extract Archive

**Untuk Backup Lite:**
```bash
tar -xzf backup_project_akhir_20251217_230125.tar.gz -C /path/to/restore/location
```

**Untuk Backup Complete:**
```bash
tar -xzf backup_project_akhir_COMPLETE_20251217_230809.tar.gz -C /path/to/restore/location
```

### 2. Install Dependencies

**Jika menggunakan Backup Lite:**
```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

**Jika menggunakan Backup Complete:**
```bash
# Dependencies sudah termasuk, skip langkah ini
```

### 3. Konfigurasi Environment

```bash
# Copy file .env (sudah ada di backup)
# Sesuaikan konfigurasi database jika perlu
```

### 4. Restore Database

```bash
# Buat database baru
mysql -u root -p -e "CREATE DATABASE db_tokoonline"

# Import database backup
mysql -u root -p db_tokoonline < database_backup.sql
```

### 5. Set Permissions (Linux/Mac)

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### 6. Generate Application Key (jika diperlukan)

```bash
php artisan key:generate
```

### 7. Build Assets

```bash
npm run build
```

### 8. Clear Cache

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

## Informasi Database

- **Nama Database:** db_tokoonline
- **Host:** 127.0.0.1
- **Port:** 3306
- **Username:** root
- **Password:** (kosong)

## Catatan Penting

1. File `.env` sudah termasuk dalam backup. Pastikan untuk menyesuaikan konfigurasi sesuai environment baru.
2. Folder `node_modules` dan `vendor` tidak disertakan untuk menghemat ukuran backup. Install ulang menggunakan `npm install` dan `composer install`.
3. Pastikan PHP versi 8.x dan MySQL sudah terinstall di server tujuan.
4. Jika menggunakan fitur storage, pastikan symbolic link dibuat dengan: `php artisan storage:link`

## Kontak

Jika ada pertanyaan terkait restore backup, hubungi administrator sistem.
