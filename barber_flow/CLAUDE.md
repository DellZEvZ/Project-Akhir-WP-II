# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Overview

**Barber Flow** — a Flutter/Dart mobile app (Mobile Programming I, course 0693) acting as a digital catalog for a barbershop: browse services (`layanan`) and products (`produk`), view details, and run a booking + payment simulation. It is the mobile client for the Laravel backend in the parent directory (`../`), which it reaches over the REST API at `routes/api.php`.

This is a standalone Flutter package — run all `flutter`/`dart` commands from this directory (`barber_flow/`), not the Laravel root.

## Commands

```bash
flutter pub get      # install deps
flutter run          # launch on connected device/emulator
flutter test         # widget tests (test/widget_test.dart)
flutter analyze      # lint via flutter_lints (analysis_options.yaml)
```

Dependencies (`pubspec.yaml`): `http` (REST calls), `shared_preferences` (token storage), `cupertino_icons`. No state-management package — screens use plain `StatefulWidget` + `setState`.

## Backend connection

`flutter run` will not show live data unless the Laravel backend is running (`composer run dev` in `../`) **and** `lib/config/app_config.dart` `baseUrl` points at it. Defaults to `http://10.0.2.2:8000/api` (Android emulator → host). Use `http://127.0.0.1:8000/api` for desktop, or the laptop's LAN IP for a physical device. `lib/data/*` holds static fallback catalog data used when the API is unavailable.

## Architecture

- **Entry** — `main.dart` → `BarberFlowApp` (`MaterialApp`, theme from `theme.dart`, home = `WelcomePage`).
- **Flow** — `WelcomePage` → login/registrasi → `MainPage`, which hosts a `BottomNavigationBar` over three tabs: `BerandaPage`, `LayananPage`, `ProdukPage`. Detail/booking/payment screens are pushed via `Navigator`.
- **Services (`lib/services/`)** — all network access goes through `ApiService` (static methods: `get`/`post`, JSON decode, `Authorization: Bearer` header, `ApiException` on non-2xx). `AuthService` (register/login/logout) saves the Sanctum token via `ApiService.saveToken` → `shared_preferences` key `auth_token`. `catalog_service` and `booking_service` wrap the catalog and booking endpoints.
- **Pages (`lib/pages/`)** — UI screens. **Widgets (`lib/widgets/`)** — reusable `katalog_card`, `foto`, `tombol_pesan`. **`theme.dart`** — `AppColors` (dark + gold palette) and `buildAppTheme()`.

### Auth contract

`/register` and `/login` responses are expected as `res['data']['token']`; protected calls pass `auth: true` so `ApiService` attaches the bearer token. Logout best-effort hits `/logout` then clears the local token regardless of network result.

## Conventions

- UI strings, comments, and many identifiers are in **Indonesian** (e.g. `layanan`, `produk`, `beranda`, `tombol_pesan`) — match this when adding code.
- Services are static-method classes (no DI/singletons); follow that pattern rather than introducing a state-management library unless asked.
- Widget test (`test/widget_test.dart`) asserts the welcome screen renders `BARBER FLOW`, `REGISTRASI`, `LOGIN` — keep it green when touching `WelcomePage`/`main.dart`.
