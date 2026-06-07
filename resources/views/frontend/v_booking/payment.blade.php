@extends('frontend.v_layouts.app')
@section('title', 'Pembayaran')

@section('content')
<section class="py-5" style="background:#f4f4f4;min-height:70vh;">
    <div class="container">
        <h3 class="font-head mb-4">PEMBAYARAN</h3>
        <div class="row g-4">
            <!-- Form pembayaran -->
            <div class="col-md-7">
                <div class="card card-bf">
                    <div class="card-body p-4">
                        <form action="{{ route('booking.pay', $order->id) }}" method="POST" enctype="multipart/form-data" id="payForm">
                            @csrf

                            @if ($order->jenis === 'produk')
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Alamat Pengiriman <span class="text-danger">*</span></label>
                                <textarea name="alamat_kirim" class="form-control @error('alamat_kirim') is-invalid @enderror" rows="2"
                                          placeholder="Alamat lengkap penerima" required>{{ old('alamat_kirim') }}</textarea>
                                @error('alamat_kirim')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                            <hr>
                            @endif

                            <label class="form-label small fw-bold">Metode Pembayaran <span class="text-danger">*</span></label>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input metode" type="radio" name="metode_bayar" id="m_transfer" value="transfer" checked>
                                    <label class="form-check-label" for="m_transfer"><i class="bi bi-bank text-gold"></i> Transfer Bank</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input metode" type="radio" name="metode_bayar" id="m_ewallet" value="ewallet">
                                    <label class="form-check-label" for="m_ewallet"><i class="bi bi-wallet2 text-gold"></i> E-Wallet (OVO / GoPay / Dana)</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input metode" type="radio" name="metode_bayar" id="m_cash" value="cash">
                                    <label class="form-check-label" for="m_cash"><i class="bi bi-cash text-gold"></i> Bayar di Tempat (Cash)</label>
                                </div>
                            </div>

                            <!-- Info rekening (transfer/ewallet) -->
                            <div id="infoBayar" class="alert alert-secondary small">
                                <div id="infoTransfer">
                                    <strong>Transfer ke:</strong><br>
                                    BCA <strong>1234567890</strong> a.n. Barber Flow<br>
                                    Mandiri <strong>0980980980</strong> a.n. Barber Flow
                                </div>
                                <div id="infoEwallet" style="display:none;">
                                    <strong>E-Wallet:</strong><br>
                                    OVO / GoPay / Dana: <strong>0812-3456-7890</strong> (Barber Flow)
                                </div>
                            </div>

                            <!-- Upload bukti -->
                            <div class="mb-3" id="buktiWrap">
                                <label class="form-label small fw-bold">Upload Bukti Pembayaran <span class="text-danger">*</span></label>
                                <input type="file" name="bukti" class="form-control @error('bukti') is-invalid @enderror" accept="image/*">
                                @error('bukti')<small class="text-danger">{{ $message }}</small>@enderror
                                <small class="text-muted">Format JPG/PNG, maks 2MB.</small>
                            </div>

                            <div id="infoCash" class="alert alert-info small" style="display:none;">
                                <i class="bi bi-info-circle"></i> Pembayaran dilakukan langsung di tempat saat kedatangan.
                            </div>

                            <button type="submit" class="btn btn-gold btn-lg w-100"><i class="bi bi-check-circle"></i> Konfirmasi Pembayaran</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Ringkasan -->
            <div class="col-md-5">
                <div class="card card-bf">
                    <div class="card-body p-4">
                        <h5 class="font-head mb-3">Ringkasan Pesanan</h5>
                        <p class="small text-muted mb-2">
                            <span class="badge bg-dark-bf text-gold">{{ $order->jenis === 'produk' ? 'Pembelian Produk' : 'Booking Layanan' }}</span>
                        </p>
                        @foreach ($order->orderItems as $item)
                        <div class="d-flex justify-content-between mb-2">
                            <span class="small">
                                {{ $item->layanan->nama_layanan ?? $item->produk->nama_produk ?? 'Item' }}
                                <span class="text-muted">x{{ $item->qty }}</span>
                            </span>
                            <span class="small">Rp {{ number_format($item->qty * $item->harga, 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                        @if ($order->jenis === 'booking')
                        <hr>
                        <p class="small mb-1"><i class="bi bi-calendar text-gold"></i> {{ $order->tanggal_booking?->format('d M Y') }}</p>
                        <p class="small mb-0"><i class="bi bi-clock text-gold"></i> {{ $order->jam_booking ? \Carbon\Carbon::parse($order->jam_booking)->format('H:i') : '-' }} WIB</p>
                        @endif
                        <hr>
                        <div class="d-flex justify-content-between">
                            <strong>Total</strong>
                            <strong class="price-tag">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    function updateMetode() {
        const val = document.querySelector('input[name="metode_bayar"]:checked').value;
        const isCash = val === 'cash';
        document.getElementById('buktiWrap').style.display = isCash ? 'none' : 'block';
        document.getElementById('infoBayar').style.display = isCash ? 'none' : 'block';
        document.getElementById('infoCash').style.display = isCash ? 'block' : 'none';
        document.getElementById('infoTransfer').style.display = val === 'transfer' ? 'block' : 'none';
        document.getElementById('infoEwallet').style.display = val === 'ewallet' ? 'block' : 'none';
    }
    document.querySelectorAll('.metode').forEach(r => r.addEventListener('change', updateMetode));
    updateMetode();
</script>
@endpush
@endsection
