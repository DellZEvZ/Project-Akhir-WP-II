@extends('backend.v_layouts.app')

@section('breadcrumb')
    <h4 class="page-title">Pengaturan Akun</h4>
    <div class="ml-auto">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('backend.beranda') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pengaturan Akun</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-10 mx-auto">
        <!-- Account Information -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <i class="mdi mdi-account-circle"></i> Informasi Akun
                </h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-3 text-center">
                        @if (Auth::user()->foto)
                            <img src="{{ asset('storage/img-user/' . Auth::user()->foto) }}" alt="user" class="rounded-circle" width="120" style="border: 3px solid #667eea;">
                        @else
                            <img src="{{ asset('storage/img-user/img-default.jpg') }}" alt="user" class="rounded-circle" width="120" style="border: 3px solid #667eea;">
                        @endif
                        <div class="mt-3">
                            <button type="button" class="btn btn-sm btn-primary" disabled>
                                <i class="mdi mdi-upload"></i> Ganti Foto
                            </button>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label text-muted">Nama Lengkap</label>
                                <h5>{{ Auth::user()->nama }}</h5>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted">Email</label>
                                <h5>{{ Auth::user()->email }}</h5>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label text-muted">Nomor Telepon</label>
                                <h5>{{ Auth::user()->hp ?? '-' }}</h5>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted">Role</label>
                                <h5>
                                    @if (Auth::user()->role == 1)
                                        <span class="badge badge-success">Administrator</span>
                                    @elseif(Auth::user()->role == 2)
                                        <span class="badge badge-info">Supervisor</span>
                                    @else
                                        <span class="badge badge-primary">Pegawai</span>
                                    @endif
                                </h5>
                            </div>
                        </div>
                        <a href="{{ route('backend.user.edit', Auth::user()->id) }}" class="btn btn-primary">
                            <i class="mdi mdi-pencil"></i> Edit Profil
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Security Settings -->
        <div class="card mb-4">
            <div class="card-header bg-warning text-white">
                <h5 class="card-title mb-0">
                    <i class="mdi mdi-lock"></i> Keamanan
                </h5>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-8">
                        <h6>Ubah Password</h6>
                        <p class="text-muted">Perbarui password akun Anda secara berkala untuk menjaga keamanan</p>
                    </div>
                    <div class="col-md-4 text-right">
                        <button type="button" class="btn btn-warning" disabled>
                            <i class="mdi mdi-key-change"></i> Ubah Password
                        </button>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-8">
                        <h6>Aktivitas Login Terakhir</h6>
                        <p class="text-muted">Lihat riwayat login dan perangkat yang terhubung</p>
                    </div>
                    <div class="col-md-4 text-right">
                        <button type="button" class="btn btn-info" disabled>
                            <i class="mdi mdi-history"></i> Lihat Riwayat
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notification Settings -->
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="card-title mb-0">
                    <i class="mdi mdi-bell"></i> Notifikasi
                </h5>
            </div>
            <div class="card-body">
                <div class="custom-control custom-switch mb-3">
                    <input type="checkbox" class="custom-control-input" id="notif-email" checked disabled>
                    <label class="custom-control-label" for="notif-email">
                        <strong>Notifikasi Email</strong>
                        <small class="d-block text-muted">Terima notifikasi penting melalui email</small>
                    </label>
                </div>

                <div class="custom-control custom-switch mb-3">
                    <input type="checkbox" class="custom-control-input" id="notif-sistem" checked disabled>
                    <label class="custom-control-label" for="notif-sistem">
                        <strong>Notifikasi Sistem</strong>
                        <small class="d-block text-muted">Terima notifikasi sistem di dalam aplikasi</small>
                    </label>
                </div>

                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="notif-sms" disabled>
                    <label class="custom-control-label" for="notif-sms">
                        <strong>Notifikasi SMS</strong>
                        <small class="d-block text-muted">Terima notifikasi penting melalui SMS</small>
                    </label>
                </div>
            </div>
        </div>

        <!-- Privacy Settings -->
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="card-title mb-0">
                    <i class="mdi mdi-shield-account"></i> Privasi
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="mdi mdi-information"></i>
                    <strong>Informasi:</strong> Data pribadi Anda dilindungi sesuai dengan kebijakan privasi kami.
                </div>

                <p class="mb-3">
                    <a href="#" class="text-primary">
                        <i class="mdi mdi-file-document"></i> Kebijakan Privasi
                    </a>
                </p>

                <p class="mb-3">
                    <a href="#" class="text-primary">
                        <i class="mdi mdi-file-document"></i> Syarat & Ketentuan
                    </a>
                </p>

                <p class="mb-0">
                    <button type="button" class="btn btn-danger btn-sm" disabled>
                        <i class="mdi mdi-delete"></i> Hapus Akun
                    </button>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
