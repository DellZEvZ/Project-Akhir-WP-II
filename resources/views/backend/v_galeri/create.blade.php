@extends('backend.v_layouts.app')

@section('breadcrumb')
<h4 class="page-title">Upload Foto Galeri</h4>
<div class="ml-auto">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('backend.beranda') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('backend.galeri.index') }}">Galeri</a></li>
            <li class="breadcrumb-item active">Upload</li>
        </ol>
    </nav>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-7">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">Upload Foto ke Galeri</h5>

                <form action="{{ route('backend.galeri.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="judul">Judul Foto <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('judul') is-invalid @enderror"
                               id="judul" name="judul" value="{{ old('judul') }}"
                               placeholder="Contoh: Fade Cut Classic, Pompadour Style" required>
                        @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label for="tipe">Tipe <span class="text-danger">*</span></label>
                        <select class="form-control @error('tipe') is-invalid @enderror" id="tipe" name="tipe" required>
                            <option value="">-- Pilih Tipe --</option>
                            <option value="haircut"   {{ old('tipe') == 'haircut'   ? 'selected' : '' }}>Haircut</option>
                            <option value="hairstyle" {{ old('tipe') == 'hairstyle' ? 'selected' : '' }}>Hairstyle</option>
                            <option value="beard"     {{ old('tipe') == 'beard'     ? 'selected' : '' }}>Beard</option>
                        </select>
                        @error('tipe')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea class="form-control @error('keterangan') is-invalid @enderror"
                                  id="keterangan" name="keterangan" rows="2"
                                  placeholder="Keterangan tambahan (opsional)">{{ old('keterangan') }}</textarea>
                        @error('keterangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label for="foto">Foto <span class="text-danger">*</span></label>
                        <input type="file" class="form-control @error('foto') is-invalid @enderror"
                               id="foto" name="foto" accept="image/jpeg,image/png,image/jpg"
                               onchange="previewFoto(this)" required>
                        @error('foto')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <small class="form-text text-muted">Format: JPG, PNG. Maks 3MB. Disarankan foto portrait untuk tampilan galeri terbaik.</small>
                        <img id="fotoPreview" src="" alt="Preview" class="mt-2 rounded"
                             style="display:none; max-width:250px; max-height:250px; object-fit:cover;">
                    </div>

                    <hr>
                    <button type="submit" class="btn btn-primary"><i class="mdi mdi-upload"></i> Upload</button>
                    <a href="{{ route('backend.galeri.index') }}" class="btn btn-secondary"><i class="mdi mdi-arrow-left"></i> Kembali</a>
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
