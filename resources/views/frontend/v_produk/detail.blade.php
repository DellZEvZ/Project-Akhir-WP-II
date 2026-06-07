@extends('frontend.v_layouts.app')
@section('title', $produk->nama_produk)

@section('content')
<section class="py-5">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('beranda') }}" class="text-decoration-none">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('front.produk') }}" class="text-decoration-none">Produk</a></li>
                <li class="breadcrumb-item active">{{ Str::limit($produk->nama_produk, 30) }}</li>
            </ol>
        </nav>

        <div class="row g-4">
            <div class="col-md-6">
                <img src="{{ asset('storage/img-produk/' . $produk->foto) }}" class="img-fluid rounded shadow-sm w-100" style="max-height:420px;object-fit:cover;" alt="{{ $produk->nama_produk }}">
            </div>
            <div class="col-md-6">
                <h2 class="font-head">{{ $produk->nama_produk }}</h2>
                <h3 class="price-tag mb-3">Rp {{ number_format($produk->harga, 0, ',', '.') }}</h3>
                <p class="mb-1"><i class="bi bi-box text-gold"></i> Stok: <strong>{{ $produk->stok }}</strong></p>
                <p class="mb-1"><i class="bi bi-rulers text-gold"></i> Berat: <strong>{{ $produk->berat }} gram</strong></p>
                <hr>
                <h6 class="font-head">Detail Produk</h6>
                <p class="text-muted">{{ $produk->detail }}</p>
                <hr>
                @if (session('customer'))
                    <form action="{{ route('produk.beli', $produk->id) }}" method="POST" class="row g-2 align-items-end">
                        @csrf
                        <div class="col-auto">
                            <label class="form-label small">Jumlah</label>
                            <input type="number" name="qty" value="1" min="1" max="{{ $produk->stok }}" class="form-control" style="width:90px;">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-gold btn-lg"><i class="bi bi-bag-check"></i> Beli Sekarang</button>
                        </div>
                    </form>
                @else
                    <a href="{{ route('customer.login') }}" class="btn btn-gold btn-lg"><i class="bi bi-box-arrow-in-right"></i> Login untuk Membeli</a>
                @endif
                <a href="https://wa.me/6281234567890?text=Halo,%20saya%20tertarik%20dengan%20produk%20{{ urlencode($produk->nama_produk) }}"
                   target="_blank" class="btn btn-outline-success btn-lg mt-2">
                    <i class="bi bi-whatsapp"></i> Tanya via WhatsApp
                </a>
            </div>
        </div>

        @if ($lainnya->count())
        <hr class="my-5">
        <h4 class="font-head mb-4">Produk Lainnya</h4>
        <div class="row g-4">
            @foreach ($lainnya as $p)
            <div class="col-md-3 col-6">
                <div class="card card-bf h-100">
                    <img src="{{ asset('storage/img-produk/' . $p->foto) }}" style="height:160px;object-fit:cover;" alt="{{ $p->nama_produk }}">
                    <div class="card-body">
                        <h6 class="font-head mb-1">{{ Str::limit($p->nama_produk, 26) }}</h6>
                        <span class="price-tag">Rp {{ number_format($p->harga, 0, ',', '.') }}</span>
                    </div>
                    <div class="card-footer bg-white border-0 pb-3">
                        <a href="{{ route('front.produk.detail', $p->id) }}" class="btn btn-outline-gold btn-sm w-100">Detail</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>
@endsection
