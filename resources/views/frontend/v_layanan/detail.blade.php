@extends('frontend.v_layouts.app')
@section('title', $layanan->nama_layanan)

@section('content')
<section class="py-5">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('beranda') }}" class="text-decoration-none">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('front.layanan') }}" class="text-decoration-none">Layanan</a></li>
                <li class="breadcrumb-item active">{{ $layanan->nama_layanan }}</li>
            </ol>
        </nav>

        <div class="row g-4">
            <div class="col-md-6">
                @if ($layanan->foto)
                    <img fetchpriority="high" decoding="async" src="{{ asset('storage/img-layanan/' . $layanan->foto) }}" class="img-fluid rounded shadow-sm w-100" style="max-height:400px;object-fit:cover;" alt="{{ $layanan->nama_layanan }}">
                @else
                    <div class="d-flex align-items-center justify-content-center bg-dark-bf rounded" style="height:400px;">
                        <i class="bi bi-scissors text-gold" style="font-size:90px;"></i>
                    </div>
                @endif
            </div>
            <div class="col-md-6">
                <h2 class="font-head">{{ $layanan->nama_layanan }}</h2>
                <h3 class="price-tag mb-3">Rp {{ number_format($layanan->harga, 0, ',', '.') }}</h3>
                <p class="mb-2"><i class="bi bi-clock text-gold"></i> Durasi: <strong>{{ $layanan->durasi_menit }} menit</strong></p>
                <hr>
                <h6 class="font-head">Deskripsi</h6>
                <p class="text-muted">{{ $layanan->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
                <hr>
                @if (session('customer'))
                    <a href="{{ route('booking.add', $layanan->id) }}" class="btn btn-gold btn-lg">
                        <i class="bi bi-calendar-plus"></i> Booking Sekarang
                    </a>
                @else
                    <a href="{{ route('customer.login') }}" class="btn btn-gold btn-lg">
                        <i class="bi bi-box-arrow-in-right"></i> Login untuk Booking
                    </a>
                @endif
                <a href="{{ route('front.layanan') }}" class="btn btn-outline-secondary btn-lg">Kembali</a>
            </div>
        </div>

        @if ($lainnya->count())
        <hr class="my-5">
        <h4 class="font-head mb-4">Layanan Lainnya</h4>
        <div class="row g-4">
            @foreach ($lainnya as $l)
            <div class="col-md-4">
                <div class="card card-bf h-100">
                    @if ($l->foto)
                        <img loading="lazy" decoding="async" src="{{ asset('storage/img-layanan/' . $l->foto) }}" style="height:160px;object-fit:cover;" alt="{{ $l->nama_layanan }}">
                    @else
                        <div class="d-flex align-items-center justify-content-center bg-dark-bf" style="height:160px;">
                            <i class="bi bi-scissors text-gold" style="font-size:40px;"></i>
                        </div>
                    @endif
                    <div class="card-body">
                        <h6 class="font-head mb-1">{{ $l->nama_layanan }}</h6>
                        <span class="price-tag">Rp {{ number_format($l->harga, 0, ',', '.') }}</span>
                    </div>
                    <div class="card-footer bg-white border-0 pb-3">
                        <a href="{{ route('front.layanan.detail', $l->id) }}" class="btn btn-outline-gold btn-sm w-100">Detail</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>
@endsection
