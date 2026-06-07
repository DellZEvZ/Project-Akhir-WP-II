# PENJELASAN WEBSITE - PROJECT AKHIR (CAREXIS)

## 📋 INFORMASI UMUM

### Nama Aplikasi
**CAREXIS - Sistem Manajemen Toko Online**

### Deskripsi
Aplikasi web berbasis Laravel 12 untuk manajemen toko online yang terintegrasi dengan sistem manajemen pegawai, aset, dan attendance. Aplikasi ini dirancang untuk membantu perusahaan dalam mengelola produk, pegawai, aset perusahaan, serta mencatat kehadiran pegawai secara digital.

### Teknologi yang Digunakan
- **Framework Backend:** Laravel 12 (PHP 8.2+)
- **Frontend:** Tailwind CSS 4.0, Vite
- **Database:** MySQL
- **Authentication:** Laravel Sanctum
- **Additional Libraries:** 
  - SweetAlert (untuk notifikasi)
  - Axios (HTTP client)
  - Chart.js / Recharts (visualisasi data)

---

## 🎯 FITUR UTAMA

### 1. **Manajemen User & Authentikasi**
- ✅ Login & Logout dengan session
- ✅ Role-based Access Control (RBAC)
- ✅ Multi-role system (Super Admin, Admin, Manager, Staff)
- ✅ Permission management untuk setiap role
- ✅ User profile management
- ✅ Two-factor authentication (2FA)
- ✅ Account locking setelah failed login attempts
- ✅ Quick login feature (untuk testing)
- ✅ Activity logging untuk audit trail

### 2. **Manajemen Produk**
- ✅ CRUD (Create, Read, Update, Delete) Produk
- ✅ Multi-foto produk (gallery)
- ✅ Kategori produk
- ✅ Filter & search produk
- ✅ Export/cetak laporan produk
- ✅ Stok management
- ✅ Status produk (aktif/nonaktif)

### 3. **Manajemen Pegawai**
- ✅ CRUD Data Pegawai
- ✅ Informasi lengkap pegawai:
  - Data pribadi (nama, email, no HP, alamat)
  - Data pekerjaan (jabatan, departemen, status)
  - Data keuangan (gaji pokok)
  - Tanggal masuk & tanggal lahir
- ✅ Status pegawai (Aktif, Cuti, Resign)
- ✅ Upload foto pegawai
- ✅ Statistik pegawai
- ✅ Laporan pegawai
- ✅ Link ke user account (untuk akses login)

### 4. **Manajemen Aset**
- ✅ CRUD Aset Perusahaan
- ✅ Informasi detail aset:
  - Nama, kode, kategori
  - Tanggal pembelian & nilai
  - Status (Baik, Rusak, Maintenance, Dijual)
  - Lokasi penyimpanan
- ✅ Upload gambar aset
- ✅ Maintenance tracking
- ✅ Depresiasi otomatis
- ✅ Statistik & laporan aset
- ✅ Filter berdasarkan status & kategori

### 5. **Sistem Absensi (Attendance)**
- ✅ Check-in & Check-out manual
- ✅ Riwayat kehadiran
- ✅ Admin panel untuk kelola attendance
- ✅ Approve/reject attendance
- ✅ Export laporan kehadiran
- ✅ Tracking jam kerja
- ✅ Integrasi dengan data pegawai

### 6. **Sistem Setting & Konfigurasi**
- ✅ Pengaturan sistem aplikasi
- ✅ Backup & restore database
- ✅ Upload backup file
- ✅ Download backup
- ✅ Activity log viewer
- ✅ Manajemen akun admin
- ✅ Halaman bantuan

### 7. **Dashboard & Reporting**
- ✅ Dashboard beranda dengan statistik
- ✅ Grafik & visualisasi data
- ✅ Quick actions
- ✅ Recent activities
- ✅ Laporan PDF (produk, pegawai, aset)
- ✅ Filter & export data

---

## 📊 STRUKTUR DATABASE

### Tabel Utama:

#### 1. **users**
- Menyimpan data user/pengguna aplikasi
- Fields: nama, email, password, role, status, hp, foto
- Security: failed_login_attempts, account_locked_until, two_factor_enabled
- Relasi: One-to-Many dengan roles, One-to-One dengan pegawai

#### 2. **roles**
- Menyimpan data role/peran (Super Admin, Admin, Manager, Staff)
- Fields: name, description, level
- Relasi: Many-to-Many dengan users dan permissions

#### 3. **permissions**
- Menyimpan hak akses (create_user, edit_product, view_report, dll)
- Fields: name, description, module
- Relasi: Many-to-Many dengan roles

#### 4. **kategori**
- Menyimpan kategori produk
- Fields: nama_kategori, user_id

#### 5. **produk**
- Menyimpan data produk
- Fields: nama_produk, harga, stok, kategori_id, status, deskripsi
- Relasi: BelongsTo kategori, HasMany foto_produk

#### 6. **foto_produk**
- Menyimpan multiple foto untuk setiap produk
- Fields: produk_id, foto_path

#### 7. **pegawais**
- Menyimpan data pegawai
- Fields: nama, email, no_hp, alamat, jabatan, departemen, status_pegawai, tanggal_masuk, tanggal_lahir, jenis_kelamin, foto, gaji_pokok, user_id
- Relasi: BelongsTo user

#### 8. **asets**
- Menyimpan data aset perusahaan
- Fields: nama_aset, kode_aset, kategori, tanggal_pembelian, nilai_pembelian, status_aset, lokasi, gambar

#### 9. **pegawai_attendance_logs**
- Menyimpan log kehadiran pegawai
- Fields: pegawai_id, check_in, check_out, status, notes, approved_by

#### 10. **activity_logs**
- Menyimpan log aktivitas user untuk audit
- Fields: user_id, action, model, model_id, description, ip_address, user_agent

#### 11. **settings**
- Menyimpan konfigurasi aplikasi
- Fields: key, value, type, group

---

## 🔐 SISTEM ROLE & PERMISSION

### Role Hierarchy:
1. **Super Admin** (Level 1) - Full Access
2. **Admin** (Level 2) - Hampir semua akses kecuali system settings
3. **Manager** (Level 3) - Akses kelola produk, pegawai, attendance
4. **Staff** (Level 4) - Akses terbatas (view data, self attendance)

### Permission Modules:
- **User Management:** create_user, edit_user, delete_user, view_user
- **Product Management:** create_product, edit_product, delete_product, view_product
- **Employee Management:** create_employee, edit_employee, delete_employee, view_employee
- **Asset Management:** create_asset, edit_asset, delete_asset, view_asset
- **Attendance:** checkin, checkout, approve_attendance, view_attendance
- **Reports:** view_reports, export_reports
- **Settings:** manage_settings, backup_restore

---

## 🗂️ STRUKTUR FOLDER

```
Project Akhir/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── BerandaController.php
│   │   │   ├── LoginController.php
│   │   │   ├── UserController.php
│   │   │   ├── ProdukController.php
│   │   │   ├── KategoriController.php
│   │   │   ├── PegawaiController.php
│   │   │   ├── AsetController.php
│   │   │   ├── AttendanceController.php
│   │   │   ├── SettingController.php
│   │   │   ├── ProfilController.php
│   │   │   ├── BackupController.php
│   │   │   └── QuickLoginController.php
│   │   └── Middleware/
│   │
│   ├── Models/
│   │   ├── User.php
│   │   ├── Role.php
│   │   ├── Permission.php
│   │   ├── Produk.php
│   │   ├── Kategori.php
│   │   ├── FotoProduk.php
│   │   ├── Pegawai.php
│   │   ├── Aset.php
│   │   ├── PegawaiAttendanceLog.php
│   │   ├── ActivityLog.php
│   │   └── Setting.php
│   │
│   ├── Helpers/
│   │   └── ImageHelper.php
│   │
│   └── Traits/
│
├── database/
│   ├── migrations/
│   └── seeders/
│
├── resources/
│   ├── views/
│   │   └── backend/
│   │       ├── v_beranda/
│   │       ├── v_login/
│   │       ├── v_user/
│   │       ├── v_produk/
│   │       ├── v_kategori/
│   │       ├── v_pegawai/
│   │       ├── v_aset/
│   │       ├── v_attendance/
│   │       ├── v_setting/
│   │       ├── v_profil/
│   │       └── v_layouts/
│   │
│   └── js/
│
├── routes/
│   ├── web.php
│   └── console.php
│
├── public/
│   ├── assets/
│   ├── images/
│   └── uploads/
│
└── storage/
    ├── app/
    ├── framework/
    └── logs/
```

---

## 🚀 CARA INSTALASI

### Prasyarat:
- PHP 8.2 atau lebih tinggi
- MySQL 5.7 atau lebih tinggi
- Composer
- Node.js & NPM
- Laragon/XAMPP/server lokal lainnya

### Langkah Instalasi:

#### 1. Clone atau Copy Project
```bash
# Letakkan di C:\laragon\www\Project Akhir
```

#### 2. Install Dependencies
```bash
# PHP Dependencies
composer install

# Node Dependencies
npm install
```

#### 3. Setup Environment
```bash
# File .env sudah ada, pastikan konfigurasi database sudah benar:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_tokoonline
DB_USERNAME=root
DB_PASSWORD=
```

#### 4. Generate Application Key
```bash
php artisan key:generate
```

#### 5. Import Database
```bash
# Buat database baru bernama 'db_tokoonline'
# Import file: database_backup.sql
mysql -u root -p db_tokoonline < database_backup.sql
```

#### 6. Storage Link
```bash
php artisan storage:link
```

#### 7. Build Assets
```bash
npm run build
# atau untuk development
npm run dev
```

#### 8. Jalankan Server
```bash
php artisan serve
# Akses: http://localhost:8000
```

---

## 👤 DEFAULT LOGIN

Setelah import database, gunakan akun berikut untuk login:

### Super Admin
- **Email:** admin@example.com
- **Password:** password

### Testing Accounts
Gunakan fitur **Quick Login** di halaman login untuk testing berbagai role.

---

## 🔧 KONFIGURASI TAMBAHAN

### Queue Worker (Optional)
Jika menggunakan queue:
```bash
php artisan queue:work
```

### Scheduler (Optional)
Tambahkan ke crontab:
```bash
* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
```

### Development Mode
```bash
npm run dev
php artisan serve
php artisan queue:listen
```

---

## 📝 FITUR BACKUP & RESTORE

### Manual Backup
1. Login sebagai Super Admin
2. Buka menu **Setting** → **Backup & Restore**
3. Klik tombol **Create Backup**
4. Download file backup (.tar.gz)

### Restore Backup
1. Upload file backup
2. Klik tombol **Restore**
3. Konfirmasi restore
4. System akan otomatis restore database dan files

### Auto Backup
- Backup otomatis dapat dikonfigurasi via scheduler
- File backup disimpan di `storage/app/backups/`

---

## 🎨 CUSTOMIZATION

### Mengubah Logo & Branding
- Edit file: `resources/views/backend/v_layouts/master.blade.php`
- Ganti logo di folder: `public/assets/images/`

### Mengubah Warna Tema
- Edit file: `resources/css/app.css`
- Atau gunakan Tailwind classes

### Menambah Role Baru
1. Buat role di database atau via seeder
2. Assign permissions
3. Update middleware jika perlu

---

## 🐛 TROUBLESHOOTING

### Error: Class not found
```bash
composer dump-autoload
```

### Error: Storage link
```bash
php artisan storage:link
```

### Error: Permission denied (Linux)
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### Clear Cache
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

---

## 📚 DOKUMENTASI TAMBAHAN

### API Endpoints
Lihat file: `routes/web.php` untuk semua endpoint yang tersedia

### Database Schema
Lihat folder: `database/migrations/` untuk struktur tabel lengkap

### Helper Functions
Lihat file: `app/Helpers/ImageHelper.php` untuk fungsi helper

---

## 🔒 KEAMANAN

### Fitur Keamanan:
- ✅ Password hashing dengan bcrypt
- ✅ CSRF protection
- ✅ SQL injection prevention (Eloquent ORM)
- ✅ XSS protection
- ✅ Role-based access control
- ✅ Failed login attempts tracking
- ✅ Account locking
- ✅ Activity logging
- ✅ Two-factor authentication

### Best Practices:
- Ganti default password setelah instalasi
- Backup database secara berkala
- Update dependencies secara rutin
- Monitor activity logs
- Gunakan HTTPS di production

---

## 📞 SUPPORT & CONTACT

Untuk pertanyaan, bug report, atau feature request:
- **Developer:** [Nama Developer]
- **Email:** [Email Contact]
- **Repository:** [Link Repository jika ada]

---

## 📄 LICENSE

Project ini dibuat untuk keperluan tugas akhir/project akhir.

---

## 🎓 CREDITS

- Laravel Framework - https://laravel.com
- Tailwind CSS - https://tailwindcss.com
- SweetAlert - https://sweetalert2.github.io
- dan berbagai open source libraries lainnya

---

**Versi:** 1.0.0
**Tanggal Update:** 17 Januari 2026
**Status:** Production Ready ✅

---

## 📈 ROADMAP PENGEMBANGAN

### Future Features:
- [ ] Multi-language support
- [ ] Export to Excel/PDF untuk semua laporan
- [ ] Dashboard analytics lebih advanced
- [ ] Mobile responsive improvement
- [ ] Real-time notifications
- [ ] Email notifications
- [ ] API REST untuk mobile app
- [ ] Point of Sale (POS) integration
- [ ] Inventory management
- [ ] Customer management
- [ ] Payroll system integration

---

**Selamat menggunakan CAREXIS!** 🚀
