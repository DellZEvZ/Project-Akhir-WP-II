@extends('frontend.v_layouts.app')
@section('title', 'Keranjang')

@section('content')
<section class="py-5" style="background:#f4f4f4;min-height:70vh;">
    <div class="container">
        <h3 class="font-head mb-4">KERANJANG SAYA</h3>

        @if ($order->orderItems->isEmpty())
            <div class="card card-bf">
                <div class="card-body text-center py-5">
                    <i class="bi bi-cart-x text-muted" style="font-size:60px;"></i>
                    <p class="mt-3 text-muted">Keranjang masih kosong.</p>
                    <a href="{{ route('front.catalog') }}" class="btn btn-gold">Jelajahi Katalog</a>
                </div>
            </div>
        @else
        <div class="row g-4">
            <div class="col-md-8">
                <div class="card card-bf">
                    <div class="card-body p-0">
                        <table class="table align-middle mb-0">
                            <tbody>
                                @foreach ($order->orderItems as $item)
                                    @php
                                        $isProduk = (bool) $item->produk_id;
                                        $nama = $isProduk ? ($item->produk->nama_produk ?? 'Produk') : ($item->layanan->nama_layanan ?? 'Layanan');
                                        $foto = $isProduk
                                            ? ($item->produk?->foto ? asset('storage/img-produk/'.$item->produk->foto) : asset('image/img-default.jpg'))
                                            : ($item->layanan?->foto ? asset('storage/img-layanan/'.$item->layanan->foto) : asset('image/img-default.jpg'));
                                    @endphp
                                    <tr class="cart-row" id="cart-row-{{ $item->id }}">
                                        <td style="padding:14px 16px;">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $foto }}" width="56" height="56" class="rounded me-3" style="object-fit:cover;" alt="">
                                                <div>
                                                    <div class="font-head">{{ $nama }}</div>
                                                    <small class="text-muted">
                                                        <i class="bi {{ $isProduk ? 'bi-bag' : 'bi-scissors' }} text-gold"></i>
                                                        {{ $isProduk ? 'Produk' : 'Layanan' }} &middot; Rp {{ number_format($item->harga, 0, ',', '.') }}
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td width="130">
                                            <form action="{{ route('booking.update', $item->id) }}" method="POST" class="d-flex">
                                                @csrf
                                                <input type="number" name="qty" value="{{ $item->qty }}" min="1" class="form-control form-control-sm" style="width:62px;">
                                                <button class="btn btn-sm btn-outline-secondary ms-1" title="Perbarui"><i class="bi bi-arrow-repeat"></i></button>
                                            </form>
                                        </td>
                                        <td class="price-tag" style="white-space:nowrap;">Rp {{ number_format($item->qty * $item->harga, 0, ',', '.') }}</td>
                                        <td width="50">
                                            <form action="{{ route('booking.remove', $item->id) }}" method="POST" class="js-remove-form" data-row="cart-row-{{ $item->id }}">
                                                @csrf
                                                <button class="btn btn-sm btn-outline-danger" title="Hapus"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-bf">
                    <div class="card-body">
                        <h5 class="font-head mb-3">Ringkasan</h5>
                        <div class="d-flex justify-content-between mb-2"><span>Jumlah item</span><span id="sumCount">{{ $order->orderItems->sum('qty') }}</span></div>
                        <div class="d-flex justify-content-between mb-3"><strong>Total</strong><strong class="price-tag" id="sumTotal">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</strong></div>
                        <a href="{{ route('booking.checkout') }}" class="btn btn-gold w-100"><i class="bi bi-arrow-right-circle"></i> Lanjut ke Checkout</a>
                        <a href="{{ route('front.catalog') }}" class="btn btn-outline-secondary w-100 mt-2">Tambah Item</a>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>

@push('scripts')
<script>
    document.querySelectorAll('.js-remove-form').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const row = document.getElementById(form.dataset.row);
            fetch(form.action, { method: 'POST', body: new FormData(form),
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } })
            .then(r => r.json())
            .then(data => {
                if (row) {
                    row.classList.add('cart-row--drop');
                    setTimeout(() => {
                        row.remove();
                        const c = document.getElementById('sumCount'); if (c) c.textContent = data.count;
                        const t = document.getElementById('sumTotal'); if (t) t.textContent = data.total;
                        if (window.updateCartBadge) window.updateCartBadge(data.count);
                        if (data.empty) window.location.reload();
                    }, 420);
                }
            })
            .catch(() => form.submit());
        });
    });
</script>
@endpush
@endsection
