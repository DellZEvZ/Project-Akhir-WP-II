@extends('backend.v_layouts.app')

@section('breadcrumb')
    <h4 class="page-title">Absensi Saya</h4>
    <div class="ml-auto">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('backend.beranda') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Absensi</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
<style>
    .attendance-card {
        border: none;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .btn-checkin {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        padding: 15px 30px;
        font-size: 18px;
        border-radius: 50px;
        transition: all 0.3s ease;
    }

    .btn-checkin:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .btn-checkout {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        border: none;
        color: white;
        padding: 15px 30px;
        font-size: 18px;
        border-radius: 50px;
        transition: all 0.3s ease;
    }

    .btn-checkout:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 20px rgba(245, 87, 108, 0.4);
        color: white;
    }

    .stats-box {
        text-align: center;
        padding: 20px;
        border-radius: 10px;
        background: white;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .stats-number {
        font-size: 2.5rem;
        font-weight: bold;
        margin: 10px 0;
    }

    .stats-label {
        color: #6c757d;
        font-size: 0.9rem;
    }

    .time-display {
        font-size: 3rem;
        font-weight: bold;
        color: #667eea;
        text-align: center;
        margin: 20px 0;
    }

    .date-display {
        font-size: 1.2rem;
        color: #6c757d;
        text-align: center;
        margin-bottom: 30px;
    }
</style>

<div class="container-fluid">
    <!-- Current Time & Date -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card attendance-card">
                <div class="card-body">
                    <div class="time-display" id="currentTime">--:--:--</div>
                    <div class="date-display" id="currentDate">{{ now()->isoFormat('dddd, D MMMM Y') }}</div>

                    <div class="text-center">
                        @if($todayAttendance && $todayAttendance->check_in_time && !$todayAttendance->check_out_time)
                            <button type="button" class="btn btn-checkout" id="checkoutBtn">
                                <i class="fas fa-sign-out-alt mr-2"></i> CHECK OUT
                            </button>
                        @elseif(!$todayAttendance || !$todayAttendance->check_in_time)
                            <button type="button" class="btn btn-checkin" id="checkinBtn">
                                <i class="fas fa-sign-in-alt mr-2"></i> CHECK IN
                            </button>
                        @else
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle"></i> Anda sudah melakukan check-in dan check-out hari ini
                            </div>
                        @endif
                    </div>

                    @if($todayAttendance)
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="text-center">
                                <h5>Check-In</h5>
                                <p class="h3 text-success">
                                    {{ $todayAttendance->check_in_time ? $todayAttendance->check_in_time->format('H:i:s') : '-' }}
                                </p>
                                <span class="badge badge-{{ $todayAttendance->status_badge }}">
                                    {{ $todayAttendance->status_label }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-center">
                                <h5>Check-Out</h5>
                                <p class="h3 text-danger">
                                    {{ $todayAttendance->check_out_time ? $todayAttendance->check_out_time->format('H:i:s') : '-' }}
                                </p>
                                <span class="text-muted">
                                    Durasi: {{ $todayAttendance->formatted_work_duration }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stats-box">
                <i class="fas fa-check-circle text-success" style="font-size: 2rem;"></i>
                <div class="stats-number text-success">{{ $stats['total_hadir'] }}</div>
                <div class="stats-label">Hadir Bulan Ini</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-box">
                <i class="fas fa-clock text-warning" style="font-size: 2rem;"></i>
                <div class="stats-number text-warning">{{ $stats['total_terlambat'] }}</div>
                <div class="stats-label">Terlambat</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-box">
                <i class="fas fa-times-circle text-danger" style="font-size: 2rem;"></i>
                <div class="stats-number text-danger">{{ $stats['total_tidak_hadir'] }}</div>
                <div class="stats-label">Tidak Hadir</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-box">
                <i class="fas fa-business-time text-info" style="font-size: 2rem;"></i>
                <div class="stats-number text-info">{{ floor($stats['total_overtime'] / 60) }}</div>
                <div class="stats-label">Jam Lembur</div>
            </div>
        </div>
    </div>

    <!-- Attendance History -->
    <div class="row">
        <div class="col-12">
            <div class="card attendance-card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-history mr-2"></i> Riwayat Absensi Bulan Ini</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Check-In</th>
                                    <th>Check-Out</th>
                                    <th>Durasi Kerja</th>
                                    <th>Lembur</th>
                                    <th>Status</th>
                                    <th>Verifikasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($attendances as $attendance)
                                <tr>
                                    <td>{{ $attendance->date->isoFormat('dddd, D MMM Y') }}</td>
                                    <td>
                                        {{ $attendance->check_in_time ? $attendance->check_in_time->format('H:i') : '-' }}
                                    </td>
                                    <td>
                                        {{ $attendance->check_out_time ? $attendance->check_out_time->format('H:i') : '-' }}
                                    </td>
                                    <td>{{ $attendance->formatted_work_duration }}</td>
                                    <td>{{ $attendance->formatted_overtime }}</td>
                                    <td>
                                        <span class="badge badge-{{ $attendance->status_badge }}">
                                            {{ $attendance->status_label }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($attendance->approved_by)
                                            <i class="fas fa-check-circle text-success" title="Diverifikasi"></i>
                                        @else
                                            <i class="fas fa-clock text-warning" title="Menunggu verifikasi"></i>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">Belum ada data absensi bulan ini</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Update current time
    function updateTime() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        document.getElementById('currentTime').textContent = `${hours}:${minutes}:${seconds}`;
    }

    setInterval(updateTime, 1000);
    updateTime();

    // Check-in button
    $('#checkinBtn').click(function() {
        if (confirm('Apakah Anda yakin ingin melakukan check-in?')) {
            $.ajax({
                url: '{{ route("attendance.checkin") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    alert(response.message);
                    location.reload();
                },
                error: function(xhr) {
                    const error = xhr.responseJSON?.error || 'Terjadi kesalahan';
                    alert(error);
                }
            });
        }
    });

    // Check-out button
    $('#checkoutBtn').click(function() {
        if (confirm('Apakah Anda yakin ingin melakukan check-out?')) {
            $.ajax({
                url: '{{ route("attendance.checkout") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    alert(response.message + '\nDurasi Kerja: ' + response.data.work_duration);
                    location.reload();
                },
                error: function(xhr) {
                    const error = xhr.responseJSON?.error || 'Terjadi kesalahan';
                    alert(error);
                }
            });
        }
    });
</script>
@endpush

@endsection
