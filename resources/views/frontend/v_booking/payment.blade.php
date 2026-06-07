@extends('frontend.v_layouts.app')
@section('title', 'Pembayaran')

@section('content')
<section class="st-section" style="background:var(--c-surface);min-height:70vh">
    <div class="st-container">
        <h1 class="st-head__title" style="margin-bottom:var(--sp-6)">Pembayaran</h1>

        <form action="{{ route('booking.pay', $order->id) }}" method="POST">
            @csrf
            <input type="hidden" name="metode_bayar" id="metodeField" value="transfer">

            <div class="pay-wrap">
                {{-- Panel metode --}}
                <div class="pay-card">
                    <div class="pay-tabs">
                        <button type="button" class="pay-tabbtn is-active" data-pane="transfer" data-metode="transfer"><i class="bi bi-bank"></i> Transfer Bank</button>
                        <button type="button" class="pay-tabbtn" data-pane="ewallet" data-metode="ewallet"><i class="bi bi-wallet2"></i> E-Wallet</button>
                        <button type="button" class="pay-tabbtn" data-pane="cash" data-metode="cash"><i class="bi bi-cash-coin"></i> Bayar di Tempat</button>
                    </div>

                    {{-- Transfer Bank --}}
                    <div class="pay-pane is-active" id="pane-transfer">
                        <div class="pay-channels">
                            @foreach ([['BCA','logo-bca','8800 1234 5678'],['BNI','logo-bni','9880 1234 5678'],['Mandiri','logo-mandiri','7000 1234 5678'],['BRI','logo-bri','0023 1234 5678']] as $b)
                            <label class="pay-channel">
                                <input type="radio" name="kanal_bayar" value="{{ $b[0] }}" data-group="transfer" @if($loop->first) checked @endif>
                                <span class="pay-channel__logo {{ $b[1] }}">{{ $b[0] }}</span>
                                <span><span class="pay-channel__name">Bank {{ $b[0] }}</span><br><span class="pay-channel__no">VA {{ $b[2] }}</span></span>
                            </label>
                            @endforeach
                        </div>
                        <div class="pay-note"><i class="bi bi-info-circle"></i> Transfer ke Virtual Account di atas. <strong>Simulasi:</strong> klik "Bayar Sekarang" untuk menandai lunas otomatis.</div>
                    </div>

                    {{-- E-Wallet --}}
                    <div class="pay-pane" id="pane-ewallet">
                        <div class="pay-channels">
                            @foreach ([['OVO','logo-ovo'],['DANA','logo-dana'],['GoPay','logo-gopay'],['ShopeePay','logo-shopee']] as $w)
                            <label class="pay-channel">
                                <input type="radio" name="kanal_bayar" value="{{ $w[0] }}" data-group="ewallet">
                                <span class="pay-channel__logo {{ $w[1] }}">{{ Str::limit($w[0],4,'') }}</span>
                                <span><span class="pay-channel__name">{{ $w[0] }}</span><br><span class="pay-channel__no">0812-3456-7890</span></span>
                            </label>
                            @endforeach
                        </div>
                        <div class="pay-note"><i class="bi bi-phone"></i> Bayar via e-wallet ke nomor terdaftar. <strong>Simulasi</strong> pembayaran berhasil seketika.</div>
                    </div>

                    {{-- Cash --}}
                    <div class="pay-pane" id="pane-cash">
                        <div class="pay-note" style="background:var(--c-primary-050);color:var(--c-ink)">
                            <i class="bi bi-shop"></i> Pembayaran tunai dilakukan langsung saat kedatangan (layanan) atau penerimaan (produk). Pesanan tetap dikonfirmasi.
                        </div>
                    </div>

                    <x-button type="submit" size="lg" block style="margin-top:var(--sp-5)"><i class="bi bi-shield-check"></i> Bayar Sekarang</x-button>
                </div>

                {{-- Ringkasan --}}
                <div class="pay-card">
                    <h3 class="card__title" style="margin-bottom:var(--sp-4)">Ringkasan Pesanan</h3>
                    @foreach ($order->orderItems as $item)
                        <div class="pay-summary__row">
                            <span>{{ $item->layanan->nama_layanan ?? $item->produk->nama_produk ?? 'Item' }} <span class="st-muted">x{{ $item->qty }}</span></span>
                            <span>Rp {{ number_format($item->qty * $item->harga, 0, ',', '.') }}</span>
                        </div>
                    @endforeach

                    @if ($order->tanggal_booking)
                        <p class="st-muted" style="font-size:var(--fs-sm);margin-top:var(--sp-3)">
                            <i class="bi bi-calendar"></i> {{ $order->tanggal_booking->format('d M Y') }}
                            <i class="bi bi-clock" style="margin-left:var(--sp-3)"></i> {{ $order->jam_booking ? \Carbon\Carbon::parse($order->jam_booking)->format('H:i') : '-' }} WIB
                        </p>
                    @endif
                    @if ($order->alamat_kirim)
                        <p class="st-muted" style="font-size:var(--fs-sm)"><i class="bi bi-geo-alt"></i> {{ $order->alamat_kirim }}</p>
                    @endif

                    <div class="pay-summary__total"><b>Total Bayar</b><b>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</b></div>
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
            document.querySelectorAll('.pay-tabbtn').forEach(b => b.classList.toggle('is-active', b === btn));
            document.querySelectorAll('.pay-pane').forEach(p => p.classList.toggle('is-active', p.id === 'pane-' + pane));
            metodeField.value = btn.dataset.metode;
            // pilih channel pertama pada grup aktif (selain cash)
            if (pane !== 'cash') {
                const first = document.querySelector('#pane-' + pane + ' input[type=radio]');
                if (first && !document.querySelector('input[data-group=' + pane + ']:checked')) first.checked = true;
            }
        });
    });
</script>
@endpush
@endsection
