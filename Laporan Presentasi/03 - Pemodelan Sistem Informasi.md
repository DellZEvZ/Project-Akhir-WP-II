# LAPORAN & PEMBAHASAN PRESENTASI
## Pemodelan Sistem Informasi (Kode 0684)
### Pemodelan UML Sistem Informasi Barbershop "Barber Flow"

---

## BAGIAN A — LAPORAN

### 1. Pendahuluan

Dokumen ini memodelkan **Sistem Informasi Barbershop Barber Flow** menggunakan **UML (Unified Modeling Language)** berbasis pendekatan **berorientasi objek**. Pemodelan mencakup Use Case Diagram, Activity Diagram, Class Diagram, dan Sequence Diagram, yang menggambarkan struktur dan perilaku sistem nyata (web Laravel + mobile Flutter dengan basis data MySQL).

### 2. Identifikasi Aktor

| Aktor | Deskripsi |
|---|---|
| **Admin** | Mengelola seluruh data master & transaksi melalui panel backend (dibatasi role/permission). |
| **Pelanggan (Customer)** | Melihat katalog, registrasi/login, melakukan booking & pembayaran (web/mobile). |
| **Sistem Pembayaran** | Aktor pendukung yang memproses pembayaran booking. |

### 3. Use Case Diagram (deskripsi tekstual)

```
                 Sistem Informasi Barber Flow
  ┌─────────────────────────────────────────────────────────┐
  │  (Login)                                                  │
  │  (Kelola Layanan)        (Lihat Katalog Layanan)          │
  │  (Kelola Produk)         (Lihat Katalog Produk)           │
  │  (Kelola Barber)         (Registrasi / Login Pelanggan)   │
  │  (Kelola Galeri)         (Booking Layanan)                │
  │  (Kelola Order)          (Bayar Booking) ····> (Proses    │
  │  (Kelola Role/Hak Akses) (Lihat Riwayat Order)   Bayar)   │
  └─────────────────────────────────────────────────────────┘
       ▲                              ▲                  ▲
     Admin                        Pelanggan      Sistem Pembayaran
```

- **<<include>>**: *Booking Layanan* include *Login Pelanggan*; setiap use case "Kelola…" include *Login*.
- **<<extend>>**: *Bayar Booking* extend ke *Proses Pembayaran* (aktor Sistem Pembayaran).

### 4. Activity Diagram — Proses Booking (deskripsi)

```
[Mulai]
  → Pelanggan membuka katalog layanan
  → Pilih layanan → Tambah ke keranjang/booking
  → <Sudah login?>  ── tidak ──> Login / Registrasi ──┐
        │ ya                                          │
        └────────────────◄───────────────────────────┘
  → Isi data booking (tanggal, jam, catatan)
  → Sistem membuat Order (status: pending)
  → Pelanggan melakukan pembayaran
  → <Pembayaran valid?> ── tidak ──> Order tetap pending → [Selesai]
        │ ya
        → Status Order = confirmed
  → Admin memproses → Status = done
[Selesai]
```

### 5. Class Diagram (struktur — sesuai model nyata)

```
+-------------------+        +------------------+        +----------------+
|      Customer     | 1    * |      Order       | 1    * |   OrderItem    |
+-------------------+--------+------------------+--------+----------------+
| -id               |        | -id              |        | -id            |
| -nama             |        | -customer_id     |        | -order_id      |
| -email            |        | -total_harga     |        | -layanan_id    |
| -password         |        | -status          |        | -qty           |
| -no_hp            |        | -tanggal_booking |        | -harga         |
| -alamat           |        | -jam_booking     |        +-------*--+-----+
| -google_id        |        | -catatan         |                |
+-------------------+        +------------------+                | *
                                                                 ▼ 1
+----------------+   1   *  +----------------+        +-------------------+
|    Kategori    |---------▶|     Produk     |        |     Layanan       |
+----------------+          +----------------+        +-------------------+
| -id            |          | -id            |        | -id               |
| -nama_kategori |          | -kategori_id   |        | -nama_layanan     |
+----------------+          | -nama_produk   |        | -deskripsi        |
                            | -harga,-stok   |        | -harga            |
        1                   | -berat,-foto   |        | -durasi_menit     |
        │ *                 | -status        |        | -foto, -status    |
        ▼                   +-------+--------+        +-------------------+
+----------------+              1   │ *
|   FotoProduk   |◄─────────────────┘
+----------------+

+----------------+  *   *  +----------------+  *   *  +----------------+
|      User      |---------|      Role      |---------|   Permission   |
+----------------+         +----------------+         +----------------+
| -id,-name      |         | -id,-name      |         | -id,-name      |
| -email         |         | -display_name  |         | -display_name  |
| -password      |         | -is_active     |         | -module        |
+----------------+         +----------------+         +----------------+

   Barber: -id,-nama,-spesialisasi,-pengalaman_tahun,-no_hp,-foto,-status
   Galeri: -id,-judul,-foto,-keterangan,-tipe(haircut|hairstyle)
```

**Multiplisitas & jenis relasi:**
- `Customer (1) ── (*) Order` — asosiasi satu-ke-banyak.
- `Order (1) ──◇ (*) OrderItem` — komposisi (OrderItem tak berarti tanpa Order; `onDelete cascade`).
- `Order (*) ── (1) Layanan` lewat `OrderItem` — many-to-many ber-atribut (qty, harga).
- `Kategori (1) ── (*) Produk`, `Produk (1) ──◇ (*) FotoProduk`.
- `User (*) ── (*) Role`, `Role (*) ── (*) Permission` — asosiasi banyak-ke-banyak (tabel pivot).

### 6. Sequence Diagram — "Booking Layanan" (deskripsi)

```
Pelanggan   UI(View)   BookingController   Order/OrderItem(Model)   DB
   │  pilih layanan │           │                  │                 │
   │───────────────▶│           │                  │                 │
   │  submit booking│           │                  │                 │
   │───────────────▶│──store()─▶│                  │                 │
   │                │           │── create Order ─▶│── INSERT ──────▶│
   │                │           │── create Items ─▶│── INSERT ──────▶│
   │                │           │◀── order(id) ────│◀── ok ──────────│
   │   tampil ringkasan booking │                  │                 │
   │◀───────────────│◀──redirect│                  │                 │
```

### 7. Pemetaan Diagram ke Materi Perkuliahan

| Pertemuan | Diagram | Bagian dokumen |
|---|---|---|
| 2 | Use Case Diagram | Bagian 3 |
| 3 | Activity Diagram | Bagian 4 |
| 4 | Class Diagram | Bagian 5 |
| 5 | Sequence Diagram | Bagian 6 |
| 1 | Konsep OOP | Model = class, atribut, relasi (inheritance Eloquent) |

### 8. Kesimpulan

Pemodelan UML berhasil mendokumentasikan sistem Barber Flow secara struktural (class diagram sesuai 17 tabel/model nyata) dan perilaku (use case, activity, sequence). Model ini konsisten dengan implementasi Laravel/Flutter, sehingga dapat dijadikan acuan rancangan maupun dokumentasi sistem.

---

## BAGIAN B — PEMBAHASAN PRESENTASI

> Saran durasi: 8–10 menit, 8 slide. Untuk presentasi, gambar ulang diagram dengan tools (draw.io / StarUML / Lucidchart) dari deskripsi di atas.

**Slide 1 — Judul & Identitas sistem.**

**Slide 2 — Gambaran Sistem & Aktor.** Perkenalkan 3 aktor (Admin, Pelanggan, Sistem Pembayaran).

**Slide 3 — Use Case Diagram.** Tunjukkan use case utama + relasi include/extend. Talking point: pisahkan fungsi admin vs pelanggan.

**Slide 4 — Activity Diagram (Booking).** Telusuri alur termasuk decision "Sudah login?" dan "Pembayaran valid?".

**Slide 5 — Class Diagram.** Fokus pada relasi Customer–Order–OrderItem–Layanan dan multiplisitasnya. Talking point: ini cerminan struktur database asli.

**Slide 6 — Sequence Diagram (Booking).** Jelaskan urutan pesan antar objek: View → Controller → Model → DB.

**Slide 7 — Konsistensi Model ↔ Implementasi.** Tunjukkan satu contoh: class `Order` di diagram = tabel `orders` + relasi Eloquent.

**Slide 8 — Kesimpulan & Tanya Jawab.**

**Antisipasi pertanyaan dosen:**
- *"Beda agregasi dan komposisi di diagram Anda?"* → `Order`–`OrderItem` komposisi (cascade delete, item tak hidup tanpa order); relasi lain umumnya asosiasi.
- *"Mengapa Order–Layanan many-to-many?"* → Satu booking bisa banyak layanan, satu layanan bisa di banyak order; dijembatani `OrderItem` yang menyimpan qty & harga.
- *"Bagaimana <<include>> diterapkan?"* → Aksi pengelolaan & booking selalu memerlukan Login, sehingga di-*include*.
