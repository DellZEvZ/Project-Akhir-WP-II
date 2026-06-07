@extends('frontend.v_layouts.app')
@section('title', 'Produk')

@section('content')

{{-- ===== PAGE HEADER ===== --}}
<section class="st-section--dark" style="padding-block:var(--sp-8)">
    <div class="st-container">
        <span class="st-head__kicker">Etalase Grooming</span>
        <h1 class="st-head__title" style="color:var(--c-ice)">Produk Perawatan</h1>
        <p class="st-muted" style="color:rgba(255,255,255,.7)">Produk grooming pria untuk perawatan di rumah.</p>
    </div>
</section>

<section class="st-section">
    <div class="st-container">

        {{-- Filter --}}
        <form action="{{ route('front.produk') }}" method="GET"
              style="display:flex;gap:var(--sp-3);flex-wrap:wrap;align-items:flex-end;margin-bottom:var(--sp-8)">
            <div style="flex:1;min-width:220px">
                <x-input name="search" label="Cari produk" placeholder="Mis. pomade, beard oil…" :value="$search" />
            </div>
            <div style="min-width:200px">
                <div class="field">
                    <label class="field__label" for="kategori">Kategori</label>
                    <select id="kategori" name="kategori" class="select" onchange="this.form.submit()">
                        <option value="">Semua Kategori</option>
                        @foreach ($kategoris as $k)
                            <option value="{{ $k->id }}" {{ request('kategori') == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <x-button type="submit"><i class="bi bi-search"></i> Cari</x-button>
        </form>

        {{-- Grid produk --}}
        <div class="st-grid st-grid--products">
            @forelse ($produks as $p)
                @php $img = $p->foto ? asset('storage/img-produk/'.$p->foto) : asset('image/img-default.jpg'); @endphp
                <x-card
                    :image="$img"
                    :title="Str::limit($p->nama_produk, 32)"
                    :href="route('front.produk.detail', $p->id)"
                    :badge="$p->stok <= 0 ? 'Habis' : null">
                    <span class="card__price">Rp {{ number_format($p->harga, 0, ',', '.') }}</span>
                    <span class="card__meta"><i class="bi bi-box-seam"></i> Stok: {{ $p->stok }}</span>
                    <x-slot:footer>
                        <x-button :href="route('front.produk.detail', $p->id)" variant="outline" size="sm" block>Lihat Detail</x-button>
                    </x-slot:footer>
                </x-card>
            @empty
                <div class="st-empty" style="grid-column:1/-1">
                    <i class="bi bi-bag-x"></i>
                    <p style="margin-top:var(--sp-3)">Produk tidak ditemukan.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div style="margin-top:var(--sp-8);display:flex;justify-content:center">
            {{ $produks->links() }}
        </div>
    </div>
</section>

@endsection
