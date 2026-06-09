<?php

namespace App\Http\Controllers;

use App\Models\PegawaiAttendanceLog;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Traits\HasPermissionCheck;
use App\Helpers\ActivityLogger;

class AttendanceController extends Controller
{
    use HasPermissionCheck;
    /**
     * Display attendance list for pegawai
     */
    public function index()
    {
        $user = Auth::user();
        $pegawai = Pegawai::where('user_id', $user->id)->first();

        // If user doesn't have pegawai data but has attendance.manage-all permission,
        // redirect to admin attendance page
        if (!$pegawai) {
            if ($user->hasPermission('attendance.manage-all')) {
                return redirect()->route('attendance.admin.index')
                    ->with('info', 'Anda dialihkan ke halaman manajemen attendance karena tidak memiliki data pegawai.');
            }

            return redirect()->route('backend.beranda')
                ->with('error', 'Data pegawai tidak ditemukan. Silakan hubungi admin untuk membuat data pegawai Anda.');
        }

        // Get current month attendance
        $currentYear = now()->year;
        $currentMonth = now()->month;

        $attendances = PegawaiAttendanceLog::where('pegawai_id', $pegawai->id)
            ->forMonth($currentYear, $currentMonth)
            ->orderBy('date', 'desc')
            ->get();

        // Get today's attendance
        $todayAttendance = PegawaiAttendanceLog::where('pegawai_id', $pegawai->id)
            ->whereDate('date', today())
            ->first();

        // Statistics
        $stats = [
            'total_hadir' => PegawaiAttendanceLog::where('pegawai_id', $pegawai->id)
                ->whereIn('status', ['present', 'late'])
                ->forMonth($currentYear, $currentMonth)
                ->count(),
            'total_terlambat' => PegawaiAttendanceLog::where('pegawai_id', $pegawai->id)
                ->where('status', 'late')
                ->forMonth($currentYear, $currentMonth)
                ->count(),
            'total_tidak_hadir' => PegawaiAttendanceLog::where('pegawai_id', $pegawai->id)
                ->where('status', 'absent')
                ->forMonth($currentYear, $currentMonth)
                ->count(),
            'total_overtime' => PegawaiAttendanceLog::where('pegawai_id', $pegawai->id)
                ->forMonth($currentYear, $currentMonth)
                ->sum('overtime_minutes'),
        ];

        return view('backend.v_attendance.index', compact('attendances', 'todayAttendance', 'stats', 'pegawai'));
    }

    /**
     * Check in
     */
    public function checkIn(Request $request)
    {
        $user = Auth::user();
        $pegawai = Pegawai::where('user_id', $user->id)->first();

        if (!$pegawai) {
            return response()->json(['error' => 'Data pegawai tidak ditemukan'], 404);
        }

        // Check if already checked in today
        $existing = PegawaiAttendanceLog::where('pegawai_id', $pegawai->id)
            ->whereDate('date', today())
            ->first();

        if ($existing && $existing->check_in_time) {
            return response()->json(['error' => 'Anda sudah melakukan check-in hari ini'], 400);
        }

        DB::beginTransaction();
        try {
            $checkInTime = now();

            if ($existing) {
                // Update existing record
                $existing->check_in_time = $checkInTime;
                $existing->determineStatus();
                $existing->save();
                $attendance = $existing;
            } else {
                // Create new record
                $attendance = new PegawaiAttendanceLog();
                $attendance->pegawai_id = $pegawai->id;
                $attendance->date = today();
                $attendance->check_in_time = $checkInTime;
                $attendance->determineStatus();
                $attendance->save();
            }

            DB::commit();

            ActivityLogger::log('login', 'absensi', "Pegawai {$pegawai->nama} check-in pukul " . $attendance->check_in_time->format('H:i'), $attendance);

            return response()->json([
                'success' => true,
                'message' => 'Check-in berhasil!',
                'data' => [
                    'check_in_time' => $attendance->check_in_time->format('H:i:s'),
                    'status' => $attendance->status_label,
                    'status_badge' => $attendance->status_badge,
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Check out
     */
    public function checkOut(Request $request)
    {
        $user = Auth::user();
        $pegawai = Pegawai::where('user_id', $user->id)->first();

        if (!$pegawai) {
            return response()->json(['error' => 'Data pegawai tidak ditemukan'], 404);
        }

        // Find today's attendance
        $attendance = PegawaiAttendanceLog::where('pegawai_id', $pegawai->id)
            ->whereDate('date', today())
            ->first();

        if (!$attendance) {
            return response()->json(['error' => 'Anda belum check-in hari ini'], 400);
        }

        if (!$attendance->check_in_time) {
            return response()->json(['error' => 'Anda belum check-in hari ini'], 400);
        }

        if ($attendance->check_out_time) {
            return response()->json(['error' => 'Anda sudah melakukan check-out hari ini'], 400);
        }

        DB::beginTransaction();
        try {
            $attendance->check_out_time = now();
            $attendance->calculateWorkDuration();
            $attendance->save();

            DB::commit();

            ActivityLogger::log('logout', 'absensi', "Pegawai {$pegawai->nama} check-out pukul " . $attendance->check_out_time->format('H:i'), $attendance);

            return response()->json([
                'success' => true,
                'message' => 'Check-out berhasil!',
                'data' => [
                    'check_out_time' => $attendance->check_out_time->format('H:i:s'),
                    'work_duration' => $attendance->formatted_work_duration,
                    'overtime' => $attendance->formatted_overtime,
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Get attendance history
     */
    public function history(Request $request)
    {
        $user = Auth::user();
        $pegawai = Pegawai::where('user_id', $user->id)->first();

        if (!$pegawai) {
            return redirect()->route('backend.beranda')->with('error', 'Data pegawai tidak ditemukan');
        }

        $year = $request->input('year', now()->year);
        $month = $request->input('month', now()->month);

        $attendances = PegawaiAttendanceLog::where('pegawai_id', $pegawai->id)
            ->forMonth($year, $month)
            ->orderBy('date', 'desc')
            ->get();

        return view('backend.v_attendance.history', compact('attendances', 'pegawai', 'year', 'month'));
    }

    /**
     * Admin: View all attendance
     */
    public function adminIndex(Request $request)
    {
        // Check permission
        if ($response = $this->checkPermission('attendance.manage-all', 'Anda tidak memiliki izin untuk mengelola attendance.')) {
            return $response;
        }

        $query = PegawaiAttendanceLog::with(['pegawai', 'approver']);

        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        } else {
            // Default: today
            $query->whereDate('date', today());
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by pegawai
        if ($request->filled('pegawai_id')) {
            $query->where('pegawai_id', $request->pegawai_id);
        }

        $attendances = $query->orderBy('date', 'desc')
            ->orderBy('check_in_time', 'asc')
            ->paginate(20);

        $pegawais = Pegawai::orderBy('nama')->get();

        return view('backend.v_attendance.admin_index', compact('attendances', 'pegawais'));
    }

    /**
     * Admin: Approve attendance
     */
    public function approve($id)
    {
        // Check permission
        if ($response = $this->checkPermission('attendance.manage-all', 'Anda tidak memiliki izin untuk meng-approve attendance.')) {
            return $response;
        }

        $attendance = PegawaiAttendanceLog::findOrFail($id);

        $attendance->approved_by = Auth::id();
        $attendance->approved_at = now();
        $attendance->check_in_verified = true;
        $attendance->check_out_verified = true;
        $attendance->save();

        return redirect()->back()->with('success', 'Attendance approved successfully');
    }

    /**
     * Admin: Edit attendance
     */
    public function edit($id)
    {
        // Check permission
        if ($response = $this->checkPermission('attendance.manage-all', 'Anda tidak memiliki izin untuk mengedit attendance.')) {
            return $response;
        }

        $attendance = PegawaiAttendanceLog::with('pegawai')->findOrFail($id);
        $pegawais = Pegawai::orderBy('nama')->get();

        return view('backend.v_attendance.edit', compact('attendance', 'pegawais'));
    }

    /**
     * Admin: Update attendance
     */
    public function update(Request $request, $id)
    {
        // Check permission
        if ($response = $this->checkPermission('attendance.manage-all', 'Anda tidak memiliki izin untuk mengupdate attendance.')) {
            return $response;
        }

        $request->validate([
            'date' => 'required|date',
            'check_in_time' => 'nullable|date_format:H:i',
            'check_out_time' => 'nullable|date_format:H:i|after:check_in_time',
            'status' => 'required|in:present,late,absent,leave,sick,holiday',
            'notes' => 'nullable|string',
        ]);

        $attendance = PegawaiAttendanceLog::findOrFail($id);

        DB::beginTransaction();
        try {
            $attendance->date = $request->date;
            $attendance->status = $request->status;
            $attendance->notes = $request->notes;

            if ($request->filled('check_in_time')) {
                $attendance->check_in_time = Carbon::parse($request->date . ' ' . $request->check_in_time);
            }

            if ($request->filled('check_out_time')) {
                $attendance->check_out_time = Carbon::parse($request->date . ' ' . $request->check_out_time);
            }

            // Recalculate work duration
            $attendance->calculateWorkDuration();

            // Mark as approved by admin
            $attendance->approved_by = Auth::id();
            $attendance->approved_at = now();
            $attendance->check_in_verified = true;
            $attendance->check_out_verified = true;

            $attendance->save();

            DB::commit();

            return redirect()->route('attendance.admin.index')
                ->with('success', 'Attendance updated successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error updating attendance: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Admin: Delete attendance
     */
    public function destroy($id)
    {
        // Check permission
        if ($response = $this->checkPermission('attendance.manage-all', 'Anda tidak memiliki izin untuk menghapus attendance.')) {
            return $response;
        }

        $attendance = PegawaiAttendanceLog::findOrFail($id);
        $attendance->delete();

        return redirect()->back()->with('success', 'Attendance deleted successfully');
    }

    /**
     * Export attendance report
     */
    public function export(Request $request)
    {
        // TODO: Implement export to Excel/PDF
        return response()->json(['message' => 'Export feature coming soon']);
    }
}
