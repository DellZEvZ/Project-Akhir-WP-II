@extends('frontend.v_layouts.app')
@section('title', 'Produk')

@section('content')
<div class="page-header" style="background-image:url('{{ asset('image/Assets/header-produk.jpg') }}')">
    <div class="container">
        <h2 class="font-head mb-0">PRODUK PERAWATAN</h2>
        <p class="mb-0 text-gold small">Produk grooming untuk perawatan di rumah</p>
    </div>
</div>

<section class="py-5">
    <div class="container">
        <form action="{{ route('front.produk') }}" method="GET" class="row g-2 mb-4 justify-content-center">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control" placeholder="Cari produk..." value="{{ $search }}">
            </div>
            <div class="col-md-3">
                <select name="kategori" class="form-select" onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    @foreach ($kategoris as $k)
                        <option value="{{ $k->id }}" {{ request('kategori') == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-gold w-100" type="submit"><i class="bi bi-search"></i> Cari</button>
            </div>
        </form>

        <div class="row g-4">
            @forelse ($produks as $p)
            <div class="col-md-4 col-6">
                <div class="card card-bf h-100">
                    <img src="{{ asset('storage/img-produk/' . $p->foto) }}" style="height:220px;object-fit:cover;" alt="{{ $p->nama_produk }}">
                    <div class="card-body">
                        <h6 class="font-head mb-1">{{ Str::limit($p->nama_produk, 32) }}</h6>
                        <span class="price-tag">Rp {{ number_format($p->harga, 0, ',', '.') }}</span>
                        <p class="text-muted small mb-0 mt-1"><i class="bi bi-box"></i> Stok: {{ $p->stok }}</p>
                    </div>
                    <div class="card-footer bg-white border-0 pb-3">
                        <a href="{{ route('front.produk.detail', $p->id) }}" class="btn btn-outline-gold btn-sm w-100">Lihat Detail</a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <i class="bi bi-bag-x text-muted" style="font-size:48px;"></i>
                <p class="mt-3 text-muted">Produk tidak ditemukan.</p>
            </div>
            @endforelse
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $produks->links() }}
        </div>
    </div>
</section>
@endsection
