@extends('backend.v_layouts.app')

@section('breadcrumb')
    <h4 class="page-title">{{ $judul }}</h4>
    <div class="ml-auto">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('backend.beranda') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('backend.pegawai.index') }}">Data Pegawai</a></li>
                <li class="breadcrumb-item active" aria-current="page">Laporan</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8 col-md-10 mx-auto">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <i class="mdi mdi-file-document"></i> {{ $judul }}
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('backend.laporan.cetakpegawai') }}" method="POST" target="_blank">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal_awal">Tanggal Awal</label>
                                <input type="date" class="form-control @error('tanggal_awal') is-invalid @enderror"
                                    id="tanggal_awal" name="tanggal_awal" value="{{ old('tanggal_awal') }}" required>
                                @error('tanggal_awal')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal_akhir">Tanggal Akhir</label>
                                <input type="date" class="form-control @error('tanggal_akhir') is-invalid @enderror"
                                    id="tanggal_akhir" name="tanggal_akhir" value="{{ old('tanggal_akhir') }}" required>
                                @error('tanggal_akhir')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">Filter Status Pegawai</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="">-- Semua Status --</option>
                                    <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="cuti" {{ old('status') == 'cuti' ? 'selected' : '' }}>Cuti</option>
                                    <option value="resign" {{ old('status') == 'resign' ? 'selected' : '' }}>Resign</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="departemen">Filter Departemen</label>
                                <input type="text" class="form-control" id="departemen" name="departemen"
                                    placeholder="Contoh: IT, HR, Finance" value="{{ old('departemen') }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="mdi mdi-printer"></i> Cetak Laporan
                        </button>
                        <a href="{{ route('backend.pegawai.index') }}" class="btn btn-secondary btn-block mt-2">
                            <i class="mdi mdi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .card-header {
        border-radius: 10px 10px 0 0;
    }

    .btn-block {
        border-radius: 8px;
    }
</style>
@endsection
