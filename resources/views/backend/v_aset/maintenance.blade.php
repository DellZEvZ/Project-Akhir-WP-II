@extends('backend.v_layouts.app')

@section('breadcrumb')
    <h4 class="page-title">{{ $judul }}</h4>
    <div class="ml-auto">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('backend.beranda') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('backend.aset.index') }}">Data Aset</a></li>
                <li class="breadcrumb-item active" aria-current="page">Maintenance</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
<style>
    .alert-overdue {
        background-color: #f8d7da;
        border-color: #f5c6cb;
        color: #721c24;
    }

    .alert-upcoming {
        background-color: #fff3cd;
        border-color: #ffeaa7;
        color: #856404;
    }

    .table-maintenance {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .table-maintenance thead {
        background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%);
        color: white;
    }

    .table-maintenance th {
        padding: 15px;
        font-weight: bold;
        border: none;
    }

    .table-maintenance td {
        padding: 12px 15px;
        border-color: #f0f0f0;
    }

    .table-maintenance tbody tr:hover {
        background-color: #f8f9fa;
    }

    .badge-overdue {
        background-color: #dc3545;
        color: white;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
    }

    .badge-upcoming {
        background-color: #ffc107;
        color: #333;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
    }

    .btn-sm {
        padding: 6px 12px;
        font-size: 12px;
    }

    .no-data {
        text-align: center;
        padding: 40px;
        color: #999;
    }

    .no-data-icon {
        font-size: 3rem;
        margin-bottom: 15px;
        opacity: 0.5;
    }

    .card-section {
        margin-bottom: 25px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .card-section-header {
        padding: 15px 20px;
        background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%);
        color: white;
        font-weight: bold;
        display: flex;
        align-items: center;
    }

    .card-section-header i {
        margin-right: 10px;
        font-size: 1.3rem;
    }

    .card-section-body {
        padding: 20px;
    }
</style>

<!-- Alert Overdue -->
@if (count($asetOverdue) > 0)
    <div class="alert alert-overdue border-0 rounded-lg mb-4">
        <h5 class="mb-2">
            <i class="mdi mdi-alert-circle"></i> PERHATIAN: Aset Perlu Maintenance Sekarang!
        </h5>
        <p class="mb-0">Terdapat {{ count($asetOverdue) }} aset yang telah melewati jadwal maintenance. Segera lakukan maintenance untuk mencegah kerusakan yang lebih serius.</p>
    </div>
@endif

<!-- Overdue Maintenance -->
@if (count($asetOverdue) > 0)
    <div class="card-section">
        <div class="card-section-header">
            <i class="mdi mdi-clock-alert-outline"></i> Maintenance Overdue (Terlambat)
            <span class="badge badge-danger ml-auto">{{ count($asetOverdue) }} Aset</span>
        </div>
        <div class="card-section-body">
            <div class="table-responsive">
                <table class="table table-maintenance mb-0">
                    <thead>
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th style="width: 15%;">Kode Aset</th>
                            <th style="width: 20%;">Nama Aset</th>
                            <th style="width: 15%;">Kategori</th>
                            <th style="width: 12%;">Last Maintenance</th>
                            <th style="width: 12%;">Next Maintenance</th>
                            <th style="width: 12%;">Terlambat</th>
                            <th style="width: 14%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($asetOverdue as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><strong>{{ $item->kode_aset }}</strong></td>
                                <td>{{ $item->nama_aset }}</td>
                                <td>{{ $item->kategori }}</td>
                                <td>
                                    @if ($item->last_maintenance)
                                        {{ $item->last_maintenance->format('d/m/Y') }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $item->next_maintenance->format('d/m/Y') }}</strong>
                                </td>
                                <td>
                                    <strong class="text-danger">
                                        {{ $item->next_maintenance->diffInDays(now()) }} hari
                                    </strong>
                                </td>
                                <td>
                                    <a href="{{ route('backend.aset.show', $item->id) }}" class="btn btn-sm btn-info">
                                        <i class="mdi mdi-pencil"></i> Update
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">
                                    <div class="no-data">
                                        <div class="no-data-icon">✓</div>
                                        <p>Semua aset sudah maintenance tepat waktu</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif

<!-- Upcoming Maintenance -->
<div class="card-section">
    <div class="card-section-header">
        <i class="mdi mdi-calendar-clock"></i> Jadwal Maintenance Mendatang (7 Hari ke Depan)
        <span class="badge badge-warning ml-auto">{{ count($asetUpcoming) }} Aset</span>
    </div>
    <div class="card-section-body">
        @if (count($asetUpcoming) > 0)
            <div class="table-responsive">
                <table class="table table-maintenance mb-0">
                    <thead>
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th style="width: 15%;">Kode Aset</th>
                            <th style="width: 20%;">Nama Aset</th>
                            <th style="width: 15%;">Kategori</th>
                            <th style="width: 12%;">Last Maintenance</th>
                            <th style="width: 12%;">Next Maintenance</th>
                            <th style="width: 12%;">Dalam</th>
                            <th style="width: 14%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($asetUpcoming as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><strong>{{ $item->kode_aset }}</strong></td>
                                <td>{{ $item->nama_aset }}</td>
                                <td>{{ $item->kategori }}</td>
                                <td>
                                    @if ($item->last_maintenance)
                                        {{ $item->last_maintenance->format('d/m/Y') }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $item->next_maintenance->format('d/m/Y') }}</strong>
                                </td>
                                <td>
                                    <strong class="text-warning">
                                        {{ now()->diffInDays($item->next_maintenance) }} hari
                                    </strong>
                                </td>
                                <td>
                                    <a href="{{ route('backend.aset.show', $item->id) }}" class="btn btn-sm btn-info">
                                        <i class="mdi mdi-pencil"></i> Update
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">
                                    <div class="no-data">
                                        <div class="no-data-icon">✓</div>
                                        <p>Tidak ada aset dengan jadwal maintenance dalam 7 hari ke depan</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @else
            <div class="no-data">
                <div class="no-data-icon">✓</div>
                <p>Tidak ada aset dengan jadwal maintenance dalam 7 hari ke depan</p>
            </div>
        @endif
    </div>
</div>

<!-- Summary Info -->
<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="mdi mdi-information-outline"></i> Informasi Maintenance
                </h5>
                <p class="mb-2">
                    <strong>Total Aset Overdue:</strong>
                    <span class="badge badge-danger">{{ count($asetOverdue) }}</span>
                </p>
                <p class="mb-2">
                    <strong>Jadwal dalam 7 Hari:</strong>
                    <span class="badge badge-warning">{{ count($asetUpcoming) }}</span>
                </p>
                <p class="mb-0">
                    <strong>Total Perlu Perhatian:</strong>
                    <span class="badge badge-danger">{{ count($asetOverdue) + count($asetUpcoming) }}</span>
                </p>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="mdi mdi-lightbulb-outline"></i> Tips Maintenance
                </h5>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <i class="mdi mdi-check text-success"></i>
                        Lakukan maintenance secara berkala sesuai jadwal
                    </li>
                    <li class="mb-2">
                        <i class="mdi mdi-check text-success"></i>
                        Catat setiap maintenance yang telah dilakukan
                    </li>
                    <li>
                        <i class="mdi mdi-check text-success"></i>
                        Periksa aset secara visual sebelum maintenance
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Action Buttons -->
<div class="row mt-4">
    <div class="col-12">
        <a href="{{ route('backend.aset.index') }}" class="btn btn-primary">
            <i class="mdi mdi-arrow-left"></i> Kembali ke Daftar Aset
        </a>
    </div>
</div>

@endsection
