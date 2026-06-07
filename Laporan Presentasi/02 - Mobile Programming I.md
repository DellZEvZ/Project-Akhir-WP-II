# LAPORAN & PEMBAHASAN PRESENTASI
## Mobile Programming I (Kode 0693)
### Aplikasi Katalog Digital "Barber Flow" (Flutter)

---

## BAGIAN A — LAPORAN

### 1. Pendahuluan

**Barber Flow** adalah aplikasi mobile berbasis **Flutter (bahasa Dart)** yang berfungsi sebagai etalase/katalog digital barbershop *men's grooming*. Aplikasi menampilkan katalog layanan dan produk, halaman detail, autentikasi pelanggan, serta simulasi booking dan pembayaran. Aplikasi ini adalah **klien mobile** dari backend Laravel pada proyek yang sama, berkomunikasi melalui **REST API** (`routes/api.php`). Folder proyek: `barber_flow/`.

### 2. Tujuan

1. Membangun aplikasi Flutter multi-halaman dengan navigasi.
2. Menerapkan widget Stateless & Stateful serta manajemen state sederhana (`setState`).
3. Mengonsumsi REST API (HTTP) dan menyimpan sesi login lokal.
4. Mengimplementasikan form (registrasi, login, booking) dengan validasi.

### 3. Teknologi & Dependency

| Komponen | Keterangan |
|---|---|
| Framework | Flutter / Dart (SDK ^3.11) |
| HTTP client | package `http` |
| Penyimpanan lokal | `shared_preferences` (token login) |
| Ikon | `cupertino_icons` |
| State management | Bawaan (`StatefulWidget` + `setState`), tanpa library tambahan |

### 4. Struktur Aplikasi (`lib/`)

| Folder/File | Isi |
|---|---|
| `main.dart` | Entry point → `MaterialApp`, tema, halaman awal `WelcomePage` |
| `theme.dart` | `AppColors` (palet dark + gold), `buildAppTheme()` |
| `config/app_config.dart` | `baseUrl` API + timeout |
| `pages/` | Layar: welcome, login, registrasi, beranda, layanan & detail, produk & detail, booking form/summary, payment, main |
| `services/` | `ApiService` (HTTP dasar + token), `AuthService`, `CatalogService`, `BookingService` |
| `widgets/` | Komponen reusable: `katalog_card`, `foto`, `tombol_pesan` |
| `data/` | Data katalog statis (fallback bila API tak tersedia) |

### 5. Alur Aplikasi

```
WelcomePage → Login / Registrasi → MainPage (BottomNavigationBar)
   ├── BerandaPage  (paket unggulan – GridView)
   ├── LayananPage  (list + pencarian real-time → DetailLayanan → BookingForm → Payment)
   └── ProdukPage   (list + pencarian → DetailProduk)
```

### 6. Penerapan Konsep Perkuliahan

| Pertemuan | Konsep | Penerapan |
|---|---|---|
| 2 | Widget dasar | Scaffold, Container, Row/Column, Image, Icon |
| 3–4 | Stateless & Stateful | Halaman statis vs halaman dengan `setState` (index nav, hasil pencarian) |
| 5 / 9 | Form & validasi | Form registrasi & booking, `GlobalKey<FormState>`, `TextFormField` |
| 6 | Navigasi | `Navigator.push/pop` ke halaman detail & booking |
| 10 | Login + SharedPreferences | Token Bearer disimpan via `shared_preferences` (key `auth_token`) |
| 11 | Bottom Navigation Bar | `MainPage` dengan 3 tab (Beranda, Layanan, Produk) |
| 12 | Halaman beranda | `GridView`, `ListView`, `Card`, pencarian real-time |

### 7. Integrasi API

Semua request melewati `ApiService` (metode statis `get`/`post`): menambah header `Accept`/`Content-Type`, menyisipkan `Authorization: Bearer <token>` bila perlu, dan melempar `ApiException` saat status non-2xx. `AuthService` memanggil `/register` & `/login`, lalu menyimpan `data.token`. Endpoint publik: `/layanan`, `/produk`, `/barber`, `/galeri`; endpoint terproteksi (Sanctum): `/me`, `/logout`, `/booking`, `/booking/{id}/pay`.

> Konfigurasi `baseUrl` di `lib/config/app_config.dart` — default emulator Android `http://10.0.2.2:8000/api`.

### 8. Pengujian

- `flutter analyze` — lint mengikuti `flutter_lints`.
- `flutter test` — widget test memastikan `WelcomePage` menampilkan teks `BARBER FLOW`, `REGISTRASI`, `LOGIN`.

### 9. Kesimpulan

Barber Flow memenuhi kompetensi Mobile Programming I: struktur proyek Flutter, widget stateful/stateless, navigasi multi-halaman, form bervalidasi, bottom navigation, konsumsi REST API, dan penyimpanan sesi lokal — terintegrasi nyata dengan backend Laravel.

---

## BAGIAN B — PEMBAHASAN PRESENTASI

> Saran durasi: 7–9 menit, 8 slide.

**Slide 1 — Judul.** "Barber Flow — Aplikasi Katalog Barbershop (Flutter)".

**Slide 2 — Latar Belakang.** Banyak barbershop belum punya katalog digital; info layanan/harga hanya lisan/WA. Barber Flow = etalase digital yang bisa diakses kapan saja.

**Slide 3 — Tujuan & Fitur.** Katalog layanan & produk, pencarian, detail, login, simulasi booking + bayar.

**Slide 4 — Arsitektur & Hubungan dengan Backend.** Diagram: Flutter app ↔ REST API (Sanctum) ↔ Laravel ↔ MySQL. Talking point: aplikasi mobile dan web berbagi data yang sama.

**Slide 5 — Demo Alur.** Welcome → Login → Bottom Nav → Layanan → Detail → Booking → Payment. Tunjukkan pencarian real-time.

**Slide 6 — Pembahasan Kode.** Tunjukkan `ApiService` (token Bearer) & `AuthService` (login + SharedPreferences). Talking point: pemisahan layer service vs halaman UI.

**Slide 7 — Penerapan Materi.** Tabel pertemuan→fitur (Stateful, Navigator, Form, BottomNav, SharedPreferences).

**Slide 8 — Kesimpulan & Tanya Jawab.**

**Antisipasi pertanyaan dosen:**
- *"Bagaimana data muncul di aplikasi?"* → Diambil dari REST API backend Laravel via package `http`; ada data statis sebagai cadangan.
- *"Bagaimana sesi login disimpan?"* → Token dari server disimpan di `shared_preferences`; disisipkan ke header tiap request terproteksi.
- *"Stateful vs Stateless?"* → Halaman yang berubah (index tab, hasil pencarian, form) pakai `StatefulWidget` + `setState`; yang statis pakai `StatelessWidget`.
- *"Kenapa tidak pakai state management (Provider/Bloc)?"* → Skala aplikasi katalog masih sederhana; `setState` cukup dan sesuai cakupan mata kuliah.
