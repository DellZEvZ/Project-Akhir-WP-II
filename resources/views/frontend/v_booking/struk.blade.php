@extends('frontend.v_layouts.app')
@section('title', 'Struk Pembayaran')

@section('content')
<section class="py-5" style="background:#f4f4f4;min-height:80vh;">
    <div class="container">
        <div class="struk">
            <div class="struk-head">
                <h4 class="font-head mb-0"><i class="bi bi-scissors text-gold"></i> BARBER<span class="text-gold">FLOW</span></h4>
                <small class="text-muted">Men's Grooming &amp; Barbershop</small><br>
                @if ($order->status_bayar === 'lunas')
                    <span class="struk-paid">&#10003; Lunas</span>
                @else
                    <span class="struk-paid" style="border-color:#c9821f;color:#c9821f;">Belum Dibayar</span>
                @endif
            </div>

            <div class="struk-row"><span>No. Struk</span><span>{{ $order->no_ref ?? '—' }}</span></div>
            <div class="struk-row"><span>Order ID</span><span>#{{ $order->id }}</span></div>
            <div class="struk-row"><span>Tanggal</span><span>{{ ($order->dibayar_pada ?? $order->created_at)->format('d M Y H:i') }}</span></div>
            <div class="struk-row"><span>Pelanggan</span><span>{{ $order->customer->nama ?? '-' }}</span></div>
            <div class="struk-row"><span>Metode</span><span>{{ $order->kanal_bayar ?? ucfirst($order->metode_bayar ?? '-') }}</span></div>
            @if ($order->tanggal_booking)
                <div class="struk-row"><span>Jadwal</span><span>{{ $order->tanggal_booking->format('d M Y') }} {{ $order->jam_booking ? \Carbon\Carbon::parse($order->jam_booking)->format('H:i') : '' }}</span></div>
            @endif

            <div class="struk-items">
                @foreach ($order->orderItems as $item)
                    <div class="struk-row mb-1">
                        <span>{{ $item->layanan->nama_layanan ?? $item->produk->nama_produk ?? 'Item' }} x{{ $item->qty }}</span>
                        <span>Rp {{ number_format($item->qty * $item->harga, 0, ',', '.') }}</span>
                    </div>
                @endforeach
                @if ($order->biaya_ongkir > 0)
                    <div class="struk-row mb-1">
                        <span>Ongkos Kirim ({{ $order->kurir }} {{ $order->layanan_ongkir }})</span>
                        <span>{{ $order->biaya_ongkir_format }}</span>
                    </div>
                @endif
            </div>

            <div class="struk-row" style="font-size:18px;font-weight:700;">
                <span>TOTAL</span><span class="text-gold">Rp {{ number_format($order->total_akhir, 0, ',', '.') }}</span>
            </div>

            @if ($order->alamat_kirim)
                <div class="struk-row mt-2"><span>Kirim ke</span><span style="text-align:right;max-width:60%;">{{ $order->alamat_kirim }}@if($order->kota_tujuan_label), {{ $order->kota_tujuan_label }}@endif</span></div>
            @endif

            @if ($order->status_bayar === 'lunas')
                <div class="text-center mt-3 pt-3" style="border-top:2px dashed #e0e0e0;">
                    <div id="qrcode" style="display:inline-block"></div>
                    <div class="text-muted small mt-2">Scan QR ini di kasir untuk verifikasi pembayaran</div>
                </div>
            @endif

            <p class="text-center text-muted small mt-3 mb-0" style="border-top:2px dashed #e0e0e0;padding-top:14px;">
                Terima kasih telah mempercayai Barber Flow.<br>Tunjukkan struk ini sebagai bukti pembayaran.
            </p>
        </div>

        <div class="text-center mt-4 struk-actions">
            <button onclick="window.print()" class="btn btn-outline-gold"><i class="bi bi-printer"></i> Cetak Struk</button>
            <a href="{{ route('customer.akun') }}" class="btn btn-gold"><i class="bi bi-person"></i> Ke Riwayat</a>
        </div>
    </div>
</section>

@if ($order->status_bayar === 'lunas')
@push('scripts')
<script src="https://cdn.jsdelivr.net/gh/davidshimjs/qrcodejs/qrcode.min.js"></script>
<script>
    (function () {
        const el = document.getElementById('qrcode');
        if (!el || typeof QRCode === 'undefined') return;
        new QRCode(el, {
            text: @json('BARBERFLOW|order:'.$order->id.'|ref:'.($order->no_ref ?? '-').'|total:'.$order->total_akhir),
            width: 150, height: 150, colorDark: '#161616', colorLight: '#ffffff',
            correctLevel: QRCode.CorrectLevel.M
        });
    })();
</script>
@endpush
@endif
@endsection
