@extends('frontend.v_layouts.app')
@section('title', 'Layanan')

@section('content')
<div class="page-header" style="background-image:url('{{ asset('image/Assets/header-layanan.jpg') }}')">
    <div class="container">
        <h2 class="font-head mb-0">LAYANAN KAMI</h2>
        <p class="mb-0 text-gold small">Pilih layanan grooming favoritmu</p>
    </div>
</div>

<section class="py-5">
    <div class="container">
        <!-- Search -->
        <form action="{{ route('front.layanan') }}" method="GET" class="row g-2 mb-4 justify-content-center">
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari layanan..." value="{{ $search }}">
                    <button class="btn btn-gold" type="submit"><i class="bi bi-search"></i> Cari</button>
                    @if ($search)
                        <a href="{{ route('front.layanan') }}" class="btn btn-outline-secondary">Reset</a>
                    @endif
                </div>
            </div>
        </form>

        <div class="row g-4">
            @forelse ($layanans as $l)
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
                        <p class="text-muted small">{{ Str::limit($l->deskripsi, 75) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="price-tag">Rp {{ number_format($l->harga, 0, ',', '.') }}</span>
                            <span class="text-muted small"><i class="bi bi-clock"></i> {{ $l->durasi_menit }} mnt</span>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0 pb-3 d-flex gap-2">
                        <a href="{{ route('front.layanan.detail', $l->id) }}" class="btn btn-outline-gold btn-sm flex-fill">Detail</a>
                        @if (session('customer'))
                            <a href="{{ route('booking.add', $l->id) }}" class="btn btn-gold btn-sm flex-fill"><i class="bi bi-calendar-plus"></i> Booking</a>
                        @else
                            <a href="{{ route('customer.login') }}" class="btn btn-gold btn-sm flex-fill"><i class="bi bi-calendar-plus"></i> Booking</a>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <i class="bi bi-search text-muted" style="font-size:48px;"></i>
                <p class="mt-3 text-muted">Layanan tidak ditemukan{{ $search ? ' untuk "'.$search.'"' : '' }}.</p>
            </div>
            @endforelse
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $layanans->links() }}
        </div>
    </div>
</section>
@endsection
