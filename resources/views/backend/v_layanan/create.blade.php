@extends('backend.v_layouts.app')

@section('breadcrumb')
<h4 class="page-title">Tambah Layanan</h4>
<div class="ml-auto">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('backend.beranda') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('backend.layanan.index') }}">Layanan</a></li>
            <li class="breadcrumb-item active">Tambah</li>
        </ol>
    </nav>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">Form Tambah Layanan</h5>

                <form action="{{ route('backend.layanan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="nama_layanan">Nama Layanan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_layanan') is-invalid @enderror"
                               id="nama_layanan" name="nama_layanan" value="{{ old('nama_layanan') }}"
                               placeholder="Contoh: Haircut Reguler" required>
                        @error('nama_layanan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                                  id="deskripsi" name="deskripsi" rows="3"
                                  placeholder="Deskripsi singkat layanan">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="harga">Harga (Rp) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
                                    <input type="number" class="form-control @error('harga') is-invalid @enderror"
                                           id="harga" name="harga" value="{{ old('harga') }}"
                                           placeholder="35000" min="0" required>
                                    @error('harga')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="durasi_menit">Durasi (Menit) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('durasi_menit') is-invalid @enderror"
                                           id="durasi_menit" name="durasi_menit" value="{{ old('durasi_menit', 30) }}"
                                           placeholder="30" min="1" required>
                                    <div class="input-group-append"><span class="input-group-text">menit</span></div>
                                    @error('durasi_menit')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="status">Status <span class="text-danger">*</span></label>
                        <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="aktif" {{ old('status','aktif') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label for="foto">Foto Layanan</label>
                        <input type="file" class="form-control @error('foto') is-invalid @enderror"
                               id="foto" name="foto" accept="image/jpeg,image/png,image/jpg"
                               onchange="previewFoto(this)">
                        @error('foto')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <small class="form-text text-muted">Format: JPG, PNG. Maks 2MB.</small>
                        <img id="fotoPreview" src="" alt="Preview" class="mt-2 rounded" style="display:none; max-width:200px; object-fit:cover;">
                    </div>

                    <hr>
                    <button type="submit" class="btn btn-primary"><i class="mdi mdi-content-save"></i> Simpan</button>
                    <a href="{{ route('backend.layanan.index') }}" class="btn btn-secondary"><i class="mdi mdi-arrow-left"></i> Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function previewFoto(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) { $('#fotoPreview').attr('src', e.target.result).show(); };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
