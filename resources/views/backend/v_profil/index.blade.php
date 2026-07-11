@extends('backend.v_layouts.app')

@section('breadcrumb')
    <h4 class="page-title">Profil Saya</h4>
    <div class="ml-auto">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('backend.beranda') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Profil Saya</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-10 mx-auto">
        <!-- Edit Profile Form -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <i class="mdi mdi-account-edit"></i> Edit Profil
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('backend.profil.update') }}" method="POST" enctype="multipart/form-data" hx-boost="false">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-3 text-center">
                            @if ($user->foto)
                                <img src="{{ asset('storage/img-user/' . $user->foto) }}" alt="user" class="rounded-circle img-preview" width="120" style="border: 3px solid #667eea;">
                            @else
                                <img src="{{ asset('storage/img-user/img-default.jpg') }}" alt="user" class="rounded-circle img-preview" width="120" style="border: 3px solid #667eea;">
                            @endif
                            <div class="mt-3">
                                <input type="file" name="foto" id="foto" class="form-control-file d-none" accept="image/*" onchange="previewImage(event)">
                                <label for="foto" class="btn btn-sm btn-primary">
                                    <i class="mdi mdi-upload"></i> Ganti Foto
                                </label>
                                <small class="d-block text-muted mt-2">Max 1 MB</small>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <label for="nama">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                       id="nama" name="nama" value="{{ old('nama', $user->nama) }}" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="hp">Nomor Telepon</label>
                                <input type="text" class="form-control @error('hp') is-invalid @enderror"
                                       id="hp" name="hp" value="{{ old('hp', $user->hp) }}">
                                @error('hp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Role</label>
                                <div>
                                    @forelse($user->roles as $role)
                                        <span class="badge badge-success badge-lg">{{ $role->display_name }}</span>
                                    @empty
                                        <span class="badge badge-secondary">No Role</span>
                                    @endforelse
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="mdi mdi-content-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Change Password -->
        <div class="card mb-4">
            <div class="card-header bg-warning text-white">
                <h5 class="card-title mb-0">
                    <i class="mdi mdi-lock-reset"></i> Ubah Password
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('backend.profil.password') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="password_lama">Password Lama <span class="text-danger">*</span></label>
                        <input type="password" class="form-control @error('password_lama') is-invalid @enderror"
                               id="password_lama" name="password_lama" required>
                        @error('password_lama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_baru">Password Baru <span class="text-danger">*</span></label>
                        <input type="password" class="form-control @error('password_baru') is-invalid @enderror"
                               id="password_baru" name="password_baru" required>
                        @error('password_baru')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Minimal 8 karakter</small>
                    </div>

                    <div class="form-group">
                        <label for="password_baru_confirmation">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                        <input type="password" class="form-control"
                               id="password_baru_confirmation" name="password_baru_confirmation" required>
                    </div>

                    <button type="submit" class="btn btn-warning">
                        <i class="mdi mdi-key-change"></i> Ubah Password
                    </button>
                </form>
            </div>
        </div>

        <!-- Account Information -->
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="card-title mb-0">
                    <i class="mdi mdi-information"></i> Informasi Akun
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="200">Status Akun</th>
                        <td>
                            @if($user->status)
                                <span class="badge badge-success">Aktif</span>
                            @else
                                <span class="badge badge-danger">Nonaktif</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Terdaftar Sejak</th>
                        <td>{{ $user->created_at ? $user->created_at->format('d M Y H:i') : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Login Terakhir</th>
                        <td>{{ $user->last_login ? $user->last_login->format('d M Y H:i') : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Total Permissions</th>
                        <td>
                            <span class="badge badge-info">
                                {{ $user->getAllPermissions()->count() }} permissions
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function previewImage(event) {
    const input = event.target;
    const preview = document.querySelector('.img-preview');

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
        }

        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
