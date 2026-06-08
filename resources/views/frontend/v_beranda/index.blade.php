@extends('frontend.v_layouts.app')
@section('title', 'Barbershop Modern')

@section('content')
<!-- HERO -->
<section class="hero text-center">
    <div class="hero-slides">
        <div class="hero-slide" style="background-image:url('{{ asset('image/Assets/hero-slide-1.jpg') }}')"></div>
        <div class="hero-slide" style="background-image:url('{{ asset('image/Assets/hero-slide-2.jpg') }}')"></div>
        <div class="hero-slide" style="background-image:url('{{ asset('image/Assets/hero-slide-3.jpg') }}')"></div>
        <div class="hero-slide" style="background-image:url('{{ asset('image/Assets/hero-slide-4.jpg') }}')"></div>
        <div class="hero-slide" style="background-image:url('{{ asset('image/Assets/hero-slide-5.jpg') }}')"></div>
    </div>
    <div class="container">
        <p class="text-gold text-uppercase font-head mb-2" style="letter-spacing:3px;">Selamat datang di Barber Flow</p>
        <h1 class="mb-3">TAMPIL RAPI &amp; <span class="text-gold">BERGAYA</span></h1>
        <p class="lead mb-4">Barbershop modern dengan layanan men's grooming premium oleh barber profesional.</p>
        <a href="{{ route('front.layanan') }}" class="btn btn-gold btn-lg me-2">Lihat Layanan</a>
        <a href="{{ route('front.barber') }}" class="btn btn-outline-light btn-lg">Tim Barber</a>
    </div>
</section>

<!-- LAYANAN UNGGULAN -->
<section class="py-5 section-bg" style="background-image:url('{{ asset('image/Assets/section-layanan-bg.jpg') }}')">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title font-head">LAYANAN KAMI</h2>
            <p class="text-muted">Pilihan layanan perawatan terbaik untuk pria</p>
        </div>
        <div class="row g-4">
            @forelse ($layananUnggulan as $l)
            <div class="col-md-4">
                <div class="card card-bf h-100">
                    @if ($l->foto)
                        <img src="{{ asset('storage/img-layanan/' . $l->foto) }}" style="height:200px;object-fit:cover;" alt="{{ $l->nama_layanan }}">
                    @else
                        <div class="d-flex align-items-center justify-content-center bg-dark-bf" style="height:200px;">
                            <i class="bi bi-scissors text-gold" style="font-size:54px;"></i>
                        </div>
                    @endif
                    <div class="card-body">
                        <h5 class="font-head mb-1">{{ $l->nama_layanan }}</h5>
                        <p class="text-muted small">{{ Str::limit($l->deskripsi, 70) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="price-tag">Rp {{ number_format($l->harga, 0, ',', '.') }}</span>
                            <span class="text-muted small"><i class="bi bi-clock"></i> {{ $l->durasi_menit }} mnt</span>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0 pb-3">
                        <a href="{{ route('front.layanan.detail', $l->id) }}" class="btn btn-outline-gold btn-sm w-100">Detail &amp; Booking</a>
                    </div>
                </div>
            </div>
            @empty
            <p class="text-center text-muted">Belum ada layanan tersedia.</p>
            @endforelse
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('front.layanan') }}" class="btn btn-gold">Lihat Semua Layanan</a>
        </div>
    </div>
</section>

<!-- TIM BARBER -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title font-head">TIM BARBER</h2>
            <p class="text-muted">Barber profesional berpengalaman</p>
        </div>
        <div class="row g-4">
            @forelse ($barbers as $b)
            <div class="col-md-3 col-6">
                <div class="card card-bf h-100 text-center">
                    @if ($b->foto)
                        <img src="{{ asset('storage/img-barber/' . $b->foto) }}" style="height:240px;object-fit:cover;" alt="{{ $b->nama }}">
                    @else
                        <div class="d-flex align-items-center justify-content-center bg-dark-bf" style="height:240px;">
                            <i class="bi bi-person text-gold" style="font-size:64px;"></i>
                        </div>
                    @endif
                    <div class="card-body">
                        <h5 class="font-head mb-0">{{ $b->nama }}</h5>
                        <p class="text-gold small mb-1">{{ $b->spesialisasi }}</p>
                        <p class="text-muted small mb-0">{{ $b->pengalaman_tahun }} tahun pengalaman</p>
                    </div>
                </div>
            </div>
            @empty
            <p class="text-center text-muted">Belum ada barber terdaftar.</p>
            @endforelse
        </div>
    </div>
</section>

<!-- GALERI -->
@if ($galeris->count())
<section class="py-5 section-bg" style="background-image:url('{{ asset('image/Assets/section-galeri-bg.jpg') }}')">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title font-head">GALERI</h2>
            <p class="text-muted">Hasil karya barber kami</p>
        </div>
        <div class="row g-3">
            @foreach ($galeris as $g)
            <div class="col-md-3 col-6">
                <div class="card card-bf">
                    <img src="{{ asset('storage/img-galeri/' . $g->foto) }}" style="height:200px;object-fit:cover;" alt="{{ $g->judul }}">
                    <div class="card-body py-2">
                        <p class="small mb-0 font-head">{{ $g->judul }}</p>
                        <span class="badge bg-dark-bf text-gold">{{ $g->tipe_label }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('front.galeri') }}" class="btn btn-outline-gold">Lihat Galeri Lengkap</a>
        </div>
    </div>
</section>
@endif

<!-- PRODUK -->
@if ($produkUnggulan->count())
<section class="py-5 section-bg" style="background-image:url('{{ asset('image/Assets/section-produk-bg.jpg') }}')">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title font-head">PRODUK PERAWATAN</h2>
            <p class="text-muted">Produk grooming pilihan untuk perawatan di rumah</p>
        </div>
        <div class="row g-4">
            @foreach ($produkUnggulan as $p)
            <div class="col-md-3 col-6">
                <div class="card card-bf h-100">
                    <img src="{{ asset('storage/img-produk/' . $p->foto) }}" style="height:200px;object-fit:cover;" alt="{{ $p->nama_produk }}">
                    <div class="card-body">
                        <h6 class="font-head mb-1">{{ Str::limit($p->nama_produk, 28) }}</h6>
                        <span class="price-tag">Rp {{ number_format($p->harga, 0, ',', '.') }}</span>
                    </div>
                    <div class="card-footer bg-white border-0 pb-3">
                        <a href="{{ route('front.produk.detail', $p->id) }}" class="btn btn-outline-gold btn-sm w-100">Lihat Detail</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('front.produk') }}" class="btn btn-gold">Lihat Semua Produk</a>
        </div>
    </div>
</section>
@endif

<!-- CTA -->
<section class="page-header text-center" style="background-image:url('{{ asset('image/Assets/header-home-cta.jpg') }}')">
    <div class="container">
        <h2 class="font-head mb-3">SIAP TAMPIL LEBIH RAPI?</h2>
        <p class="lead mb-4">Booking layanan favoritmu sekarang dan rasakan pengalaman grooming premium.</p>
        <a href="{{ route('front.layanan') }}" class="btn btn-gold btn-lg">Booking Sekarang</a>
    </div>
</section>
@endsection
