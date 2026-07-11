@extends('backend.v_layouts.app')

@section('breadcrumb')
<h4 class="page-title">Edit Barber</h4>
<div class="ml-auto">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('backend.beranda') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('backend.barber.index') }}">Barber</a></li>
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
                <h5 class="card-title mb-4">Edit Data Barber</h5>

                <form action="{{ route('backend.barber.update', $barber->id) }}" method="POST" enctype="multipart/form-data" hx-boost="false">
                    @csrf @method('PUT')

                    <div class="form-group">
                        <label for="nama">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror"
                               id="nama" name="nama" value="{{ old('nama', $barber->nama) }}" required>
                        @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label for="spesialisasi">Spesialisasi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('spesialisasi') is-invalid @enderror"
                               id="spesialisasi" name="spesialisasi" value="{{ old('spesialisasi', $barber->spesialisasi) }}" required>
                        @error('spesialisasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pengalaman_tahun">Pengalaman (Tahun) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('pengalaman_tahun') is-invalid @enderror"
                                       id="pengalaman_tahun" name="pengalaman_tahun"
                                       value="{{ old('pengalaman_tahun', $barber->pengalaman_tahun) }}" min="0" required>
                                @error('pengalaman_tahun')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="no_hp">Nomor HP</label>
                                <input type="text" class="form-control @error('no_hp') is-invalid @enderror"
                                       id="no_hp" name="no_hp" value="{{ old('no_hp', $barber->no_hp) }}">
                                @error('no_hp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="status">Status <span class="text-danger">*</span></label>
                        <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="aktif" {{ old('status', $barber->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ old('status', $barber->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label>Foto Barber</label>
                        @if ($barber->foto)
                            <div class="mb-2">
                                <img src="{{ asset('storage/img-barber/' . $barber->foto) }}"
                                     alt="{{ $barber->nama }}" class="rounded"
                                     style="max-width:120px; max-height:120px; object-fit:cover;">
                                <small class="d-block text-muted mt-1">Foto saat ini</small>
                            </div>
                        @endif
                        <input type="file" class="form-control @error('foto') is-invalid @enderror"
                               id="foto" name="foto" accept="image/jpeg,image/png,image/jpg"
                               onchange="previewFoto(this)">
                        @error('foto')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti foto. Format: JPG, PNG. Maks 2MB.</small>
                        <img id="fotoPreview" src="" alt="Preview" class="mt-2 rounded" style="display:none; max-width:150px; object-fit:cover;">
                    </div>

                    <hr>
                    <button type="submit" class="btn btn-primary"><i class="mdi mdi-content-save"></i> Perbarui</button>
                    <a href="{{ route('backend.barber.index') }}" class="btn btn-secondary"><i class="mdi mdi-arrow-left"></i> Kembali</a>
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
