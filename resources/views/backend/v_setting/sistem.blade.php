@extends('backend.v_layouts.app')

@section('breadcrumb')
    <h4 class="page-title">Pengaturan Sistem</h4>
    <div class="ml-auto">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('backend.beranda') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Pengaturan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Sistem</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-10 mx-auto">
        <!-- Success Message -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="mdi mdi-check-circle"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <i class="mdi mdi-cog"></i> Pengaturan Sistem
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info" role="alert">
                    <i class="mdi mdi-information"></i>
                    <strong>Informasi:</strong> Halaman ini digunakan untuk mengatur konfigurasi sistem CAREXIS.
                </div>

                <form action="{{ route('backend.setting.sistem.update') }}" method="POST">
                    @csrf

                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-6">
                            <!-- Nama Aplikasi -->
                            <div class="form-group">
                                <label for="app_name" class="form-label font-weight-bold">Nama Aplikasi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('app_name') is-invalid @enderror"
                                       id="app_name" name="app_name"
                                       value="{{ old('app_name', $settings['app_name'] ?? 'CAREXIS') }}" required>
                                <small class="form-text text-muted">Nama sistem informasi manajemen terintegrasi</small>
                                @error('app_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Versi Sistem -->
                            <div class="form-group">
                                <label for="app_version" class="form-label font-weight-bold">Versi Sistem <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('app_version') is-invalid @enderror"
                                       id="app_version" name="app_version"
                                       value="{{ old('app_version', $settings['app_version'] ?? '1.0.0') }}" required>
                                <small class="form-text text-muted">Versi aplikasi saat ini</small>
                                @error('app_version')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Timezone -->
                            <div class="form-group">
                                <label for="app_timezone" class="form-label font-weight-bold">Timezone <span class="text-danger">*</span></label>
                                <select class="form-control @error('app_timezone') is-invalid @enderror"
                                        id="app_timezone" name="app_timezone" required>
                                    <option value="Asia/Jakarta" {{ (old('app_timezone', $settings['app_timezone'] ?? '') == 'Asia/Jakarta') ? 'selected' : '' }}>Asia/Jakarta (WIB)</option>
                                    <option value="Asia/Makassar" {{ (old('app_timezone', $settings['app_timezone'] ?? '') == 'Asia/Makassar') ? 'selected' : '' }}>Asia/Makassar (WITA)</option>
                                    <option value="Asia/Jayapura" {{ (old('app_timezone', $settings['app_timezone'] ?? '') == 'Asia/Jayapura') ? 'selected' : '' }}>Asia/Jayapura (WIT)</option>
                                </select>
                                <small class="form-text text-muted">Zona waktu untuk sistem</small>
                                @error('app_timezone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Pagination -->
                            <div class="form-group">
                                <label for="pagination_per_page" class="form-label font-weight-bold">Jumlah Data Per Halaman <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('pagination_per_page') is-invalid @enderror"
                                       id="pagination_per_page" name="pagination_per_page"
                                       value="{{ old('pagination_per_page', $settings['pagination_per_page'] ?? 15) }}"
                                       min="5" max="100" required>
                                <small class="form-text text-muted">Jumlah baris data yang ditampilkan per halaman (5-100)</small>
                                @error('pagination_per_page')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Session Lifetime -->
                            <div class="form-group">
                                <label for="session_lifetime" class="form-label font-weight-bold">Durasi Sesi (Menit) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('session_lifetime') is-invalid @enderror"
                                       id="session_lifetime" name="session_lifetime"
                                       value="{{ old('session_lifetime', $settings['session_lifetime'] ?? 120) }}"
                                       min="30" max="1440" required>
                                <small class="form-text text-muted">Durasi sesi pengguna dalam menit (30-1440)</small>
                                @error('session_lifetime')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-6">
                            <!-- Date Format -->
                            <div class="form-group">
                                <label for="date_format" class="form-label font-weight-bold">Format Tanggal <span class="text-danger">*</span></label>
                                <select class="form-control @error('date_format') is-invalid @enderror"
                                        id="date_format" name="date_format" required>
                                    <option value="d-m-Y" {{ (old('date_format', $settings['date_format'] ?? '') == 'd-m-Y') ? 'selected' : '' }}>DD-MM-YYYY (31-12-2025)</option>
                                    <option value="Y-m-d" {{ (old('date_format', $settings['date_format'] ?? '') == 'Y-m-d') ? 'selected' : '' }}>YYYY-MM-DD (2025-12-31)</option>
                                    <option value="m/d/Y" {{ (old('date_format', $settings['date_format'] ?? '') == 'm/d/Y') ? 'selected' : '' }}>MM/DD/YYYY (12/31/2025)</option>
                                    <option value="d/m/Y" {{ (old('date_format', $settings['date_format'] ?? '') == 'd/m/Y') ? 'selected' : '' }}>DD/MM/YYYY (31/12/2025)</option>
                                </select>
                                <small class="form-text text-muted">Format tanggal yang digunakan di seluruh sistem</small>
                                @error('date_format')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Time Format -->
                            <div class="form-group">
                                <label for="time_format" class="form-label font-weight-bold">Format Waktu <span class="text-danger">*</span></label>
                                <select class="form-control @error('time_format') is-invalid @enderror"
                                        id="time_format" name="time_format" required>
                                    <option value="H:i:s" {{ (old('time_format', $settings['time_format'] ?? '') == 'H:i:s') ? 'selected' : '' }}>24 Jam (23:59:59)</option>
                                    <option value="h:i:s A" {{ (old('time_format', $settings['time_format'] ?? '') == 'h:i:s A') ? 'selected' : '' }}>12 Jam (11:59:59 PM)</option>
                                    <option value="H:i" {{ (old('time_format', $settings['time_format'] ?? '') == 'H:i') ? 'selected' : '' }}>24 Jam - Tanpa Detik (23:59)</option>
                                </select>
                                <small class="form-text text-muted">Format waktu yang digunakan di seluruh sistem</small>
                                @error('time_format')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Backup Auto Delete -->
                            <div class="form-group">
                                <label for="backup_auto_delete_days" class="form-label font-weight-bold">Hapus Backup Otomatis (Hari) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('backup_auto_delete_days') is-invalid @enderror"
                                       id="backup_auto_delete_days" name="backup_auto_delete_days"
                                       value="{{ old('backup_auto_delete_days', $settings['backup_auto_delete_days'] ?? 30) }}"
                                       min="7" max="365" required>
                                <small class="form-text text-muted">Backup yang lebih lama dari (hari) akan dihapus otomatis (7-365)</small>
                                @error('backup_auto_delete_days')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Enable Registration -->
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input"
                                           id="enable_registration" name="enable_registration" value="1"
                                           {{ old('enable_registration', $settings['enable_registration'] ?? false) ? 'checked' : '' }}>
                                    <label class="custom-control-label font-weight-bold" for="enable_registration">Izinkan Pendaftaran User Baru</label>
                                </div>
                                <small class="form-text text-muted">Memungkinkan user baru untuk mendaftar sendiri</small>
                            </div>

                            <!-- Maintenance Mode -->
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input"
                                           id="maintenance_mode" name="maintenance_mode" value="1"
                                           {{ old('maintenance_mode', $settings['maintenance_mode'] ?? false) ? 'checked' : '' }}>
                                    <label class="custom-control-label font-weight-bold" for="maintenance_mode">Mode Maintenance</label>
                                </div>
                                <small class="form-text text-muted">Aktifkan untuk membatasi akses sistem (hanya admin yang dapat mengakses)</small>
                            </div>

                            <!-- Pesan Maintenance -->
                            <div class="form-group">
                                <label for="maintenance_message" class="form-label font-weight-bold">Pesan Maintenance</label>
                                <textarea class="form-control @error('maintenance_message') is-invalid @enderror"
                                          id="maintenance_message" name="maintenance_message" rows="3"
                                          placeholder="Masukkan pesan yang akan ditampilkan saat mode maintenance aktif">{{ old('maintenance_message', $settings['maintenance_message'] ?? '') }}</textarea>
                                <small class="form-text text-muted">Pesan yang ditampilkan saat mode maintenance aktif</small>
                                @error('maintenance_message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Submit Button -->
                    <div class="form-group mb-0">
                        <button type="submit" class="btn btn-primary">
                            <i class="mdi mdi-content-save"></i> Simpan Pengaturan
                        </button>
                        <a href="{{ route('backend.beranda') }}" class="btn btn-secondary">
                            <i class="mdi mdi-close"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
