@extends('backend.v_layouts.app')

@section('breadcrumb')
<h4 class="page-title">Dashboard Barbershop</h4>
<div class="ml-auto">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('backend.beranda') }}">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </nav>
</div>
@endsection

@section('content')
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    <i class="mdi mdi-check-circle"></i> {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
</div>
@endif

<style>
.stat-card { transition: transform 0.3s ease, box-shadow 0.3s ease; border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
.stat-card:hover { transform: translateY(-5px); box-shadow: 0 5px 20px rgba(0,0,0,0.2); }
.card-barber    { background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%); color: white; }
.card-layanan   { background: linear-gradient(135deg, #b8860b 0%, #daa520 100%); color: white; }
.card-galeri    { background: linear-gradient(135deg, #2c3e50 0%, #4a6fa5 100%); color: white; }
.card-produk    { background: linear-gradient(135deg, #1a6b3c 0%, #27ae60 100%); color: white; }
</style>

<!-- Stat Cards -->
<div class="row">
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card stat-card card-barber">
            <div class="card-body d-flex align-items-center justify-content-between p-4">
                <div>
                    <h6 class="mb-1 text-white-50">Total Barber</h6>
                    <h2 class="mb-0 font-weight-bold">{{ $totalBarber }}</h2>
                    <small class="text-white-50">{{ $barberAktif }} aktif bertugas</small>
                </div>
                <i class="mdi mdi-content-cut" style="font-size:48px; opacity:0.4;"></i>
            </div>
            <div class="card-footer border-0 bg-transparent pt-0 pb-3 px-4">
                <a href="{{ route('backend.barber.index') }}" class="text-white-50 small">Lihat Semua →</a>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card stat-card card-layanan">
            <div class="card-body d-flex align-items-center justify-content-between p-4">
                <div>
                    <h6 class="mb-1 text-white-50">Total Layanan</h6>
                    <h2 class="mb-0 font-weight-bold">{{ $totalLayanan }}</h2>
                    <small class="text-white-50">{{ $layananAktif }} layanan aktif</small>
                </div>
                <i class="mdi mdi-scissors-cutting" style="font-size:48px; opacity:0.4;"></i>
            </div>
            <div class="card-footer border-0 bg-transparent pt-0 pb-3 px-4">
                <a href="{{ route('backend.layanan.index') }}" class="text-white-50 small">Lihat Semua →</a>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card stat-card card-galeri">
            <div class="card-body d-flex align-items-center justify-content-between p-4">
                <div>
                    <h6 class="mb-1 text-white-50">Foto Galeri</h6>
                    <h2 class="mb-0 font-weight-bold">{{ $totalGaleri }}</h2>
                    <small class="text-white-50">hairstyle & haircut</small>
                </div>
                <i class="mdi mdi-image-multiple" style="font-size:48px; opacity:0.4;"></i>
            </div>
            <div class="card-footer border-0 bg-transparent pt-0 pb-3 px-4">
                <a href="{{ route('backend.galeri.index') }}" class="text-white-50 small">Lihat Semua →</a>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card stat-card card-produk">
            <div class="card-body d-flex align-items-center justify-content-between p-4">
                <div>
                    <h6 class="mb-1 text-white-50">Produk</h6>
                    <h2 class="mb-0 font-weight-bold">{{ $totalProduk }}</h2>
                    <small class="text-white-50">produk perawatan rambut</small>
                </div>
                <i class="mdi mdi-bottle-tonic" style="font-size:48px; opacity:0.4;"></i>
            </div>
            <div class="card-footer border-0 bg-transparent pt-0 pb-3 px-4">
                <a href="{{ route('backend.produk.index') }}" class="text-white-50 small">Lihat Semua →</a>
            </div>
        </div>
    </div>
</div>

<!-- Layanan Terbaru + Barber Aktif -->
<div class="row">
    <div class="col-md-7">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0">Layanan Terbaru</h5>
                    <a href="{{ route('backend.layanan.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead class="thead-dark">
                            <tr><th>Nama Layanan</th><th>Harga</th><th>Durasi</th><th>Status</th></tr>
                        </thead>
                        <tbody>
                            @forelse ($layananTerbaru as $l)
                            <tr>
                                <td>{{ $l->nama_layanan }}</td>
                                <td>Rp {{ number_format($l->harga, 0, ',', '.') }}</td>
                                <td>{{ $l->durasi_menit }} mnt</td>
                                <td>
                                    @if ($l->status === 'aktif')
                                        <span class="badge badge-success">Aktif</span>
                                    @else
                                        <span class="badge badge-secondary">Nonaktif</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center text-muted">Belum ada layanan</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0">Tim Barber</h5>
                    <a href="{{ route('backend.barber.index') }}" class="btn btn-sm btn-outline-dark">Lihat Semua</a>
                </div>
                @forelse ($barberTerbaru as $b)
                <div class="d-flex align-items-center mb-3">
                    @if ($b->foto)
                        <img src="{{ asset('storage/img-barber/' . $b->foto) }}"
                             class="rounded-circle mr-3" width="42" height="42" style="object-fit:cover;">
                    @else
                        <img src="{{ asset('storage/img-user/img-default.jpg') }}"
                             class="rounded-circle mr-3" width="42" height="42" style="object-fit:cover;">
                    @endif
                    <div>
                        <div class="font-weight-bold" style="font-size:14px;">{{ $b->nama }}</div>
                        <small class="text-muted">{{ $b->spesialisasi }} · {{ $b->pengalaman_tahun }} thn</small>
                    </div>
                    <span class="ml-auto badge badge-success">Aktif</span>
                </div>
                @empty
                <p class="text-muted text-center">Belum ada barber terdaftar</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Booking Terbaru -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0">
                        Booking Terbaru
                        @if ($bookingBaru > 0)
                            <span class="badge badge-warning ml-1">{{ $bookingBaru }} perlu diproses</span>
                        @endif
                    </h5>
                    <a href="{{ route('backend.order.index') }}" class="btn btn-sm btn-outline-dark">Kelola Booking</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead class="thead-dark">
                            <tr><th>#</th><th>Customer</th><th>Jadwal</th><th>Layanan</th><th>Total</th><th>Status</th></tr>
                        </thead>
                        <tbody>
                            @forelse ($bookingTerbaru as $o)
                            <tr>
                                <td>{{ $o->id }}</td>
                                <td>{{ $o->customer->nama ?? '-' }}</td>
                                <td>{{ $o->tanggal_booking?->format('d/m/Y') ?? '-' }} {{ $o->jam_booking ? \Carbon\Carbon::parse($o->jam_booking)->format('H:i') : '' }}</td>
                                <td>{{ $o->orderItems->count() }} layanan</td>
                                <td>Rp {{ number_format($o->total_harga, 0, ',', '.') }}</td>
                                <td>
                                    @if ($o->status == 'confirmed')
                                        <span class="badge badge-warning">Dikonfirmasi</span>
                                    @elseif ($o->status == 'done')
                                        <span class="badge badge-success">Selesai</span>
                                    @elseif ($o->status == 'batal')
                                        <span class="badge badge-danger">Dibatalkan</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="text-center text-muted">Belum ada booking masuk</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mt-2">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Aksi Cepat</h5>
                <a href="{{ route('backend.barber.create') }}" class="btn btn-dark mr-2 mb-2">
                    <i class="mdi mdi-account-plus"></i> Tambah Barber
                </a>
                <a href="{{ route('backend.layanan.create') }}" class="btn btn-warning mr-2 mb-2">
                    <i class="mdi mdi-plus"></i> Tambah Layanan
                </a>
                <a href="{{ route('backend.galeri.create') }}" class="btn btn-info mr-2 mb-2">
                    <i class="mdi mdi-camera-plus"></i> Upload Galeri
                </a>
                <a href="{{ route('backend.produk.create') }}" class="btn btn-success mr-2 mb-2">
                    <i class="mdi mdi-plus"></i> Tambah Produk
                </a>
                <a href="{{ route('backend.user.index') }}" class="btn btn-secondary mr-2 mb-2">
                    <i class="mdi mdi-account-supervisor"></i> Kelola User
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
