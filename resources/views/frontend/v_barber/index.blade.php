@extends('frontend.v_layouts.app')
@section('title', 'Tim Barber')

@section('content')
<div class="page-header" style="background-image:url('{{ asset('image/Assets/header-barber.jpg') }}')">
    <div class="container">
        <h2 class="font-head mb-0">TIM BARBER</h2>
        <p class="mb-0 text-gold small">Barber profesional siap melayani gaya terbaikmu</p>
    </div>
</div>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            @forelse ($barbers as $b)
            <div class="col-md-3 col-6">
                <div class="card card-bf h-100 text-center">
                    @if ($b->foto)
                        <img src="{{ asset('storage/img-barber/' . $b->foto) }}" style="height:260px;object-fit:cover;" alt="{{ $b->nama }}">
                    @else
                        <div class="d-flex align-items-center justify-content-center bg-dark-bf" style="height:260px;">
                            <i class="bi bi-person text-gold" style="font-size:70px;"></i>
                        </div>
                    @endif
                    <div class="card-body">
                        <h5 class="font-head mb-1">{{ $b->nama }}</h5>
                        <p class="text-gold small mb-1">{{ $b->spesialisasi }}</p>
                        <p class="text-muted small mb-0"><i class="bi bi-award"></i> {{ $b->pengalaman_tahun }} tahun pengalaman</p>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <i class="bi bi-people text-muted" style="font-size:48px;"></i>
                <p class="mt-3 text-muted">Belum ada barber terdaftar.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
