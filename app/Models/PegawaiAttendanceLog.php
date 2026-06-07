<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PegawaiAttendanceLog extends Model
{
    use HasFactory;

    protected $table = 'pegawai_attendance_logs';

    protected $fillable = [
        'pegawai_id',
        'date',
        'check_in_time',
        'check_out_time',
        'check_in_photo',
        'check_out_photo',
        'check_in_verified',
        'check_out_verified',
        'status',
        'work_duration_minutes',
        'overtime_minutes',
        'notes',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'date' => 'date',
        'check_in_time' => 'datetime',
        'check_out_time' => 'datetime',
        'check_in_verified' => 'boolean',
        'check_out_verified' => 'boolean',
        'approved_at' => 'datetime',
    ];

    /**
     * Relationship: Attendance belongs to Pegawai
     */
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }

    /**
     * Relationship: Approved by User
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Scope: Get attendance for today
     */
    public function scopeToday($query)
    {
        return $query->whereDate('date', today());
    }

    /**
     * Scope: Get attendance for specific month
     */
    public function scopeForMonth($query, $year, $month)
    {
        return $query->whereYear('date', $year)
                     ->whereMonth('date', $month);
    }

    /**
     * Scope: Get pending approval
     */
    public function scopePendingApproval($query)
    {
        return $query->whereNull('approved_by');
    }

    /**
     * Calculate work duration automatically
     */
    public function calculateWorkDuration()
    {
        if ($this->check_in_time && $this->check_out_time) {
            $duration = $this->check_in_time->diffInMinutes($this->check_out_time);
            $this->work_duration_minutes = $duration;

            // Calculate overtime (if work > 8 hours)
            $standardMinutes = 8 * 60; // 8 hours
            if ($duration > $standardMinutes) {
                $this->overtime_minutes = $duration - $standardMinutes;
            }

            return $this;
        }
        return $this;
    }

    /**
     * Auto-determine status based on check-in time
     */
    public function determineStatus()
    {
        if (!$this->check_in_time) {
            $this->status = 'absent';
        } else {
            // Consider late if check-in after 08:30
            $lateThreshold = $this->date->copy()->setTime(8, 30);
            if ($this->check_in_time->gt($lateThreshold)) {
                $this->status = 'late';
            } else {
                $this->status = 'present';
            }
        }
        return $this;
    }

    /**
     * Format work duration as hours and minutes
     */
    public function getFormattedWorkDurationAttribute()
    {
        if (!$this->work_duration_minutes) {
            return '-';
        }

        $hours = floor($this->work_duration_minutes / 60);
        $minutes = $this->work_duration_minutes % 60;

        return sprintf('%d jam %d menit', $hours, $minutes);
    }

    /**
     * Format overtime as hours and minutes
     */
    public function getFormattedOvertimeAttribute()
    {
        if (!$this->overtime_minutes) {
            return '-';
        }

        $hours = floor($this->overtime_minutes / 60);
        $minutes = $this->overtime_minutes % 60;

        return sprintf('%d jam %d menit', $hours, $minutes);
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'present' => 'success',
            'late' => 'warning',
            'absent' => 'danger',
            'leave' => 'info',
            'sick' => 'secondary',
            'holiday' => 'primary',
            default => 'light',
        };
    }

    /**
     * Get status label in Indonesian
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'present' => 'Hadir',
            'late' => 'Terlambat',
            'absent' => 'Tidak Hadir',
            'leave' => 'Cuti',
            'sick' => 'Sakit',
            'holiday' => 'Libur',
            default => 'Unknown',
        };
    }
}
