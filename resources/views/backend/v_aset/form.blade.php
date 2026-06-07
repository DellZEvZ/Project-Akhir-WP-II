@extends('backend.v_layouts.app')

@section('breadcrumb')
    <h4 class="page-title">{{ $judul }}</h4>
    <div class="ml-auto">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('backend.beranda') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('backend.aset.index') }}">Data Aset</a></li>
                <li class="breadcrumb-item active" aria-current="page">Laporan</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8 col-md-10 mx-auto">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="card-title mb-0">
                    <i class="mdi mdi-file-document"></i> {{ $judul }}
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('backend.laporan.cetakaset') }}" method="POST" target="_blank">
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
                                <label for="status">Filter Status Aset</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="">-- Semua Status --</option>
                                    <option value="baik" {{ old('status') == 'baik' ? 'selected' : '' }}>Baik</option>
                                    <option value="rusak" {{ old('status') == 'rusak' ? 'selected' : '' }}>Rusak</option>
                                    <option value="hilang" {{ old('status') == 'hilang' ? 'selected' : '' }}>Hilang</option>
                                    <option value="dijual" {{ old('status') == 'dijual' ? 'selected' : '' }}>Dijual</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kategori">Filter Kategori</label>
                                <input type="text" class="form-control" id="kategori" name="kategori"
                                    placeholder="Contoh: Elektronik, Furniture" value="{{ old('kategori') }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-info btn-block">
                            <i class="mdi mdi-printer"></i> Cetak Laporan
                        </button>
                        <a href="{{ route('backend.aset.index') }}" class="btn btn-secondary btn-block mt-2">
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
