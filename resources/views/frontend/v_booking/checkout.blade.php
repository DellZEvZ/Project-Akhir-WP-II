@extends('frontend.v_layouts.app')
@section('title', 'Checkout')

@section('content')
<section class="py-5" style="background:#f4f4f4;min-height:70vh;">
    <div class="container">
        <h3 class="font-head mb-4">CHECKOUT</h3>
        <form action="{{ route('booking.confirm') }}" method="POST">
            @csrf
            <div class="row g-4">
                <div class="col-md-7">
                    <div class="card card-bf">
                        <div class="card-body p-4">
                            @if ($order->has_layanan)
                                <h5 class="font-head mb-3"><i class="bi bi-calendar-check text-gold"></i> Jadwal Kunjungan</h5>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label small">Tanggal <span class="text-danger">*</span></label>
                                        <input type="date" id="tanggal_booking" name="tanggal_booking" class="form-control @error('tanggal_booking') is-invalid @enderror"
                                               min="{{ date('Y-m-d') }}" value="{{ old('tanggal_booking') }}" required>
                                        @error('tanggal_booking')<small class="text-danger">{{ $message }}</small>@enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label small">Jam (09.00–21.00) <span class="text-danger">*</span></label>
                                        <input type="time" id="jam_booking" name="jam_booking" class="form-control" min="09:00" max="21:00" value="{{ old('jam_booking') }}" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label small">Pilih Barber <span class="text-danger">*</span></label>
                                        <select name="barber_id" class="form-select @error('barber_id') is-invalid @enderror" required>
                                            <option value="">-- Pilih Barber --</option>
                                            @foreach ($barbers as $barber)
                                                <option value="{{ $barber->id }}" {{ old('barber_id') == $barber->id ? 'selected' : '' }}>
                                                    {{ $barber->nama }} ({{ $barber->spesialisasi }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('barber_id')<small class="text-danger">{{ $message }}</small>@enderror
                                    </div>
                                </div>
                                <div id="slotInfo" class="small mb-3"></div>
                            @endif

                            @if ($order->has_produk)
                                <h5 class="font-head mb-3 {{ $order->has_layanan ? 'mt-2' : '' }}"><i class="bi bi-truck text-gold"></i> Alamat Pengiriman</h5>
                                <div class="mb-3">
                                    <textarea name="alamat_kirim" class="form-control @error('alamat_kirim') is-invalid @enderror" rows="2"
                                              placeholder="Alamat lengkap penerima" required>{{ old('alamat_kirim') }}</textarea>
                                    @error('alamat_kirim')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                            @endif

                            <div class="mb-3">
                                <label class="form-label small">Catatan (opsional)</label>
                                <textarea name="catatan" class="form-control" rows="2" placeholder="Permintaan khusus, gaya rambut, dll.">{{ old('catatan') }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-gold btn-lg w-100"><i class="bi bi-credit-card"></i> Lanjut ke Pembayaran</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="card card-bf">
                        <div class="card-body p-4">
                            <h5 class="font-head mb-3">Ringkasan</h5>
                            @foreach ($order->orderItems as $item)
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="small">{{ $item->layanan->nama_layanan ?? $item->produk->nama_produk ?? 'Item' }} <span class="text-muted">x{{ $item->qty }}</span></span>
                                    <span class="small">Rp {{ number_format($item->qty * $item->harga, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                            <hr>
                            <div class="d-flex justify-content-between"><strong>Total</strong><strong class="price-tag">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</strong></div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

@push('scripts')
<script>
    const tgl = document.getElementById('tanggal_booking');
    const jam = document.getElementById('jam_booking');
    const info = document.getElementById('slotInfo');
    let takenSlots = [];

    async function loadSlots() {
        if (!tgl || !tgl.value || !info) return;
        try {
            const res = await fetch('{{ route('booking.slots') }}?tanggal=' + tgl.value, { headers: { 'Accept': 'application/json' } });
            takenSlots = (await res.json()).taken || [];
            info.innerHTML = takenSlots.length
                ? '<span class="text-danger"><i class="bi bi-exclamation-circle"></i> Jam penuh pada tanggal ini: <strong>' + takenSlots.join(', ') + '</strong></span>'
                : '<span class="text-success"><i class="bi bi-check-circle"></i> Semua jam masih tersedia.</span>';
            checkJam();
        } catch (e) {}
    }
    function checkJam() {
        if (!jam || !jam.value) return;
        if (takenSlots.includes(jam.value)) {
            info.innerHTML = '<span class="text-danger"><i class="bi bi-x-circle"></i> Jam <strong>' + jam.value + '</strong> sudah dibooking pelanggan lain. Pilih jam lain.</span>';
            jam.setCustomValidity('Jam sudah penuh');
        } else {
            jam.setCustomValidity('');
        }
    }
    tgl?.addEventListener('change', loadSlots);
    jam?.addEventListener('input', checkJam);
    loadSlots();
</script>
@endpush
@endsection
