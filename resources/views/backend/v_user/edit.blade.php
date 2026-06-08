@extends('backend.v_layouts.app')

@section('breadcrumb')
    <h4 class="page-title">Edit User</h4>
    <div class="ml-auto">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('backend.beranda') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('backend.user.index') }}">User</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
<!-- contentAwal -->
<style>
.gradient-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 10px;
    padding: 15px 20px;
    margin-bottom: 20px;
}
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="gradient-header">
                <h4 class="mb-0"><i class="fas fa-user-edit"></i> Edit User BARBERFLOW</h4>
            </div>
        </div>
    </div>

    @if($errors->any())
    <div class="row">
        <div class="col-12">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h5><i class="fas fa-exclamation-triangle"></i> Terdapat kesalahan input:</h5>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{ route('backend.user.update', $edit->id) }}" method="post" enctype="multipart/form-data">
                    @method('put')
                    @csrf

                    <div class="card-body">
                        <h5 class="card-title mb-4"><i class="fas fa-info-circle"></i> Informasi User</h5>

                        <div class="row">
                            {{-- Kolom Foto --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Foto</label>

                                    {{-- Preview Foto --}}
                                    @if ($edit->foto)
                                        <img src="{{ asset('storage/img-user/' . $edit->foto) }}" class="foto-preview" width="100%">
                                    @else
                                        <img src="{{ asset('storage/img-user/img-default.jpg') }}" class="foto-preview" width="100%">
                                    @endif

                                    <p></p>

                                    {{-- Upload Foto --}}
                                    <input type="file" 
                                           name="foto" 
                                           class="form-control @error('foto') is-invalid @enderror" 
                                           onchange="previewFoto()">

                                    @error('foto')
                                        <div class="invalid-feedback alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Kolom Data User --}}
                            <div class="col-md-8">
                                {{-- Role --}}
                                <div class="form-group">
                                    <label><i class="fas fa-user-shield text-primary"></i> Role / Hak Akses <span class="text-danger">*</span></label>
                                    <select name="role_id" class="form-control @error('role_id') is-invalid @enderror" required>
                                        <option value=""> - Pilih Role - </option>
                                        @foreach($roles as $role)
                                            @php
                                                $userRoleId = $edit->roles->first()->id ?? null;
                                                $selectedRoleId = old('role_id', $userRoleId);
                                            @endphp
                                            <option value="{{ $role->id }}" {{ $selectedRoleId == $role->id ? 'selected' : '' }}>
                                                {{ $role->display_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">
                                        Role saat ini: <strong>{{ $edit->roles->first()->display_name ?? 'Belum ada role' }}</strong>
                                    </small>
                                    @error('role_id')
                                        <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Status --}}
                                <div class="form-group">
                                    <label><i class="fas fa-toggle-on text-primary"></i> Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                                        <option value="" {{ old('status', $edit->status) == '' ? 'selected' : '' }}>
                                            - Pilih Status -
                                        </option>
                                        <option value="1" {{ old('status', $edit->status) == '1' ? 'selected' : '' }}>
                                            <i class="fas fa-check-circle"></i> Aktif
                                        </option>
                                        <option value="0" {{ old('status', $edit->status) == '0' ? 'selected' : '' }}>
                                            <i class="fas fa-times-circle"></i> Nonaktif
                                        </option>
                                    </select>
                                    <small class="form-text text-muted">User nonaktif tidak dapat login ke sistem</small>
                                    @error('status')
                                        <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Nama --}}
                                <div class="form-group">
                                    <label><i class="fas fa-user text-primary"></i> Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text"
                                           name="nama"
                                           value="{{ old('nama', $edit->nama) }}"
                                           class="form-control @error('nama') is-invalid @enderror"
                                           placeholder="Masukkan Nama Lengkap"
                                           required>
                                    @error('nama')
                                        <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Email --}}
                                <div class="form-group">
                                    <label><i class="fas fa-envelope text-primary"></i> Email <span class="text-danger">*</span></label>
                                    <input type="email"
                                           name="email"
                                           value="{{ old('email', $edit->email) }}"
                                           class="form-control @error('email') is-invalid @enderror"
                                           placeholder="contoh: user@carexis.com"
                                           required>
                                    <small class="form-text text-muted">Email akan digunakan untuk login ke sistem</small>
                                    @error('email')
                                        <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Nomor HP --}}
                                <div class="form-group">
                                    <label><i class="fas fa-phone text-primary"></i> No. HP <span class="text-danger">*</span></label>
                                    <input type="text"
                                           name="hp"
                                           value="{{ old('hp', $edit->hp) }}"
                                           onkeypress="return hanyaAngka(event)"
                                           class="form-control @error('hp') is-invalid @enderror"
                                           placeholder="contoh: 08123456789"
                                           maxlength="13"
                                           required>
                                    <small class="form-text text-muted">Minimal 10 digit, maksimal 13 digit</small>
                                    @error('hp')
                                        <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="border-top">
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Perbaharui Data
                            </button>
                            <a href="{{ route('backend.user.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- contentAkhir -->
@endsection

@push('scripts')
<script>
    // Preview Foto
    function previewFoto() {
        const foto = document.querySelector('input[name="foto"]');
        const fotoPreview = document.querySelector('.foto-preview');

        const fileFoto = new FileReader();
        fileFoto.readAsDataURL(foto.files[0]);

        fileFoto.onload = function(e) {
            fotoPreview.src = e.target.result;
        }
    }

    // Hanya Angka untuk input HP
    function hanyaAngka(event) {
        var angka = (event.which) ? event.which : event.keyCode;
        if (angka != 46 && angka > 31 && (angka < 48 || angka > 57))
            return false;
        return true;
    }
</script>
@endpush
