# LAPORAN PROYEK AKHIR
## Mobile Programming I
### Aplikasi Katalog Digital "Barber Flow"
### Men's Grooming & Barbershop

---

> **Nama Aplikasi:** Barber Flow  
> **Platform:** Flutter / Dart (Android & iOS)  
> **Tema:** Katalog Produk & Layanan Barbershop Modern  
> **Mata Kuliah:** Mobile Programming I  

---

## BAB I — PENDAHULUAN

### 1.1 Latar Belakang

Industri barbershop dan perawatan pria (*men's grooming*) di Indonesia mengalami pertumbuhan yang signifikan dalam beberapa tahun terakhir. Tren ini didorong oleh meningkatnya kesadaran pria akan pentingnya penampilan dan perawatan diri, khususnya di kalangan generasi muda perkotaan. Barbershop modern kini tidak sekadar menawarkan jasa potong rambut, melainkan juga layanan premium seperti facial pria, creambath, pijat kepala, perawatan jenggot, hingga paket perawatan ala spa yang lengkap.

**Barber Flow** merupakan aplikasi mobile berbasis Flutter yang dirancang sebagai etalase digital bagi barbershop modern dengan spesialisasi *men's grooming*. Aplikasi ini menyajikan katalog layanan perawatan pria secara lengkap — mulai dari layanan dasar seperti haircut reguler dan shave, hingga paket premium seperti *Royal Men's Spa* yang mencakup creambath, pijat kepala, masker rambut, dan hand massage. Selain layanan, aplikasi ini juga menampilkan katalog produk perawatan rambut dan jenggot seperti pomade, beard oil, hair tonic, dan shampo pria yang tersedia untuk dibeli.

Meskipun industri ini terus berkembang, banyak barbershop kecil hingga menengah belum memiliki media promosi digital yang terstruktur. Informasi mengenai harga, jenis layanan, dan produk yang tersedia seringkali hanya disampaikan secara lisan atau melalui pesan WhatsApp yang tidak terorganisir. Akibatnya, pelanggan kesulitan mendapatkan informasi sebelum datang, layanan premium yang berpotensi tinggi justru tidak diketahui, dan staf terbebani dengan pertanyaan yang sama berulang-ulang.

Berangkat dari permasalahan tersebut, **Barber Flow** hadir sebagai solusi katalog digital yang dapat diakses kapan saja dan di mana saja. Dengan fitur penelusuran layanan, pencarian produk secara real-time, halaman detail yang informatif, serta simulasi form pemesanan, aplikasi ini menjembatani kebutuhan informasi pelanggan sekaligus menjadi sarana promosi yang efektif bagi pemilik barbershop.

### 1.2 Analisis Masalah dan Solusi

| No | Masalah | Solusi dalam Barber Flow |
|---|---|---|
| 1 | Pelanggan tidak mendapatkan informasi layanan dan harga sebelum datang ke barbershop | Halaman katalog layanan menampilkan nama, harga, durasi, dan deskripsi setiap layanan secara lengkap |
| 2 | Layanan premium (spa pria, facial, creambath) tidak dikenal karena kurang dipromosikan | Halaman Beranda menampilkan tiga paket unggulan secara visual menggunakan GridView dengan foto dan deskripsi menarik |
| 3 | Pelanggan kesulitan menemukan produk atau layanan tertentu dari daftar yang panjang | Fitur pencarian real-time dengan `SearchField` memfilter hasil secara instan saat pengguna mengetik kata kunci |
| 4 | Tidak ada media pra-pemesanan sehingga antrian tidak terprediksi | Form Pemesanan dengan input nama, tanggal (DatePicker), jam, dan catatan memberikan simulasi alur booking yang nyata |
| 5 | Produk perawatan yang tersedia di display tidak diketahui harga dan spesifikasinya | Katalog produk menampilkan gambar, nama, harga, dan deskripsi setiap produk dengan halaman detail tersendiri |

### 1.3 Tujuan dan Manfaat

**Tujuan:**
1. Membangun aplikasi katalog digital berbasis Flutter yang mencakup fitur penelusuran layanan, produk, dan simulasi pemesanan untuk barbershop modern.
2. Menerapkan seluruh kompetensi yang diajarkan dalam mata kuliah Mobile Programming I (Pertemuan 1–13) ke dalam satu proyek yang fungsional dan terintegrasi.
3. Menyediakan solusi nyata bagi permasalahan digitalisasi informasi pada UMKM barbershop.

**Manfaat:**
- **Bagi pelanggan:** Dapat mengakses informasi layanan (harga, durasi, deskripsi) dan produk perawatan secara lengkap tanpa perlu datang langsung, sehingga pengambilan keputusan menjadi lebih mudah.
- **Bagi pemilik usaha:** Memiliki media promosi digital yang rapi dan profesional, meningkatkan visibilitas layanan premium, dan mengurangi beban komunikasi manual melalui WhatsApp.
- **Bagi pengembang/mahasiswa:** Merupakan implementasi menyeluruh dari materi Mobile Programming I yang terstruktur dan dapat dikembangkan lebih lanjut dengan integrasi API di semester berikutnya.

### 1.4 Batasan Perangkat Lunak

Aplikasi **Barber Flow** dikembangkan dengan batasan dan spesifikasi perangkat lunak sebagai berikut:

| Komponen | Spesifikasi |
|---|---|
| **Platform target** | Android (utama); kompatibel dengan iOS |
| **Framework** | Flutter (versi stabil terbaru) |
| **Bahasa pemrograman** | Dart |
| **Teks editor / IDE** | Visual Studio Code atau Android Studio |
| **Manajemen aset** | Gambar statis disimpan di folder `assets/img/`, dideklarasikan di `pubspec.yaml` |
| **Sumber data** | Statis — seluruh data layanan, produk, dan paket disimpan dalam `List<Map<String, dynamic>>` di dalam kode (tidak terhubung ke database atau server) |
| **Autentikasi** | Simulasi — form registrasi dan login tidak memverifikasi data ke server; hanya mensimulasikan alur navigasi |
| **Pemesanan** | Simulasi — data form pemesanan ditampilkan di halaman ringkasan dan tidak dikirim ke server manapun |
| **Koneksi internet** | Tidak diperlukan pada tahap ini (semua data lokal) |
| **Deskripsi aplikasi** | Barber Flow adalah aplikasi katalog digital barbershop yang memungkinkan pengguna menelusuri layanan perawatan pria, mencari produk, melihat detail harga dan deskripsi, serta melakukan simulasi pemesanan — seluruhnya dalam satu antarmuka mobile yang intuitif |

---

## BAB II — STUDI KASUS DAN ANALISIS MASALAH

### 2.1 Studi Kasus: Barbershop "Groom's Haven"

Sebuah barbershop bernama **"Groom's Haven"** berlokasi di pusat kota dengan 8 kursi dan 4 barber aktif. Setiap akhir pekan, antrian pelanggan dapat mencapai 60–90 menit. Pemilik mengidentifikasi beberapa masalah utama:

1. **Pertanyaan berulang via WhatsApp** — Pelanggan sering mengirim pesan: *"Ada gunting merk apa?"*, *"Berapa harga hair spa?"*, *"Apakah tersedia minyak jenggot?"*. Karena tidak ada sistem informasi terpusat, staf harus menjawab satu per satu secara manual.

2. **Layanan premium tidak dikenal** — Layanan seperti *Royal Men's Spa* (creambath + pijat kepala + masker rambut + hand massage) sangat jarang dipesan karena pelanggan tidak mengetahui keberadaannya. Padahal margin keuntungan layanan ini lebih tinggi dibandingkan potong rambut biasa.

3. **Produk perawatan kurang terjual** — Produk seperti pomade, minyak jenggot, dan hair tonic tersedia di display, namun karena tidak ada informasi harga dan deskripsi yang jelas, pelanggan jarang menanyakannya.

4. **Tidak ada sistem pra-pemesanan** — Pelanggan datang tanpa janji, menyebabkan penumpukan antrian yang tidak terprediksi.

### 2.2 Solusi yang Ditawarkan Barber Flow

Dengan **Barber Flow**, seluruh informasi disajikan dalam satu aplikasi yang dapat diakses kapan saja:

- Pelanggan dapat **menelusuri katalog layanan** lengkap dengan harga, durasi, dan deskripsi sebelum datang.
- **Fitur pencarian** memungkinkan pelanggan menemukan layanan spesifik (misalnya mengetik "facial" atau "creambath") dalam hitungan detik.
- Halaman detail setiap layanan/produk menampilkan foto, spesifikasi, dan tombol **"Pesan Sekarang"** yang mengarahkan ke form pemesanan sederhana.
- **Simulasi pemesanan** (nama, tanggal, jam, catatan) memberikan gambaran alur booking yang nyata, meskipun data belum tersimpan ke server pada tahap ini.

---

## BAB III — KONSEP DAN PERANCANGAN APLIKASI

### 3.1 Nama dan Identitas Aplikasi

| Elemen | Keterangan |
|---|---|
| **Nama** | Barber Flow |
| **Tagline** | *Your Style, Your Flow* |
| **Target pengguna** | Pria usia 17–45 tahun yang peduli penampilan |
| **Platform** | Android (utama), iOS (kompatibel) |
| **Bahasa pemrograman** | Dart, framework Flutter |
| **Warna tema** | Hitam, emas (*gold*), putih — mencerminkan kesan premium dan maskulin |

### 3.2 Fitur Utama Aplikasi

| No | Fitur | Deskripsi |
|---|---|---|
| 1 | **Halaman Welcome** | Tampilan pembuka dengan logo, tagline, dan tombol Registrasi/Login |
| 2 | **Registrasi & Login** | Form pendaftaran dan masuk (simulasi tanpa backend) |
| 3 | **Bottom Navigation Bar** | Navigasi utama: Beranda, Layanan, Produk |
| 4 | **Beranda** | Grid 3 paket unggulan barbershop |
| 5 | **Katalog Layanan** | Grid semua layanan (10+ item) dengan pencarian real-time |
| 6 | **Katalog Produk** | Grid produk perawatan rambut & jenggot dengan pencarian |
| 7 | **Halaman Detail** | Foto, harga, durasi/berat, deskripsi lengkap, tombol Pesan |
| 8 | **Form Pemesanan** | Input nama, tanggal (DatePicker), jam, dan catatan tambahan |
| 9 | **Ringkasan Pesanan** | Konfirmasi data pemesanan sebelum diproses |

### 3.3 Konten Katalog

**Paket Unggulan (Beranda):**
| Paket | Isi | Harga | Durasi |
|---|---|---|---|
| Royal Men's Spa | Creambath + Pijat Kepala + Masker Rambut + Hand Massage | Rp 200.000 | 120 menit |
| Executive Grooming | Haircut + Shave + Hair Tonic + Styling | Rp 150.000 | 90 menit |
| Hair & Beard Treatment | Hair Wash + Beard Trim + Beard Oil | Rp 85.000 | 60 menit |

**Layanan (10+ item):**
Haircut Reguler (Rp 35.000), Haircut + Styling (Rp 50.000), Shave & Beard Trim (Rp 25.000), Hair Wash + Blow Dry (Rp 30.000), Creambath (Rp 75.000), Hair Coloring (Rp 150.000), Paket Full Service (Rp 200.000), Facial Pria (Rp 90.000), Pijat Kepala (Rp 45.000), Hair Tonic Treatment (Rp 55.000), Masker Rambut (Rp 65.000)

**Produk (10+ item):**
Pomade Suavecito Original (Rp 95.000), Shampoo Men Dove (Rp 28.000), Hair Tonic Makarizo (Rp 45.000), Wax Matrix (Rp 75.000), Beard Oil Premium (Rp 110.000), Kondisioner Pantene Men (Rp 32.000), dan lainnya.

### 3.4 Struktur Folder Proyek Flutter

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
│   │   ├── main_page.dart
│   │   ├── beranda/
│   │   │   ├── beranda_page.dart
│   │   │   ├── paket_list.dart
│   │   │   └── paket_card.dart
│   │   ├── layanan/
│   │   │   ├── layanan_page.dart
│   │   │   ├── layanan_list.dart
│   │   │   ├── layanan_card.dart
│   │   │   └── detail_layanan.dart
│   │   ├── produk/
│   │   │   ├── produk_page.dart
│   │   │   ├── produk_list.dart
│   │   │   ├── produk_card.dart
│   │   │   └── detail_produk.dart
│   │   └── booking/
│   │       ├── booking_form.dart
│   │       └── booking_summary.dart
│   └── widgets/
│       ├── tombol_pesan.dart
│       └── custom_appbar.dart
├── assets/
│   └── img/
└── pubspec.yaml
```

---

## BAB IV — KETERKAITAN DENGAN MATERI MOBILE PROGRAMMING I

Setiap fitur Barber Flow dirancang agar **secara langsung merepresentasikan kompetensi** yang diajarkan dalam setiap pertemuan kuliah. Berikut penjelasan deskriptifnya:

### Pertemuan 1–4 — Pengenalan Flutter & Struktur Proyek

Barber Flow adalah bukti nyata bahwa aplikasi mobile dapat dibangun oleh satu orang menggunakan Flutter dengan satu basis kode (*single codebase*) yang kompatibel di Android maupun iOS. Proyek ini dibuat dari nol menggunakan Android Studio atau VS Code — mulai dari perintah `flutter create`, pengaturan folder `lib`, `assets`, hingga menjalankan aplikasi pertama kali di emulator maupun perangkat fisik.

Widget-widget dasar seperti `MaterialApp`, `Scaffold`, `AppBar`, `Text`, `Container`, `Column`, dan `Row` menjadi pondasi setiap halaman dalam aplikasi ini, persis sebagaimana yang diperkenalkan di awal modul.

### Pertemuan 5 — Column, Row, dan Parsing Data

Pada halaman detail layanan, informasi harga, durasi, dan deskripsi disusun secara vertikal menggunakan `Column`, sementara ikon dan label kategori disusun secara horizontal menggunakan `Row`. Seluruh data produk dan layanan disimpan dalam `List<Map<String, dynamic>>` — bentuk parsing data statis yang identik dengan contoh di modul — dengan kunci: `judul`, `harga`, `gambar`, `kategori`, dan `deskripsi`.

### Pertemuan 6 — Stateless dan Stateful Widget

Halaman beranda menggunakan `StatelessWidget` karena isinya bersifat tetap — hanya menampilkan grid tiga paket unggulan. Sebaliknya, halaman katalog layanan dan produk dibuat sebagai `StatefulWidget` karena kolom pencarian (*search field*) di `AppBar` perlu merespons setiap perubahan input teks dari pengguna. Setiap kali pengguna mengetik, `setState` dipanggil untuk memfilter ulang daftar yang ditampilkan — ini adalah penerapan langsung dari konsep *state management* dasar.

### Pertemuan 7 — Form dan Input Pengguna

Halaman Form Pemesanan (*Booking Form*) adalah implementasi utama dari materi ini. Form menggunakan `GlobalKey<FormState>` untuk validasi, `TextFormField` dengan atribut `validator` untuk memastikan tidak ada field yang kosong, dan `TextEditingController` untuk mengambil nilai nama pelanggan, nomor HP, dan catatan tambahan. Selain itu, pemilihan tanggal menggunakan `showDatePicker` — sebuah dialog bawaan Flutter yang menampilkan kalender interaktif.

### Pertemuan 8 — Navigasi Berpindah Halaman & Mengirim Data

Ketika pelanggan mengetuk salah satu kartu layanan di halaman katalog, aplikasi menggunakan `Navigator.push` dengan `MaterialPageRoute` untuk membuka halaman detail. Data layanan (judul, harga, gambar, deskripsi) dikirimkan sebagai parameter *constructor* ke halaman tujuan. Setelah form pemesanan diisi dan disubmit, data kembali dikirim ke halaman Ringkasan Pesanan menggunakan mekanisme yang sama — memperkuat pemahaman tentang aliran data antar halaman.

### Pertemuan 9 — Asset Gambar

Semua gambar yang digunakan dalam aplikasi — termasuk logo Barber Flow, foto setiap layanan, dan gambar produk perawatan — disimpan di folder `assets/img/`. Setiap gambar dideklarasikan secara eksplisit di `pubspec.yaml` sebelum dapat digunakan dengan widget `Image.asset()`. Ini mengikuti secara tepat panduan aset gambar yang dijelaskan dalam modul.

### Pertemuan 10–11 — Registrasi dan Login

Halaman Registrasi menyediakan form untuk mengisi nama, email, dan kata sandi menggunakan `TextField` dengan `prefixIcon` dan `TextEditingController`. Halaman Login melakukan hal serupa dengan validasi sederhana. Pada tahap ini, proses autentikasi masih berbentuk simulasi (data tidak dikirim ke server), namun alur navigasi — dari Welcome ke Registrasi, dari Login ke halaman utama — sudah berfungsi penuh menggunakan `Navigator.push` dan `Navigator.pushReplacement`.

### Pertemuan 12 — Bottom Navigation Bar

Setelah berhasil login, pengguna masuk ke **Main Page** yang menampilkan `BottomNavigationBar` dengan tiga tab: **Beranda**, **Layanan**, dan **Produk**. Perpindahan antar tab dikendalikan oleh variabel `currentIndex` yang diperbarui dengan `setState` setiap kali pengguna menekan tab yang berbeda. Ini adalah penerapan langsung dari materi navigasi bottom bar yang diajarkan di pertemuan 12.

### Pertemuan 13 — GridView dan Halaman Beranda

Halaman Beranda menampilkan tiga paket unggulan dalam format `GridView.builder` dengan dua kolom. Setiap item dirender menggunakan widget `Card` kustom (`PaketCard`) yang menampilkan `ClipRRect` untuk gambar dengan sudut melengkung, nama paket, harga, dan durasi. Halaman Katalog Layanan dan Produk juga menggunakan `GridView` yang serupa, dilengkapi `SearchField` di `AppBar` yang secara real-time memfilter item berdasarkan kata kunci yang diketik pengguna — menampilkan pesan *"Tidak ditemukan"* jika hasil filter kosong.

---

## BAB V — ALUR PENGGUNA (USER JOURNEY)

Berikut adalah skenario penggunaan aplikasi dari sudut pandang pelanggan:

1. Pelanggan membuka **Barber Flow** → melihat halaman *Welcome* dengan logo dan tagline.
2. Menekan tombol **Registrasi** → mengisi nama, email, dan password → kembali ke halaman Login.
3. Melakukan **Login** → masuk ke **Main Page** dengan tiga menu di bagian bawah layar.
4. Di tab **Beranda**, melihat tiga paket unggulan dalam grid → mengetuk *"Royal Men's Spa"*.
5. Halaman **Detail Paket** terbuka → membaca deskripsi lengkap, harga Rp 200.000, durasi 120 menit.
6. Menekan tombol **"Pesan Sekarang"** → mengisi **Form Pemesanan** (nama, tanggal melalui DatePicker, jam, catatan).
7. Menekan **Submit** → masuk ke halaman **Ringkasan Pesanan** yang menampilkan konfirmasi data.
8. Kembali ke tab **Layanan** → mengetik *"facial"* di kolom pencarian → daftar terfilter menampilkan *"Facial Pria"*.
9. Mengetuk kartu Facial Pria → melihat detail → memesan lagi melalui alur yang sama.
10. Berpindah ke tab **Produk** → menelusuri produk pomade, minyak jenggot, shampoo → memilih dan melihat detail.

---

## BAB VI — KEUNGGULAN DAN RELEVANSI TEMA

### 6.1 Keunikan Tema "Barber Flow"

Dibandingkan tema katalog generik seperti katalog buku atau pakaian, tema barbershop & *men's grooming* memiliki beberapa keunggulan:

- **Target pasar yang jelas dan berkembang** — Pria usia 17–45 tahun yang peduli penampilan adalah segmen yang terus tumbuh, terutama di perkotaan.
- **Konsep "spa untuk pria" masih langka** — Layanan seperti facial pria, pijat kepala, dan masker rambut jarang dipublikasikan secara digital, menjadikan Barber Flow menarik sebagai inovasi sederhana namun berdampak.
- **Mudah dipresentasikan** — Skenario pengguna yang realistis (mencari layanan, membandingkan harga, memesan) sangat mudah didemonstrasikan dan dipahami oleh siapapun yang menguji aplikasi.
- **Relatabel bagi mahasiswa** — Hampir semua mahasiswa pernah ke barbershop, sehingga konteks penggunaannya langsung dipahami tanpa perlu penjelasan tambahan.

### 6.2 Cakupan Materi Modul

| Pertemuan | Materi | Implementasi dalam Barber Flow |
|---|---|---|
| 1–4 | Pengenalan Flutter, setup proyek, widget dasar | Struktur folder, `MaterialApp`, `Scaffold`, `AppBar` |
| 5 | Column, Row, Parsing Data | Layout detail layanan, `List<Map>` sebagai sumber data |
| 6 | Stateless & Stateful Widget | Beranda (stateless) vs. Katalog + SearchField (stateful) |
| 7 | Form & Input | Form Pemesanan dengan validasi, `showDatePicker` |
| 8 | Navigasi & Pengiriman Data | `Navigator.push`, data passing via constructor |
| 9 | Asset Gambar | Folder `assets/img/`, deklarasi `pubspec.yaml`, `Image.asset` |
| 10–11 | Registrasi & Login | Halaman Registrasi dan Login dengan `TextEditingController` |
| 12 | Bottom Navigation Bar | Main Page dengan 3 tab: Beranda, Layanan, Produk |
| 13 | GridView & Halaman Beranda | `GridView.builder`, `SearchField`, `PaketCard`, filter real-time |

---

## BAB VII — BATASAN DAN RENCANA PENGEMBANGAN

### 7.1 Batasan Aplikasi (Mobile Programming I)

Pada tahap ini, Barber Flow memiliki batasan berikut:
- **Data bersifat statis** — Seluruh informasi layanan, produk, dan paket disimpan langsung dalam kode sebagai `List<Map>`, bukan dari database atau server.
- **Autentikasi simulasi** — Proses registrasi dan login tidak memverifikasi data ke server; hanya simulasi alur navigasi.
- **Pemesanan tidak tersimpan** — Data form pemesanan hanya ditampilkan di halaman ringkasan dan tidak dikirim ke mana pun.

Batasan-batasan ini adalah konsekuensi dari cakupan materi Mobile Programming I yang memang belum mencakup koneksi ke *backend*.

### 7.2 Rencana Pengembangan (Mobile Programming II)

Aplikasi Barber Flow dirancang dengan struktur yang **siap untuk integrasi API** di semester berikutnya:

- **Koneksi ke Backend Laravel** — Data layanan, produk, dan barber akan diambil secara dinamis dari API REST yang disediakan oleh sistem manajemen berbasis Laravel (bagian lain dari proyek ini).
- **Autentikasi Nyata** — Login dan registrasi akan menggunakan token dari Laravel Sanctum, disimpan di `SharedPreferences`.
- **Pemesanan Terkirim ke Server** — Form pemesanan akan mengirim data ke endpoint API dan hasilnya dapat dilihat di panel admin Laravel.
- **Fitur Tambahan** — Riwayat pesanan, notifikasi status pesanan, sistem poin loyalitas, dan integrasi WhatsApp Gateway.

---

## BAB VIII — KESIMPULAN

**Barber Flow** adalah proyek akhir Mobile Programming I yang tidak hanya memenuhi seluruh kompetensi teknis yang diajarkan dalam modul (Pertemuan 1–13), tetapi juga menawarkan solusi nyata bagi permasalahan digitalisasi UMKM barbershop di Indonesia.

Melalui aplikasi ini, seluruh konsep fundamental Flutter — mulai dari widget dasar, pengelolaan *state*, navigasi antar halaman, form dengan validasi, penggunaan aset gambar, hingga penyajian data dalam *grid* dengan fitur pencarian — diterapkan dalam satu alur pengguna yang kohesif dan mudah dipahami.

Lebih dari sekadar tugas akhir, Barber Flow adalah **fondasi yang siap dikembangkan** menjadi sistem yang terintegrasi penuh dengan backend Laravel di semester Mobile Programming II, menjadikannya investasi pembelajaran yang berkelanjutan dan bernilai tinggi.

---

*Laporan ini merupakan bagian dari dokumentasi Proyek Akhir Web Programming II & Mobile Programming I.*
