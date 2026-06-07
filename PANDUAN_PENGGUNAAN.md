# PANDUAN PENGGUNAAN - CAREXIS
## Sistem Manajemen Toko Online

---

## 📱 AKSES APLIKASI

### URL Akses
```
http://localhost:8000/backend/login
```

### Akun Default
**Super Admin:**
- Email: admin@example.com
- Password: password

*Catatan: Segera ganti password setelah login pertama kali*

---

## 🏠 HALAMAN BERANDA (DASHBOARD)

Setelah login, Anda akan masuk ke halaman beranda yang menampilkan:

### 1. Statistik Umum
- **Total User**: Jumlah pengguna terdaftar
- **Total Produk**: Jumlah produk dalam sistem
- **Total Pegawai**: Jumlah pegawai aktif
- **Total Aset**: Jumlah aset perusahaan

### 2. Grafik & Chart
- Grafik penjualan (jika ada)
- Statistik pegawai per departemen
- Status aset perusahaan
- Aktivitas terkini

### 3. Quick Actions
- Tombol cepat untuk tambah produk
- Tombol cepat untuk tambah pegawai
- Tombol cepat untuk check-in attendance

---

## 👥 MANAJEMEN USER

### Melihat Daftar User
1. Klik menu **User Management** di sidebar
2. Akan tampil tabel daftar user dengan informasi:
   - Nama
   - Email
   - Role
   - Status
   - Tanggal dibuat
   - Aksi (Edit/Hapus)

### Menambah User Baru
1. Klik tombol **Tambah User**
2. Isi form:
   - **Nama**: Nama lengkap user
   - **Email**: Email aktif (untuk login)
   - **Password**: Minimal 8 karakter
   - **Konfirmasi Password**: Ulangi password
   - **Role**: Pilih role (Super Admin, Admin, Manager, Staff)
   - **No HP**: Nomor telepon
   - **Status**: Aktif/Nonaktif
   - **Foto**: Upload foto profil (opsional)
3. Klik **Simpan**

### Mengedit User
1. Klik tombol **Edit** pada user yang ingin diedit
2. Ubah data yang diperlukan
3. Klik **Update**

*Catatan: Password hanya perlu diisi jika ingin mengubah password*

### Menghapus User
1. Klik tombol **Hapus** pada user yang ingin dihapus
2. Konfirmasi penghapusan
3. User akan dihapus dari sistem

*Catatan: Tidak bisa menghapus user sendiri yang sedang login*

### Manajemen Role & Permission
**Khusus Super Admin:**

1. Klik tombol **Kelola Permission** pada user
2. Pilih role yang ingin diberikan
3. Centang permission yang diinginkan:
   - **User Management**: create_user, edit_user, delete_user, view_user
   - **Product Management**: create_product, edit_product, delete_product, view_product
   - **Employee Management**: create_employee, edit_employee, delete_employee, view_employee
   - **Asset Management**: create_asset, edit_asset, delete_asset, view_asset
   - **Reports**: view_reports, export_reports
   - **Settings**: manage_settings, backup_restore
4. Klik **Simpan**

---

## 🏷️ MANAJEMEN KATEGORI

### Melihat Daftar Kategori
1. Klik menu **Kategori** di sidebar
2. Akan tampil daftar kategori produk

### Menambah Kategori
1. Klik tombol **Tambah Kategori**
2. Isi nama kategori
3. Klik **Simpan**

### Mengedit/Menghapus Kategori
- Klik tombol **Edit** untuk mengubah
- Klik tombol **Hapus** untuk menghapus

*Catatan: Kategori yang sudah digunakan produk tidak bisa dihapus*

---

## 📦 MANAJEMEN PRODUK

### Melihat Daftar Produk
1. Klik menu **Produk** di sidebar
2. Akan tampil tabel produk dengan informasi:
   - Foto produk
   - Nama produk
   - Kategori
   - Harga
   - Stok
   - Status
   - Aksi

### Fitur Pencarian & Filter
- **Search**: Ketik nama produk di kolom pencarian
- **Filter Kategori**: Pilih kategori dari dropdown
- **Filter Status**: Filter berdasarkan aktif/nonaktif
- **Urutkan**: Klik header kolom untuk sorting

### Menambah Produk Baru
1. Klik tombol **Tambah Produk**
2. Isi form produk:
   - **Nama Produk**: Nama produk yang jelas
   - **Kategori**: Pilih kategori produk
   - **Harga**: Harga jual produk (tanpa titik/koma)
   - **Stok**: Jumlah stok tersedia
   - **Status**: Aktif (dijual) / Nonaktif (tidak dijual)
   - **Deskripsi**: Deskripsi detail produk
   - **Foto**: Upload foto produk (maksimal 5 foto)
3. Klik **Simpan**

### Mengedit Produk
1. Klik tombol **Edit** pada produk
2. Ubah data yang diperlukan
3. Untuk menambah foto:
   - Klik **Tambah Foto**
   - Pilih file foto
   - Upload
4. Untuk menghapus foto:
   - Klik icon **X** pada foto yang ingin dihapus
5. Klik **Update**

### Menghapus Produk
1. Klik tombol **Hapus**
2. Konfirmasi penghapusan
3. Produk dan semua fotonya akan dihapus

### Cetak Laporan Produk
1. Klik menu **Laporan** → **Laporan Produk**
2. Pilih filter:
   - Kategori (semua/spesifik)
   - Status (semua/aktif/nonaktif)
   - Tanggal (dari - sampai)
3. Klik **Cetak PDF**
4. File PDF akan didownload

---

## 👨‍💼 MANAJEMEN PEGAWAI

### Melihat Daftar Pegawai
1. Klik menu **Pegawai** di sidebar
2. Akan tampil tabel pegawai dengan informasi lengkap

### Menambah Pegawai Baru
1. Klik tombol **Tambah Pegawai**
2. Isi form pegawai:
   
   **Data Pribadi:**
   - Nama Lengkap
   - Email
   - No HP
   - Alamat Lengkap
   - Tanggal Lahir
   - Jenis Kelamin (L/P)
   - Foto (upload foto pegawai)
   
   **Data Pekerjaan:**
   - Jabatan (Manager, Supervisor, Staff, dll)
   - Departemen (HRD, Marketing, IT, dll)
   - Status Pegawai (Aktif/Cuti/Resign)
   - Tanggal Masuk
   - Gaji Pokok
   
   **Link User Account (Opsional):**
   - Pilih user jika pegawai ini memiliki akun login
   
3. Klik **Simpan**

### Mengedit Data Pegawai
1. Klik tombol **Edit** pada pegawai
2. Ubah data yang diperlukan
3. Klik **Update**

### Mengubah Status Pegawai
- **Aktif**: Pegawai sedang bekerja
- **Cuti**: Pegawai sedang cuti
- **Resign**: Pegawai sudah mengundurkan diri

### Melihat Detail Pegawai
1. Klik nama pegawai atau tombol **Detail**
2. Akan tampil informasi lengkap:
   - Data pribadi
   - Data pekerjaan
   - Lama bekerja
   - Umur
   - Riwayat attendance (jika ada)

### Statistik Pegawai
1. Klik menu **Statistik Pegawai**
2. Akan tampil:
   - Jumlah pegawai per departemen
   - Jumlah pegawai per status
   - Grafik lama bekerja
   - Total gaji pegawai aktif

### Cetak Laporan Pegawai
1. Klik menu **Laporan** → **Laporan Pegawai**
2. Pilih filter:
   - Departemen
   - Status pegawai
   - Tanggal masuk
3. Klik **Cetak PDF**

---

## 🏢 MANAJEMEN ASET

### Melihat Daftar Aset
1. Klik menu **Aset** di sidebar
2. Akan tampil tabel aset perusahaan

### Menambah Aset Baru
1. Klik tombol **Tambah Aset**
2. Isi form aset:
   - **Nama Aset**: Nama aset (misal: Laptop HP Pavilion)
   - **Kode Aset**: Kode unik (misal: AST-001)
   - **Kategori**: Elektronik, Furniture, Kendaraan, dll
   - **Tanggal Pembelian**: Kapan aset dibeli
   - **Nilai Pembelian**: Harga beli aset
   - **Status**: Baik, Rusak, Maintenance, Dijual
   - **Lokasi**: Lokasi penyimpanan aset
   - **Gambar**: Upload foto aset
   - **Deskripsi**: Keterangan tambahan
3. Klik **Simpan**

### Mengedit Aset
1. Klik tombol **Edit** pada aset
2. Ubah data yang diperlukan
3. Klik **Update**

### Update Status Maintenance
1. Pada detail aset, klik **Update Maintenance**
2. Isi informasi maintenance:
   - Tanggal maintenance
   - Biaya maintenance
   - Keterangan perbaikan
3. Status aset akan otomatis berubah ke "Maintenance"

### Melihat Nilai Depresiasi
- Sistem otomatis menghitung depresiasi aset
- Depresiasi ditampilkan di halaman detail aset
- Formula: Nilai Beli - (Umur Aset × Nilai Depresiasi/Tahun)

### Statistik Aset
1. Klik menu **Statistik Aset**
2. Akan tampil:
   - Total nilai aset
   - Aset per kategori
   - Aset per status
   - Aset yang perlu maintenance

### Cetak Laporan Aset
1. Klik menu **Laporan** → **Laporan Aset**
2. Pilih filter:
   - Kategori aset
   - Status aset
   - Tanggal pembelian
3. Klik **Cetak PDF**

---

## ⏰ SISTEM ABSENSI (ATTENDANCE)

### Check-In (Masuk Kerja)
1. Klik menu **Attendance** di sidebar
2. Klik tombol **Check In**
3. Konfirmasi check-in
4. Waktu masuk akan tercatat

### Check-Out (Pulang Kerja)
1. Klik menu **Attendance**
2. Klik tombol **Check Out**
3. Isi catatan (opsional)
4. Konfirmasi check-out
5. Waktu pulang akan tercatat

### Melihat Riwayat Kehadiran
1. Klik menu **Attendance** → **Riwayat**
2. Akan tampil daftar kehadiran Anda:
   - Tanggal
   - Check-in
   - Check-out
   - Total jam kerja
   - Status
   - Catatan

### Filter Riwayat
- Filter berdasarkan bulan
- Filter berdasarkan status (Hadir, Sakit, Izin, Alpa)
- Export ke PDF/Excel

### Kelola Attendance (Admin/Supervisor)
1. Klik menu **Attendance Admin**
2. Akan tampil semua attendance pegawai
3. Fitur yang tersedia:
   - **Edit**: Koreksi waktu check-in/out
   - **Approve**: Setujui attendance
   - **Reject**: Tolak attendance
   - **Hapus**: Hapus record attendance

---

## 📊 LAPORAN

### Jenis Laporan Tersedia:
1. **Laporan User**
   - Daftar user berdasarkan role
   - Status aktif/nonaktif
   - Export PDF

2. **Laporan Produk**
   - Daftar produk berdasarkan kategori
   - Stok produk
   - Harga dan status
   - Export PDF

3. **Laporan Pegawai**
   - Daftar pegawai per departemen
   - Status pegawai
   - Gaji pegawai
   - Export PDF

4. **Laporan Aset**
   - Daftar aset per kategori
   - Status dan nilai aset
   - Lokasi aset
   - Export PDF

5. **Laporan Attendance**
   - Kehadiran pegawai
   - Jam kerja
   - Status kehadiran
   - Export Excel/PDF

### Cara Membuat Laporan:
1. Pilih menu **Laporan**
2. Pilih jenis laporan yang diinginkan
3. Atur filter (tanggal, kategori, status, dll)
4. Klik **Cetak** atau **Export**
5. File akan otomatis didownload

---

## ⚙️ PENGATURAN (SETTINGS)

### Pengaturan Sistem
**Khusus Super Admin**

1. Klik menu **Settings** → **Sistem**
2. Konfigurasi yang tersedia:
   - **Nama Aplikasi**: Nama sistem
   - **Logo**: Upload logo perusahaan
   - **Email Sistem**: Email untuk notifikasi
   - **Timezone**: Zona waktu aplikasi
   - **Maintenance Mode**: Aktifkan mode maintenance
3. Klik **Simpan Perubahan**

### Backup & Restore
**Khusus Super Admin**

#### Membuat Backup:
1. Klik menu **Settings** → **Backup & Restore**
2. Klik tombol **Create Backup**
3. Tunggu proses backup selesai
4. File backup (.tar.gz) akan tersedia untuk download

#### Download Backup:
1. Di halaman Backup & Restore
2. Klik tombol **Download** pada file backup
3. File akan terdownload ke komputer Anda

#### Restore Backup:
1. Upload file backup (.tar.gz)
2. Klik tombol **Restore**
3. Konfirmasi restore
4. **PERINGATAN**: Proses ini akan menimpa data yang ada!

#### Hapus Backup:
1. Klik tombol **Hapus** pada file backup
2. Konfirmasi penghapusan

### Activity Log
**Khusus Admin & Super Admin**

1. Klik menu **Settings** → **Log Aktivitas**
2. Akan tampil semua aktivitas user:
   - User yang melakukan
   - Jenis aktivitas (Create, Update, Delete)
   - Modul (User, Produk, Pegawai, dll)
   - Deskripsi detail
   - Waktu aktivitas
   - IP Address
3. Gunakan filter untuk pencarian spesifik

### Bantuan
1. Klik menu **Settings** → **Bantuan**
2. Akan tampil dokumentasi dan FAQ
3. Informasi kontak support

---

## 👤 PROFIL USER

### Melihat Profil
1. Klik nama Anda di pojok kanan atas
2. Pilih **Profil Saya**
3. Akan tampil informasi profil lengkap

### Edit Profil
1. Di halaman profil, klik **Edit Profil**
2. Ubah data yang ingin diubah:
   - Nama
   - Email
   - No HP
   - Foto profil
3. Klik **Simpan Perubahan**

### Ganti Password
1. Di halaman profil, klik tab **Ganti Password**
2. Isi form:
   - Password Lama
   - Password Baru (minimal 8 karakter)
   - Konfirmasi Password Baru
3. Klik **Ganti Password**

*Tips Keamanan Password:*
- Minimal 8 karakter
- Kombinasi huruf besar, kecil, angka
- Gunakan karakter spesial (!@#$%^&*)
- Jangan gunakan password yang mudah ditebak

---

## 🔔 NOTIFIKASI

### Melihat Notifikasi
1. Klik icon bell (🔔) di header
2. Akan tampil dropdown notifikasi terbaru
3. Klik notifikasi untuk melihat detail

### Jenis Notifikasi:
- User baru terdaftar
- Produk stok menipis
- Pegawai baru ditambahkan
- Aset perlu maintenance
- Attendance perlu approval
- Backup berhasil/gagal
- Dan lain-lain

---

## 📱 PESAN (MESSAGING)

### Melihat Pesan
1. Klik menu **Pesan** di sidebar
2. Akan tampil inbox pesan

### Kirim Pesan
1. Klik tombol **Pesan Baru**
2. Pilih penerima
3. Tulis subjek dan pesan
4. Klik **Kirim**

### Reply Pesan
1. Buka pesan yang ingin dibalas
2. Klik **Reply**
3. Tulis balasan
4. Klik **Kirim**

---

## 🔐 KEAMANAN & TIPS

### Keamanan Akun
1. **Jangan bagikan password** ke siapapun
2. **Logout** setelah selesai menggunakan aplikasi
3. **Ganti password** secara berkala (minimal 3 bulan sekali)
4. **Aktifkan 2FA** (Two-Factor Authentication) jika tersedia
5. **Jangan login di komputer umum** atau tidak aman

### Tips Penggunaan
1. **Backup data** secara rutin (minimal 1 minggu sekali)
2. **Cek activity log** untuk memantau aktivitas sistem
3. **Update data** secara berkala agar data tetap akurat
4. **Gunakan fitur search** untuk mempercepat pencarian data
5. **Export laporan** secara periodik untuk arsip

### Jika Lupa Password
1. Hubungi Administrator
2. Admin akan reset password Anda
3. Login dengan password baru
4. Segera ganti password setelah login

### Jika Akun Terkunci
- Akun akan otomatis terkunci setelah 5x gagal login
- Tunggu 30 menit atau hubungi Administrator untuk unlock

---

## ❓ TROUBLESHOOTING

### Tidak Bisa Login
**Penyebab:**
- Email/password salah
- Akun nonaktif
- Akun terkunci (5x gagal login)

**Solusi:**
- Periksa email dan password
- Hubungi Administrator untuk aktivasi akun
- Tunggu 30 menit jika akun terkunci

### Foto/File Tidak Bisa Diupload
**Penyebab:**
- File terlalu besar (max 2MB)
- Format file tidak didukung
- Koneksi internet bermasalah

**Solusi:**
- Kompres file gambar
- Gunakan format: jpg, jpeg, png
- Periksa koneksi internet

### Laporan Tidak Keluar
**Penyebab:**
- Filter tanggal tidak valid
- Tidak ada data sesuai filter
- Browser block popup

**Solusi:**
- Periksa filter tanggal
- Ubah kriteria filter
- Allow popup di browser

### Halaman Error/Blank
**Penyebab:**
- Koneksi internet terputus
- Session expired
- Server error

**Solusi:**
- Periksa koneksi internet
- Refresh halaman (F5)
- Login ulang
- Hubungi Administrator jika masih error

---

## 📞 KONTAK SUPPORT

Jika mengalami kesulitan atau menemukan bug:

**Administrator Sistem:**
- Email: admin@carexis.com
- Telp: (021) 1234-5678
- Jam Kerja: Senin - Jumat, 08:00 - 17:00 WIB

**Technical Support:**
- Email: support@carexis.com
- WhatsApp: 0812-3456-7890

---

## 📝 CATATAN PENTING

1. **Jangan menghapus data sembarangan** - Data yang sudah dihapus tidak bisa dikembalikan
2. **Backup sebelum restore** - Restore akan menimpa semua data yang ada
3. **Periksa permission** - Pastikan Anda memiliki hak akses yang sesuai
4. **Logout setelah selesai** - Untuk keamanan akun Anda
5. **Gunakan browser terbaru** - Chrome, Firefox, atau Edge versi terbaru

---

**Terima kasih telah menggunakan CAREXIS!**

Semoga panduan ini membantu Anda dalam menggunakan sistem.

*Versi Dokumen: 1.0*
*Terakhir Diupdate: 17 Januari 2026*
