# RANCANGAN TRANSFORMASI WEBSITE: Rumah Sakit → Barbershop

## Gambaran Umum

Website ini akan diubah dari sistem inventaris & kepegawaian rumah sakit menjadi **sistem manajemen barbershop** yang mencakup:
- Inventaris produk perawatan & kesehatan rambut
- Deskripsi layanan barbershop
- Galeri foto hairstyle & haircut
- Manajemen data barber (menggantikan pegawai)

---

## Pemetaan Perubahan

### Model & Database

| Lama (Rumah Sakit) | Baru (Barbershop) | Perubahan |
|---|---|---|
| `Pegawai` | `Barber` | Rename tabel + field (nama, spesialisasi, pengalaman_tahun, foto, status) |
| `Aset` | `Layanan` | Rename tabel → tabel layanan barbershop (nama, deskripsi, harga, durasi_menit, foto) |
| `Produk` | `Produk` | Tetap, ubah data → produk perawatan rambut |
| `Kategori` | `Kategori` | Tetap, ubah data → kategori produk rambut |
| `FotoProduk` | `FotoProduk` | Tetap |
| `User` | `User` | Tetap |
| `Role`, `Permission` | `Role`, `Permission` | Tetap |

#### Tabel Baru: `barber` (menggantikan `pegawais`)
```
id, nama, spesialisasi, pengalaman_tahun, no_hp, foto, status (aktif/nonaktif), timestamps
```

#### Tabel Baru: `layanan` (menggantikan `asets`)
```
id, kategori_id, nama_layanan, deskripsi, harga, durasi_menit, foto, status, timestamps
```

#### Tabel Baru: `galeri`
```
id, judul, foto, keterangan, tipe (hairstyle/haircut), timestamps
```

---

### Controller

| Lama | Baru | Keterangan |
|---|---|---|
| `PegawaiController` | `BarberController` | CRUD barber, foto profil |
| `AsetController` | `LayananController` | CRUD layanan barbershop |
| `ProdukController` | `ProdukController` | Tetap, sesuaikan data |
| `KategoriController` | `KategoriController` | Tetap |
| `AttendanceController` | `GaleriController` | Diganti → upload & kelola foto hairstyle |
| `BerandaController` | `BerandaController` | Update dashboard dengan statistik barbershop |
| `SettingController` | `SettingController` | Tetap |
| `ProfilController` | `ProfilController` | Tetap |

---

### Views (resources/views/backend/)

| Folder Lama | Folder Baru | Isi |
|---|---|---|
| `v_pegawai/` | `v_barber/` | index, create, edit, show barber |
| `v_aset/` | `v_layanan/` | index, create, edit layanan |
| `v_attendance/` | `v_galeri/` | index, upload, hapus foto galeri |
| `v_produk/` | `v_produk/` | Tetap, sesuaikan label |
| `v_kategori/` | `v_kategori/` | Tetap |
| `v_beranda/` | `v_beranda/` | Update statistik & info barbershop |
| `v_layouts/` | `v_layouts/` | Ganti nama menu sidebar |

---

### Perubahan Sidebar (v_layouts/app.blade.php)

```
Lama:
├── Beranda
├── User
├── Pegawai
│   ├── Data Pegawai
│   └── Absensi
├── Inventaris
│   ├── Kategori
│   ├── Produk
│   └── Aset
├── Laporan
└── Pengaturan

Baru:
├── Beranda
├── User
├── Barber
│   ├── Data Barber
│   └── Galeri Foto
├── Inventaris
│   ├── Kategori Produk
│   ├── Produk Rambut
│   └── Layanan
├── Laporan
└── Pengaturan
```

---

### Perubahan Konten & Branding

| Elemen | Lama | Baru |
|---|---|---|
| Nama aplikasi | Sistem RS / Inventaris RS | **BarberShop Management** |
| Logo | Logo rumah sakit | Logo gunting/cukur |
| Warna tema | Biru/putih medis | Hitam/gold/putih (tema barbershop) |
| Dashboard | Jumlah pasien, pegawai, aset | Jumlah produk, layanan, barber, galeri |
| Ikon sidebar | Ikon medis | Ikon barbershop (scissors, cut, etc.) |

---

### Data Seeder Baru

#### Kategori Produk Rambut
```
- Shampoo & Conditioner
- Pomade & Hair Wax
- Hair Tonic & Serum
- Peralatan Potong
- Aksesori Barbershop
```

#### Layanan Barbershop
```
- Haircut Reguler         → Rp 35.000 / 30 menit
- Haircut + Styling       → Rp 50.000 / 45 menit
- Shave & Beard Trim      → Rp 25.000 / 20 menit
- Hair Wash + Blow Dry    → Rp 30.000 / 30 menit
- Creambath               → Rp 75.000 / 60 menit
- Hair Coloring           → Rp 150.000 / 90 menit
- Paket Full Service      → Rp 200.000 / 120 menit
```

#### Produk Rambut (contoh)
```
- Pomade Suavecito Original  → Rp 95.000
- Shampoo Men Dove           → Rp 28.000
- Hair Tonic Makarizo        → Rp 45.000
- Wax Matrix                 → Rp 75.000
- Kondisioner Pantene Men    → Rp 32.000
```

---

## Urutan Eksekusi

### Tahap 1 — Persiapan & Database
- [ ] Buat migration `create_barber_table`
- [ ] Buat migration `create_layanan_table`
- [ ] Buat migration `create_galeri_table`
- [ ] Buat Model `Barber`, `Layanan`, `Galeri`
- [ ] Buat seeder kategori, produk, layanan, barber

### Tahap 2 — Controller
- [ ] Buat `BarberController` (CRUD + upload foto)
- [ ] Buat `LayananController` (CRUD + upload foto)
- [ ] Buat `GaleriController` (upload, index, hapus)
- [ ] Update `BerandaController` (statistik barbershop)

### Tahap 3 — Views
- [ ] Update `v_layouts/app.blade.php` (sidebar + branding)
- [ ] Buat `v_barber/` (index, create, edit, show)
- [ ] Buat `v_layanan/` (index, create, edit)
- [ ] Buat `v_galeri/` (index, upload)
- [ ] Update `v_beranda/index.blade.php` (dashboard barbershop)
- [ ] Update semua label teks (pegawai→barber, aset→layanan, dll)

### Tahap 4 — Routes & Finishing
- [ ] Update `routes/web.php` (tambah route barber, layanan, galeri)
- [ ] Sesuaikan warna tema di CSS/layout
- [ ] Jalankan seeder data dummy
- [ ] Test semua fitur CRUD

---

## Catatan Teknis

- **Tidak perlu install package baru** — semua menggunakan struktur yang sudah ada
- **ImageHelper** sudah ada → langsung dipakai untuk upload foto barber, layanan, galeri
- **Role & Permission** tetap digunakan tanpa perubahan
- **ActivityLog** tetap aktif untuk audit trail
- **Folder gambar baru** yang perlu dibuat:
  - `public/storage/img-barber/`
  - `public/storage/img-layanan/`
  - `public/storage/img-galeri/`
- Tabel `pegawais` dan `asets` **tidak dihapus**, cukup buat tabel baru di samping (aman jika perlu rollback)
