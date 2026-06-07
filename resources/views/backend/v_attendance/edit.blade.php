@extends('backend.v_layouts.app')

@section('breadcrumb')
    <h4 class="page-title">Edit Absensi</h4>
    <div class="ml-auto">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('backend.beranda') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('attendance.admin.index') }}">Manajemen Absensi</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-edit mr-2"></i> Edit Data Absensi</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('attendance.admin.update', $attendance->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Pegawai Info (Read Only) -->
                        <div class="form-group">
                            <label>Pegawai</label>
                            <input type="text" class="form-control" value="{{ $attendance->pegawai->nama }}" readonly>
                            <small class="text-muted">{{ $attendance->pegawai->jabatan }} - {{ $attendance->pegawai->departemen }}</small>
                        </div>

                        <div class="row">
                            <!-- Tanggal -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal <span class="text-danger">*</span></label>
                                    <input type="date" name="date" class="form-control @error('date') is-invalid @enderror"
                                           value="{{ old('date', $attendance->date->format('Y-m-d')) }}" required>
                                    @error('date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                                        <option value="present" {{ old('status', $attendance->status) == 'present' ? 'selected' : '' }}>Hadir</option>
                                        <option value="late" {{ old('status', $attendance->status) == 'late' ? 'selected' : '' }}>Terlambat</option>
                                        <option value="absent" {{ old('status', $attendance->status) == 'absent' ? 'selected' : '' }}>Tidak Hadir</option>
                                        <option value="leave" {{ old('status', $attendance->status) == 'leave' ? 'selected' : '' }}>Cuti</option>
                                        <option value="sick" {{ old('status', $attendance->status) == 'sick' ? 'selected' : '' }}>Sakit</option>
                                        <option value="holiday" {{ old('status', $attendance->status) == 'holiday' ? 'selected' : '' }}>Libur</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Check-In Time -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Check-In Time</label>
                                    <input type="time" name="check_in_time"
                                           class="form-control @error('check_in_time') is-invalid @enderror"
                                           value="{{ old('check_in_time', $attendance->check_in_time ? $attendance->check_in_time->format('H:i') : '') }}">
                                    <small class="text-muted">Format: HH:MM (24 jam)</small>
                                    @error('check_in_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Check-Out Time -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Check-Out Time</label>
                                    <input type="time" name="check_out_time"
                                           class="form-control @error('check_out_time') is-invalid @enderror"
                                           value="{{ old('check_out_time', $attendance->check_out_time ? $attendance->check_out_time->format('H:i') : '') }}">
                                    <small class="text-muted">Format: HH:MM (24 jam)</small>
                                    @error('check_out_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="form-group">
                            <label>Catatan</label>
                            <textarea name="notes" class="form-control @error('notes') is-invalid @enderror"
                                      rows="3" placeholder="Tambahkan catatan jika diperlukan">{{ old('notes', $attendance->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Current Info (Read Only) -->
                        <div class="alert alert-info">
                            <h6><i class="fas fa-info-circle"></i> Informasi Saat Ini:</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <small>
                                        <strong>Durasi Kerja:</strong> {{ $attendance->formatted_work_duration }}<br>
                                        <strong>Lembur:</strong> {{ $attendance->formatted_overtime }}
                                    </small>
                                </div>
                                <div class="col-md-6">
                                    <small>
                                        @if($attendance->approved_by)
                                            <strong>Diverifikasi:</strong> {{ $attendance->approver->nama }}<br>
                                            <strong>Pada:</strong> {{ $attendance->approved_at->isoFormat('DD MMM Y, HH:mm') }}
                                        @else
                                            <span class="badge badge-warning">Belum Diverifikasi</span>
                                        @endif
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Perhatian:</strong> Data yang diubah akan otomatis ditandai sebagai "Diverifikasi oleh Admin".
                            Durasi kerja dan lembur akan dihitung ulang secara otomatis.
                        </div>

                        <!-- Buttons -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('attendance.admin.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@if($errors->any())
<script>
    $(document).ready(function() {
        Swal.fire({
            icon: 'error',
            title: 'Validation Error!',
            html: '<ul style="text-align: left;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
        });
    });
</script>
@endif

@endsection
