@extends('frontend.v_layouts.app')
@section('title', 'Katalog')

@section('content')
<div class="page-header" style="background-image:url('{{ asset('image/Assets/header-produk.jpg') }}')">
    <div class="container">
        <h2 class="font-head mb-0">KATALOG BARBER FLOW</h2>
        <p class="mb-0 text-gold small">Pesan layanan grooming &amp; beli produk perawatan dalam satu keranjang</p>
    </div>
</div>

<section class="py-5">
    <div class="container">

        {{-- Pencarian --}}
        <form action="{{ route('front.catalog') }}" method="GET" class="row g-2 mb-4 justify-content-center">
            <input type="hidden" name="tab" id="tabField" value="{{ $tab }}">
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari layanan atau produk..." value="{{ $search }}">
                    <button class="btn btn-gold" type="submit"><i class="bi bi-search"></i></button>
                </div>
            </div>
        </form>

        {{-- Tab --}}
        <div class="cat-tabs mb-4">
            <button type="button" class="cat-tab {{ $tab === 'layanan' ? 'active' : '' }}" data-tab="layanan"><i class="bi bi-scissors"></i> Layanan ({{ $layanans->count() }})</button>
            <button type="button" class="cat-tab {{ $tab === 'produk' ? 'active' : '' }}" data-tab="produk"><i class="bi bi-bag"></i> Produk ({{ $produks->count() }})</button>
        </div>

        {{-- Pane Layanan --}}
        <div class="cat-pane {{ $tab === 'layanan' ? 'active' : '' }}" id="pane-layanan">
            <div class="row g-4">
                @forelse ($layanans as $l)
                    @php $img = $l->foto ? asset('storage/img-layanan/'.$l->foto) : asset('image/img-default.jpg'); @endphp
                    <div class="col-md-4 col-6 product-cell">
                        <div class="card card-bf h-100">
                            <img loading="lazy" decoding="async" src="{{ $img }}" style="height:200px;object-fit:cover;" alt="{{ $l->nama_layanan }}">
                            <div class="card-body">
                                <h6 class="font-head mb-1">{{ $l->nama_layanan }}</h6>
                                <span class="price-tag">Rp {{ number_format($l->harga, 0, ',', '.') }}</span>
                                <p class="text-muted small mb-0 mt-1"><i class="bi bi-clock"></i> {{ $l->durasi_menit }} menit</p>
                            </div>
                            <div class="card-footer bg-white border-0 pb-3 d-flex gap-2">
                                <a href="{{ route('front.layanan.detail', $l->id) }}" class="btn btn-outline-gold btn-sm">Detail</a>
                                <a href="{{ route('booking.add', $l->id) }}" data-url="{{ route('booking.add', $l->id) }}" class="btn btn-gold btn-sm flex-fill js-add-cart"><i class="bi bi-cart-plus"></i> Keranjang</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5"><i class="bi bi-scissors text-muted" style="font-size:46px;"></i><p class="text-muted mt-2">Tidak ada layanan ditemukan.</p></div>
                @endforelse
            </div>
        </div>

        {{-- Pane Produk --}}
        <div class="cat-pane {{ $tab === 'produk' ? 'active' : '' }}" id="pane-produk">
            <div class="row g-4">
                @forelse ($produks as $p)
                    @php $img = $p->foto ? asset('storage/img-produk/'.$p->foto) : asset('image/img-default.jpg'); @endphp
                    <div class="col-md-3 col-6 product-cell">
                        <div class="card card-bf h-100">
                            <img loading="lazy" decoding="async" src="{{ $img }}" style="height:200px;object-fit:cover;" alt="{{ $p->nama_produk }}">
                            <div class="card-body">
                                <h6 class="font-head mb-1">{{ Str::limit($p->nama_produk, 30) }}</h6>
                                <span class="price-tag">Rp {{ number_format($p->harga, 0, ',', '.') }}</span>
                                <p class="text-muted small mb-0 mt-1"><i class="bi bi-box"></i> Stok: {{ $p->stok }}</p>
                            </div>
                            <div class="card-footer bg-white border-0 pb-3 d-flex gap-2">
                                <a href="{{ route('front.produk.detail', $p->id) }}" class="btn btn-outline-gold btn-sm">Detail</a>
                                @if ($p->stok > 0)
                                    <a href="{{ route('booking.add.produk', $p->id) }}" data-url="{{ route('booking.add.produk', $p->id) }}" class="btn btn-gold btn-sm flex-fill js-add-cart"><i class="bi bi-cart-plus"></i> Keranjang</a>
                                @else
                                    <button class="btn btn-secondary btn-sm flex-fill" disabled>Habis</button>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5"><i class="bi bi-bag-x text-muted" style="font-size:46px;"></i><p class="text-muted mt-2">Tidak ada produk ditemukan.</p></div>
                @endforelse
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    const tabField = document.getElementById('tabField');
    document.querySelectorAll('.cat-tab').forEach(btn => {
        btn.addEventListener('click', () => {
            const t = btn.dataset.tab;
            document.querySelectorAll('.cat-tab').forEach(b => b.classList.toggle('active', b === btn));
            document.querySelectorAll('.cat-pane').forEach(p => p.classList.toggle('active', p.id === 'pane-' + t));
            if (tabField) tabField.value = t;
        });
    });
</script>
@endpush
@endsection
