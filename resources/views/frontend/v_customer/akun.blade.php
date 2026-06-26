@extends('frontend.v_layouts.app')
@section('title', 'Akun Saya')

@section('content')
<section class="py-5" style="background:#f4f4f4;">
    <div class="container">
        <div class="row g-4">
            <!-- Profil -->
            <div class="col-md-4">
                <div class="card card-bf">
                    <div class="card-body text-center p-4">
                        @if ($customer->foto && !Str::startsWith($customer->foto, 'http'))
                            <img src="{{ asset('storage/img-customer/' . $customer->foto) }}" class="rounded-circle mb-3" width="100" height="100" style="object-fit:cover;">
                        @elseif ($customer->foto)
                            <img src="{{ $customer->foto }}" class="rounded-circle mb-3" width="100" height="100" style="object-fit:cover;">
                        @else
                            <div class="rounded-circle bg-dark-bf d-inline-flex align-items-center justify-content-center mb-3" style="width:100px;height:100px;">
                                <i class="bi bi-person text-gold" style="font-size:48px;"></i>
                            </div>
                        @endif
                        <h5 class="font-head mb-0">{{ $customer->nama }}</h5>
                        <p class="text-muted small mb-3">{{ $customer->email }}</p>
                        <form action="{{ route('customer.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm w-100"><i class="bi bi-box-arrow-right"></i> Keluar / Logout</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Form edit + riwayat -->
            <div class="col-md-8">
                <div class="card card-bf mb-4">
                    <div class="card-body p-4">
                        <h5 class="font-head mb-3">Edit Profil</h5>
                        <form action="{{ route('customer.akun.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small">Nama</label>
                                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $customer->nama) }}" required>
                                    @error('nama')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small">No. HP</label>
                                    <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp', $customer->no_hp) }}" placeholder="08xxxxxxxxxx">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small">Alamat</label>
                                <textarea name="alamat" class="form-control" rows="2" placeholder="Alamat lengkap">{{ old('alamat', $customer->alamat) }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small">Foto Profil</label>
                                <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/*">
                                @error('foto')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                            <button type="submit" class="btn btn-gold"><i class="bi bi-save"></i> Simpan Perubahan</button>
                        </form>
                    </div>
                </div>

                <!-- Riwayat Booking -->
                <div class="card card-bf">
                    <div class="card-body p-4">
                        <h5 class="font-head mb-3">Riwayat Booking</h5>
                        @forelse ($orders as $order)
                        <div class="border rounded p-3 mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <strong>{{ $order->jenis === 'produk' ? 'Pesanan' : 'Booking' }} #{{ $order->id }}</strong>
                                    <span class="badge {{ $order->status == 'done' ? 'bg-success' : ($order->status == 'confirmed' ? 'bg-warning text-dark' : 'bg-secondary') }}">
                                        {{ $order->status_label }}
                                    </span>
                                    <span class="badge {{ $order->status_bayar == 'lunas' ? 'bg-success' : ($order->status_bayar == 'menunggu_verifikasi' ? 'bg-info text-dark' : 'bg-danger') }}">
                                        {{ $order->status_bayar_label }}
                                    </span>
                                </div>
                                <span class="price-tag">Rp {{ number_format($order->total_akhir, 0, ',', '.') }}</span>
                            </div>
                            @if ($order->jenis === 'booking')
                            <p class="small text-muted mb-2">
                                <i class="bi bi-calendar"></i> {{ $order->tanggal_booking?->format('d M Y') ?? '-' }}
                                <i class="bi bi-clock ms-2"></i> {{ $order->jam_booking ? \Carbon\Carbon::parse($order->jam_booking)->format('H:i') : '-' }}
                            </p>
                            @endif
                            <ul class="list-unstyled small mb-0">
                                @foreach ($order->orderItems as $item)
                                <li>
                                    <i class="bi {{ $item->produk_id ? 'bi-bag' : 'bi-scissors' }} text-gold"></i>
                                    {{ $item->layanan->nama_layanan ?? $item->produk->nama_produk ?? 'Item' }} ({{ $item->qty }}x) — Rp {{ number_format($item->harga, 0, ',', '.') }}
                                </li>
                                @endforeach
                                @if ($order->biaya_ongkir > 0)
                                <li>
                                    <i class="bi bi-truck text-gold"></i>
                                    Ongkos Kirim ({{ $order->kurir }} {{ $order->layanan_ongkir }}) — {{ $order->biaya_ongkir_format }}
                                </li>
                                @endif
                            </ul>
                            @if ($order->catatan)
                                <p class="small text-muted mt-2 mb-0"><i class="bi bi-chat-left-text"></i> {{ $order->catatan }}</p>
                            @endif
                            @if ($order->status_bayar == 'belum' && $order->metode_bayar !== 'cash')
                                <a href="{{ route('booking.payment', $order->id) }}" class="btn btn-sm btn-gold mt-2"><i class="bi bi-credit-card"></i> Bayar Sekarang</a>
                            @endif
                            @if ($order->status_bayar == 'lunas')
                                <a href="{{ route('booking.struk', $order->id) }}" class="btn btn-sm btn-outline-gold mt-2"><i class="bi bi-receipt"></i> Lihat Struk</a>
                            @endif
                        </div>
                        @empty
                        <div class="text-center py-4">
                            <i class="bi bi-calendar-x text-muted" style="font-size:40px;"></i>
                            <p class="text-muted mt-2">Belum ada riwayat pesanan.</p>
                            <a href="{{ route('front.catalog') }}" class="btn btn-gold btn-sm">Mulai Belanja</a>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
