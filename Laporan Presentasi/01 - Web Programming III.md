# LAPORAN & PEMBAHASAN PRESENTASI
## Web Programming III (Kode 0688)
### Studi Kasus: Sistem Informasi Barbershop "Barber Flow" (Web)

---

## BAGIAN A — LAPORAN

### 1. Pendahuluan

Proyek akhir Web Programming III adalah aplikasi web **manajemen barbershop** yang dibangun dengan framework **Laravel 12 (PHP, pola MVC)**. Aplikasi terdiri dari dua sisi: **panel admin (backend)** untuk mengelola data operasional, dan **storefront (frontend)** yang dapat diakses pelanggan untuk melihat layanan, produk, galeri, tim barber, serta melakukan booking. Sistem ini merupakan hasil transformasi domain dari sistem manajemen rumah sakit menjadi domain barbershop (lihat `RANCANGAN_BARBERSHOP.md`).

### 2. Tujuan

1. Menerapkan konsep Laravel MVC: Routing → Middleware → Controller → Model (Eloquent ORM) → View (Blade).
2. Membangun dua sistem autentikasi terpisah (admin & pelanggan).
3. Mengimplementasikan manajemen data (CRUD) lengkap dengan hak akses berbasis role/permission.
4. Membuat alur transaksi: katalog → keranjang/booking → checkout → pembayaran → riwayat.

### 3. Teknologi yang Digunakan

| Komponen | Teknologi |
|---|---|
| Framework | Laravel 12 (PHP 8.2) |
| Database | MySQL (`db_projectakhir`) |
| Templating | Blade |
| Styling | Bootstrap 5 + CSS kustom (tema gold/dark) |
| Build tool | Vite |
| Autentikasi API | Laravel Sanctum (untuk aplikasi mobile) |
| Notifikasi UI | SweetAlert |

### 4. Arsitektur Sistem

```
Request → Route (web.php) → Middleware (auth / is.customer / permission)
        → Controller → Model (Eloquent) → Database (MySQL)
        → View (Blade) → Response
```

- **91 route web** dan **15 route API** terdaftar.
- **Dua konteks autentikasi**:
  1. **Admin** — guard `auth` Laravel, tabel `users`, dilengkapi sistem **Role & Permission** (middleware `CheckPermission`).
  2. **Pelanggan (web)** — sesi kustom `session('customer')`, tabel `customers`, dijaga middleware `IsCustomer`.

### 5. Struktur Data Utama (Eloquent Models)

| Model | Tabel | Field Utama | Relasi |
|---|---|---|---|
| `User` | users | name, email, password | belongsToMany `Role` |
| `Role` / `Permission` | roles / permissions | name, display_name, module | many-to-many |
| `Barber` | barbers | nama, spesialisasi, pengalaman_tahun, no_hp, foto, status | — |
| `Layanan` | layanans | nama_layanan, deskripsi, harga, durasi_menit, foto, status | hasMany `OrderItem` |
| `Kategori` | kategori | nama_kategori | hasMany `Produk` |
| `Produk` | produk | nama_produk, detail, harga, stok, berat, foto, status | belongsTo `Kategori`, hasMany `FotoProduk` |
| `Galeri` | galeris | judul, foto, keterangan, tipe (haircut/hairstyle) | — |
| `Customer` | customers | nama, email, password, no_hp, alamat, foto, google_id | hasMany `Order` |
| `Order` | orders | customer_id, total_harga, status, jenis, tanggal_booking, jam_booking, alamat_kirim, metode_bayar, kanal_bayar, status_bayar, no_ref, dibayar_pada, catatan | belongsTo `Customer`, hasMany `OrderItem` |
| `OrderItem` | order_items | order_id, layanan_id, produk_id, qty, harga | belongsTo `Order`, `Layanan`, `Produk` |

### 6. Fitur yang Diimplementasikan

**Backend (Admin):**
- CRUD Layanan, Produk + foto, Kategori, Barber, Galeri, Customer, User.
- Manajemen Role & Permission (hak akses per modul).
- Manajemen Order/Booking (ubah status: pending → confirmed → done / batal).
- Pengaturan situs (`Setting`), Activity Log, fitur Backup database.

**Frontend (Pelanggan):**
- Beranda dengan hero slideshow, layanan unggulan, tim barber, galeri, produk.
- **Katalog gabungan** (Layanan + Produk dalam satu halaman bertab) dengan pencarian.
- Autentikasi pelanggan (registrasi/login, termasuk Google OAuth via `google_id`).
- **Keranjang campuran** (layanan + produk) dengan tombol "Masukkan ke Keranjang" **beranimasi** (item terbang ke ikon keranjang) + badge jumlah; **hapus item** dengan animasi *drop* (AJAX, tanpa reload).
- **Checkout kondisional**: jadwal kunjungan untuk layanan, alamat pengiriman untuk produk.
- **Pembayaran simulasi**: pilih metode (Transfer Bank / E-Wallet / Bayar di Tempat) berkanal **berlogo** (BCA, BNI, Mandiri, BRI, OVO, DANA, GoPay, ShopeePay) → diarahkan ke **halaman gateway mitra (simulasi)** (nomor VA / e-wallet, hitung mundur) → konfirmasi → **lunas + struk**.
- **Struk / bukti pembayaran** (No. Referensi, dapat dicetak) + **riwayat pesanan** di halaman Akun dengan tombol "Lihat Struk".

### 7. Materi Mata Kuliah yang Diterapkan

| Pertemuan | Topik | Bukti penerapan di proyek |
|---|---|---|
| 1–2 | Setup, Blade, Eloquent relasi produk-kategori | View frontend, relasi `Produk`–`Kategori` |
| 3 | Google OAuth (Socialite) | Login pelanggan via `google_id` |
| 4 | User Management, role/permission | Modul `Role`/`Permission` + `CheckPermission` |
| 5 | Route group & middleware | Prefix `backend/`, middleware `auth`/`is.customer`/`permission` |
| 6 | Shopping cart | Keranjang booking layanan |
| 7 | API pihak ketiga (ongkir) | Layer integrasi (analog RajaOngkir pada e-commerce) |
| 9–11 | Payment gateway & order management | Status order, halaman checkout/payment, panel admin order |
| 12 | Dashboard & laporan | Dashboard admin + Activity Log |

### 8. Dua Versi Tampilan (Iterasi Terakhir)

Storefront dikembangkan dalam **dua versi tema** yang dapat dibandingkan (dikelola dengan Git branch):

| Versi | Branch | Ciri |
|---|---|---|
| **Original** | `main` | Tema Bootstrap navbar gelap + aksen maroon/gold, hero slideshow crossfade 5 gambar, latar bergambar tiap section. |
| **Remake (Supreme-Trimmer)** | `redesign-supremetrimmer` | Mini design system (CSS variabel: warna, tipografi, spacing, radius, shadow), tema putih bersih ala e-commerce, komponen Blade reusable (`x-button`, `x-card`, `x-input`), hero auto-slideshow. |

Kedua versi memiliki fitur fungsional sama (katalog gabungan, keranjang, gateway pembayaran + logo, struk). Tag `original-baseline` menyimpan tampilan awal sebelum semua fitur ini.

**Simulasi gateway pembayaran:** alur `payment → pay() (simpan metode/kanal) → halaman gateway mitra → konfirmasi → lunas + no. referensi + struk`. Logo brand dimuat dari `public/image/icon/` dengan *fallback* chip warna bila file belum ada.

### 9. Kesimpulan

Proyek berhasil mengimplementasikan seluruh kompetensi inti Web Programming III: MVC Laravel, Eloquent relasional, dua sistem autentikasi, otorisasi berbasis role, alur transaksi e-commerce, dan integrasi API untuk klien mobile. Seluruh halaman telah diuji merespons HTTP 200.

---

## BAGIAN B — PEMBAHASAN PRESENTASI

> Saran durasi: 8–10 menit, 9 slide.

**Slide 1 — Judul.** "Sistem Informasi Barbershop Barber Flow — Web". Nama, NIM, mata kuliah.

**Slide 2 — Latar Belakang & Masalah.** Barbershop modern butuh kanal digital terstruktur (info layanan, harga, booking) — selama ini hanya lisan/WA. Talking point: aplikasi menggantikan proses manual.

**Slide 3 — Tujuan & Ruang Lingkup.** Sebutkan 4 tujuan. Tegaskan ada dua sisi: admin & pelanggan.

**Slide 4 — Teknologi & Arsitektur MVC.** Tampilkan diagram alur Request→Route→Middleware→Controller→Model→View. Talking point: jelaskan kenapa MVC memisahkan logika & tampilan.

**Slide 5 — Demo Backend.** Tunjukkan CRUD Layanan, manajemen Role/Permission, dan ubah status Order. Talking point: hak akses berbeda per role.

**Slide 6 — Demo Frontend.** Tunjukkan beranda (hero slideshow), katalog layanan + pencarian, alur booking. Talking point: pengalaman pelanggan.

**Slide 7 — Dua Sistem Autentikasi.** Bandingkan admin (guard `auth` + role) vs pelanggan (`session('customer')` + Google OAuth). Ini nilai jual teknis utama.

**Slide 8 — Penerapan Materi Perkuliahan.** Tabel pertemuan→fitur (slide 7 laporan). Tunjukkan tiap materi benar-benar dipakai.

**Slide 9 — Kesimpulan & Tanya Jawab.** Ringkas pencapaian + rencana lanjut (payment gateway real, optimasi gambar).

**Antisipasi pertanyaan dosen:**
- *"Bedanya guard admin dan session customer?"* → Admin pakai sistem auth bawaan Laravel (tabel users + role). Customer pakai session kustom karena entitas & alur berbeda, plus dukungan login Google.
- *"Bagaimana mencegah akses tak berizin?"* → Middleware `auth`, `is.customer`, dan `permission:<modul>` pada grup route.
- *"Relasi order dan layanan?"* → `Order` hasMany `OrderItem`; tiap `OrderItem` belongsTo `Layanan` (many-to-many lewat tabel pivot order_items dengan qty & harga).
