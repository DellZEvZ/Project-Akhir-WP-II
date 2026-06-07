@extends('frontend.v_layouts.app')
@section('title', 'Checkout')

@section('content')
<section class="st-section" style="background:var(--c-surface);min-height:70vh">
    <div class="st-container">
        <h1 class="st-head__title" style="margin-bottom:var(--sp-6)">Checkout</h1>

        <form action="{{ route('booking.confirm') }}" method="POST">
            @csrf
            <div class="pay-wrap">
                <div class="pay-card">
                    @if ($order->has_layanan)
                        <h3 class="card__title" style="margin-bottom:var(--sp-4)"><i class="bi bi-calendar-check"></i> Jadwal Kunjungan</h3>
                        <div class="st-grid st-grid--2" style="gap:var(--sp-4)">
                            <x-input type="date" name="tanggal_booking" label="Tanggal" :value="old('tanggal_booking')" min="{{ date('Y-m-d') }}" required />
                            <x-input type="time" name="jam_booking" label="Jam (09.00–21.00)" :value="old('jam_booking')" min="09:00" max="21:00" required />
                        </div>
                        @error('tanggal_booking')<small style="color:var(--c-danger)">{{ $message }}</small>@enderror
                    @endif

                    @if ($order->has_produk)
                        <div class="field" style="margin-top:var(--sp-5)">
                            <label class="field__label">Alamat Pengiriman</label>
                            <textarea name="alamat_kirim" class="input" rows="3" placeholder="Alamat lengkap penerima" required>{{ old('alamat_kirim') }}</textarea>
                            @error('alamat_kirim')<small style="color:var(--c-danger)">{{ $message }}</small>@enderror
                        </div>
                    @endif

                    <div class="field" style="margin-top:var(--sp-5)">
                        <label class="field__label">Catatan (opsional)</label>
                        <textarea name="catatan" class="input" rows="2" placeholder="Permintaan khusus, gaya rambut, dll.">{{ old('catatan') }}</textarea>
                    </div>
                </div>

                <div class="pay-card">
                    <h3 class="card__title" style="margin-bottom:var(--sp-4)">Ringkasan</h3>
                    @foreach ($order->orderItems as $item)
                        <div class="pay-summary__row">
                            <span>{{ $item->layanan->nama_layanan ?? $item->produk->nama_produk ?? 'Item' }} <span class="st-muted">x{{ $item->qty }}</span></span>
                            <span>Rp {{ number_format($item->qty * $item->harga, 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                    <div class="pay-summary__total"><b>Total</b><b>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</b></div>
                    <x-button type="submit" size="lg" block class="mt-3" style="margin-top:var(--sp-5)"><i class="bi bi-credit-card"></i> Lanjut ke Pembayaran</x-button>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection
