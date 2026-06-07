@extends('frontend.v_layouts.app')
@section('title', 'Konfirmasi Booking')

@section('content')
<section class="py-5" style="background:#f4f4f4;min-height:70vh;">
    <div class="container">
        <h3 class="font-head mb-4">KONFIRMASI BOOKING</h3>
        <div class="row g-4">
            <!-- Form jadwal -->
            <div class="col-md-7">
                <div class="card card-bf">
                    <div class="card-body p-4">
                        <h5 class="font-head mb-3">Jadwal Kunjungan</h5>
                        <form action="{{ route('booking.confirm') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small">Tanggal Booking <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_booking" class="form-control @error('tanggal_booking') is-invalid @enderror"
                                           min="{{ date('Y-m-d') }}" value="{{ old('tanggal_booking') }}" required>
                                    @error('tanggal_booking')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small">Jam Booking <span class="text-danger">*</span></label>
                                    <input type="time" name="jam_booking" class="form-control @error('jam_booking') is-invalid @enderror"
                                           min="09:00" max="21:00" value="{{ old('jam_booking') }}" required>
                                    @error('jam_booking')<small class="text-danger">{{ $message }}</small>@enderror
                                    <small class="text-muted">Jam operasional 09.00 - 21.00</small>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small">Catatan (opsional)</label>
                                <textarea name="catatan" class="form-control" rows="3" placeholder="Permintaan khusus, gaya rambut, dll.">{{ old('catatan') }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-gold btn-lg w-100"><i class="bi bi-check-circle"></i> Konfirmasi Booking</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Ringkasan -->
            <div class="col-md-5">
                <div class="card card-bf">
                    <div class="card-body p-4">
                        <h5 class="font-head mb-3">Ringkasan Layanan</h5>
                        @foreach ($order->orderItems as $item)
                        <div class="d-flex justify-content-between mb-2">
                            <span class="small">{{ $item->layanan->nama_layanan ?? 'Layanan' }} <span class="text-muted">x{{ $item->qty }}</span></span>
                            <span class="small">Rp {{ number_format($item->qty * $item->harga, 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                        <hr>
                        <div class="d-flex justify-content-between">
                            <strong>Total</strong>
                            <strong class="price-tag">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</strong>
                        </div>
                        <p class="small text-muted mt-3 mb-0"><i class="bi bi-info-circle"></i> Pembayaran dilakukan langsung di tempat setelah layanan selesai.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
