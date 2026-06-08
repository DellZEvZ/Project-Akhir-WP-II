@extends('frontend.v_layouts.app')
@section('title', 'Gateway Pembayaran')

@php
    $slug = \Illuminate\Support\Str::of($order->kanal_bayar)->lower()->replace(' ', '');
    $isBank = $order->metode_bayar === 'transfer';
    $va = '8' . str_pad($order->id, 4, '0', STR_PAD_LEFT) . ' 1234 ' . str_pad($order->id * 7 % 10000, 4, '0', STR_PAD_LEFT);
@endphp

@section('content')
<section class="py-5" style="background:#ececed;min-height:80vh;">
    <div class="container" style="max-width:520px;">
        <div class="text-center mb-3">
            <span class="badge bg-dark-bf text-gold"><i class="bi bi-shield-lock"></i> Simulasi Gateway Pembayaran Mitra</span>
        </div>

        <div class="card card-bf">
            {{-- Header mitra --}}
            <div class="p-4 text-center" style="background:{{ $isBank ? '#0b1f3a' : '#2d1b4e' }};color:#fff;">
                <span class="pay-logo logo-{{ $slug }}" id="gwlogo" style="display:inline-flex;height:40px;min-width:64px;font-size:14px;">{{ Str::upper($order->kanal_bayar) }}</span>
                <img src="{{ asset('image/icon/'.$slug.'.png') }}" alt="{{ $order->kanal_bayar }}" style="height:40px;max-width:140px;object-fit:contain;background:#fff;border-radius:6px;padding:4px 8px;"
                     onload="document.getElementById('gwlogo').style.display='none'" onerror="this.style.display='none'">
                <div class="mt-2 small" style="opacity:.85;">{{ $isBank ? 'Virtual Account' : 'Pembayaran E-Wallet' }} · {{ $order->kanal_bayar }}</div>
            </div>

            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted small">Bayar ke</span>
                    <strong class="font-head">BARBER<span class="text-gold">FLOW</span></strong>
                </div>

                <div class="text-center py-2 mb-3" style="background:#f6f6f6;border-radius:10px;">
                    <div class="text-muted small">Total Pembayaran</div>
                    <div class="price-tag" style="font-size:30px;">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</div>
                </div>

                @if ($isBank)
                    <div class="mb-3">
                        <div class="text-muted small">Nomor Virtual Account</div>
                        <div class="d-flex justify-content-between align-items-center border rounded px-3 py-2">
                            <strong style="letter-spacing:1px;">{{ $va }}</strong>
                            <span class="badge bg-light text-dark">{{ Str::upper($order->kanal_bayar) }}</span>
                        </div>
                    </div>
                    <p class="small text-muted"><i class="bi bi-info-circle"></i> Transfer tepat sejumlah di atas ke Virtual Account melalui m-Banking/ATM {{ $order->kanal_bayar }}.</p>
                @else
                    <div class="mb-3">
                        <div class="text-muted small">Nomor {{ $order->kanal_bayar }} terdaftar</div>
                        <div class="border rounded px-3 py-2"><strong>0812-3456-7890</strong> &middot; Barber Flow</div>
                    </div>
                    <p class="small text-muted"><i class="bi bi-phone"></i> Buka aplikasi {{ $order->kanal_bayar }} dan setujui permintaan pembayaran.</p>
                @endif

                <div class="alert alert-warning small d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-clock-history"></i> Selesaikan dalam</span>
                    <strong id="countdown">14:59</strong>
                </div>

                {{-- Konfirmasi (simulasi berhasil) --}}
                <form action="{{ route('booking.pay.confirm', $order->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-gold btn-lg w-100" id="payBtn">
                        <i class="bi bi-check2-circle"></i> Bayar Sekarang
                    </button>
                </form>
                <a href="{{ route('booking.payment', $order->id) }}" class="btn btn-outline-secondary w-100 mt-2">Batal / Ganti Metode</a>

                <p class="text-center text-muted small mt-3 mb-0">Halaman ini hanya <strong>simulasi</strong> gateway pembayaran. Tidak ada transaksi nyata.</p>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    // Hitung mundur kosmetik
    let sisa = 15 * 60 - 1;
    const el = document.getElementById('countdown');
    const tick = setInterval(() => {
        if (sisa <= 0) { clearInterval(tick); el.textContent = '00:00'; return; }
        sisa--;
        const m = String(Math.floor(sisa / 60)).padStart(2, '0');
        const s = String(sisa % 60).padStart(2, '0');
        el.textContent = m + ':' + s;
    }, 1000);

    // Feedback "memproses" saat klik bayar
    document.getElementById('payBtn')?.closest('form')?.addEventListener('submit', function () {
        const b = document.getElementById('payBtn');
        b.disabled = true;
        b.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Memproses pembayaran...';
    });
</script>
@endpush
@endsection
