@extends('frontend.v_layouts.app')
@section('title', 'Galeri')

@section('content')
<div class="page-header" style="background-image:url('{{ asset('image/Assets/header-galeri.jpg') }}')">
    <div class="container">
        <h2 class="font-head mb-0">GALERI</h2>
        <p class="mb-0 text-gold small">Inspirasi gaya dari hasil karya barber kami</p>
    </div>
</div>

<section class="py-5">
    <div class="container">
        <!-- Filter tipe -->
        <div class="text-center mb-4">
            <a href="{{ route('front.galeri') }}" class="btn btn-sm {{ !$tipe ? 'btn-gold' : 'btn-outline-gold' }}">Semua</a>
            <a href="{{ route('front.galeri', ['tipe' => 'haircut']) }}" class="btn btn-sm {{ $tipe == 'haircut' ? 'btn-gold' : 'btn-outline-gold' }}">Haircut</a>
            <a href="{{ route('front.galeri', ['tipe' => 'hairstyle']) }}" class="btn btn-sm {{ $tipe == 'hairstyle' ? 'btn-gold' : 'btn-outline-gold' }}">Hairstyle</a>
            <a href="{{ route('front.galeri', ['tipe' => 'beard']) }}" class="btn btn-sm {{ $tipe == 'beard' ? 'btn-gold' : 'btn-outline-gold' }}">Beard</a>
        </div>

        <div class="row g-3">
            @forelse ($galeris as $g)
            <div class="col-md-3 col-6">
                <div class="card card-bf">
                    <img loading="lazy" decoding="async" src="{{ asset('storage/img-galeri/' . $g->foto) }}" style="height:230px;object-fit:cover;" alt="{{ $g->judul }}">
                    <div class="card-body py-2">
                        <p class="font-head mb-1">{{ $g->judul }}</p>
                        <span class="badge bg-dark-bf text-gold">{{ $g->tipe_label }}</span>
                        @if ($g->keterangan)
                            <p class="small text-muted mt-1 mb-0">{{ Str::limit($g->keterangan, 50) }}</p>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <i class="bi bi-images text-muted" style="font-size:48px;"></i>
                <p class="mt-3 text-muted">Belum ada foto di galeri.</p>
            </div>
            @endforelse
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $galeris->links() }}
        </div>
    </div>
</section>
@endsection
