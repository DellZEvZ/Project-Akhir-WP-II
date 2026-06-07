@extends('backend.v_layouts.app')

@section('breadcrumb')
    <h4 class="page-title">Notifikasi</h4>
    <div class="ml-auto">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('backend.beranda') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Notifikasi</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-10 mx-auto">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="mdi mdi-bell"></i> Semua Notifikasi
                    </h5>
                    <div>
                        <button type="button" class="btn btn-sm btn-light" title="Filter">
                            <i class="mdi mdi-filter"></i> Filter
                        </button>
                        <button type="button" class="btn btn-sm btn-light" title="Refresh">
                            <i class="mdi mdi-refresh"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    <!-- Notification 1 -->
                    <div class="list-group-item p-3 border-bottom">
                        <div class="d-flex align-items-start">
                            <div class="mr-3">
                                <span class="btn btn-warning btn-sm btn-circle"><i class="mdi mdi-account-alert"></i></span>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Pengajuan Cuti Baru</h6>
                                <p class="text-muted mb-1">Ada pengajuan cuti baru dari Budi Santoso yang memerlukan persetujuan Anda</p>
                                <small class="text-muted"><i class="mdi mdi-clock"></i> 2 jam yang lalu</small>
                            </div>
                            <div class="ml-2">
                                <span class="badge badge-warning">Pending</span>
                            </div>
                        </div>
                    </div>

                    <!-- Notification 2 -->
                    <div class="list-group-item p-3 border-bottom">
                        <div class="d-flex align-items-start">
                            <div class="mr-3">
                                <span class="btn btn-info btn-sm btn-circle"><i class="mdi mdi-calendar-clock"></i></span>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Jadwal Shift Minggu Depan</h6>
                                <p class="text-muted mb-1">Jadwal shift untuk minggu depan telah dipublikasikan. Silakan periksa jadwal Anda</p>
                                <small class="text-muted"><i class="mdi mdi-clock"></i> 5 jam yang lalu</small>
                            </div>
                            <div class="ml-2">
                                <span class="badge badge-info">Info</span>
                            </div>
                        </div>
                    </div>

                    <!-- Notification 3 -->
                    <div class="list-group-item p-3 border-bottom">
                        <div class="d-flex align-items-start">
                            <div class="mr-3">
                                <span class="btn btn-success btn-sm btn-circle"><i class="mdi mdi-package-variant"></i></span>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Aset Baru Ditambahkan</h6>
                                <p class="text-muted mb-1">5 unit aset baru telah ditambahkan ke sistem inventaris. Total nilai Rp 25.000.000</p>
                                <small class="text-muted"><i class="mdi mdi-clock"></i> 1 hari yang lalu</small>
                            </div>
                            <div class="ml-2">
                                <span class="badge badge-success">Success</span>
                            </div>
                        </div>
                    </div>

                    <!-- Notification 4 -->
                    <div class="list-group-item p-3 border-bottom">
                        <div class="d-flex align-items-start">
                            <div class="mr-3">
                                <span class="btn btn-danger btn-sm btn-circle"><i class="mdi mdi-alert-circle"></i></span>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Aset Memerlukan Maintenance</h6>
                                <p class="text-muted mb-1">15 aset telah melewati jadwal maintenance. Segera lakukan maintenance untuk mencegah kerusakan</p>
                                <small class="text-muted"><i class="mdi mdi-clock"></i> 2 hari yang lalu</small>
                            </div>
                            <div class="ml-2">
                                <span class="badge badge-danger">Urgent</span>
                            </div>
                        </div>
                    </div>

                    <!-- Notification 5 -->
                    <div class="list-group-item p-3 border-bottom">
                        <div class="d-flex align-items-start">
                            <div class="mr-3">
                                <span class="btn btn-secondary btn-sm btn-circle"><i class="mdi mdi-account-multiple"></i></span>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Update Tim</h6>
                                <p class="text-muted mb-1">Ada update dari manajemen tentang kebijakan absensi baru yang akan berlaku mulai bulan depan</p>
                                <small class="text-muted"><i class="mdi mdi-clock"></i> 3 hari yang lalu</small>
                            </div>
                            <div class="ml-2">
                                <span class="badge badge-secondary">Update</span>
                            </div>
                        </div>
                    </div>

                    <!-- Notification 6 -->
                    <div class="list-group-item p-3">
                        <div class="d-flex align-items-start">
                            <div class="mr-3">
                                <span class="btn btn-primary btn-sm btn-circle"><i class="mdi mdi-backup-restore"></i></span>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Backup Sistem Selesai</h6>
                                <p class="text-muted mb-1">Backup otomatis sistem telah selesai dilakukan dengan sukses</p>
                                <small class="text-muted"><i class="mdi mdi-clock"></i> 1 minggu yang lalu</small>
                            </div>
                            <div class="ml-2">
                                <span class="badge badge-primary">Backup</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center mb-0">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1">Sebelumnya</a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Selanjutnya</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-circle {
        border-radius: 50%;
        width: 40px;
        height: 40px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .list-group-item:hover {
        background-color: #f8f9fa;
        transition: background-color 0.3s ease;
    }
</style>
@endsection
