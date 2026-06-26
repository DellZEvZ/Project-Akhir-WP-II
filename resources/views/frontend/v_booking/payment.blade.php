@extends('frontend.v_layouts.app')
@section('title', 'Pembayaran')

@section('content')
<section class="py-5" style="background:#f4f4f4;min-height:70vh;">
    <div class="container">
        <h3 class="font-head mb-4">PEMBAYARAN</h3>
        <form action="{{ route('booking.pay', $order->id) }}" method="POST">
            @csrf
            <input type="hidden" name="metode_bayar" id="metodeField" value="transfer">
            <div class="row g-4">
                <div class="col-md-7">
                    <div class="card card-bf">
                        <div class="card-body p-4">
                            <div class="pay-tabs">
                                <button type="button" class="pay-tabbtn active" data-pane="transfer" data-metode="transfer"><i class="bi bi-bank"></i> Transfer Bank</button>
                                <button type="button" class="pay-tabbtn" data-pane="ewallet" data-metode="ewallet"><i class="bi bi-wallet2"></i> E-Wallet</button>
                                <button type="button" class="pay-tabbtn" data-pane="cash" data-metode="cash"><i class="bi bi-cash-coin"></i> Bayar di Tempat</button>
                            </div>

                            <div class="pay-pane active" id="pane-transfer">
                                @foreach ([['BCA','bca','8800 1234 5678'],['BNI','bni','9880 1234 5678'],['Mandiri','mandiri','7000 1234 5678'],['BRI','bri','0023 1234 5678']] as $b)
                                    <label class="pay-ch">
                                        <input type="radio" name="kanal_bayar" value="{{ $b[0] }}" data-group="transfer" @if($loop->first) checked @endif>
                                        <span class="pay-logo logo-{{ $b[1] }}" id="lg-{{ $b[1] }}">{{ $b[0] }}</span>
                                        <img class="pay-logo-img" src="{{ asset('image/icon/'.$b[1].'.png') }}" alt="{{ $b[0] }}"
                                             onload="document.getElementById('lg-{{ $b[1] }}').style.display='none'" onerror="this.style.display='none'">
                                        <span><strong>Bank {{ $b[0] }}</strong><br><small class="text-muted">VA {{ $b[2] }}</small></span>
                                    </label>
                                @endforeach
                                <div class="alert alert-secondary small mb-0"><i class="bi bi-info-circle"></i> Pilih bank, lalu lanjut ke gateway pembayaran mitra (simulasi).</div>
                                <div class="d-flex gap-2 mt-3">
                                    <a href="{{ route('booking.checkout') }}" class="btn btn-outline-secondary btn-sm flex-grow-1">
                                        <i class="bi bi-arrow-left"></i> Pilih Ulang / Batal
                                    </a>
                                </div>
                            </div>

                            <div class="pay-pane" id="pane-ewallet">
                                @foreach ([['OVO','ovo'],['DANA','dana'],['GoPay','gopay'],['ShopeePay','shopeepay']] as $w)
                                    <label class="pay-ch">
                                        <input type="radio" name="kanal_bayar" value="{{ $w[0] }}" data-group="ewallet">
                                        <span class="pay-logo logo-{{ $w[1] }}" id="lg-{{ $w[1] }}">{{ Str::limit($w[0],4,'') }}</span>
                                        <img class="pay-logo-img" src="{{ asset('image/icon/'.$w[1].'.png') }}" alt="{{ $w[0] }}"
                                             onload="document.getElementById('lg-{{ $w[1] }}').style.display='none'" onerror="this.style.display='none'">
                                        <span><strong>{{ $w[0] }}</strong><br><small class="text-muted">0812-3456-7890</small></span>
                                    </label>
                                @endforeach
                                <div class="alert alert-secondary small mb-0"><i class="bi bi-phone"></i> Pilih e-wallet, lalu lanjut ke gateway pembayaran mitra (simulasi).</div>
                                <div class="d-flex gap-2 mt-3">
                                    <a href="{{ route('booking.checkout') }}" class="btn btn-outline-secondary btn-sm flex-grow-1">
                                        <i class="bi bi-arrow-left"></i> Pilih Ulang / Batal
                                    </a>
                                </div>
                            </div>

                            <div class="pay-pane" id="pane-cash">
                                <div class="alert alert-info small mb-0"><i class="bi bi-shop"></i> Pembayaran tunai dilakukan langsung saat kedatangan (layanan) atau penerimaan (produk). Pesanan tetap dikonfirmasi.</div>
                                <div class="d-flex gap-2 mt-3">
                                    <a href="{{ route('booking.checkout') }}" class="btn btn-outline-secondary btn-sm flex-grow-1">
                                        <i class="bi bi-arrow-left"></i> Pilih Ulang / Batal
                                    </a>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-gold btn-lg w-100 mt-4"><i class="bi bi-arrow-right-circle"></i> Lanjut ke Pembayaran</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="card card-bf">
                        <div class="card-body p-4">
                            <h5 class="font-head mb-3">Ringkasan Pesanan</h5>
                            @foreach ($order->orderItems as $item)
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="small">{{ $item->layanan->nama_layanan ?? $item->produk->nama_produk ?? 'Item' }} <span class="text-muted">x{{ $item->qty }}</span></span>
                                    <span class="small">Rp {{ number_format($item->qty * $item->harga, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                            @if ($order->tanggal_booking)
                                <hr>
                                <p class="small mb-1"><i class="bi bi-calendar text-gold"></i> {{ $order->tanggal_booking->format('d M Y') }}
                                    <i class="bi bi-clock text-gold ms-2"></i> {{ $order->jam_booking ? \Carbon\Carbon::parse($order->jam_booking)->format('H:i') : '-' }} WIB</p>
                            @endif
                            @if ($order->alamat_kirim)
                                <p class="small mb-0"><i class="bi bi-geo-alt text-gold"></i> {{ $order->alamat_kirim }}</p>
                            @endif
                            <hr>
                            <div class="d-flex justify-content-between"><strong>Total Bayar</strong><strong class="price-tag">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</strong></div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

@push('scripts')
<script>
    const metodeField = document.getElementById('metodeField');
    document.querySelectorAll('.pay-tabbtn').forEach(btn => {
        btn.addEventListener('click', () => {
            const pane = btn.dataset.pane;
            document.querySelectorAll('.pay-tabbtn').forEach(b => b.classList.toggle('active', b === btn));
            document.querySelectorAll('.pay-pane').forEach(p => p.classList.toggle('active', p.id === 'pane-' + pane));
            metodeField.value = btn.dataset.metode;
            if (pane !== 'cash' && !document.querySelector('input[data-group=' + pane + ']:checked')) {
                const first = document.querySelector('#pane-' + pane + ' input[type=radio]');
                if (first) first.checked = true;
            }
        });
    });
</script>
@endpush
@endsection
