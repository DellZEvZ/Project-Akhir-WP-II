# Plan: Hospital → Barbershop Website Transformation

## Goal

Convert the existing Laravel hospital management system into a **Barbershop website** with:
- **Backend (admin panel)** — reuse existing design, replace hospital-domain content with barbershop content
- **Frontend (customer-facing)** — new public pages modeled after `TokoOnline`'s frontend structure

---

## Current State

### Existing Backend (keep the design, change the domain)
| Controller | Model | Views |
|---|---|---|
| `PegawaiController` | `Pegawai` | `v_pegawai/` |
| `AsetController` | `Aset` | `v_aset/` |
| `AttendanceController` | `PegawaiAttendanceLog` | `v_attendance/` |
| `KategoriController`, `ProdukController` | `Kategori`, `Produk` | `v_kategori/`, `v_produk/` |
| `UserController`, `SettingController`, `ProfilController`, `BerandaController` | — | keep as-is |

### New Tables Needed
- `barbers` — replaces/parallels `pegawais`
- `layanans` — replaces/parallels `asets`
- `galeris` — replaces `attendance` concept
- `customers` — new (frontend users, like TokoOnline)
- `orders` — new (frontend bookings/purchases)
- `order_items` — new

---

## Phase 1 — Backend Transformation (keep existing design)

### 1A. Database
Create new migrations alongside existing tables (do NOT drop old ones):
- `create_barbers_table` — `id, nama, spesialisasi, pengalaman_tahun, no_hp, foto, status(aktif/nonaktif), timestamps`
- `create_layanans_table` — `id, nama_layanan, deskripsi, harga, durasi_menit, foto, status, timestamps`
- `create_galeris_table` — `id, judul, foto, keterangan, tipe(hairstyle/haircut/beard), timestamps`

Models to create: `Barber`, `Layanan`, `Galeri`

Seeders:
- `BarberSeeder` — 5 sample barbers
- `LayananSeeder` — 7 services (Haircut Reguler Rp35k, Haircut+Styling Rp50k, Shave&Beard Rp25k, Hair Wash+Blow Dry Rp30k, Creambath Rp75k, Hair Coloring Rp150k, Paket Full Service Rp200k)
- Update `KategoriSeeder` — Shampoo & Conditioner, Pomade & Hair Wax, Hair Tonic & Serum, Peralatan Potong, Aksesori Barbershop
- Update `ProdukSeeder` — hair care product examples

### 1B. Controllers (new, modeled after existing pattern)
- `BarberController` — CRUD + foto upload (model after `PegawaiController`)
- `LayananController` — CRUD + foto upload (model after `AsetController`)
- `GaleriController` — upload, index, delete (model after `AttendanceController`, simpler)
- Update `BerandaController::berandaBackend()` — stats: count barbers, layanan, galeri, produk

### 1C. Views — backend (reuse existing layout, change labels/icons)
- `v_barber/` — `index`, `create`, `edit`, `show` (copy `v_pegawai/` structure, change field names)
- `v_layanan/` — `index`, `create`, `edit` (copy `v_aset/` structure, drop maintenance/depreciation fields)
- `v_galeri/` — `index`, `upload` (simple grid of photos, simpler than attendance)
- Update `v_layouts/app.blade.php` — sidebar menu & branding:
  - App name: **BarberShop Management**
  - Color theme: dark/gold instead of blue/white
  - Menu: Beranda, User, Barber (Data Barber, Galeri Foto), Inventaris (Kategori, Produk, Layanan), Laporan, Pengaturan
- Update `v_beranda/index.blade.php` — stat cards: Barber, Layanan, Produk, Galeri

### 1D. Routes
Add to `routes/web.php` inside `auth` middleware group:
```
Route::resource('backend/barber', BarberController::class, ['as' => 'backend']);
Route::resource('backend/layanan', LayananController::class, ['as' => 'backend']);
Route::resource('backend/galeri', GaleriController::class, ['as' => 'backend']);
// Laporan barber & layanan (PDF)
```

---

## Phase 2 — Frontend (new, modeled after TokoOnline)

### 2A. Database (additional)
- `create_customers_table` — `id, nama, email, password, foto, google_id, timestamps`
- `create_orders_table` — `id, customer_id, total_harga, status(pending/confirmed/done), catatan, timestamps`
- `create_order_items_table` — `id, order_id, layanan_id, qty, harga, timestamps`

Models: `Customer`, `Order`, `OrderItem`  
Middleware: `IsCustomer` — checks `session('customer')`, redirects to `/login` if not set

### 2B. Frontend Controllers
- `CustomerController` (frontend) — manual login/register, profile, logout. No Google OAuth needed unless desired.
- `BookingController` — browse layanan, add to "booking cart", checkout (confirm booking)
- `FrontendBerandaController` (or reuse `BerandaController`) — homepage: hero, layanan highlight, barber team, galeri preview, produk featured

### 2C. Frontend Views (model after TokoOnline's `frontend/`)
```
resources/views/frontend/
  v_layouts/app.blade.php        — navbar (logo, nav links, cart/login), footer
  v_beranda/index.blade.php      — homepage: hero banner, featured layanan, barber team, galeri, produk
  v_layanan/index.blade.php      — all services grid with price & duration
  v_layanan/detail.blade.php     — single service detail + booking button
  v_barber/index.blade.php       — barber team page (photo, nama, spesialisasi)
  v_galeri/index.blade.php       — photo gallery grid (hairstyle/haircut/beard)
  v_produk/index.blade.php       — product catalog (hair care products for sale)
  v_produk/detail.blade.php      — single product detail
  v_booking/cart.blade.php       — booking summary / cart
  v_customer/login.blade.php     — login & register form
  v_customer/akun.blade.php      — customer account & booking history
```

### 2D. Frontend Routes
```php
// Public
Route::get('/', [FrontendBerandaController::class, 'index'])->name('beranda');
Route::get('/layanan', [BookingController::class, 'index'])->name('layanan.index');
Route::get('/layanan/{id}', [BookingController::class, 'detail'])->name('layanan.detail');
Route::get('/barber', [BarberFrontController::class, 'index'])->name('barber.index');
Route::get('/galeri', [GaleriFrontController::class, 'index'])->name('galeri.index');
Route::get('/produk', [ProdukFrontController::class, 'index'])->name('produk.front.index');
Route::get('/produk/{id}', [ProdukFrontController::class, 'detail'])->name('produk.front.detail');

// Auth customer
Route::get('/login', [CustomerController::class, 'loginPage'])->name('customer.login');
Route::post('/login', [CustomerController::class, 'loginPost'])->name('customer.loginPost');
Route::post('/register', [CustomerController::class, 'register'])->name('customer.register');
Route::post('/logout', [CustomerController::class, 'logout'])->name('customer.logout');

// Customer-only (protected by is.customer middleware)
Route::middleware('is.customer')->group(function () {
    Route::get('/akun', [CustomerController::class, 'akun'])->name('customer.akun');
    Route::get('/booking', [BookingController::class, 'cart'])->name('booking.cart');
    Route::get('/booking/add/{id}', [BookingController::class, 'addToCart'])->name('booking.add');
    Route::post('/booking/update/{id}', [BookingController::class, 'updateCart'])->name('booking.update');
    Route::post('/booking/hapus/{id}', [BookingController::class, 'removeFromCart'])->name('booking.remove');
    Route::get('/booking/checkout', [BookingController::class, 'checkout'])->name('booking.checkout');
    Route::post('/booking/confirm', [BookingController::class, 'confirm'])->name('booking.confirm');
});
```

---

## Phase 3 — Backend: Order Management (admin sees customer bookings)

Add to backend:
- `backend/order` — admin view of all bookings (index, show, update status)
- `OrderController` (backend) — list orders, update status (pending → confirmed → done), input notes
- `v_order/index.blade.php`, `v_order/show.blade.php`
- Add "Pesanan" to backend sidebar

---

---

## Phase 4 — Mobile App: "Barber Flow" (Flutter/Dart)

A standalone Flutter app named **Barber Flow** living in `barber_flow/` alongside the Laravel project. For **Mobile Programming I** all data is static (`List<Map>`); the structure is built API-ready for Mobile Programming II integration later.

### 4A. Project Structure

```
barber_flow/
├── lib/
│   ├── main.dart
│   ├── pages/
│   │   ├── welcome/
│   │   │   ├── welcome_page.dart
│   │   │   ├── tombol_registrasi.dart
│   │   │   └── tombol_login.dart
│   │   ├── registrasi/
│   │   │   ├── registrasi_page.dart
│   │   │   └── submit_registrasi.dart
│   │   ├── login/
│   │   │   ├── login_page.dart
│   │   │   └── submit_login.dart
│   │   ├── main_page.dart          ← BottomNavigationBar (Beranda, Layanan, Produk)
│   │   ├── beranda/
│   │   │   ├── beranda_page.dart   ← featured paket unggulan (GridView)
│   │   │   ├── paket_list.dart     ← static data
│   │   │   └── paket_card.dart
│   │   ├── layanan/
│   │   │   ├── layanan_page.dart   ← all services GridView + search
│   │   │   ├── layanan_list.dart   ← static data
│   │   │   ├── layanan_card.dart
│   │   │   └── detail_layanan.dart
│   │   ├── produk/
│   │   │   ├── produk_page.dart    ← products GridView + search
│   │   │   ├── produk_list.dart    ← static data
│   │   │   ├── produk_card.dart
│   │   │   └── detail_produk.dart
│   │   └── booking/
│   │       ├── booking_form.dart   ← nama, tanggal (DatePicker), jam, catatan
│   │       └── booking_summary.dart
│   └── widgets/
│       ├── tombol_pesan.dart       ← reusable booking button
│       └── custom_appbar.dart
├── assets/
│   └── img/                        ← logo, layanan photos, produk photos
└── pubspec.yaml
```

### 4B. Pages & Key Flutter Concepts Used

| Page | Key Widgets/Concepts |
|---|---|
| Welcome | `Scaffold`, `SafeArea`, `ListView`, `Image.asset`, `ElevatedButton` |
| Registrasi / Login | `StatefulWidget`, `TextField`, `TextEditingController`, `Navigator.push` |
| Main Page | `BottomNavigationBar`, `currentIndex`, `setState`, `pageList` |
| Beranda | `GridView.builder`, `Card`, `ClipRRect`, `Image.asset` |
| Layanan / Produk | `List<Map<String,dynamic>>` static data, `GridView`, search with `onChanged` + `setState` |
| Detail | `Navigator.push` + `MaterialPageRoute`, data passing via constructor |
| Booking Form | `GlobalKey<FormState>`, `TextFormField` + validators, `showDatePicker` |
| Booking Summary | data passed from form, read-only summary display |

### 4C. Static Data Content (Mobile Programming I)

**Paket Unggulan (Beranda — 3 items):**
- Royal Men's Spa — Creambath + Pijat Kepala + Masker + Hand Massage — Rp 200.000 / 120 menit
- Executive Grooming — Haircut + Shave + Hair Tonic + Styling — Rp 150.000 / 90 menit
- Hair & Beard Treatment — Hair Wash + Beard Trim + Beard Oil — Rp 85.000 / 60 menit

**Layanan (10+ items):** same list as Laravel backend seeder (Haircut Reguler, Haircut+Styling, Shave & Beard Trim, Hair Wash, Creambath, Hair Coloring, Paket Full Service, Facial Pria, Pijat Kepala, Hair Tonic Treatment, Masker Rambut)

**Produk (10+ items):** same list as Laravel backend seeder + Beard Oil, Sisir, Handuk, dll.

### 4D. User Journey

1. **Welcome** → klik Registrasi / Login
2. **Registrasi** → isi form (simulasi, no API) → back to Login
3. **Login** → masuk ke **Main Page** (BottomNav)
4. **Beranda** → lihat 3 paket unggulan → klik → Detail → klik "Pesan Sekarang"
5. **Booking Form** → isi nama, tanggal, jam, catatan → Submit
6. **Booking Summary** → tampil ringkasan pesanan
7. **Tab Layanan** → lihat semua layanan → search "facial" → filter muncul → klik → Detail → Pesan
8. **Tab Produk** → sama seperti Layanan, data produk perawatan rambut

---

## Phase 5 — API Integration (Mobile Programming II)

This phase wires the Flutter app to the Laravel backend. Two parts: Laravel exposes a JSON API, Flutter consumes it.

### 5A. Laravel — API Routes (`routes/api.php`)

Laravel Sanctum (already in `composer.json`) handles token-based auth for mobile.

#### Public endpoints (no token required)
```php
// Catalog
Route::get('/layanan', [LayananController::class, 'apiIndex']);        // list all layanan
Route::get('/layanan/{id}', [LayananController::class, 'apiShow']);    // detail layanan
Route::get('/produk', [ProdukController::class, 'apiIndex']);          // list all produk
Route::get('/produk/{id}', [ProdukController::class, 'apiShow']);      // detail produk
Route::get('/barber', [BarberController::class, 'apiIndex']);          // barber team list
Route::get('/galeri', [GaleriController::class, 'apiIndex']);          // galeri photos

// Customer auth
Route::post('/register', [CustomerApiController::class, 'register']);  // returns token
Route::post('/login',    [CustomerApiController::class, 'login']);     // returns token
```

#### Protected endpoints (requires `Authorization: Bearer {token}`)
```php
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout',           [CustomerApiController::class, 'logout']);
    Route::get('/akun',              [CustomerApiController::class, 'akun']);
    Route::put('/akun',              [CustomerApiController::class, 'updateAkun']);

    // Booking
    Route::get('/booking',           [BookingApiController::class, 'index']);   // order history
    Route::post('/booking',          [BookingApiController::class, 'store']);   // create booking
    Route::get('/booking/{id}',      [BookingApiController::class, 'show']);    // booking detail
    Route::delete('/booking/{id}',   [BookingApiController::class, 'cancel']); // cancel booking
});
```

#### JSON response shape (consistent across all endpoints)
```json
{
  "success": true,
  "data": { ... },
  "message": "OK"
}
```

#### New controllers needed (API-specific, extends existing logic)
- `CustomerApiController` — register/login returning Sanctum token, akun, updateAkun, logout
- `BookingApiController` — CRUD bookings returning JSON (reuses `Order` / `OrderItem` models from Phase 2)
- Add `apiIndex` / `apiShow` methods to `LayananController`, `ProdukController`, `BarberController`, `GaleriController` — these just call the same Eloquent queries and return `response()->json()`

### 5B. Flutter — HTTP Integration

**New dependencies in `pubspec.yaml`:**
```yaml
dependencies:
  http: ^1.2.0
  shared_preferences: ^2.2.0
```

**New files to add inside `barber_flow/lib/`:**
```
lib/
├── services/
│   ├── api_service.dart        ← base HTTP client, sets base URL + auth header
│   ├── auth_service.dart       ← register, login, logout, store token
│   ├── layanan_service.dart    ← fetchLayanan(), fetchLayananDetail(id)
│   ├── produk_service.dart     ← fetchProduk(), fetchProdukDetail(id)
│   └── booking_service.dart    ← fetchBookings(), createBooking(), cancelBooking()
├── models/
│   ├── layanan_model.dart      ← fromJson() factory
│   ├── produk_model.dart
│   ├── barber_model.dart
│   ├── booking_model.dart
│   └── customer_model.dart
└── config/
    └── app_config.dart         ← base URL constant (e.g. http://192.168.x.x/api)
```

**Migration path from static → live data (per page):**

| Page | Before (MP1) | After (MP2) |
|---|---|---|
| Layanan | `layanan_list.dart` static list | `LayananService.fetchLayanan()` → `FutureBuilder` |
| Produk | `produk_list.dart` static list | `ProdukService.fetchProduk()` → `FutureBuilder` |
| Beranda paket | hardcoded 3 items | API `/layanan?featured=1` or top 3 from response |
| Login | simulated (no API) | `AuthService.login()` → store token in `SharedPreferences` |
| Registrasi | simulated | `AuthService.register()` |
| Booking Form | local summary only | `BookingService.createBooking()` → POST to API |
| Booking Summary | static confirmation | real booking ID + status from API response |

**Token handling in `api_service.dart`:**
```dart
// Every protected request includes:
headers: {
  'Authorization': 'Bearer $token',
  'Accept': 'application/json',
  'Content-Type': 'application/json',
}
```

### 5C. Local Development Setup (connecting Flutter to Laragon)

Flutter on a physical device cannot reach `localhost` — use the machine's local IP:
- Run `ipconfig` on Windows → find IPv4 (e.g. `192.168.1.5`)
- Set `app_config.dart`: `const String baseUrl = 'http://192.168.1.5:8000/api';`
- Ensure Laragon is running and the device is on the same WiFi
- For Android emulator, use `http://10.0.2.2:8000/api` instead

---

## Phase 6 — Pemesanan & Pembayaran

Memperluas booking menjadi alur pemesanan + pembayaran yang lengkap, baik untuk **layanan** (booking) maupun **produk** (pembelian).

### 6A. Database
Tambahkan kolom pembayaran ke tabel `orders`:
- `metode_bayar` enum(`transfer`, `cash`, `ewallet`) nullable
- `status_bayar` enum(`belum`, `menunggu_verifikasi`, `lunas`) default `belum`
- `bukti_bayar` string nullable (upload bukti transfer)
- `jenis` enum(`booking`, `produk`) default `booking` — bedakan order layanan vs produk

`order_items` ditambah `produk_id` nullable (agar bisa menampung item produk, bukan hanya layanan).

### 6B. Web — Pembayaran Booking
- Setelah konfirmasi booking → halaman **pembayaran**: pilih metode, tampilkan info rekening/e-wallet, upload bukti transfer (jika transfer)
- Status alur: `pending` → `confirmed` (dijadwalkan) → setelah bayar `status_bayar` jadi `menunggu_verifikasi` → admin verifikasi → `lunas`
- Halaman akun customer menampilkan status pembayaran tiap order

### 6C. Web — Pembelian Produk
- Tombol "Beli" di katalog/detail produk → keranjang produk (order `jenis=produk`)
- Checkout produk → alamat pengiriman + metode bayar → pembayaran

### 6D. Backend — Verifikasi Pembayaran
- Di `OrderController` admin: lihat bukti bayar, tombol **Verifikasi** (set `status_bayar=lunas`) atau **Tolak**
- Kartu statistik pendapatan (total `lunas`)

### 6E. Mobile (opsional, lanjutan)
- Endpoint API pembayaran + upload bukti
- Halaman pembayaran di Flutter setelah booking summary

---

## Execution Order

1. **Phase 1A** — Migrations + Models + Seeders (barber, layanan, galeri)
2. **Phase 1B** — Backend Controllers (Barber, Layanan, Galeri, update Beranda)
3. **Phase 1C** — Backend Views (v_barber, v_layanan, v_galeri, sidebar, dashboard)
4. **Phase 1D** — Backend Routes
5. **Phase 2A** — Migrations + Models (customer, order, order_items) + IsCustomer middleware
6. **Phase 2B–2D** — Frontend Controllers, Views, Routes
7. **Phase 3** — Backend order management
8. **Phase 4A–4D** — Flutter app (static data, all Mobile Programming I modules covered)
9. **Phase 5A** — Laravel API routes + controllers returning JSON
10. **Phase 5B–5C** — Flutter services/models, replace static data with HTTP calls
11. **Phase 6A–6D** — Pemesanan & pembayaran (web): kolom bayar, halaman pembayaran, pembelian produk, verifikasi admin
12. **Phase 6E** — Pembayaran di mobile (lanjutan)

---

## Key Technical Notes

- **Do not drop** existing tables (`pegawais`, `asets`, `pegawai_attendance_logs`) — just add new tables alongside
- **ImageHelper** (`app/Helpers/ImageHelper.php`) already handles upload + resize via GD — reuse for barber, layanan, galeri photos
- **Role & Permission** system stays untouched
- **ActivityLog** stays untouched
- Image folders to create under `public/storage/`: `img-barber/`, `img-layanan/`, `img-galeri/`
- Frontend uses `session('customer')` (not Laravel `auth` guard) — same pattern as TokoOnline
- Backend stays on Laravel `auth` guard (`users` table)
- The root `/` currently redirects to `backend.login` — change to frontend homepage after Phase 2
- `QuickLoginController` is a dev/testing tool — leave it as-is
- **Flutter app** lives at `barber_flow/` inside the project root — run separately with `flutter run`, completely independent from Laravel until Phase 4E
