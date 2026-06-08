@extends('backend.v_layouts.app')

@section('breadcrumb')
    <h4 class="page-title">Bantuan & Dukungan</h4>
    <div class="ml-auto">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('backend.beranda') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Bantuan</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- Search Help -->
        <div class="card mb-4">
            <div class="card-body">
                <form>
                    <div class="input-group">
                        <input type="text" class="form-control form-control-lg" placeholder="Cari bantuan atau pertanyaan...">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="mdi mdi-magnify"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Categories -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card text-center" style="cursor: pointer;">
                    <div class="card-body">
                        <i class="mdi mdi-file-document" style="font-size: 3rem; color: #667eea;"></i>
                        <h5 class="card-title mt-3">Dokumentasi</h5>
                        <p class="text-muted">Panduan lengkap penggunaan</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-center" style="cursor: pointer;">
                    <div class="card-body">
                        <i class="mdi mdi-video" style="font-size: 3rem; color: #764ba2;"></i>
                        <h5 class="card-title mt-3">Video Tutorial</h5>
                        <p class="text-muted">Pelajari melalui video</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-center" style="cursor: pointer;">
                    <div class="card-body">
                        <i class="mdi mdi-help-circle" style="font-size: 3rem; color: #f5576c;"></i>
                        <h5 class="card-title mt-3">FAQ</h5>
                        <p class="text-muted">Pertanyaan yang sering ditanya</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-center" style="cursor: pointer;">
                    <div class="card-body">
                        <i class="mdi mdi-email" style="font-size: 3rem; color: #4facfe;"></i>
                        <h5 class="card-title mt-3">Hubungi Kami</h5>
                        <p class="text-muted">Tanyakan langsung</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Frequently Asked Questions -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <i class="mdi mdi-help-circle"></i> Pertanyaan yang Sering Ditanyakan (FAQ)
                </h5>
            </div>
            <div class="card-body">
                <div class="accordion" id="faqAccordion">
                    <!-- FAQ Item 1 -->
                    <div class="card border-0 mb-0">
                        <div class="card-header" id="headingOne" style="background: none; border: none;">
                            <button class="btn btn-link text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <strong>Bagaimana cara menambahkan data pegawai baru?</strong>
                                <span class="float-right"><i class="mdi mdi-chevron-down"></i></span>
                            </button>
                        </div>
                        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#faqAccordion">
                            <div class="card-body">
                                Untuk menambahkan data pegawai baru, ikuti langkah-langkah berikut:
                                <ol>
                                    <li>Pergi ke menu <strong>Kepegawaian > Data Pegawai</strong></li>
                                    <li>Klik tombol <strong>Tambah Data</strong></li>
                                    <li>Isi semua informasi yang diperlukan</li>
                                    <li>Klik <strong>Simpan</strong></li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Item 2 -->
                    <div class="card border-0 mb-0">
                        <div class="card-header" id="headingTwo" style="background: none; border: none;">
                            <button class="btn btn-link text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <strong>Bagaimana cara membuat laporan aset?</strong>
                                <span class="float-right"><i class="mdi mdi-chevron-down"></i></span>
                            </button>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#faqAccordion">
                            <div class="card-body">
                                Untuk membuat laporan aset:
                                <ol>
                                    <li>Pergi ke menu <strong>Inventaris > Laporan Aset</strong></li>
                                    <li>Pilih tanggal awal dan akhir</li>
                                    <li>Opsional: Pilih filter status atau kategori</li>
                                    <li>Klik <strong>Cetak Laporan</strong></li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Item 3 -->
                    <div class="card border-0 mb-0">
                        <div class="card-header" id="headingThree" style="background: none; border: none;">
                            <button class="btn btn-link text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                <strong>Bagaimana cara mengubah password saya?</strong>
                                <span class="float-right"><i class="mdi mdi-chevron-down"></i></span>
                            </button>
                        </div>
                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#faqAccordion">
                            <div class="card-body">
                                Untuk mengubah password:
                                <ol>
                                    <li>Klik foto profil Anda di sudut kanan atas</li>
                                    <li>Pilih <strong>Pengaturan Akun</strong></li>
                                    <li>Di bagian <strong>Keamanan</strong>, klik <strong>Ubah Password</strong></li>
                                    <li>Masukkan password lama dan password baru</li>
                                    <li>Klik <strong>Simpan</strong></li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Item 4 -->
                    <div class="card border-0 mb-0">
                        <div class="card-header" id="headingFour" style="background: none; border: none;">
                            <button class="btn btn-link text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                <strong>Bagaimana cara membuat backup data?</strong>
                                <span class="float-right"><i class="mdi mdi-chevron-down"></i></span>
                            </button>
                        </div>
                        <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#faqAccordion">
                            <div class="card-body">
                                Untuk membuat backup data:
                                <ol>
                                    <li>Pergi ke menu <strong>Pengaturan > Backup & Restore</strong></li>
                                    <li>Di bagian <strong>Backup Data</strong>, pilih opsi backup yang diinginkan</li>
                                    <li>Klik <strong>Buat Backup Sekarang</strong></li>
                                    <li>File backup akan diunduh secara otomatis</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Support -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0">
                            <i class="mdi mdi-email"></i> Hubungi Tim Dukungan
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">Butuh bantuan lebih lanjut? Hubungi tim dukungan kami</p>
                        <div class="mb-3">
                            <label class="form-label">Email:</label>
                            <a href="mailto:support@carexis.com" class="text-primary">support@carexis.com</a>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Telepon:</label>
                            <a href="tel:+62123456789" class="text-primary">+62 (123) 456-789</a>
                        </div>
                        <div class="mb-0">
                            <label class="form-label">Jam Operasional:</label>
                            <p class="text-muted">Senin - Jumat, 08:00 - 17:00 WIB</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="card-title mb-0">
                            <i class="mdi mdi-information"></i> Informasi Sistem
                        </h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <strong>Nama Sistem:</strong> BARBERFLOW
                            </li>
                            <li class="mb-2">
                                <strong>Versi:</strong> 1.0.0
                            </li>
                            <li class="mb-2">
                                <strong>Platform:</strong> Web-Based
                            </li>
                            <li class="mb-2">
                                <strong>Browser Didukung:</strong> Chrome, Firefox, Safari, Edge
                            </li>
                            <li class="mb-0">
                                <strong>Resolusi Minimum:</strong> 1024x768
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
