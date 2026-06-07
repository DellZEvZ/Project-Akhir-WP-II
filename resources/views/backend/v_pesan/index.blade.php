@extends('backend.v_layouts.app')

@section('breadcrumb')
    <h4 class="page-title">Pesan</h4>
    <div class="ml-auto">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('backend.beranda') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pesan</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
<div class="row h-100">
    <div class="col-lg-4 col-md-5">
        <div class="card h-100" style="max-height: calc(100vh - 200px);">
            <div class="card-header bg-primary text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="mdi mdi-email"></i> Pesan
                    </h5>
                    <button type="button" class="btn btn-sm btn-light" title="Compose">
                        <i class="mdi mdi-pencil"></i>
                    </button>
                </div>
            </div>

            <div class="card-body p-0 overflow-auto" style="max-height: calc(100vh - 300px);">
                <div class="list-group list-group-flush">
                    <!-- Message 1 -->
                    <div class="list-group-item p-3 border-bottom" style="background-color: #f0f7ff; cursor: pointer;">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="mb-0"><strong>Budi Santoso</strong></h6>
                            <small class="text-muted">09:30</small>
                        </div>
                        <p class="text-muted mb-0 small">Jadwal Hari Ini - Pengingat jadwal shift Anda</p>
                    </div>

                    <!-- Message 2 -->
                    <div class="list-group-item p-3 border-bottom" style="cursor: pointer;">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="mb-0"><strong>HR Manager</strong></h6>
                            <small class="text-muted">08:15</small>
                        </div>
                        <p class="text-muted mb-0 small">Update Tim - Ada update dari manajemen tentang kebijakan</p>
                    </div>

                    <!-- Message 3 -->
                    <div class="list-group-item p-3 border-bottom" style="cursor: pointer;">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="mb-0"><strong>Admin Sistem</strong></h6>
                            <small class="text-muted">Kemarin</small>
                        </div>
                        <p class="text-muted mb-0 small">Backup Sistem - Backup otomatis telah selesai dilakukan</p>
                    </div>

                    <!-- Message 4 -->
                    <div class="list-group-item p-3 border-bottom" style="cursor: pointer;">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="mb-0"><strong>Departemen Keuangan</strong></h6>
                            <small class="text-muted">2 hari</small>
                        </div>
                        <p class="text-muted mb-0 small">Pengajuan Anggaran - Review pengajuan anggaran bulan depan</p>
                    </div>

                    <!-- Message 5 -->
                    <div class="list-group-item p-3" style="cursor: pointer;">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="mb-0"><strong>Kepala Departemen</strong></h6>
                            <small class="text-muted">1 minggu</small>
                        </div>
                        <p class="text-muted mb-0 small">Evaluasi Kinerja - Evaluasi kinerja kuartal ini telah dimulai</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8 col-md-7">
        <div class="card h-100" style="max-height: calc(100vh - 200px);">
            <div class="card-header bg-light border-bottom">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-0">
                            <i class="mdi mdi-calendar-check"></i> Jadwal Hari Ini
                        </h5>
                        <small class="text-muted">Dari: Budi Santoso</small>
                    </div>
                    <div>
                        <button type="button" class="btn btn-sm btn-outline-secondary">
                            <i class="mdi mdi-flag"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary">
                            <i class="mdi mdi-archive"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary">
                            <i class="mdi mdi-delete"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="card-body overflow-auto" style="max-height: calc(100vh - 450px);">
                <div class="mb-4">
                    <div class="d-flex mb-2">
                        <div class="mr-3">
                            <img src="{{ asset('storage/img-user/img-default.jpg') }}" alt="user" class="rounded-circle" width="40" height="40">
                        </div>
                        <div>
                            <h6 class="mb-0"><strong>Budi Santoso</strong></h6>
                            <small class="text-muted">Hari ini, 09:30</small>
                        </div>
                    </div>
                    <div class="bg-light p-3 rounded" style="max-width: 80%;">
                        <p class="mb-0">Assalamu'alaikum,<br><br>Jadwal shift Anda untuk hari ini adalah:<br>
                        <strong>Pukul 09:00 - 17:00</strong><br><br>
                        Pastikan Anda hadir tepat waktu. Jika ada masalah, hubungi bagian HR.<br><br>
                        Terima kasih</p>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="d-flex mb-2 justify-content-end">
                        <div class="text-right mr-3">
                            <h6 class="mb-0"><strong>Anda</strong></h6>
                            <small class="text-muted">Hari ini, 09:45</small>
                        </div>
                        <div>
                            <img src="{{ asset('storage/img-user/img-default.jpg') }}" alt="user" class="rounded-circle" width="40" height="40">
                        </div>
                    </div>
                    <div class="bg-primary text-white p-3 rounded" style="max-width: 80%; margin-left: auto;">
                        <p class="mb-0">Wa'alaikum assalam,<br><br>Baik, saya sudah catat. Terima kasih atas pengingatan nya. Saya akan hadir tepat waktu.<br><br>Salam</p>
                    </div>
                </div>
            </div>

            <div class="card-footer bg-light">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Tulis pesan...">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button">
                            <i class="mdi mdi-send"></i> Kirim
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .overflow-auto {
        overflow-y: auto;
    }

    .list-group-item:hover {
        background-color: #f8f9fa;
        transition: background-color 0.3s ease;
    }
</style>
@endsection
