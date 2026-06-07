@extends('frontend.v_layouts.app')
@section('title', 'Keranjang')

@section('content')
<section class="st-section" style="background:var(--c-surface);min-height:70vh">
    <div class="st-container">
        <h1 class="st-head__title" style="margin-bottom:var(--sp-6)">Keranjang Saya</h1>

        @if ($order->orderItems->isEmpty())
            <div class="pay-card" style="text-align:center;padding:var(--sp-10)">
                <i class="bi bi-cart-x" style="font-size:3rem;color:var(--c-line)"></i>
                <p class="st-muted" style="margin:var(--sp-3) 0">Keranjang masih kosong.</p>
                <x-button :href="route('front.catalog')">Jelajahi Katalog</x-button>
            </div>
        @else
        <div class="pay-wrap">
            <div class="pay-card cart-table-wrap" style="padding:0">
                <table style="width:100%;border-collapse:collapse">
                    <tbody>
                        @foreach ($order->orderItems as $item)
                            @php
                                $isProduk = (bool) $item->produk_id;
                                $nama = $isProduk ? ($item->produk->nama_produk ?? 'Produk') : ($item->layanan->nama_layanan ?? 'Layanan');
                                $foto = $isProduk
                                    ? ($item->produk?->foto ? asset('storage/img-produk/'.$item->produk->foto) : asset('image/img-default.jpg'))
                                    : ($item->layanan?->foto ? asset('storage/img-layanan/'.$item->layanan->foto) : asset('image/img-default.jpg'));
                            @endphp
                            <tr class="cart-row" id="cart-row-{{ $item->id }}" style="border-bottom:1px solid var(--c-line)">
                                <td style="padding:var(--sp-4)">
                                    <div style="display:flex;gap:var(--sp-4);align-items:center">
                                        <img src="{{ $foto }}" alt="" style="width:64px;height:64px;object-fit:cover;border-radius:var(--radius)">
                                        <div>
                                            <div style="font-family:var(--font-display);text-transform:uppercase">{{ $nama }}</div>
                                            <span class="st-muted" style="font-size:var(--fs-xs)">
                                                <i class="bi {{ $isProduk ? 'bi-bag' : 'bi-scissors' }}"></i> {{ $isProduk ? 'Produk' : 'Layanan' }}
                                                &middot; Rp {{ number_format($item->harga, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td style="padding:var(--sp-4);width:140px">
                                    <form action="{{ route('booking.update', $item->id) }}" method="POST" style="display:flex;gap:var(--sp-2)">
                                        @csrf
                                        <input type="number" name="qty" value="{{ $item->qty }}" min="1" class="input" style="width:70px;padding:.4em .5em">
                                        <button class="btn btn--outline btn--sm" title="Perbarui"><i class="bi bi-arrow-repeat"></i></button>
                                    </form>
                                </td>
                                <td style="padding:var(--sp-4);text-align:right;white-space:nowrap">
                                    <div class="card__price" style="font-size:var(--fs-lg)">Rp {{ number_format($item->qty * $item->harga, 0, ',', '.') }}</div>
                                </td>
                                <td style="padding:var(--sp-4);width:50px">
                                    <form action="{{ route('booking.remove', $item->id) }}" method="POST" class="js-remove-form" data-row="cart-row-{{ $item->id }}">
                                        @csrf
                                        <button class="btn btn--ghost" title="Hapus" style="color:var(--c-danger)"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pay-card">
                <h3 class="card__title" style="margin-bottom:var(--sp-4)">Ringkasan</h3>
                <div class="pay-summary__row"><span>Jumlah item</span><span id="sumCount">{{ $order->orderItems->sum('qty') }}</span></div>
                <div class="pay-summary__total"><b>Total</b><b id="sumTotal">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</b></div>
                <div style="margin-top:var(--sp-5);display:flex;flex-direction:column;gap:var(--sp-3)">
                    <x-button :href="route('booking.checkout')" block><i class="bi bi-arrow-right-circle"></i> Lanjut ke Checkout</x-button>
                    <x-button :href="route('front.catalog')" variant="outline" block>Tambah Item</x-button>
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
            fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(data => {
                if (row) {
                    row.classList.add('cart-row--drop');
                    setTimeout(() => {
                        row.remove();
                        const c = document.getElementById('sumCount'); if (c) c.textContent = data.count;
                        const t = document.getElementById('sumTotal'); if (t) t.textContent = data.total;
                        if (window.updateCartBadge) window.updateCartBadge(data.count);
                        if (data.empty) window.location.reload(); // tampilkan state kosong
                    }, 420);
                }
            })
            .catch(() => form.submit());
        });
    });
</script>
@endpush
@endsection
