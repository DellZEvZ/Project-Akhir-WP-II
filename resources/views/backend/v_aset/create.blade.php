@extends('backend.v_layouts.app')

@section('breadcrumb')
<h4 class="page-title">Tambah Aset</h4>
<div class="ml-auto">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('backend.beranda') }}">Home</a></li>
            <li class="breadcrumb-item">Inventaris</li>
            <li class="breadcrumb-item"><a href="{{ route('backend.aset.index') }}">Aset</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah</li>
        </ol>
    </nav>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">Form Tambah Aset/Inventaris</h5>

                <form action="{{ route('backend.aset.store') }}" method="POST" enctype="multipart/form-data" hx-boost="false">
                    @csrf

                    <div class="row">
                        <!-- Kolom Kiri -->
                        <div class="col-md-6">
                            <!-- Nama Aset -->
                            <div class="form-group">
                                <label for="nama_aset">Nama Aset <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('nama_aset') is-invalid @enderror"
                                       id="nama_aset"
                                       name="nama_aset"
                                       value="{{ old('nama_aset') }}"
                                       placeholder="Masukkan nama aset"
                                       required>
                                @error('nama_aset')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Kode Aset -->
                            <div class="form-group">
                                <label for="kode_aset">Kode Aset <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('kode_aset') is-invalid @enderror"
                                       id="kode_aset"
                                       name="kode_aset"
                                       value="{{ old('kode_aset') }}"
                                       placeholder="Contoh: AST-001, MED-2024-001"
                                       required>
                                @error('kode_aset')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Kode unik untuk identifikasi aset</small>
                            </div>

                            <!-- Deskripsi -->
                            <div class="form-group">
                                <label for="deskripsi">Deskripsi</label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                                          id="deskripsi"
                                          name="deskripsi"
                                          rows="4"
                                          placeholder="Masukkan deskripsi lengkap aset">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Kategori -->
                            <div class="form-group">
                                <label for="kategori">Kategori <span class="text-danger">*</span></label>
                                <select class="form-control @error('kategori') is-invalid @enderror"
                                        id="kategori"
                                        name="kategori"
                                        required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <option value="Alat Medis" {{ old('kategori') == 'Alat Medis' ? 'selected' : '' }}>Alat Medis</option>
                                    <option value="Furniture" {{ old('kategori') == 'Furniture' ? 'selected' : '' }}>Furniture</option>
                                    <option value="Elektronik" {{ old('kategori') == 'Elektronik' ? 'selected' : '' }}>Elektronik</option>
                                    <option value="Kendaraan" {{ old('kategori') == 'Kendaraan' ? 'selected' : '' }}>Kendaraan</option>
                                </select>
                                @error('kategori')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Supplier -->
                            <div class="form-group">
                                <label for="supplier">Supplier</label>
                                <input type="text"
                                       class="form-control @error('supplier') is-invalid @enderror"
                                       id="supplier"
                                       name="supplier"
                                       value="{{ old('supplier') }}"
                                       placeholder="Nama pemasok/supplier">
                                @error('supplier')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Lokasi -->
                            <div class="form-group">
                                <label for="lokasi">Lokasi</label>
                                <input type="text"
                                       class="form-control @error('lokasi') is-invalid @enderror"
                                       id="lokasi"
                                       name="lokasi"
                                       value="{{ old('lokasi') }}"
                                       placeholder="Contoh: Lantai 2 Ruang 201, Gudang Utama">
                                @error('lokasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Kolom Kanan -->
                        <div class="col-md-6">
                            <!-- Tanggal Pembelian -->
                            <div class="form-group">
                                <label for="tanggal_pembelian">Tanggal Pembelian <span class="text-danger">*</span></label>
                                <input type="date"
                                       class="form-control @error('tanggal_pembelian') is-invalid @enderror"
                                       id="tanggal_pembelian"
                                       name="tanggal_pembelian"
                                       value="{{ old('tanggal_pembelian') }}"
                                       required>
                                @error('tanggal_pembelian')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Harga Perolehan -->
                            <div class="form-group">
                                <label for="harga_perolehan">Harga Perolehan <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="number"
                                           class="form-control @error('harga_perolehan') is-invalid @enderror"
                                           id="harga_perolehan"
                                           name="harga_perolehan"
                                           value="{{ old('harga_perolehan') }}"
                                           placeholder="10000000"
                                           step="0.01"
                                           required>
                                    @error('harga_perolehan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="form-text text-muted">Harga saat pembelian/perolehan aset</small>
                            </div>

                            <!-- Nilai Saat Ini -->
                            <div class="form-group">
                                <label for="nilai_saat_ini">Nilai Saat Ini <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="number"
                                           class="form-control @error('nilai_saat_ini') is-invalid @enderror"
                                           id="nilai_saat_ini"
                                           name="nilai_saat_ini"
                                           value="{{ old('nilai_saat_ini') }}"
                                           placeholder="8000000"
                                           step="0.01"
                                           required>
                                    @error('nilai_saat_ini')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="form-text text-muted">Nilai aset setelah depresiasi. Untuk aset baru, isi dengan harga perolehan</small>
                            </div>

                            <!-- Status Aset -->
                            <div class="form-group">
                                <label for="status_aset">Status Aset <span class="text-danger">*</span></label>
                                <select class="form-control @error('status_aset') is-invalid @enderror"
                                        id="status_aset"
                                        name="status_aset"
                                        required>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="aktif" {{ old('status_aset') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="rusak" {{ old('status_aset') == 'rusak' ? 'selected' : '' }}>Rusak</option>
                                    <option value="hilang" {{ old('status_aset') == 'hilang' ? 'selected' : '' }}>Hilang</option>
                                    <option value="dijual" {{ old('status_aset') == 'dijual' ? 'selected' : '' }}>Dijual</option>
                                </select>
                                @error('status_aset')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Last Maintenance -->
                            <div class="form-group">
                                <label for="last_maintenance">Tanggal Maintenance Terakhir</label>
                                <input type="date"
                                       class="form-control @error('last_maintenance') is-invalid @enderror"
                                       id="last_maintenance"
                                       name="last_maintenance"
                                       value="{{ old('last_maintenance') }}">
                                @error('last_maintenance')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Kosongkan jika belum pernah maintenance</small>
                            </div>

                            <!-- Next Maintenance -->
                            <div class="form-group">
                                <label for="next_maintenance">Tanggal Maintenance Berikutnya</label>
                                <input type="date"
                                       class="form-control @error('next_maintenance') is-invalid @enderror"
                                       id="next_maintenance"
                                       name="next_maintenance"
                                       value="{{ old('next_maintenance') }}">
                                @error('next_maintenance')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Jadwal maintenance yang akan datang</small>
                            </div>

                            <!-- Foto Aset -->
                            <div class="form-group">
                                <label for="foto_aset">Foto Aset</label>
                                <input type="file"
                                       class="form-control @error('foto_aset') is-invalid @enderror"
                                       id="foto_aset"
                                       name="foto_aset"
                                       accept="image/jpeg,image/png,image/jpg"
                                       onchange="previewFoto()">
                                @error('foto_aset')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Format: JPG, PNG. Maksimal 2MB</small>

                                <!-- Preview Foto -->
                                <img class="foto-preview mt-2 rounded"
                                     src=""
                                     alt="Preview Foto"
                                     style="display: none; max-width: 200px; max-height: 200px;">
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Action Buttons -->
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="mdi mdi-content-save"></i> Simpan
                        </button>
                        <a href="{{ route('backend.aset.index') }}" class="btn btn-secondary">
                            <i class="mdi mdi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto-fill nilai_saat_ini when harga_perolehan changes (for new assets)
    document.getElementById('harga_perolehan').addEventListener('input', function() {
        const nilaiSaatIni = document.getElementById('nilai_saat_ini');
        if (nilaiSaatIni.value === '' || nilaiSaatIni.value === '0') {
            nilaiSaatIni.value = this.value;
        }
    });
</script>
@endpush
