@extends('backend.v_layouts.app')

@section('breadcrumb')
    <h4 class="page-title">Tambah User</h4>
    <div class="ml-auto">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('backend.beranda') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('backend.user.index') }}">User</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
<!-- ============================================================== -->
<!-- contentAwal -->
<!-- ============================================================== -->
<style>
.gradient-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 10px;
    padding: 15px 20px;
    margin-bottom: 20px;
}
.password-requirement {
    font-size: 12px;
    margin-top: 5px;
}
.password-requirement i {
    margin-right: 5px;
}
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="gradient-header">
                <h4 class="mb-0"><i class="fas fa-user-plus"></i> Tambah User Baru CAREXIS</h4>
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
                <form class="form-horizontal" action="{{ route('backend.user.store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="card-body">
                        <h5 class="card-title mb-4"><i class="fas fa-info-circle"></i> Informasi User</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Foto</label>
                                    <img class="foto-preview">
                                    <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" onchange="previewFoto()">
                                    @error('foto')
                                    <div class="invalid-feedback alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label><i class="fas fa-user-shield text-primary"></i> Role / Hak Akses <span class="text-danger">*</span></label>
                                    <select name="role_id" class="form-control @error('role_id') is-invalid @enderror" required>
                                        <option value=""> - Pilih Role - </option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                                {{ $role->display_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">Pilih role sesuai dengan hak akses yang dibutuhkan</small>
                                    @error('role_id')
                                    <span class="invalid-feedback alert-danger" role="alert">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label><i class="fas fa-user text-primary"></i> Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="nama" value="{{ old('nama') }}" class="form-control @error('nama') is-invalid @enderror" placeholder="Masukkan Nama Lengkap" required>
                                    @error('nama')
                                    <span class="invalid-feedback alert-danger" role="alert">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label><i class="fas fa-envelope text-primary"></i> Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="contoh: user@carexis.com" required>
                                    <small class="form-text text-muted">Email akan digunakan untuk login ke sistem</small>
                                    @error('email')
                                    <span class="invalid-feedback alert-danger" role="alert">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label><i class="fas fa-phone text-primary"></i> No. HP <span class="text-danger">*</span></label>
                                    <input type="text" onkeypress="return hanyaAngka(event)" name="hp" value="{{ old('hp') }}" class="form-control @error('hp') is-invalid @enderror" placeholder="contoh: 08123456789" maxlength="13" required>
                                    <small class="form-text text-muted">Minimal 10 digit, maksimal 13 digit</small>
                                    @error('hp')
                                    <span class="invalid-feedback alert-danger" role="alert">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label><i class="fas fa-lock text-primary"></i> Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan Password" required>
                                    <div class="password-requirement text-muted">
                                        <i class="fas fa-info-circle"></i> Password harus memenuhi syarat:
                                        <ul class="mb-0">
                                            <li>Minimal 4 karakter</li>
                                            <li>Mengandung huruf besar (A-Z)</li>
                                            <li>Mengandung huruf kecil (a-z)</li>
                                            <li>Mengandung angka (0-9)</li>
                                            <li>Mengandung simbol (@, #, $, %, dll)</li>
                                        </ul>
                                    </div>
                                    @error('password')
                                    <span class="invalid-feedback alert-danger" role="alert">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label><i class="fas fa-lock text-primary"></i> Konfirmasi Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi Password" required>
                                    <small class="form-text text-muted">Masukkan password yang sama dengan di atas</small>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- Section Data Pegawai --}}
                        <div class="row">
                            <div class="col-12">
                                <div class="custom-control custom-checkbox mb-3">
                                    <input type="checkbox" class="custom-control-input" id="buatPegawai" name="buat_pegawai" value="1" {{ old('buat_pegawai') ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="buatPegawai">
                                        <i class="fas fa-user-tie text-info"></i> <strong>Buat data pegawai sekaligus</strong>
                                    </label>
                                    <small class="form-text text-muted">Centang jika ingin membuat data pegawai untuk user ini</small>
                                </div>
                            </div>
                        </div>

                        <div id="dataPegawaiSection" style="display: none;">
                            <h5 class="card-title mb-4 mt-3"><i class="fas fa-id-card"></i> Data Pegawai</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><i class="fas fa-map-marker-alt text-primary"></i> Alamat</label>
                                        <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3" placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>
                                        @error('alamat')
                                        <span class="invalid-feedback alert-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label><i class="fas fa-calendar text-primary"></i> Tanggal Lahir</label>
                                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="form-control @error('tanggal_lahir') is-invalid @enderror">
                                        @error('tanggal_lahir')
                                        <span class="invalid-feedback alert-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label><i class="fas fa-venus-mars text-primary"></i> Jenis Kelamin</label>
                                        <div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="lakiLaki" name="jenis_kelamin" class="custom-control-input" value="laki-laki" {{ old('jenis_kelamin') == 'laki-laki' ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="lakiLaki">Laki-laki</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="perempuan" name="jenis_kelamin" class="custom-control-input" value="perempuan" {{ old('jenis_kelamin') == 'perempuan' ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="perempuan">Perempuan</label>
                                            </div>
                                        </div>
                                        @error('jenis_kelamin')
                                        <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><i class="fas fa-calendar-plus text-primary"></i> Tanggal Masuk</label>
                                        <input type="date" name="tanggal_masuk" value="{{ old('tanggal_masuk', date('Y-m-d')) }}" class="form-control @error('tanggal_masuk') is-invalid @enderror">
                                        @error('tanggal_masuk')
                                        <span class="invalid-feedback alert-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label><i class="fas fa-building text-primary"></i> Departemen</label>
                                        <input type="text" name="departemen" value="{{ old('departemen') }}" class="form-control @error('departemen') is-invalid @enderror" placeholder="contoh: IT, HRD, Finance">
                                        @error('departemen')
                                        <span class="invalid-feedback alert-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label><i class="fas fa-briefcase text-primary"></i> Jabatan</label>
                                        <input type="text" name="jabatan" value="{{ old('jabatan') }}" class="form-control @error('jabatan') is-invalid @enderror" placeholder="contoh: Staff, Supervisor, Manager">
                                        @error('jabatan')
                                        <span class="invalid-feedback alert-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label><i class="fas fa-money-bill-wave text-primary"></i> Gaji Pokok</label>
                                        <input type="number" name="gaji_pokok" value="{{ old('gaji_pokok', '5000000') }}" class="form-control @error('gaji_pokok') is-invalid @enderror" placeholder="5000000">
                                        <small class="form-text text-muted">Masukkan nominal tanpa titik atau koma</small>
                                        @error('gaji_pokok')
                                        <span class="invalid-feedback alert-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="border-top">
                        <div class="card-body">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Simpan User
                            </button>
                            <a href="{{ route('backend.user.index') }}">
                                <button type="button" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </button>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- contentAkhir -->
<!-- ============================================================== -->
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
            fotoPreview.style.display = 'block';
            fotoPreview.style.width = '100%';
            fotoPreview.style.marginBottom = '10px';
            fotoPreview.style.marginTop = '10px';
            fotoPreview.style.borderRadius = '5px';
        }
    }

    // Hanya Angka untuk input HP
    function hanyaAngka(event) {
        var angka = (event.which) ? event.which : event.keyCode;
        if (angka != 46 && angka > 31 && (angka < 48 || angka > 57))
            return false;
        return true;
    }

    // Toggle Data Pegawai Section
    $('#buatPegawai').on('change', function() {
        if ($(this).is(':checked')) {
            $('#dataPegawaiSection').slideDown();
        } else {
            $('#dataPegawaiSection').slideUp();
        }
    });

    // Show section if checkbox is checked on page load (for old() values)
    $(document).ready(function() {
        if ($('#buatPegawai').is(':checked')) {
            $('#dataPegawaiSection').show();
        }
    });
</script>
@endpush