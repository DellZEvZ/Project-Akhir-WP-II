@extends('backend.v_layouts.app')

@section('breadcrumb')
<h4 class="page-title">Manajemen Booking</h4>
<div class="ml-auto">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('backend.beranda') }}">Home</a></li>
            <li class="breadcrumb-item active">Booking</li>
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

<!-- Stat ringkas -->
<div class="row">
    <div class="col-md-3 mb-3">
        <div class="card text-white" style="background:linear-gradient(135deg,#b8860b,#daa520);">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div><h6 class="mb-1 text-white-50">Dikonfirmasi</h6><h3 class="mb-0">{{ $stats['confirmed'] }}</h3></div>
                <i class="mdi mdi-calendar-clock" style="font-size:38px;opacity:.4;"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-white" style="background:linear-gradient(135deg,#1a6b3c,#27ae60);">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div><h6 class="mb-1 text-white-50">Selesai</h6><h3 class="mb-0">{{ $stats['done'] }}</h3></div>
                <i class="mdi mdi-check-circle" style="font-size:38px;opacity:.4;"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-white" style="background:linear-gradient(135deg,#1f6f8b,#2e9bbd);">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div><h6 class="mb-1 text-white-50">Perlu Verifikasi</h6><h3 class="mb-0">{{ $stats['verifikasi'] }}</h3></div>
                <i class="mdi mdi-cash-clock" style="font-size:38px;opacity:.4;"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-white" style="background:linear-gradient(135deg,#1a1a2e,#3a3a5e);">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div><h6 class="mb-1 text-white-50">Pendapatan</h6><h4 class="mb-0">Rp {{ number_format($stats['pendapatan'], 0, ',', '.') }}</h4></div>
                <i class="mdi mdi-cash-multiple" style="font-size:38px;opacity:.4;"></i>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('backend.order.index') }}" method="GET" class="row mb-3">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control" placeholder="Cari nama / email customer..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-control" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                    <option value="done" {{ request('status') == 'done' ? 'selected' : '' }}>Selesai</option>
                    <option value="batal" {{ request('status') == 'batal' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary btn-block" type="submit"><i class="mdi mdi-magnify"></i> Cari</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('backend.order.index') }}" class="btn btn-secondary btn-block">Reset</a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Customer</th>
                        <th>Jenis</th>
                        <th>Item</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Bayar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>
                            <strong>{{ $order->customer->nama ?? '-' }}</strong><br>
                            <small class="text-muted">{{ $order->customer->email ?? '' }}</small>
                        </td>
                        <td>
                            @if ($order->jenis === 'produk')
                                <span class="badge badge-dark">Produk</span>
                            @else
                                <span class="badge badge-secondary">Booking</span>
                            @endif
                        </td>
                        <td>{{ $order->orderItems->count() }} item</td>
                        <td>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                        <td>
                            @if ($order->status == 'confirmed')
                                <span class="badge badge-warning">Dikonfirmasi</span>
                            @elseif ($order->status == 'done')
                                <span class="badge badge-success">Selesai</span>
                            @elseif ($order->status == 'batal')
                                <span class="badge badge-danger">Dibatalkan</span>
                            @endif
                        </td>
                        <td>
                            @if ($order->status_bayar == 'lunas')
                                <span class="badge badge-success">Lunas</span>
                            @elseif ($order->status_bayar == 'menunggu_verifikasi')
                                <span class="badge badge-info">Verifikasi</span>
                            @else
                                <span class="badge badge-light">Belum</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('backend.order.show', $order->id) }}" class="btn btn-sm btn-info" title="Detail">
                                <i class="mdi mdi-eye"></i>
                            </a>
                            @if ($order->status == 'confirmed')
                                <form action="{{ route('backend.order.status', $order->id) }}" method="POST" class="d-inline">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="status" value="done">
                                    <button class="btn btn-sm btn-success" title="Tandai Selesai"><i class="mdi mdi-check"></i></button>
                                </form>
                                <form action="{{ route('backend.order.status', $order->id) }}" method="POST" class="d-inline">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="status" value="batal">
                                    <button class="btn btn-sm btn-danger" title="Batalkan"><i class="mdi mdi-close"></i></button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <i class="mdi mdi-calendar-blank" style="font-size:48px;color:#ccc;"></i>
                            <p class="mt-2 text-muted">Belum ada pesanan</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $orders->links() }}</div>
    </div>
</div>
@endsection
