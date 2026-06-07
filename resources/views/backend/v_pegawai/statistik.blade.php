@extends('backend.v_layouts.app')

@section('breadcrumb')
    <h4 class="page-title">{{ $judul }}</h4>
    <div class="ml-auto">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('backend.beranda') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('backend.pegawai.index') }}">Data Pegawai</a></li>
                <li class="breadcrumb-item active" aria-current="page">Statistik</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
<style>
    .stat-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 10px;
        padding: 30px;
        margin-bottom: 20px;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 25px rgba(102, 126, 234, 0.4);
    }

    .stat-card.aktif {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
    }

    .stat-card.cuti {
        background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
        box-shadow: 0 4px 15px rgba(255, 193, 7, 0.3);
    }

    .stat-card.resign {
        background: linear-gradient(135deg, #dc3545 0%, #e83e8c 100%);
        box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
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

    .chart-container {
        position: relative;
        height: 400px;
        margin-top: 30px;
    }

    .info-card {
        background: #f8f9fa;
        border-left: 4px solid #667eea;
        padding: 20px;
        border-radius: 5px;
        margin-top: 20px;
    }

    .info-card h5 {
        color: #667eea;
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
        font-size: 1.2rem;
        font-weight: bold;
        color: #667eea;
    }
</style>

<div class="row">
    <!-- Total Pegawai -->
    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="card stat-card">
            <div class="stat-icon">👥</div>
            <div class="stat-label">Total Pegawai</div>
            <div class="stat-number">{{ $totalPegawai }}</div>
            <small>Seluruh Data</small>
        </div>
    </div>

    <!-- Pegawai Aktif -->
    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="card stat-card aktif">
            <div class="stat-icon">✓</div>
            <div class="stat-label">Pegawai Aktif</div>
            <div class="stat-number">{{ $pegawaiAktif }}</div>
            <small>Status Aktif</small>
        </div>
    </div>

    <!-- Pegawai Cuti -->
    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="card stat-card cuti">
            <div class="stat-icon">🏖️</div>
            <div class="stat-label">Pegawai Cuti</div>
            <div class="stat-number">{{ $pegawaiCuti }}</div>
            <small>Status Cuti</small>
        </div>
    </div>

    <!-- Pegawai Resign -->
    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="card stat-card resign">
            <div class="stat-icon">✕</div>
            <div class="stat-label">Pegawai Resign</div>
            <div class="stat-number">{{ $pegawaiResign }}</div>
            <small>Status Resign</small>
        </div>
    </div>
</div>

<!-- Summary Info -->
<div class="row mt-4">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="info-card">
                    <h5>📊 Ringkasan Status Pegawai</h5>
                    <div class="info-item">
                        <span class="info-label">Total Pegawai:</span>
                        <span class="info-value">{{ $totalPegawai }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Pegawai Aktif:</span>
                        <span class="info-value" style="color: #28a745;">{{ $pegawaiAktif }}
                            ({{ $totalPegawai > 0 ? round(($pegawaiAktif / $totalPegawai) * 100, 1) : 0 }}%)
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Pegawai Cuti:</span>
                        <span class="info-value" style="color: #ffc107;">{{ $pegawaiCuti }}
                            ({{ $totalPegawai > 0 ? round(($pegawaiCuti / $totalPegawai) * 100, 1) : 0 }}%)
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Pegawai Resign:</span>
                        <span class="info-value" style="color: #dc3545;">{{ $pegawaiResign }}
                            ({{ $totalPegawai > 0 ? round(($pegawaiResign / $totalPegawai) * 100, 1) : 0 }}%)
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
                    <h5>📈 Persentase Distribusi</h5>
                    <div class="progress" style="height: 25px; margin-bottom: 15px;">
                        <div class="progress-bar bg-success" role="progressbar"
                            style="width: {{ $totalPegawai > 0 ? ($pegawaiAktif / $totalPegawai) * 100 : 0 }}%;"
                            aria-valuenow="{{ $pegawaiAktif }}" aria-valuemin="0" aria-valuemax="{{ $totalPegawai }}">
                            Aktif: {{ $totalPegawai > 0 ? round(($pegawaiAktif / $totalPegawai) * 100, 1) : 0 }}%
                        </div>
                    </div>
                    <div class="progress" style="height: 25px; margin-bottom: 15px;">
                        <div class="progress-bar bg-warning" role="progressbar"
                            style="width: {{ $totalPegawai > 0 ? ($pegawaiCuti / $totalPegawai) * 100 : 0 }}%;"
                            aria-valuenow="{{ $pegawaiCuti }}" aria-valuemin="0" aria-valuemax="{{ $totalPegawai }}">
                            Cuti: {{ $totalPegawai > 0 ? round(($pegawaiCuti / $totalPegawai) * 100, 1) : 0 }}%
                        </div>
                    </div>
                    <div class="progress" style="height: 25px;">
                        <div class="progress-bar bg-danger" role="progressbar"
                            style="width: {{ $totalPegawai > 0 ? ($pegawaiResign / $totalPegawai) * 100 : 0 }}%;"
                            aria-valuenow="{{ $pegawaiResign }}" aria-valuemin="0" aria-valuemax="{{ $totalPegawai }}">
                            Resign: {{ $totalPegawai > 0 ? round(($pegawaiResign / $totalPegawai) * 100, 1) : 0 }}%
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Action Button -->
<div class="row mt-4">
    <div class="col-12">
        <a href="{{ route('backend.pegawai.index') }}" class="btn btn-primary">
            <i class="mdi mdi-arrow-left"></i> Kembali ke Daftar Pegawai
        </a>
    </div>
</div>

@endsection
