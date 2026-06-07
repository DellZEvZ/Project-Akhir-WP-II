@extends('backend.v_layouts.app')

@section('breadcrumb')
<h4 class="page-title">Detail Booking #{{ $order->id }}</h4>
<div class="ml-auto">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('backend.beranda') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('backend.order.index') }}">Booking</a></li>
            <li class="breadcrumb-item active">Detail</li>
        </ol>
    </nav>
</div>
@endsection

@section('content')
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="mdi mdi-check-circle"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
@endif

<div class="row">
    <!-- Info Customer & Jadwal -->
    <div class="col-md-5">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Informasi Customer</h5>
                <table class="table table-borderless table-sm">
                    <tr><th width="40%">Nama</th><td>{{ $order->customer->nama ?? '-' }}</td></tr>
                    <tr><th>Email</th><td>{{ $order->customer->email ?? '-' }}</td></tr>
                    <tr><th>No. HP</th><td>{{ $order->customer->no_hp ?? '-' }}</td></tr>
                    <tr><th>Alamat</th><td>{{ $order->customer->alamat ?? '-' }}</td></tr>
                </table>

                <hr>
                <h5 class="card-title">{{ $order->jenis === 'produk' ? 'Info Pesanan' : 'Jadwal Booking' }}</h5>
                <table class="table table-borderless table-sm">
                    <tr><th width="40%">Jenis</th><td>{{ $order->jenis === 'produk' ? 'Pembelian Produk' : 'Booking Layanan' }}</td></tr>
                    @if ($order->jenis === 'booking')
                    <tr><th>Tanggal</th><td>{{ $order->tanggal_booking?->format('d F Y') ?? '-' }}</td></tr>
                    <tr><th>Jam</th><td>{{ $order->jam_booking ? \Carbon\Carbon::parse($order->jam_booking)->format('H:i') : '-' }} WIB</td></tr>
                    @else
                    <tr><th>Alamat Kirim</th><td>{{ $order->alamat_kirim ?? '-' }}</td></tr>
                    @endif
                    <tr><th>Status</th>
                        <td>
                            @if ($order->status == 'confirmed')
                                <span class="badge badge-warning">Dikonfirmasi</span>
                            @elseif ($order->status == 'done')
                                <span class="badge badge-success">Selesai</span>
                            @elseif ($order->status == 'batal')
                                <span class="badge badge-danger">Dibatalkan</span>
                            @endif
                        </td>
                    </tr>
                    <tr><th>Catatan</th><td>{{ $order->catatan ?? '-' }}</td></tr>
                    <tr><th>Dibuat</th><td>{{ $order->created_at->format('d/m/Y H:i') }}</td></tr>
                </table>

                <hr>
                <h5 class="card-title">Pembayaran</h5>
                <table class="table table-borderless table-sm">
                    <tr><th width="40%">Metode</th><td>{{ $order->metode_bayar ? ucfirst($order->metode_bayar) : '-' }}</td></tr>
                    <tr><th>Kanal</th><td>{{ $order->kanal_bayar ?? '-' }}</td></tr>
                    <tr><th>No. Referensi</th><td><code>{{ $order->no_ref ?? '-' }}</code></td></tr>
                    <tr><th>Dibayar Pada</th><td>{{ $order->dibayar_pada ? $order->dibayar_pada->format('d/m/Y H:i') : '-' }}</td></tr>
                    <tr><th>Status Bayar</th>
                        <td>
                            @if ($order->status_bayar == 'lunas')
                                <span class="badge badge-success">Lunas</span>
                            @elseif ($order->status_bayar == 'menunggu_verifikasi')
                                <span class="badge badge-info">Menunggu Verifikasi</span>
                            @else
                                <span class="badge badge-light">Belum Bayar</span>
                            @endif
                        </td>
                    </tr>
                </table>
                @if ($order->bukti_bayar)
                    <p class="mb-1"><strong>Bukti Pembayaran:</strong></p>
                    <a href="{{ asset('storage/img-bukti/' . $order->bukti_bayar) }}" target="_blank">
                        <img src="{{ asset('storage/img-bukti/' . $order->bukti_bayar) }}" alt="Bukti" class="img-fluid rounded border" style="max-height:220px;">
                    </a>
                @endif

                @if ($order->status_bayar == 'menunggu_verifikasi')
                <div class="mt-3">
                    <form action="{{ route('backend.order.verify', $order->id) }}" method="POST" class="d-inline">
                        @csrf @method('PUT')
                        <input type="hidden" name="aksi" value="lunas">
                        <button class="btn btn-success btn-sm"><i class="mdi mdi-check-decagram"></i> Verifikasi Lunas</button>
                    </form>
                    <form action="{{ route('backend.order.verify', $order->id) }}" method="POST" class="d-inline">
                        @csrf @method('PUT')
                        <input type="hidden" name="aksi" value="tolak">
                        <button class="btn btn-outline-danger btn-sm"><i class="mdi mdi-close"></i> Tolak</button>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Layanan & Aksi -->
    <div class="col-md-7">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Item Dipesan</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr><th>Item</th><th>Harga</th><th>Qty</th><th>Subtotal</th></tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderItems as $item)
                        <tr>
                            <td>
                                @if ($item->produk_id)<span class="badge badge-dark">Produk</span>@else<span class="badge badge-secondary">Layanan</span>@endif
                                {{ $item->layanan->nama_layanan ?? $item->produk->nama_produk ?? 'Item' }}
                            </td>
                            <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                            <td>{{ $item->qty }}</td>
                            <td>Rp {{ number_format($item->qty * $item->harga, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="font-weight-bold">
                            <td colspan="3" class="text-right">Total</td>
                            <td>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>

                @if ($order->status == 'confirmed')
                <hr>
                <h6>Ubah Status</h6>
                <form action="{{ route('backend.order.status', $order->id) }}" method="POST" class="d-inline">
                    @csrf @method('PUT')
                    <input type="hidden" name="status" value="done">
                    <button class="btn btn-success"><i class="mdi mdi-check"></i> Tandai Selesai</button>
                </form>
                <form action="{{ route('backend.order.status', $order->id) }}" method="POST" class="d-inline">
                    @csrf @method('PUT')
                    <input type="hidden" name="status" value="batal">
                    <button class="btn btn-danger"><i class="mdi mdi-close"></i> Batalkan Booking</button>
                </form>
                @endif

                <a href="{{ route('backend.order.index') }}" class="btn btn-secondary float-right">
                    <i class="mdi mdi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
