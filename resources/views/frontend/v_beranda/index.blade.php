@extends('frontend.v_layouts.app')
@section('title', 'Barbershop Modern')

@section('content')

{{-- ===== HERO ===== --}}
<section class="st-hero">
    <div class="st-hero__bg" style="background-image:url('{{ asset('image/Assets/hero-barber.jpg') }}')"></div>
    <div class="st-container">
        <div class="st-hero__inner">
            <span class="st-hero__kicker">Men's Grooming &amp; Barbershop</span>
            <h1 class="st-hero__title">Tampil Rapi<br>&amp; <em>Bergaya</em></h1>
            <p class="st-hero__lead">Layanan barbershop premium dan produk perawatan rambut &amp; jenggot pilihan — dirawat oleh barber profesional.</p>
            <div class="st-hero__cta">
                <x-button :href="route('front.layanan')" size="lg">Lihat Layanan</x-button>
                <x-button :href="route('front.produk')" variant="light" size="lg">Belanja Produk</x-button>
            </div>
        </div>
    </div>
</section>

{{-- ===== FEATURE STRIP ===== --}}
<section class="st-section--alt">
    <div class="st-container st-features" style="padding-block:var(--sp-6)">
        <div class="st-feature">
            <div class="st-feature__icon"><i class="bi bi-scissors"></i></div>
            <h3 class="st-feature__title">Barber Ahli</h3>
            <p class="st-feature__text">Tim berpengalaman & bersertifikat.</p>
        </div>
        <div class="st-feature">
            <div class="st-feature__icon"><i class="bi bi-gem"></i></div>
            <h3 class="st-feature__title">Produk Premium</h3>
            <p class="st-feature__text">Pomade, beard oil, hair tonic asli.</p>
        </div>
        <div class="st-feature">
            <div class="st-feature__icon"><i class="bi bi-calendar-check"></i></div>
            <h3 class="st-feature__title">Booking Mudah</h3>
            <p class="st-feature__text">Pesan layanan kapan saja, online.</p>
        </div>
        <div class="st-feature">
            <div class="st-feature__icon"><i class="bi bi-shield-check"></i></div>
            <h3 class="st-feature__title">Higienis</h3>
            <p class="st-feature__text">Peralatan steril & nyaman.</p>
        </div>
    </div>
</section>

{{-- ===== LAYANAN UNGGULAN ===== --}}
<section class="st-section">
    <div class="st-container">
        <div class="st-head">
            <span class="st-head__kicker">Layanan Kami</span>
            <h2 class="st-head__title">Perawatan Terbaik untuk Pria</h2>
            <p class="st-head__sub">Pilihan layanan grooming favorit pelanggan.</p>
        </div>

        <div class="st-grid st-grid--3">
            @forelse ($layananUnggulan as $l)
                @php $img = $l->foto ? asset('storage/img-layanan/'.$l->foto) : asset('image/img-default.jpg'); @endphp
                <x-card :image="$img" :title="$l->nama_layanan" :href="route('front.layanan.detail', $l->id)">
                    <span class="card__price">Rp {{ number_format($l->harga, 0, ',', '.') }}</span>
                    <span class="card__meta"><i class="bi bi-clock"></i> {{ $l->durasi_menit }} menit</span>
                    <x-slot:footer>
                        <x-button :href="route('front.layanan.detail', $l->id)" variant="outline" size="sm" block>Detail &amp; Booking</x-button>
                    </x-slot:footer>
                </x-card>
            @empty
                <p class="st-empty" style="grid-column:1/-1">Belum ada layanan tersedia.</p>
            @endforelse
        </div>

        <div style="text-align:center;margin-top:var(--sp-8)">
            <x-button :href="route('front.layanan')">Lihat Semua Layanan</x-button>
        </div>
    </div>
</section>

{{-- ===== TIM BARBER ===== --}}
<section class="st-section st-section--alt">
    <div class="st-container">
        <div class="st-head">
            <span class="st-head__kicker">Tim Kami</span>
            <h2 class="st-head__title">Barber Profesional</h2>
        </div>
        <div class="st-grid st-grid--products">
            @forelse ($barbers as $b)
                @php $img = $b->foto ? asset('storage/img-barber/'.$b->foto) : asset('image/img-default.jpg'); @endphp
                <x-card :image="$img" :title="$b->nama">
                    <span class="card__meta" style="color:var(--c-primary);font-weight:600">{{ $b->spesialisasi }}</span>
                    <span class="card__meta">{{ $b->pengalaman_tahun }} tahun pengalaman</span>
                </x-card>
            @empty
                <p class="st-empty" style="grid-column:1/-1">Belum ada barber terdaftar.</p>
            @endforelse
        </div>
    </div>
</section>

{{-- ===== PRODUK UNGGULAN ===== --}}
@if ($produkUnggulan->count())
<section class="st-section">
    <div class="st-container">
        <div class="st-head">
            <span class="st-head__kicker">Etalase</span>
            <h2 class="st-head__title">Produk Perawatan</h2>
            <p class="st-head__sub">Grooming pilihan untuk perawatan di rumah.</p>
        </div>
        <div class="st-grid st-grid--products">
            @foreach ($produkUnggulan as $p)
                @php $img = $p->foto ? asset('storage/img-produk/'.$p->foto) : asset('image/img-default.jpg'); @endphp
                <x-card :image="$img" :title="Str::limit($p->nama_produk, 30)" :href="route('front.produk.detail', $p->id)">
                    <span class="card__price">Rp {{ number_format($p->harga, 0, ',', '.') }}</span>
                    <x-slot:footer>
                        <x-button :href="route('front.produk.detail', $p->id)" variant="outline" size="sm" block>Lihat Detail</x-button>
                    </x-slot:footer>
                </x-card>
            @endforeach
        </div>
        <div style="text-align:center;margin-top:var(--sp-8)">
            <x-button :href="route('front.produk')">Lihat Semua Produk</x-button>
        </div>
    </div>
</section>
@endif

{{-- ===== CTA BANNER ===== --}}
<section class="st-cta" style="background-image:url('{{ asset('image/Assets/header-home-cta.jpg') }}')">
    <div class="st-container st-cta__inner">
        <h2 class="st-cta__title">Siap Tampil Lebih Rapi?</h2>
        <p class="st-cta__text">Booking layanan favoritmu sekarang dan rasakan pengalaman grooming premium.</p>
        <x-button :href="route('front.layanan')" variant="light" size="lg">Booking Sekarang</x-button>
    </div>
</section>

@endsection
