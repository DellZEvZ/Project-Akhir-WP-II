@extends('frontend.v_layouts.app')
@section('title', 'Keranjang Booking')

@section('content')
<section class="py-5" style="background:#f4f4f4;min-height:70vh;">
    <div class="container">
        <h3 class="font-head mb-4">KERANJANG BOOKING</h3>

        @if ($order->orderItems->isEmpty())
            <div class="card card-bf">
                <div class="card-body text-center py-5">
                    <i class="bi bi-calendar-x text-muted" style="font-size:60px;"></i>
                    <p class="mt-3 text-muted">Keranjang booking masih kosong.</p>
                    <a href="{{ route('front.layanan') }}" class="btn btn-gold">Pilih Layanan</a>
                </div>
            </div>
        @else
        <div class="row g-4">
            <div class="col-md-8">
                <div class="card card-bf">
                    <div class="card-body">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr class="text-uppercase small text-muted">
                                    <th>Layanan</th>
                                    <th width="120">Harga</th>
                                    <th width="130">Jumlah</th>
                                    <th width="120">Subtotal</th>
                                    <th width="50"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->orderItems as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if ($item->layanan && $item->layanan->foto)
                                                <img src="{{ asset('storage/img-layanan/' . $item->layanan->foto) }}" width="50" height="50" class="rounded me-2" style="object-fit:cover;">
                                            @else
                                                <span class="bg-dark-bf rounded d-inline-flex align-items-center justify-content-center me-2" style="width:50px;height:50px;"><i class="bi bi-scissors text-gold"></i></span>
                                            @endif
                                            <span class="font-head">{{ $item->layanan->nama_layanan ?? 'Layanan' }}</span>
                                        </div>
                                    </td>
                                    <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                    <td>
                                        <form action="{{ route('booking.update', $item->id) }}" method="POST" class="d-flex">
                                            @csrf
                                            <input type="number" name="qty" value="{{ $item->qty }}" min="1" class="form-control form-control-sm" style="width:60px;">
                                            <button class="btn btn-sm btn-outline-secondary ms-1"><i class="bi bi-arrow-repeat"></i></button>
                                        </form>
                                    </td>
                                    <td class="price-tag">Rp {{ number_format($item->qty * $item->harga, 0, ',', '.') }}</td>
                                    <td>
                                        <form action="{{ route('booking.remove', $item->id) }}" method="POST">
                                            @csrf
                                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-bf">
                    <div class="card-body">
                        <h5 class="font-head mb-3">Ringkasan</h5>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Total Layanan</span>
                            <span>{{ $order->orderItems->count() }} item</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <strong>Total Harga</strong>
                            <strong class="price-tag">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</strong>
                        </div>
                        <a href="{{ route('booking.checkout') }}" class="btn btn-gold w-100"><i class="bi bi-calendar-check"></i> Lanjut Booking</a>
                        <a href="{{ route('front.layanan') }}" class="btn btn-outline-secondary w-100 mt-2">Tambah Layanan</a>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>
@endsection
