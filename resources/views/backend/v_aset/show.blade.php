@extends('backend.v_layouts.app')

@section('breadcrumb')
<h4 class="page-title">Detail Aset</h4>
<div class="ml-auto">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('backend.beranda') }}">Home</a></li>
            <li class="breadcrumb-item">Inventaris</li>
            <li class="breadcrumb-item"><a href="{{ route('backend.aset.index') }}">Aset</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail</li>
        </ol>
    </nav>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-8">
                        <h5 class="card-title">Detail Aset/Inventaris</h5>
                    </div>
                    <div class="col-md-4 text-right">
                        <a href="{{ route('backend.aset.edit', $aset->id) }}" class="btn btn-warning">
                            <i class="mdi mdi-pencil"></i> Edit
                        </a>
                        <a href="{{ route('backend.aset.index') }}" class="btn btn-secondary">
                            <i class="mdi mdi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="row">
                    <!-- Kolom Kiri - Foto dan Info Status -->
                    <div class="col-md-4">
                        <div class="text-center mb-4">
                            @if ($aset->foto_aset)
                            <img src="{{ asset('storage/img-aset/' . $aset->foto_aset) }}"
                                 alt="{{ $aset->nama_aset }}"
                                 class="rounded img-fluid"
                                 style="max-width: 300px; max-height: 300px; object-fit: cover;">
                            @else
                            <img src="{{ asset('storage/img-user/img-default.jpg') }}"
                                 alt="{{ $aset->nama_aset }}"
                                 class="rounded img-fluid"
                                 style="max-width: 300px; max-height: 300px; object-fit: cover;">
                            @endif
                        </div>

                        <div class="card border mb-3">
                            <div class="card-body">
                                <h5 class="card-title text-center mb-3">Status Aset</h5>
                                <div class="text-center mb-3">
                                    @if ($aset->status_aset == 'aktif')
                                        <span class="badge badge-success p-2" style="font-size: 14px;">
                                            <i class="mdi mdi-check-circle"></i> Aktif
                                        </span>
                                    @elseif ($aset->status_aset == 'rusak')
                                        <span class="badge badge-warning p-2" style="font-size: 14px;">
                                            <i class="mdi mdi-alert"></i> Rusak
                                        </span>
                                    @elseif ($aset->status_aset == 'hilang')
                                        <span class="badge badge-danger p-2" style="font-size: 14px;">
                                            <i class="mdi mdi-alert-circle"></i> Hilang
                                        </span>
                                    @elseif ($aset->status_aset == 'dijual')
                                        <span class="badge badge-secondary p-2" style="font-size: 14px;">
                                            <i class="mdi mdi-cash-multiple"></i> Dijual
                                        </span>
                                    @endif
                                </div>

                                <hr>

                                <div class="mb-2">
                                    <strong><i class="mdi mdi-tag text-primary"></i> Kode Aset:</strong><br>
                                    <span class="ml-4 badge badge-dark">{{ $aset->kode_aset }}</span>
                                </div>

                                <div class="mb-2">
                                    <strong><i class="mdi mdi-shape text-primary"></i> Kategori:</strong><br>
                                    <span class="ml-4">{{ $aset->kategori }}</span>
                                </div>

                                @if ($aset->lokasi)
                                <div class="mb-2">
                                    <strong><i class="mdi mdi-map-marker text-danger"></i> Lokasi:</strong><br>
                                    <span class="ml-4">{{ $aset->lokasi }}</span>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Nilai Aset -->
                        <div class="card border" style="border-left: 4px solid #667eea !important;">
                            <div class="card-body">
                                <h6 class="card-title">Nilai Aset</h6>
                                <div class="mb-2">
                                    <small class="text-muted">Harga Perolehan</small><br>
                                    <strong class="text-success">Rp {{ number_format($aset->harga_perolehan, 0, ',', '.') }}</strong>
                                </div>
                                <div class="mb-2">
                                    <small class="text-muted">Nilai Saat Ini</small><br>
                                    <strong class="text-info">Rp {{ number_format($aset->nilai_saat_ini, 0, ',', '.') }}</strong>
                                </div>
                                <hr>
                                <div>
                                    <small class="text-muted">Depresiasi</small><br>
                                    @php
                                        $depresiasi = $aset->harga_perolehan - $aset->nilai_saat_ini;
                                        $persenDepresiasi = $aset->harga_perolehan > 0 ? ($depresiasi / $aset->harga_perolehan) * 100 : 0;
                                    @endphp
                                    <strong class="text-danger">Rp {{ number_format($depresiasi, 0, ',', '.') }}</strong>
                                    <span class="badge badge-danger ml-1">{{ number_format($persenDepresiasi, 1) }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Kanan - Detail Lengkap -->
                    <div class="col-md-8">
                        <!-- Informasi Umum -->
                        <div class="card border mb-3">
                            <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <h5 class="card-title mb-0 text-white">
                                    <i class="mdi mdi-information"></i> Informasi Umum
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="text-muted small">Nama Aset</label>
                                        <p class="mb-0"><strong style="font-size: 18px;">{{ $aset->nama_aset }}</strong></p>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="text-muted small">Deskripsi</label>
                                        <p class="mb-0">
                                            @if ($aset->deskripsi)
                                                {{ $aset->deskripsi }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="text-muted small">Supplier/Pemasok</label>
                                        <p class="mb-0">
                                            @if ($aset->supplier)
                                                <i class="mdi mdi-truck"></i> {{ $aset->supplier }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="text-muted small">Tanggal Pembelian</label>
                                        <p class="mb-0">
                                            <i class="mdi mdi-calendar"></i>
                                            {{ \Carbon\Carbon::parse($aset->tanggal_pembelian)->format('d F Y') }}
                                        </p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="text-muted small">Umur Aset</label>
                                        <p class="mb-0">
                                            <i class="mdi mdi-clock-outline"></i>
                                            @php
                                                $umurAset = \Carbon\Carbon::parse($aset->tanggal_pembelian)->diff(\Carbon\Carbon::now());
                                                $tahun = $umurAset->y;
                                                $bulan = $umurAset->m;
                                            @endphp
                                            @if ($tahun > 0)
                                                {{ $tahun }} tahun
                                            @endif
                                            @if ($bulan > 0)
                                                {{ $bulan }} bulan
                                            @endif
                                            @if ($tahun == 0 && $bulan == 0)
                                                Baru dibeli
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Maintenance -->
                        <div class="card border mb-3">
                            <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <h5 class="card-title mb-0 text-white">
                                    <i class="mdi mdi-wrench"></i> Informasi Maintenance
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="text-muted small">Maintenance Terakhir</label>
                                        <p class="mb-0">
                                            @if ($aset->last_maintenance)
                                                <i class="mdi mdi-calendar-check text-success"></i>
                                                {{ \Carbon\Carbon::parse($aset->last_maintenance)->format('d F Y') }}
                                                <br>
                                                <small class="text-muted">
                                                    ({{ \Carbon\Carbon::parse($aset->last_maintenance)->diffForHumans() }})
                                                </small>
                                            @else
                                                <span class="text-muted">Belum pernah maintenance</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="text-muted small">Maintenance Berikutnya</label>
                                        <p class="mb-0">
                                            @if ($aset->next_maintenance)
                                                <i class="mdi mdi-calendar-clock text-warning"></i>
                                                {{ \Carbon\Carbon::parse($aset->next_maintenance)->format('d F Y') }}
                                                <br>
                                                <small class="text-muted">
                                                    ({{ \Carbon\Carbon::parse($aset->next_maintenance)->diffForHumans() }})
                                                </small>
                                            @else
                                                <span class="text-muted">Belum dijadwalkan</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="text-muted small">Status Maintenance</label>
                                        <p class="mb-0">
                                            @php
                                                $maintenanceStatus = 'ok';
                                                $maintenanceMessage = 'Tidak ada maintenance yang dijadwalkan';
                                                $maintenanceBadge = 'secondary';

                                                if ($aset->next_maintenance) {
                                                    $nextMaintenance = \Carbon\Carbon::parse($aset->next_maintenance);
                                                    $today = \Carbon\Carbon::now();
                                                    $daysUntil = $today->diffInDays($nextMaintenance, false);

                                                    if ($daysUntil < 0) {
                                                        $maintenanceStatus = 'overdue';
                                                        $maintenanceMessage = 'Maintenance sudah melewati jadwal! Segera lakukan maintenance.';
                                                        $maintenanceBadge = 'danger';
                                                    } elseif ($daysUntil <= 7) {
                                                        $maintenanceStatus = 'upcoming';
                                                        $maintenanceMessage = 'Maintenance akan segera dilakukan dalam ' . abs($daysUntil) . ' hari.';
                                                        $maintenanceBadge = 'warning';
                                                    } else {
                                                        $maintenanceStatus = 'ok';
                                                        $maintenanceMessage = 'Maintenance sudah dijadwalkan, masih ' . $daysUntil . ' hari lagi.';
                                                        $maintenanceBadge = 'success';
                                                    }
                                                }
                                            @endphp
                                            <span class="badge badge-{{ $maintenanceBadge }} p-2">
                                                @if ($maintenanceStatus == 'ok')
                                                    <i class="mdi mdi-check-circle"></i> OK
                                                @elseif ($maintenanceStatus == 'upcoming')
                                                    <i class="mdi mdi-clock-alert"></i> Upcoming
                                                @elseif ($maintenanceStatus == 'overdue')
                                                    <i class="mdi mdi-alert-circle"></i> Overdue
                                                @endif
                                            </span>
                                            <br>
                                            <small>{{ $maintenanceMessage }}</small>
                                        </p>
                                    </div>
                                </div>

                                @if ($maintenanceStatus == 'overdue' || $maintenanceStatus == 'upcoming')
                                <div class="text-center mt-3">
                                    <a href="{{ route('backend.aset.edit', $aset->id) }}" class="btn btn-sm btn-warning">
                                        <i class="mdi mdi-calendar-edit"></i> Update Jadwal Maintenance
                                    </a>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Timeline/History (Future Enhancement) -->
                        <div class="card border">
                            <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <h5 class="card-title mb-0 text-white">
                                    <i class="mdi mdi-history"></i> Riwayat Aset
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="timeline">
                                    <div class="timeline-item mb-3">
                                        <div class="d-flex">
                                            <div class="mr-3">
                                                <span class="badge badge-primary" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                                                    <i class="mdi mdi-shopping"></i>
                                                </span>
                                            </div>
                                            <div>
                                                <strong>Pembelian Aset</strong>
                                                <p class="text-muted mb-0 small">
                                                    {{ \Carbon\Carbon::parse($aset->tanggal_pembelian)->format('d F Y') }}
                                                </p>
                                                <p class="mb-0">Aset dibeli dengan harga Rp {{ number_format($aset->harga_perolehan, 0, ',', '.') }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    @if ($aset->last_maintenance)
                                    <div class="timeline-item mb-3">
                                        <div class="d-flex">
                                            <div class="mr-3">
                                                <span class="badge badge-success" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                                                    <i class="mdi mdi-wrench"></i>
                                                </span>
                                            </div>
                                            <div>
                                                <strong>Maintenance Terakhir</strong>
                                                <p class="text-muted mb-0 small">
                                                    {{ \Carbon\Carbon::parse($aset->last_maintenance)->format('d F Y') }}
                                                </p>
                                                <p class="mb-0">Maintenance rutin dilakukan</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    <div class="timeline-item">
                                        <div class="d-flex">
                                            <div class="mr-3">
                                                <span class="badge badge-info" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                                                    <i class="mdi mdi-update"></i>
                                                </span>
                                            </div>
                                            <div>
                                                <strong>Status Saat Ini</strong>
                                                <p class="text-muted mb-0 small">Sekarang</p>
                                                <p class="mb-0">
                                                    Nilai aset: Rp {{ number_format($aset->nilai_saat_ini, 0, ',', '.') }}
                                                    <br>
                                                    Status:
                                                    @if ($aset->status_aset == 'aktif')
                                                        <span class="badge badge-success">Aktif</span>
                                                    @elseif ($aset->status_aset == 'rusak')
                                                        <span class="badge badge-warning">Rusak</span>
                                                    @elseif ($aset->status_aset == 'hilang')
                                                        <span class="badge badge-danger">Hilang</span>
                                                    @elseif ($aset->status_aset == 'dijual')
                                                        <span class="badge badge-secondary">Dijual</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Action Buttons -->
                <div class="text-center">
                    <a href="{{ route('backend.aset.edit', $aset->id) }}" class="btn btn-warning">
                        <i class="mdi mdi-pencil"></i> Edit Aset
                    </a>
                    <a href="{{ route('backend.aset.index') }}" class="btn btn-secondary">
                        <i class="mdi mdi-arrow-left"></i> Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
