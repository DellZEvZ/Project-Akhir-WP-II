@extends('backend.v_layouts.app')

@section('breadcrumb')
<h4 class="page-title">Edit Layanan</h4>
<div class="ml-auto">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('backend.beranda') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('backend.layanan.index') }}">Layanan</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">Edit Data Layanan</h5>

                <form action="{{ route('backend.layanan.update', $layanan->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')

                    <div class="form-group">
                        <label for="nama_layanan">Nama Layanan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_layanan') is-invalid @enderror"
                               id="nama_layanan" name="nama_layanan"
                               value="{{ old('nama_layanan', $layanan->nama_layanan) }}" required>
                        @error('nama_layanan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                                  id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $layanan->deskripsi) }}</textarea>
                        @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="harga">Harga (Rp) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
                                    <input type="number" class="form-control @error('harga') is-invalid @enderror"
                                           id="harga" name="harga"
                                           value="{{ old('harga', $layanan->harga) }}" min="0" required>
                                    @error('harga')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="durasi_menit">Durasi (Menit) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('durasi_menit') is-invalid @enderror"
                                           id="durasi_menit" name="durasi_menit"
                                           value="{{ old('durasi_menit', $layanan->durasi_menit) }}" min="1" required>
                                    <div class="input-group-append"><span class="input-group-text">menit</span></div>
                                    @error('durasi_menit')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="status">Status <span class="text-danger">*</span></label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="aktif" {{ old('status', $layanan->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ old('status', $layanan->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Foto Layanan</label>
                        @if ($layanan->foto)
                            <div class="mb-2">
                                <img src="{{ asset('storage/img-layanan/' . $layanan->foto) }}"
                                     alt="{{ $layanan->nama_layanan }}" class="rounded"
                                     style="max-width:150px; max-height:100px; object-fit:cover;">
                                <small class="d-block text-muted mt-1">Foto saat ini</small>
                            </div>
                        @endif
                        <input type="file" class="form-control @error('foto') is-invalid @enderror"
                               id="foto" name="foto" accept="image/jpeg,image/png,image/jpg"
                               onchange="previewFoto(this)">
                        @error('foto')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti foto.</small>
                        <img id="fotoPreview" src="" alt="Preview" class="mt-2 rounded" style="display:none; max-width:200px; object-fit:cover;">
                    </div>

                    <hr>
                    <button type="submit" class="btn btn-primary"><i class="mdi mdi-content-save"></i> Perbarui</button>
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
