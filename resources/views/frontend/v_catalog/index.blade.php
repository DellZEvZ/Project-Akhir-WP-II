@extends('frontend.v_layouts.app')
@section('title', 'Katalog')

@section('content')

{{-- Header --}}
<section class="st-section--dark" style="padding-block:var(--sp-8)">
    <div class="st-container">
        <span class="st-head__kicker">Layanan &amp; Produk</span>
        <h1 class="st-head__title" style="color:var(--c-ice)">Katalog Barber Flow</h1>
        <p class="st-muted" style="color:rgba(255,255,255,.7)">Pesan layanan grooming dan beli produk perawatan dalam satu keranjang.</p>
    </div>
</section>

<section class="st-section">
    <div class="st-container">

        {{-- Pencarian --}}
        <form action="{{ route('front.catalog') }}" method="GET"
              style="display:flex;gap:var(--sp-3);max-width:560px;margin:0 auto var(--sp-6);">
            <input type="hidden" name="tab" id="tabField" value="{{ $tab }}">
            <div style="flex:1"><x-input name="search" placeholder="Cari layanan atau produk…" :value="$search" /></div>
            <x-button type="submit"><i class="bi bi-search"></i></x-button>
        </form>

        {{-- Tab --}}
        <div class="st-tabs">
            <button type="button" class="st-tab {{ $tab === 'layanan' ? 'is-active' : '' }}" data-tab="layanan">
                <i class="bi bi-scissors"></i> Layanan ({{ $layanans->count() }})
            </button>
            <button type="button" class="st-tab {{ $tab === 'produk' ? 'is-active' : '' }}" data-tab="produk">
                <i class="bi bi-bag"></i> Produk ({{ $produks->count() }})
            </button>
        </div>

        {{-- Pane: Layanan --}}
        <div class="st-tabpane {{ $tab === 'layanan' ? 'is-active' : '' }}" id="pane-layanan">
            <div class="st-grid st-grid--3">
                @forelse ($layanans as $l)
                    @php $img = $l->foto ? asset('storage/img-layanan/'.$l->foto) : asset('image/img-default.jpg'); @endphp
                    <x-card :image="$img" :title="$l->nama_layanan" :href="route('front.layanan.detail', $l->id)" badge="Layanan">
                        <span class="card__price">Rp {{ number_format($l->harga, 0, ',', '.') }}</span>
                        <span class="card__meta"><i class="bi bi-clock"></i> {{ $l->durasi_menit }} menit</span>
                        <x-slot:footer>
                            <x-button :href="route('booking.add', $l->id)" :data-url="route('booking.add', $l->id)" class="js-add-cart" size="sm" block><i class="bi bi-cart-plus"></i> Masukkan ke Keranjang</x-button>
                        </x-slot:footer>
                    </x-card>
                @empty
                    <p class="st-empty" style="grid-column:1/-1">Tidak ada layanan ditemukan.</p>
                @endforelse
            </div>
        </div>

        {{-- Pane: Produk --}}
        <div class="st-tabpane {{ $tab === 'produk' ? 'is-active' : '' }}" id="pane-produk">
            <div class="st-grid st-grid--products">
                @forelse ($produks as $p)
                    @php $img = $p->foto ? asset('storage/img-produk/'.$p->foto) : asset('image/img-default.jpg'); @endphp
                    <x-card :image="$img" :title="Str::limit($p->nama_produk, 32)" :href="route('front.produk.detail', $p->id)"
                            :badge="$p->stok <= 0 ? 'Habis' : null">
                        <span class="card__price">Rp {{ number_format($p->harga, 0, ',', '.') }}</span>
                        <span class="card__meta"><i class="bi bi-box-seam"></i> Stok: {{ $p->stok }}</span>
                        <x-slot:footer>
                            @if ($p->stok > 0)
                                <x-button :href="route('booking.add.produk', $p->id)" :data-url="route('booking.add.produk', $p->id)" class="js-add-cart" size="sm" block><i class="bi bi-cart-plus"></i> Masukkan ke Keranjang</x-button>
                            @else
                                <x-button variant="outline" size="sm" block disabled>Stok Habis</x-button>
                            @endif
                        </x-slot:footer>
                    </x-card>
                @empty
                    <p class="st-empty" style="grid-column:1/-1">Tidak ada produk ditemukan.</p>
                @endforelse
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    const tabField = document.getElementById('tabField');
    document.querySelectorAll('.st-tab').forEach(btn => {
        btn.addEventListener('click', () => {
            const t = btn.dataset.tab;
            document.querySelectorAll('.st-tab').forEach(b => b.classList.toggle('is-active', b === btn));
            document.querySelectorAll('.st-tabpane').forEach(p => p.classList.toggle('is-active', p.id === 'pane-' + t));
            if (tabField) tabField.value = t;
        });
    });
</script>
@endpush
@endsection
