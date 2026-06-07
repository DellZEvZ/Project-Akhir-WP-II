@extends('backend.v_layouts.app')

@section('breadcrumb')
    <h4 class="page-title">Manajemen Absensi</h4>
    <div class="ml-auto">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('backend.beranda') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Manajemen Absensi</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Filter Section -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-filter mr-2"></i> Filter Absensi</h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('attendance.admin.index') }}">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Tanggal</label>
                                    <input type="date" name="date" class="form-control"
                                           value="{{ request('date', date('Y-m-d')) }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Pegawai</label>
                                    <select name="pegawai_id" class="form-control">
                                        <option value="">Semua Pegawai</option>
                                        @foreach($pegawais as $pegawai)
                                            <option value="{{ $pegawai->id }}"
                                                {{ request('pegawai_id') == $pegawai->id ? 'selected' : '' }}>
                                                {{ $pegawai->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="">Semua Status</option>
                                        <option value="present" {{ request('status') == 'present' ? 'selected' : '' }}>Hadir</option>
                                        <option value="late" {{ request('status') == 'late' ? 'selected' : '' }}>Terlambat</option>
                                        <option value="absent" {{ request('status') == 'absent' ? 'selected' : '' }}>Tidak Hadir</option>
                                        <option value="leave" {{ request('status') == 'leave' ? 'selected' : '' }}>Cuti</option>
                                        <option value="sick" {{ request('status') == 'sick' ? 'selected' : '' }}>Sakit</option>
                                        <option value="holiday" {{ request('status') == 'holiday' ? 'selected' : '' }}>Libur</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <div>
                                        <button type="submit" class="btn btn-primary btn-block">
                                            <i class="fas fa-search"></i> Filter
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Attendance List -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-list mr-2"></i>
                            Daftar Absensi - {{ request('date', date('d/m/Y')) }}
                        </h5>
                        <div>
                            <a href="{{ route('attendance.export') }}" class="btn btn-success btn-sm">
                                <i class="fas fa-file-excel"></i> Export Excel
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Pegawai</th>
                                    <th>Tanggal</th>
                                    <th>Check-In</th>
                                    <th>Check-Out</th>
                                    <th>Durasi</th>
                                    <th>Lembur</th>
                                    <th>Status</th>
                                    <th>Verifikasi</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($attendances as $index => $attendance)
                                <tr>
                                    <td>{{ $attendances->firstItem() + $index }}</td>
                                    <td>
                                        <strong>{{ $attendance->pegawai->nama }}</strong><br>
                                        <small class="text-muted">{{ $attendance->pegawai->jabatan }}</small>
                                    </td>
                                    <td>{{ $attendance->date->isoFormat('DD MMM Y') }}</td>
                                    <td>
                                        @if($attendance->check_in_time)
                                            <span class="badge badge-success">
                                                {{ $attendance->check_in_time->format('H:i') }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($attendance->check_out_time)
                                            <span class="badge badge-danger">
                                                {{ $attendance->check_out_time->format('H:i') }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $attendance->formatted_work_duration }}</td>
                                    <td>{{ $attendance->formatted_overtime }}</td>
                                    <td>
                                        <span class="badge badge-{{ $attendance->status_badge }}">
                                            {{ $attendance->status_label }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if($attendance->approved_by)
                                            <i class="fas fa-check-circle text-success"
                                               title="Diverifikasi oleh {{ $attendance->approver->nama }}"></i>
                                            <br>
                                            <small class="text-muted">
                                                {{ $attendance->approved_at->diffForHumans() }}
                                            </small>
                                        @else
                                            <span class="badge badge-warning">Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            @if(!$attendance->approved_by)
                                            <form action="{{ route('attendance.admin.approve', $attendance->id) }}"
                                                  method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm"
                                                        title="Approve"
                                                        onclick="return confirm('Approve absensi ini?')">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            @endif

                                            <a href="{{ route('attendance.admin.edit', $attendance->id) }}"
                                               class="btn btn-warning btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form action="{{ route('attendance.admin.destroy', $attendance->id) }}"
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                        title="Delete"
                                                        onclick="return confirm('Hapus data absensi ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">Tidak ada data absensi untuk tanggal ini</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-3">
                        {{ $attendances->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
<script>
    $(document).ready(function() {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session("success") }}',
            timer: 2000,
            showConfirmButton: false
        });
    });
</script>
@endif

@if(session('error'))
<script>
    $(document).ready(function() {
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '{{ session("error") }}',
        });
    });
</script>
@endif

@endsection
