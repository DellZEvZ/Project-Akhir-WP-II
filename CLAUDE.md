# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

A **barbershop management system** (men's grooming) built as the Semester IV final project. It was transformed from an earlier hospital inventory/staffing system — see `RANCANGAN_BARBERSHOP.md` for the full domain-mapping (e.g. `Pegawai`→`Barber`, `Aset`→`Layanan`). The project has three deliverables in one repo:

1. **Laravel web app** — admin panel (`backend/`) + customer-facing storefront, with a REST API for the mobile app.
2. **Flutter mobile app** (`barber_flow/`) — "Barber Flow" digital catalog (services, products, booking simulation).
3. **Design & planning artifacts** — UML models and project-management documents (in the Markdown docs at the repo root).

> Naming note: some legacy docs (`DOKUMENTASI_TEKNIS.md`) still refer to the old name "CAREXIS"; the active domain is **barbershop**.

### This project spans four courses

| Course | Code | Covered by |
|---|---|---|
| **Web Programming III** | 0688 | The Laravel web app — Eloquent, Blade, auth, RajaOngkir/Midtrans-style integrations, order management |
| **Mobile Programming I** | 0693 | The Flutter app `barber_flow/` — widgets, navigation, forms, SharedPreferences, consuming the REST API |
| **Pemodelan Sistem Informasi** | 0684 | UML models (use case / activity / class / sequence) documenting this system |
| **Manajemen Proyek Sistem Informasi** | 0009 | Project-management docs — scope, WBS, schedule, the planning/backup Markdown files |

Course materials (modules, slides, per-course `CLAUDE.md`) live under `C:\Users\Deli Kurniawan\Documents\Materi Kuliah\Semester 4\`.

---

## Commands

### Laravel web app (run from this directory)

```bash
composer run setup          # install deps, copy .env, key:generate, migrate, npm build
composer run dev            # serve + queue:listen + vite (concurrent)
composer run test           # config:clear then artisan test
php artisan test --filter=TestName   # single test
./vendor/bin/pint           # format PHP
php artisan migrate:fresh --seed     # rebuild DB + seed
```

### Flutter mobile app (run from `barber_flow/`)

```bash
flutter pub get             # install Dart/Flutter deps
flutter run                 # launch on connected device/emulator
flutter test                # run widget tests
flutter analyze             # lint (flutter_lints)
```

The Flutter app talks to the Laravel API; set the base URL in `barber_flow/lib/config/app_config.dart` (point it at the running `php artisan serve` host).

---

## Architecture

### Web routes & controllers

- **Admin panel** — `backend/`-prefixed routes under the Laravel `auth` guard; named `backend.*`. Controllers: `Barber`, `Layanan`, `Produk`, `Kategori`, `Galeri`, `Pegawai`, `Aset`, `User`, `Order`, `Booking`, `Setting`, `Backup`, `Attendance`, `Profil`.
- **Storefront (customer)** — public pages via `FrontController` / `FrontCustomerController`; customer-only pages guarded by the `is.customer` middleware (`app/Http/Middleware/IsCustomer.php`), which checks `session('customer')`.
- `LoginController` / `QuickLoginController` — custom admin login (not Breeze/Jetstream).

### Three authentication contexts

1. **Admin** — Laravel `auth` guard, `users` table, with a **role/permission system** (`Role`, `Permission` models + `CheckPermission` middleware). Routes apply `permission:*` checks.
2. **Web customer** — custom `session('customer')` (`customers` table), enforced by `IsCustomer`.
3. **Mobile customer** — Laravel **Sanctum** bearer tokens for the REST API (same `customers` data).

### REST API (`routes/api.php`, `app/Http/Controllers/Api/`)

Consumed by the Flutter app:
- **Public:** `GET /api/layanan`, `/api/produk`, `/api/barber`, `/api/galeri` (`CatalogApiController`); `POST /api/register`, `/api/login` (`CustomerApiController`).
- **Protected (`auth:sanctum`):** `/api/me`, `/api/logout`; booking CRUD + `POST /api/booking/{id}/pay` (`BookingApiController`).

### Key models

`Barber`, `Layanan`, `Produk`+`FotoProduk`, `Kategori`, `Galeri` (catalog); `Customer`, `User`+`Role`+`Permission` (auth); `Order`+`OrderItem` (orders **and bookings** — `BookingController` persists bookings through the `Order` model, there is no separate `Booking` model); `Pegawai`+`PegawaiAttendanceLog`, `Aset` (legacy staffing/asset features retained from the hospital origin); `Setting`, `ActivityLog` (activity logging).

### Frontend assets

Blade + Vite; SweetAlert for dialogs (vendored in `sweetalert/`). No JS SPA framework.

### Flutter app structure (`barber_flow/lib/`)

- `pages/` — screens (welcome, login/registrasi, beranda, layanan/produk lists + detail, booking form/summary, payment).
- `services/` — `api_service` (HTTP base), `auth_service` (token via `shared_preferences`), `catalog_service`, `booking_service`.
- `config/app_config.dart` — API base URL; `data/` — static fallback catalog data; `widgets/`, `theme.dart`.

---

## Notes

- This is a standalone Laravel app (own `composer.json`, `.env`, `vendor/`, DB) — run all artisan/composer/npm commands from this directory, **not** the `www` root.
- A SQL snapshot (`database_backup.sql`) and a full project archive (`backup_project_akhir_COMPLETE_*.tar.gz`) exist at the root; prefer `migrate:fresh --seed` over importing the dump unless reproducing a specific saved state.
- Reference docs at the repo root: `RANCANGAN_BARBERSHOP.md` (domain transformation), `DOKUMENTASI_TEKNIS.md` (technical/API), `LAPORAN_MOBILE.md` (mobile report), `PANDUAN_PENGGUNAAN.md` (user guide), `PENJELASAN_WEBSITE.md`, `plan.md`.
