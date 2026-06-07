# DOKUMENTASI TEKNIS - PROJECT AKHIR (CAREXIS)

## 🏗️ ARSITEKTUR SISTEM

### Design Pattern
Aplikasi ini menggunakan **MVC (Model-View-Controller)** pattern dari Laravel dengan tambahan:
- **Repository Pattern** untuk data access layer
- **Service Layer** untuk business logic
- **Observer Pattern** untuk activity logging
- **Middleware** untuk authentication & authorization

### Flow Diagram

```
User Request
    ↓
Route (web.php)
    ↓
Middleware (Auth, Permission)
    ↓
Controller
    ↓
Model/Eloquent ORM
    ↓
Database
    ↓
View (Blade Template)
    ↓
Response to User
```

---

## 🔌 API & ENDPOINTS

### Authentication Endpoints

| Method | Endpoint | Controller@Method | Middleware | Keterangan |
|--------|----------|-------------------|------------|------------|
| GET | `/backend/login` | LoginController@loginBackend | - | Tampil form login |
| POST | `/backend/login` | LoginController@authenticateBackend | - | Proses login |
| POST | `/backend/logout` | LoginController@logoutBackend | auth | Logout user |
| POST | `/backend/quick-login/{userId}` | QuickLoginController@loginAs | - | Quick login (testing) |

### User Management Endpoints

| Method | Endpoint | Controller@Method | Middleware | Permission Required |
|--------|----------|-------------------|------------|---------------------|
| GET | `/backend/user` | UserController@index | auth | view_user |
| GET | `/backend/user/create` | UserController@create | auth | create_user |
| POST | `/backend/user` | UserController@store | auth | create_user |
| GET | `/backend/user/{id}/edit` | UserController@edit | auth | edit_user |
| PUT | `/backend/user/{id}` | UserController@update | auth | edit_user |
| DELETE | `/backend/user/{id}` | UserController@destroy | auth | delete_user |

### Product Management Endpoints

| Method | Endpoint | Controller@Method | Middleware | Permission Required |
|--------|----------|-------------------|------------|---------------------|
| GET | `/backend/produk` | ProdukController@index | auth | view_product |
| GET | `/backend/produk/create` | ProdukController@create | auth | create_product |
| POST | `/backend/produk` | ProdukController@store | auth | create_product |
| GET | `/backend/produk/{id}/edit` | ProdukController@edit | auth | edit_product |
| PUT | `/backend/produk/{id}` | ProdukController@update | auth | edit_product |
| DELETE | `/backend/produk/{id}` | ProdukController@destroy | auth | delete_product |
| POST | `/foto-produk/store` | ProdukController@storeFoto | auth | edit_product |
| DELETE | `/foto-produk/{id}` | ProdukController@destroyFoto | auth | edit_product |

### Employee (Pegawai) Endpoints

| Method | Endpoint | Controller@Method | Middleware | Permission Required |
|--------|----------|-------------------|------------|---------------------|
| GET | `/backend/pegawai` | PegawaiController@index | auth | view_employee |
| GET | `/backend/pegawai/create` | PegawaiController@create | auth | create_employee |
| POST | `/backend/pegawai` | PegawaiController@store | auth | create_employee |
| GET | `/backend/pegawai/{id}/edit` | PegawaiController@edit | auth | edit_employee |
| PUT | `/backend/pegawai/{id}` | PegawaiController@update | auth | edit_employee |
| DELETE | `/backend/pegawai/{id}` | PegawaiController@destroy | auth | delete_employee |
| GET | `/backend/pegawai-statistik` | PegawaiController@statistik | auth | view_employee |

### Asset Management Endpoints

| Method | Endpoint | Controller@Method | Middleware | Permission Required |
|--------|----------|-------------------|------------|---------------------|
| GET | `/backend/aset` | AsetController@index | auth | view_asset |
| GET | `/backend/aset/create` | AsetController@create | auth | create_asset |
| POST | `/backend/aset` | AsetController@store | auth | create_asset |
| GET | `/backend/aset/{id}/edit` | AsetController@edit | auth | edit_asset |
| PUT | `/backend/aset/{id}` | AsetController@update | auth | edit_asset |
| DELETE | `/backend/aset/{id}` | AsetController@destroy | auth | delete_asset |
| POST | `/backend/aset/{id}/maintenance` | AsetController@updateMaintenance | auth | edit_asset |
| GET | `/backend/aset-statistik` | AsetController@statistik | auth | view_asset |

### Attendance Endpoints

| Method | Endpoint | Controller@Method | Middleware | Permission Required |
|--------|----------|-------------------|------------|---------------------|
| GET | `/backend/attendance` | AttendanceController@index | auth | - |
| POST | `/backend/attendance/checkin` | AttendanceController@checkIn | auth | - |
| POST | `/backend/attendance/checkout` | AttendanceController@checkOut | auth | - |
| GET | `/backend/attendance/history` | AttendanceController@history | auth | - |
| GET | `/backend/attendance/export` | AttendanceController@export | auth | view_reports |
| GET | `/backend/attendance/admin` | AttendanceController@adminIndex | auth | approve_attendance |
| PUT | `/backend/attendance/admin/{id}` | AttendanceController@update | auth | approve_attendance |
| POST | `/backend/attendance/admin/{id}/approve` | AttendanceController@approve | auth | approve_attendance |
| DELETE | `/backend/attendance/admin/{id}` | AttendanceController@destroy | auth | delete_attendance |

### Reports Endpoints

| Method | Endpoint | Controller@Method | Middleware | Permission Required |
|--------|----------|-------------------|------------|---------------------|
| GET | `/backend/laporan/formuser` | UserController@formUser | auth | view_reports |
| POST | `/backend/laporan/cetakuser` | UserController@cetakUser | auth | export_reports |
| GET | `/backend/laporan/formproduk` | ProdukController@formProduk | auth | view_reports |
| POST | `/backend/laporan/cetakproduk` | ProdukController@cetakProduk | auth | export_reports |
| GET | `/backend/laporan/formpegawai` | PegawaiController@formPegawai | auth | view_reports |
| POST | `/backend/laporan/cetakpegawai` | PegawaiController@cetakPegawai | auth | export_reports |
| GET | `/backend/laporan/formaset` | AsetController@formAset | auth | view_reports |
| POST | `/backend/laporan/cetakaset` | AsetController@cetakAset | auth | export_reports |

### Settings Endpoints

| Method | Endpoint | Controller@Method | Middleware | Permission Required |
|--------|----------|-------------------|------------|---------------------|
| GET | `/backend/setting/sistem` | SettingController@sistem | auth | manage_settings |
| POST | `/backend/setting/sistem` | SettingController@updateSistem | auth | manage_settings |
| GET | `/backend/setting/backup` | BackupController@index | auth | backup_restore |
| POST | `/backend/setting/backup/create` | BackupController@create | auth | backup_restore |
| GET | `/backend/setting/backup/download/{file}` | BackupController@download | auth | backup_restore |
| DELETE | `/backend/setting/backup/delete/{file}` | BackupController@destroy | auth | backup_restore |
| POST | `/backend/setting/backup/restore/{file}` | BackupController@restore | auth | backup_restore |
| GET | `/backend/setting/log` | SettingController@log | auth | view_logs |

---

## 💾 DATABASE SCHEMA DETAIL

### Table: users
```sql
CREATE TABLE users (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) DEFAULT 'staff',
    status BOOLEAN DEFAULT 1,
    hp VARCHAR(20),
    foto VARCHAR(255),
    last_login TIMESTAMP NULL,
    failed_login_attempts INT DEFAULT 0,
    account_locked_until TIMESTAMP NULL,
    two_factor_enabled BOOLEAN DEFAULT 0,
    two_factor_secret VARCHAR(255),
    remember_token VARCHAR(100),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### Table: roles
```sql
CREATE TABLE roles (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) UNIQUE NOT NULL,
    description TEXT,
    level INT NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### Table: permissions
```sql
CREATE TABLE permissions (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) UNIQUE NOT NULL,
    description TEXT,
    module VARCHAR(50) NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### Table: role_permissions
```sql
CREATE TABLE role_permissions (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    role_id BIGINT UNSIGNED,
    permission_id BIGINT UNSIGNED,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE,
    FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE
);
```

### Table: user_roles
```sql
CREATE TABLE user_roles (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT UNSIGNED,
    role_id BIGINT UNSIGNED,
    assigned_by BIGINT UNSIGNED NULL,
    assigned_at TIMESTAMP,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE,
    FOREIGN KEY (assigned_by) REFERENCES users(id) ON DELETE SET NULL
);
```

### Table: kategori
```sql
CREATE TABLE kategori (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    nama_kategori VARCHAR(255) NOT NULL,
    user_id BIGINT UNSIGNED,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);
```

### Table: produk
```sql
CREATE TABLE produk (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    nama_produk VARCHAR(255) NOT NULL,
    kategori_id BIGINT UNSIGNED,
    user_id BIGINT UNSIGNED,
    harga DECIMAL(15,2) NOT NULL,
    stok INT DEFAULT 0,
    status VARCHAR(20) DEFAULT 'aktif',
    deskripsi TEXT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (kategori_id) REFERENCES kategori(id) ON DELETE SET NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);
```

### Table: foto_produk
```sql
CREATE TABLE foto_produk (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    produk_id BIGINT UNSIGNED NOT NULL,
    foto VARCHAR(255) NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (produk_id) REFERENCES produk(id) ON DELETE CASCADE
);
```

### Table: pegawais
```sql
CREATE TABLE pegawais (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    no_hp VARCHAR(20),
    alamat TEXT,
    jabatan VARCHAR(100),
    departemen VARCHAR(100),
    status_pegawai ENUM('aktif','cuti','resign') DEFAULT 'aktif',
    tanggal_masuk DATE,
    tanggal_lahir DATE,
    jenis_kelamin ENUM('L','P'),
    foto VARCHAR(255),
    user_id BIGINT UNSIGNED NULL,
    gaji_pokok DECIMAL(15,2),
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);
```

### Table: asets
```sql
CREATE TABLE asets (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    nama_aset VARCHAR(255) NOT NULL,
    kode_aset VARCHAR(100) UNIQUE,
    kategori VARCHAR(100),
    tanggal_pembelian DATE,
    nilai_pembelian DECIMAL(15,2),
    status_aset ENUM('baik','rusak','maintenance','dijual') DEFAULT 'baik',
    lokasi VARCHAR(255),
    gambar VARCHAR(255),
    deskripsi TEXT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### Table: pegawai_attendance_logs
```sql
CREATE TABLE pegawai_attendance_logs (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    pegawai_id BIGINT UNSIGNED NOT NULL,
    check_in TIMESTAMP NOT NULL,
    check_out TIMESTAMP NULL,
    status VARCHAR(50) DEFAULT 'hadir',
    notes TEXT,
    approved_by BIGINT UNSIGNED NULL,
    approved_at TIMESTAMP NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (pegawai_id) REFERENCES pegawais(id) ON DELETE CASCADE,
    FOREIGN KEY (approved_by) REFERENCES users(id) ON DELETE SET NULL
);
```

### Table: activity_logs
```sql
CREATE TABLE activity_logs (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT UNSIGNED NULL,
    action VARCHAR(100) NOT NULL,
    model VARCHAR(100),
    model_id BIGINT UNSIGNED,
    description TEXT,
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);
```

### Table: settings
```sql
CREATE TABLE settings (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    key VARCHAR(100) UNIQUE NOT NULL,
    value TEXT,
    type VARCHAR(50) DEFAULT 'string',
    group VARCHAR(50) DEFAULT 'general',
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

---

## 🔐 AUTHENTICATION & AUTHORIZATION

### Login Flow
```php
1. User mengakses /backend/login
2. User memasukkan email & password
3. LoginController@authenticateBackend validates credentials
4. Cek failed_login_attempts < 5
5. Cek account_locked_until (jika ada)
6. Jika valid:
   - Session created
   - Update last_login
   - Reset failed_login_attempts
   - Redirect ke /backend/beranda
7. Jika invalid:
   - Increment failed_login_attempts
   - Jika attempts >= 5, set account_locked_until (30 menit)
   - Return error message
```

### Permission Check Flow
```php
1. User mengakses protected route
2. Middleware 'auth' cek apakah user sudah login
3. Controller cek permission dengan method:
   - $user->hasPermission('permission_name')
4. Jika tidak ada permission:
   - Return 403 Forbidden
   - Atau redirect dengan error message
5. Jika ada permission:
   - Lanjutkan ke controller method
```

### Role Assignment
```php
// Assign role ke user
$user->assignRole('admin', $assignedBy);

// Assign multiple roles
$user->syncRoles(['admin', 'manager'], $assignedBy);

// Remove role
$user->removeRole('staff');

// Check role
if ($user->hasRole('admin')) {
    // User adalah admin
}

// Check multiple roles
if ($user->hasAnyRole(['admin', 'manager'])) {
    // User adalah admin atau manager
}
```

---

## 📝 ACTIVITY LOGGING

### Cara Kerja Activity Log
Setiap aksi penting di aplikasi akan dicatat ke tabel `activity_logs`:

```php
ActivityLog::create([
    'user_id' => auth()->id(),
    'action' => 'create',
    'model' => 'Produk',
    'model_id' => $produk->id,
    'description' => 'Menambahkan produk: ' . $produk->nama_produk,
    'ip_address' => request()->ip(),
    'user_agent' => request()->userAgent(),
]);
```

### Actions yang Dicatat:
- create (tambah data)
- update (edit data)
- delete (hapus data)
- login (user login)
- logout (user logout)
- failed_login (login gagal)
- export (export data)
- backup (backup database)
- restore (restore database)

---

## 🎨 FRONTEND STRUCTURE

### Blade Layout Hierarchy
```
resources/views/backend/v_layouts/master.blade.php
    ├── Header
    ├── Sidebar
    ├── Content (@yield('content'))
    └── Footer
```

### View Naming Convention
```
v_[module]/
    ├── index.blade.php     (List/Table view)
    ├── create.blade.php    (Form tambah)
    ├── edit.blade.php      (Form edit)
    ├── show.blade.php      (Detail view)
    └── form_laporan.blade.php (Form filter laporan)
```

### JavaScript & CSS Assets
```
resources/
    ├── js/
    │   └── app.js (Main JS file, compiled by Vite)
    └── css/
        └── app.css (Main CSS file with Tailwind)
```

### Vite Build Process
```javascript
// vite.config.js
export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
```

---

## 🛠️ HELPER FUNCTIONS

### ImageHelper.php
```php
// Upload & resize image
uploadAndResizeImage($file, $path, $maxWidth, $maxHeight);

// Delete image
deleteImage($imagePath);

// Get image URL
getImageUrl($imagePath);

// Generate thumbnail
generateThumbnail($imagePath, $width, $height);
```

### Custom Blade Directives
```php
// Check permission in blade
@can('edit_product')
    <button>Edit</button>
@endcan

// Check role in blade
@role('admin')
    <a href="/admin/settings">Settings</a>
@endrole

// Format currency
{{ formatRupiah($harga) }}

// Format date
{{ formatTanggal($tanggal) }}
```

---

## 🧪 TESTING

### Unit Testing
```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter=UserTest
```

### Feature Testing
```php
// Test login
public function test_user_can_login()
{
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password'),
    ]);

    $response = $this->post('/backend/login', [
        'email' => 'test@example.com',
        'password' => 'password',
    ]);

    $response->assertRedirect('/backend/beranda');
    $this->assertAuthenticatedAs($user);
}
```

---

## 🚀 DEPLOYMENT

### Production Checklist
- [ ] Set `APP_ENV=production` di `.env`
- [ ] Set `APP_DEBUG=false` di `.env`
- [ ] Generate production app key
- [ ] Run `php artisan config:cache`
- [ ] Run `php artisan route:cache`
- [ ] Run `php artisan view:cache`
- [ ] Run `npm run build`
- [ ] Set proper file permissions (755 for directories, 644 for files)
- [ ] Configure web server (Nginx/Apache)
- [ ] Enable HTTPS
- [ ] Setup backup scheduler
- [ ] Configure email (jika digunakan)
- [ ] Setup monitoring & logging

### Nginx Configuration Example
```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /path/to/project/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

---

## 📊 PERFORMANCE OPTIMIZATION

### Database Optimization
```php
// Use eager loading to prevent N+1 queries
$products = Produk::with(['kategori', 'user', 'gambar'])->get();

// Use pagination
$products = Produk::paginate(20);

// Use indexes on frequently queried columns
// Add indexes in migration:
$table->index('kategori_id');
$table->index('status');
```

### Caching Strategy
```php
// Cache configuration
config(['cache.default' => 'database']);

// Cache data
Cache::remember('products', 3600, function () {
    return Produk::all();
});

// Clear specific cache
Cache::forget('products');

// Clear all cache
Cache::flush();
```

### Query Optimization
```php
// Select only needed columns
Produk::select('id', 'nama_produk', 'harga')->get();

// Use chunk for large datasets
Produk::chunk(100, function ($products) {
    foreach ($products as $product) {
        // Process product
    }
});
```

---

## 🔍 DEBUGGING

### Enable Query Log
```php
// In controller
DB::enableQueryLog();
// ... your queries
dd(DB::getQueryLog());
```

### Debug Bar (Development)
```bash
composer require barryvdh/laravel-debugbar --dev
```

### Log Debugging
```php
// Write to log file
Log::info('User login', ['user_id' => $user->id]);
Log::error('Failed to save product', ['error' => $e->getMessage()]);

// View logs
tail -f storage/logs/laravel.log
```

---

## 📦 PACKAGE DEPENDENCIES

### PHP Dependencies (composer.json)
```json
{
    "require": {
        "php": "^8.2",
        "laravel/framework": "^12.0",
        "laravel/sanctum": "^4.2",
        "laravel/tinker": "^2.10.1"
    }
}
```

### JavaScript Dependencies (package.json)
```json
{
    "devDependencies": {
        "@tailwindcss/vite": "^4.0.0",
        "axios": "^1.11.0",
        "laravel-vite-plugin": "^2.0.0",
        "tailwindcss": "^4.0.0",
        "vite": "^7.0.7"
    }
}
```

---

## 🐛 COMMON ERRORS & SOLUTIONS

### Error: Class 'App\Models\XXX' not found
**Solution:**
```bash
composer dump-autoload
```

### Error: SQLSTATE[HY000] [1045] Access denied
**Solution:**
Check database credentials in `.env` file

### Error: The stream or file "storage/logs/laravel.log" could not be opened
**Solution:**
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### Error: Mix manifest not found
**Solution:**
```bash
npm install
npm run build
```

---

**Last Updated:** 17 Januari 2026
**Version:** 1.0.0
