# PROJECT CHARTER
## Manajemen Proyek Sistem Informasi (Kode 0009)
### Proyek: Pengembangan Sistem Informasi Barbershop "Barber Flow"

---

### 1. Informasi Umum Proyek

| | |
|---|---|
| **Nama Proyek** | Sistem Informasi Barbershop "Barber Flow" (Web + Mobile) |
| **Manajer Proyek** | _(Nama mahasiswa / ketua kelompok)_ |
| **Sponsor** | Dosen Pengampu — Manajemen Proyek Sistem Informasi |
| **Tanggal Mulai** | _(isi)_ |
| **Tanggal Selesai (target)** | _(isi)_ |
| **Tanggal Charter** | 7 Juni 2026 |

### 2. Latar Belakang & Justifikasi Bisnis

Barbershop modern membutuhkan kanal informasi dan pemesanan digital yang terstruktur. Saat ini informasi layanan, harga, dan ketersediaan umumnya disampaikan secara lisan atau melalui WhatsApp yang tidak terorganisir, sehingga pelanggan sulit memperoleh informasi sebelum datang dan layanan premium kurang terpromosikan. Proyek ini membangun sistem informasi terintegrasi (web admin + storefront + aplikasi mobile katalog) untuk mengatasi masalah tersebut.

### 3. Tujuan Proyek (SMART)

1. Membangun panel admin untuk mengelola layanan, produk, barber, galeri, dan order.
2. Menyediakan storefront web bagi pelanggan untuk melihat katalog dan melakukan booking.
3. Menyediakan aplikasi mobile (Flutter) sebagai katalog digital yang terhubung ke backend via REST API.
4. Menyelesaikan seluruh fitur inti dan diuji berfungsi (HTTP 200) dalam periode satu semester.

### 4. Ruang Lingkup (Scope)

**Termasuk (In-Scope):**
- Modul autentikasi admin (role/permission) & pelanggan (termasuk Google OAuth).
- CRUD: Layanan, Produk + foto, Kategori, Barber, Galeri, Customer, User.
- Manajemen Order/Booking (status: pending → confirmed → done / batal).
- Storefront: beranda, katalog layanan & produk, galeri, tim barber, booking, riwayat.
- Aplikasi mobile katalog + konsumsi REST API.
- Pengaturan situs, Activity Log, dan backup database.

**Tidak Termasuk (Out-of-Scope):**
- Integrasi payment gateway produksi nyata (baru simulasi).
- Sistem antrian real-time / notifikasi push.
- Deployment ke server produksi & domain berbayar.

### 5. Deliverables Utama

| No | Deliverable |
|---|---|
| 1 | Aplikasi web Laravel (admin + storefront) |
| 2 | Aplikasi mobile Flutter "Barber Flow" |
| 3 | REST API + dokumentasi teknis |
| 4 | Basis data MySQL + skrip migrasi/seed |
| 5 | Dokumen pemodelan UML & laporan tiap mata kuliah |

### 6. Milestone & Jadwal Ringkas

| Milestone | Target |
|---|---|
| M1 — Perencanaan & rancangan (transformasi domain, ERD/UML) | Minggu 1–3 |
| M2 — Backend & autentikasi + role/permission | Minggu 4–6 |
| M3 — Storefront & modul order/booking | Minggu 7–9 |
| M4 — Aplikasi mobile + integrasi API | Minggu 10–12 |
| M5 — Pengujian, perapihan UI (rebranding gambar), dokumentasi | Minggu 13–15 |
| M6 — Presentasi & penyerahan akhir | Minggu 16 |

### 7. Stakeholder

| Stakeholder | Peran/Kepentingan |
|---|---|
| Dosen Pengampu | Sponsor & penilai |
| Mahasiswa/Tim | Pelaksana proyek |
| Pemilik barbershop (pengguna ideal) | Pengguna admin |
| Pelanggan barbershop | Pengguna akhir storefront/mobile |

### 8. Anggaran Ringkas (estimasi)

| Item | Estimasi |
|---|---|
| Lisensi software | Rp 0 (Laravel, Flutter, MySQL — open source) |
| Perangkat pengembangan | Tersedia (laptop mahasiswa) |
| Hosting/domain | Rp 0 (lokal — Laragon) |
| **Total biaya tunai** | **Rp 0** (biaya utama berupa waktu/effort) |

### 9. Risiko Utama & Mitigasi

| Risiko | Dampak | Mitigasi |
|---|---|---|
| Transformasi domain (RS→barbershop) menyisakan data lama | Sedang | Pemetaan eksplisit di `RANCANGAN_BARBERSHOP.md`, retensi tabel legacy terkendali |
| Integrasi API web–mobile gagal/tidak sinkron | Tinggi | Sanctum token, pengujian endpoint, konfigurasi `baseUrl` terpusat |
| Gambar storefront terlalu besar → performa | Rendah | Rencana kompresi/resize gambar |
| Waktu terbatas satu semester | Sedang | Milestone mingguan + ruang lingkup terkunci |

### 10. Kriteria Keberhasilan

- Seluruh halaman web merespons HTTP 200 tanpa error.
- Alur booking & autentikasi berjalan di web maupun mobile.
- Dokumentasi (UML, laporan, charter) lengkap dan konsisten dengan implementasi.

### 11. Otorisasi / Persetujuan

| Peran | Nama | Tanda Tangan | Tanggal |
|---|---|---|---|
| Sponsor (Dosen) | __________ | __________ | ______ |
| Manajer Proyek | __________ | __________ | ______ |

---

## CATATAN PEMBAHASAN PRESENTASI (Project Charter)

> Untuk Manajemen Proyek SI, presentasikan **charter** ini (bukan laporan teknis). Saran 5–6 menit.

- **Inti yang ditekankan:** Charter adalah dokumen otorisasi formal yang menandai proyek resmi dimulai — berisi tujuan, ruang lingkup, milestone, stakeholder, anggaran, dan risiko.
- **Alur slide:** Latar belakang → Tujuan SMART → Scope (in/out) → Deliverables → Milestone → Risiko & mitigasi → Kriteria sukses.
- **Antisipasi pertanyaan:**
  - *"Apa beda in-scope & out-of-scope?"* → Menetapkan batas pekerjaan agar proyek terukur dan menghindari *scope creep*.
  - *"Kenapa biaya tunai Rp 0?"* → Semua tool open source & dikerjakan lokal; sumber daya utama adalah waktu/effort, bukan uang.
  - *"Bagaimana mengelola risiko terbesar?"* → Integrasi API web–mobile dimitigasi dengan Sanctum + pengujian endpoint + konfigurasi terpusat.
