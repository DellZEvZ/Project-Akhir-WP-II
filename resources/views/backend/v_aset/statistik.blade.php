@extends('backend.v_layouts.app')

@section('breadcrumb')
    <h4 class="page-title">{{ $judul }}</h4>
    <div class="ml-auto">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('backend.beranda') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('backend.aset.index') }}">Data Aset</a></li>
                <li class="breadcrumb-item active" aria-current="page">Statistik</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
<style>
    .stat-card {
        background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%);
        color: white;
        border: none;
        border-radius: 10px;
        padding: 30px;
        margin-bottom: 20px;
        box-shadow: 0 4px 15px rgba(23, 162, 184, 0.3);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 25px rgba(23, 162, 184, 0.4);
    }

    .stat-card.aktif {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
    }

    .stat-card.rusak {
        background: linear-gradient(135deg, #dc3545 0%, #e83e8c 100%);
        box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
    }

    .stat-card.hilang {
        background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
        box-shadow: 0 4px 15px rgba(255, 193, 7, 0.3);
    }

    .stat-card.dijual {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
        box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
    }

    .stat-number {
        font-size: 3rem;
        font-weight: bold;
        margin: 15px 0;
    }

    .stat-label {
        font-size: 1.1rem;
        opacity: 0.95;
    }

    .stat-icon {
        font-size: 3rem;
        opacity: 0.8;
        float: right;
    }

    .info-card {
        background: #f8f9fa;
        border-left: 4px solid #17a2b8;
        padding: 20px;
        border-radius: 5px;
        margin-top: 20px;
    }

    .info-card h5 {
        color: #17a2b8;
        margin-bottom: 15px;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #dee2e6;
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-label {
        font-weight: 500;
        color: #495057;
    }

    .info-value {
        font-size: 1.1rem;
        font-weight: bold;
        color: #17a2b8;
    }

    .currency {
        color: #28a745;
    }
</style>

<div class="row">
    <!-- Total Aset -->
    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="card stat-card">
            <div class="stat-icon">📦</div>
            <div class="stat-label">Total Aset</div>
            <div class="stat-number">{{ $totalAset }}</div>
            <small>Seluruh Aset</small>
        </div>
    </div>

    <!-- Aset Aktif -->
    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="card stat-card aktif">
            <div class="stat-icon">✓</div>
            <div class="stat-label">Aset Aktif</div>
            <div class="stat-number">{{ $asetAktif }}</div>
            <small>Status Baik</small>
        </div>
    </div>

    <!-- Aset Rusak -->
    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="card stat-card rusak">
            <div class="stat-icon">⚠️</div>
            <div class="stat-label">Aset Rusak</div>
            <div class="stat-number">{{ $asetRusak }}</div>
            <small>Perlu Perbaikan</small>
        </div>
    </div>

    <!-- Aset Hilang/Dijual -->
    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="card stat-card hilang">
            <div class="stat-icon">❌</div>
            <div class="stat-label">Tidak Aktif</div>
            <div class="stat-number">{{ $asetHilang + $asetDijual }}</div>
            <small>Hilang/Dijual</small>
        </div>
    </div>
</div>

<!-- Detailed Summary -->
<div class="row mt-4">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="info-card">
                    <h5>📊 Ringkasan Status Aset</h5>
                    <div class="info-item">
                        <span class="info-label">Total Aset:</span>
                        <span class="info-value">{{ $totalAset }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Aset Aktif (Baik):</span>
                        <span class="info-value" style="color: #28a745;">{{ $asetAktif }}
                            ({{ $totalAset > 0 ? round(($asetAktif / $totalAset) * 100, 1) : 0 }}%)
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Aset Rusak:</span>
                        <span class="info-value" style="color: #dc3545;">{{ $asetRusak }}
                            ({{ $totalAset > 0 ? round(($asetRusak / $totalAset) * 100, 1) : 0 }}%)
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Aset Hilang:</span>
                        <span class="info-value" style="color: #ffc107;">{{ $asetHilang }}
                            ({{ $totalAset > 0 ? round(($asetHilang / $totalAset) * 100, 1) : 0 }}%)
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Aset Dijual:</span>
                        <span class="info-value" style="color: #6c757d;">{{ $asetDijual }}
                            ({{ $totalAset > 0 ? round(($asetDijual / $totalAset) * 100, 1) : 0 }}%)
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="info-card">
                    <h5>💰 Ringkasan Nilai Aset</h5>
                    <div class="info-item">
                        <span class="info-label">Total Harga Perolehan:</span>
                        <span class="info-value currency">Rp {{ number_format($totalNilaiPerolehan, 0, ',', '.') }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Total Nilai Saat Ini:</span>
                        <span class="info-value currency">Rp {{ number_format($totalNilaiSaatIni, 0, ',', '.') }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Total Depresiasi:</span>
                        <span class="info-value currency">Rp {{ number_format($totalNilaiPerolehan - $totalNilaiSaatIni, 0, ',', '.') }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Persentase Depresiasi:</span>
                        <span class="info-value currency">
                            {{ $totalNilaiPerolehan > 0 ? round((($totalNilaiPerolehan - $totalNilaiSaatIni) / $totalNilaiPerolehan) * 100, 2) : 0 }}%
                        </span>
                    </div>
                    <hr>
                    <div class="info-item">
                        <span class="info-label">⚙️ Aset Perlu Maintenance:</span>
                        <span class="info-value" style="color: #dc3545;">{{ $asetNeedMaintenance }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Status Distribution Progress Bars -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="info-card">
                    <h5>📈 Distribusi Status Aset</h5>
                    <div class="mb-3">
                        <label class="mb-2">Aset Aktif (Baik)</label>
                        <div class="progress" style="height: 30px;">
                            <div class="progress-bar bg-success" role="progressbar"
                                style="width: {{ $totalAset > 0 ? ($asetAktif / $totalAset) * 100 : 0 }}%;"
                                aria-valuenow="{{ $asetAktif }}" aria-valuemin="0" aria-valuemax="{{ $totalAset }}">
                                {{ $asetAktif }} ({{ $totalAset > 0 ? round(($asetAktif / $totalAset) * 100, 1) : 0 }}%)
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="mb-2">Aset Rusak</label>
                        <div class="progress" style="height: 30px;">
                            <div class="progress-bar bg-danger" role="progressbar"
                                style="width: {{ $totalAset > 0 ? ($asetRusak / $totalAset) * 100 : 0 }}%;"
                                aria-valuenow="{{ $asetRusak }}" aria-valuemin="0" aria-valuemax="{{ $totalAset }}">
                                {{ $asetRusak }} ({{ $totalAset > 0 ? round(($asetRusak / $totalAset) * 100, 1) : 0 }}%)
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="mb-2">Aset Hilang</label>
                        <div class="progress" style="height: 30px;">
                            <div class="progress-bar bg-warning" role="progressbar"
                                style="width: {{ $totalAset > 0 ? ($asetHilang / $totalAset) * 100 : 0 }}%;"
                                aria-valuenow="{{ $asetHilang }}" aria-valuemin="0" aria-valuemax="{{ $totalAset }}">
                                {{ $asetHilang }} ({{ $totalAset > 0 ? round(($asetHilang / $totalAset) * 100, 1) : 0 }}%)
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="mb-2">Aset Dijual</label>
                        <div class="progress" style="height: 30px;">
                            <div class="progress-bar bg-secondary" role="progressbar"
                                style="width: {{ $totalAset > 0 ? ($asetDijual / $totalAset) * 100 : 0 }}%;"
                                aria-valuenow="{{ $asetDijual }}" aria-valuemin="0" aria-valuemax="{{ $totalAset }}">
                                {{ $asetDijual }} ({{ $totalAset > 0 ? round(($asetDijual / $totalAset) * 100, 1) : 0 }}%)
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Action Buttons -->
<div class="row mt-4">
    <div class="col-12">
        <a href="{{ route('backend.aset.maintenance.list') }}" class="btn btn-warning mr-2">
            <i class="mdi mdi-wrench"></i> Lihat Maintenance List
        </a>
        <a href="{{ route('backend.aset.index') }}" class="btn btn-primary">
            <i class="mdi mdi-arrow-left"></i> Kembali ke Daftar Aset
        </a>
    </div>
</div>

@endsection
