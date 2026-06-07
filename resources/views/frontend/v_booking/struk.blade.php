@extends('frontend.v_layouts.app')
@section('title', 'Struk Pembayaran')

@section('content')
<section class="struk-page">
    <div class="struk">
        <div class="struk__head">
            <div class="struk__brand">BARBER<span>FLOW</span></div>
            <div class="st-muted" style="font-size:var(--fs-xs)">Men's Grooming &amp; Barbershop</div>
            @if ($order->status_bayar === 'lunas')
                <div class="struk__paid">&#10003; Lunas</div>
            @else
                <div class="struk__paid" style="border-color:var(--c-warning);color:var(--c-warning)">Belum Dibayar</div>
            @endif
        </div>

        <div class="struk__row"><span>No. Struk</span><span>{{ $order->no_ref ?? '—' }}</span></div>
        <div class="struk__row"><span>Order ID</span><span>#{{ $order->id }}</span></div>
        <div class="struk__row"><span>Tanggal</span><span>{{ ($order->dibayar_pada ?? $order->created_at)->format('d M Y H:i') }}</span></div>
        <div class="struk__row"><span>Pelanggan</span><span>{{ $order->customer->nama ?? '-' }}</span></div>
        <div class="struk__row"><span>Metode</span><span>{{ $order->kanal_bayar ?? ucfirst($order->metode_bayar ?? '-') }}</span></div>
        @if ($order->tanggal_booking)
            <div class="struk__row"><span>Jadwal</span><span>{{ $order->tanggal_booking->format('d M Y') }} {{ $order->jam_booking ? \Carbon\Carbon::parse($order->jam_booking)->format('H:i') : '' }}</span></div>
        @endif

        <div class="struk__items">
            @foreach ($order->orderItems as $item)
                <div class="struk__item">
                    <span>{{ $item->layanan->nama_layanan ?? $item->produk->nama_produk ?? 'Item' }} x{{ $item->qty }}</span>
                    <span>Rp {{ number_format($item->qty * $item->harga, 0, ',', '.') }}</span>
                </div>
            @endforeach
        </div>

        <div class="struk__total">
            <span>TOTAL</span>
            <span>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
        </div>

        @if ($order->alamat_kirim)
            <div class="struk__row" style="margin-top:var(--sp-3)"><span>Kirim ke</span><span style="text-align:right;max-width:60%">{{ $order->alamat_kirim }}</span></div>
        @endif

        <div class="struk__foot">
            Terima kasih telah mempercayai Barber Flow.<br>Tunjukkan struk ini sebagai bukti pembayaran.
        </div>
    </div>

    <div class="struk-actions" style="text-align:center;margin-top:var(--sp-5);display:flex;gap:var(--sp-3);justify-content:center">
        <x-button onclick="window.print()" variant="outline"><i class="bi bi-printer"></i> Cetak Struk</x-button>
        <x-button :href="route('customer.akun')"><i class="bi bi-person"></i> Ke Riwayat</x-button>
    </div>
</section>
@endsection
