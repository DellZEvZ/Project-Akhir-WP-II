@extends('backend.v_layouts.app')

@section('breadcrumb')
    <h4 class="page-title">Backup & Restore Data</h4>
    <div class="ml-auto">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('backend.beranda') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Pengaturan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Backup & Restore</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
<!-- Alert Messages -->
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="mdi mdi-check-circle"></i> {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert">
        <span>&times;</span>
    </button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="mdi mdi-alert-circle"></i> {{ session('error') }}
    <button type="button" class="close" data-dismiss="alert">
        <span>&times;</span>
    </button>
</div>
@endif

<!-- Statistics -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h6 class="card-title">Total Backups</h6>
                <h3 class="mb-0">{{ $totalBackups }}</h3>
                <small>File backup tersimpan</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h6 class="card-title">Total Ukuran</h6>
                <h3 class="mb-0">{{ $totalSize }}</h3>
                <small>Ruang penyimpanan terpakai</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h6 class="card-title">Backup Terakhir</h6>
                <h5 class="mb-0">{{ $lastBackup ? date('d M Y', strtotime($lastBackup['date'])) : '-' }}</h5>
                <small>{{ $lastBackup ? date('H:i', strtotime($lastBackup['date'])) : 'Belum ada backup' }}</small>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Create Backup Section -->
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <i class="mdi mdi-database-export"></i> Buat Backup Baru
                </h5>
            </div>
            <div class="card-body">
                <p class="text-muted">Buat backup data sistem untuk keamanan dan pemulihan data.</p>

                <div class="alert alert-info" role="alert">
                    <i class="mdi mdi-information"></i>
                    <strong>Yang akan di-backup:</strong>
                    <ul class="mb-0 mt-2">
                        <li>Database lengkap (semua tabel)</li>
                        <li>File gambar (pegawai, aset, produk)</li>
                    </ul>
                </div>

                <form action="{{ route('backend.setting.backup.create') }}" method="POST" onsubmit="return confirm('Yakin ingin membuat backup? Proses ini mungkin memakan waktu beberapa menit.');">
                    @csrf
                    <button type="submit" class="btn btn-success btn-block">
                        <i class="mdi mdi-cloud-download"></i> Buat Backup Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Upload Backup Section -->
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header bg-warning text-white">
                <h5 class="card-title mb-0">
                    <i class="mdi mdi-upload"></i> Upload File Backup
                </h5>
            </div>
            <div class="card-body">
                <p class="text-muted">Upload file backup dari komputer untuk di-restore.</p>

                <div class="alert alert-warning" role="alert">
                    <i class="mdi mdi-alert"></i>
                    <strong>Format file:</strong> .zip (maksimal 500MB)
                </div>

                <form action="{{ route('backend.setting.backup.upload') }}" method="POST" enctype="multipart/form-data" hx-boost="false">
                    @csrf
                    <div class="form-group">
                        <div class="custom-file">
                            <input type="file" name="backup_file" class="custom-file-input" id="backupFile" accept=".zip" required>
                            <label class="custom-file-label" for="backupFile">Pilih file...</label>
                        </div>
                        @error('backup_file')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-warning btn-block">
                        <i class="mdi mdi-upload"></i> Upload Backup
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Backup List -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h5 class="card-title mb-0">
                    <i class="mdi mdi-history"></i> Daftar Backup
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th width="5%">No</th>
                                <th width="35%">Nama File</th>
                                <th width="12%">Ukuran</th>
                                <th width="18%">Tanggal Dibuat</th>
                                <th width="30%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($backups as $index => $backup)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <i class="mdi mdi-zip-box text-primary"></i>
                                    <strong>{{ $backup['name'] }}</strong>
                                    @if(str_contains($backup['name'], 'safety_backup'))
                                    <span class="badge badge-info ml-2">Safety Backup</span>
                                    @endif
                                </td>
                                <td>{{ $backup['size'] }}</td>
                                <td>
                                    <small class="d-block">{{ date('d M Y', strtotime($backup['date'])) }}</small>
                                    <small class="text-primary">{{ date('H:i:s', strtotime($backup['date'])) }}</small>
                                </td>
                                <td>
                                    <!-- Download -->
                                    <a href="{{ route('backend.setting.backup.download', $backup['name']) }}" class="btn btn-sm btn-info" title="Download">
                                        <i class="mdi mdi-download"></i> Download
                                    </a>

                                    <!-- Restore -->
                                    <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#restoreModal{{ $index }}" title="Restore">
                                        <i class="mdi mdi-restore"></i> Restore
                                    </button>

                                    <!-- Delete -->
                                    <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal{{ $index }}" title="Hapus">
                                        <i class="mdi mdi-delete"></i>
                                    </button>
                                </td>
                            </tr>

                            <!-- Restore Modal -->
                            <div class="modal fade" id="restoreModal{{ $index }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-warning text-white">
                                            <h5 class="modal-title">Konfirmasi Restore</h5>
                                            <button type="button" class="close text-white" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="alert alert-warning">
                                                <i class="mdi mdi-alert"></i>
                                                <strong>PERINGATAN!</strong>
                                            </div>
                                            <p>Anda akan me-restore data dari backup:</p>
                                            <ul>
                                                <li><strong>File:</strong> {{ $backup['name'] }}</li>
                                                <li><strong>Tanggal:</strong> {{ $backup['date'] }}</li>
                                            </ul>
                                            <p class="text-danger"><strong>Semua data saat ini akan diganti dengan data dari backup ini!</strong></p>
                                            <p class="text-info"><small><i class="mdi mdi-information"></i> Backup keamanan akan dibuat otomatis sebelum restore.</small></p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            <form action="{{ route('backend.setting.backup.restore', $backup['name']) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-warning">
                                                    <i class="mdi mdi-restore"></i> Ya, Restore Sekarang
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Delete Modal -->
                            <div class="modal fade" id="deleteModal{{ $index }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title">Konfirmasi Hapus</h5>
                                            <button type="button" class="close text-white" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Yakin ingin menghapus backup ini?</p>
                                            <p><strong>{{ $backup['name'] }}</strong></p>
                                            <p class="text-danger">File yang dihapus tidak dapat dikembalikan!</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            <form action="{{ route('backend.setting.backup.delete', $backup['name']) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="mdi mdi-delete"></i> Ya, Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="mdi mdi-folder-open" style="font-size: 2rem; color: #ccc;"></i>
                                    <p class="mt-2">Belum ada backup. Silakan buat backup baru.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Progress Overlay -->
<div id="progressOverlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 9999; justify-content: center; align-items: center;">
    <div style="background: white; border-radius: 15px; padding: 40px; max-width: 500px; width: 90%; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
        <div class="text-center mb-4">
            <div id="progressIcon" style="font-size: 48px; margin-bottom: 15px;">
                <i class="mdi mdi-loading mdi-spin text-primary"></i>
            </div>
            <h4 id="progressTitle" class="mb-2">Memproses...</h4>
            <p id="progressMessage" class="text-muted mb-3">Mohon tunggu sebentar</p>
        </div>

        <!-- Progress Bar -->
        <div class="progress" style="height: 25px; margin-bottom: 20px;">
            <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: 0%">
                <span id="progressPercent">0%</span>
            </div>
        </div>

        <!-- Progress Steps -->
        <div id="progressSteps">
            <div class="step-item" data-step="1">
                <i class="mdi mdi-check-circle text-muted"></i>
                <span class="step-text text-muted">Menyiapkan...</span>
            </div>
            <div class="step-item" data-step="2">
                <i class="mdi mdi-check-circle text-muted"></i>
                <span class="step-text text-muted">Memproses...</span>
            </div>
            <div class="step-item" data-step="3">
                <i class="mdi mdi-check-circle text-muted"></i>
                <span class="step-text text-muted">Menyelesaikan...</span>
            </div>
        </div>

        <div class="text-center mt-3">
            <small class="text-danger"><i class="mdi mdi-alert"></i> Jangan tutup halaman ini!</small>
        </div>
    </div>
</div>

<style>
    .step-item {
        display: flex;
        align-items: center;
        padding: 8px 0;
        transition: all 0.3s;
    }
    .step-item i {
        font-size: 20px;
        margin-right: 10px;
        transition: all 0.3s;
    }
    .step-item.active {
        font-weight: bold;
    }
    .step-item.active i {
        color: #667eea !important;
        animation: pulse 1s infinite;
    }
    .step-item.completed i {
        color: #28a745 !important;
    }
    .step-item.completed .step-text {
        color: #28a745 !important;
    }
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }
</style>

@endsection

@section('scripts')
<script>
    // Custom file input label
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').html(fileName);
    });

    // Auto hide alerts
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);

    // ===== PROGRESS BAR FUNCTIONS =====

    function showProgress(title, type = 'backup') {
        $('#progressOverlay').css('display', 'flex');
        $('#progressTitle').text(title);
        $('#progressBar').css('width', '0%');
        $('#progressPercent').text('0%');

        // Reset steps
        $('.step-item').removeClass('active completed');
        $('.step-item i').removeClass('text-primary text-success').addClass('text-muted');
        $('.step-item .step-text').removeClass('text-primary text-success').addClass('text-muted');

        // Set step labels based on type
        if (type === 'backup') {
            $('.step-item[data-step="1"] .step-text').text('Menyiapkan database...');
            $('.step-item[data-step="2"] .step-text').text('Mengompres file...');
            $('.step-item[data-step="3"] .step-text').text('Menyimpan backup...');
        } else if (type === 'restore') {
            $('.step-item[data-step="1"] .step-text').text('Membuat safety backup...');
            $('.step-item[data-step="2"] .step-text').text('Memulihkan database...');
            $('.step-item[data-step="3"] .step-text').text('Memulihkan file...');
        } else if (type === 'upload') {
            $('.step-item[data-step="1"] .step-text').text('Mengunggah file...');
            $('.step-item[data-step="2"] .step-text').text('Memvalidasi backup...');
            $('.step-item[data-step="3"] .step-text').text('Menyimpan...');
        }

        // Simulate progress
        simulateProgress(type);
    }

    function hideProgress() {
        setTimeout(function() {
            $('#progressOverlay').fadeOut(300);
        }, 1000);
    }

    function updateProgress(percent, step) {
        $('#progressBar').css('width', percent + '%');
        $('#progressPercent').text(percent + '%');

        // Update step status
        for (let i = 1; i <= 3; i++) {
            let stepItem = $('.step-item[data-step="' + i + '"]');
            if (i < step) {
                stepItem.removeClass('active').addClass('completed');
                stepItem.find('i').removeClass('text-muted text-primary').addClass('text-success');
                stepItem.find('.step-text').removeClass('text-muted text-primary').addClass('text-success');
            } else if (i === step) {
                stepItem.addClass('active').removeClass('completed');
                stepItem.find('i').removeClass('text-muted text-success').addClass('text-primary');
                stepItem.find('.step-text').removeClass('text-muted text-success').addClass('text-primary');
            } else {
                stepItem.removeClass('active completed');
                stepItem.find('i').removeClass('text-primary text-success').addClass('text-muted');
                stepItem.find('.step-text').removeClass('text-primary text-success').addClass('text-muted');
            }
        }
    }

    function simulateProgress(type) {
        let progress = 0;
        let step = 1;

        let interval = setInterval(function() {
            progress += Math.random() * 15;

            if (progress >= 33 && step === 1) {
                step = 2;
                updateProgress(33, step);
            } else if (progress >= 66 && step === 2) {
                step = 3;
                updateProgress(66, step);
            } else if (progress >= 100) {
                progress = 100;
                updateProgress(100, 3);
                clearInterval(interval);

                // Mark all as completed
                $('.step-item').removeClass('active').addClass('completed');
                $('.step-item i').removeClass('text-muted text-primary').addClass('text-success');
                $('.step-item .step-text').removeClass('text-muted text-primary').addClass('text-success');

                $('#progressIcon').html('<i class="mdi mdi-check-circle text-success"></i>');
                $('#progressTitle').text('Selesai!');
                $('#progressMessage').text('Proses berhasil diselesaikan');
            } else {
                updateProgress(Math.min(progress, 100), step);
            }
        }, type === 'restore' ? 300 : 200); // Restore lebih lambat
    }

    // ===== FORM SUBMIT HANDLERS =====

    // Create Backup Form
    $('form[action="{{ route("backend.setting.backup.create") }}"]').on('submit', function(e) {
        e.preventDefault();

        if (!confirm('Yakin ingin membuat backup? Proses ini mungkin memakan waktu beberapa menit.')) {
            return false;
        }

        showProgress('Membuat Backup...', 'backup');

        // Submit form via AJAX or regular submit
        let form = $(this);
        setTimeout(function() {
            form.off('submit').submit(); // Remove handler and submit
        }, 100);
    });

    // Upload Backup Form
    $('form[action="{{ route("backend.setting.backup.upload") }}"]').on('submit', function(e) {
        let fileInput = $(this).find('input[type="file"]');
        if (!fileInput.val()) {
            e.preventDefault();
            alert('Silakan pilih file backup terlebih dahulu!');
            return false;
        }

        showProgress('Mengunggah Backup...', 'upload');

        // Let form submit normally
    });

    // Restore Form (in modal)
    $('form[action^="{{ url("backend/setting/backup/restore") }}"]').on('submit', function(e) {
        e.preventDefault();

        let form = $(this);
        let modal = form.closest('.modal');

        modal.modal('hide');
        showProgress('Memulihkan Data...', 'restore');

        setTimeout(function() {
            form.off('submit').submit();
        }, 500);
    });

    // Delete Form (just close modal, no progress needed)
    $('form[action^="{{ url("backend/setting/backup/delete") }}"]').on('submit', function(e) {
        let modal = $(this).closest('.modal');
        modal.modal('hide');
    });
</script>
@endsection
