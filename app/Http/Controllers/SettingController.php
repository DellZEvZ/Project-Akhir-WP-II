<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityLog;
use App\Models\User;
use App\Models\Setting;
use App\Helpers\ActivityLogger;

class SettingController extends Controller
{
    /**
     * Display System Settings
     */
    public function sistem()
    {
        $settings = Setting::getAll();

        return view('backend.v_setting.sistem', [
            'judul' => 'Pengaturan Sistem',
            'settings' => $settings
        ]);
    }

    /**
     * Update System Settings
     */
    public function updateSistem(Request $request)
    {
        $validated = $request->validate([
            'app_name' => 'required|string|max:255',
            'app_version' => 'required|string|max:50',
            'app_timezone' => 'required|string',
            'pagination_per_page' => 'required|integer|min:5|max:100',
            'maintenance_mode' => 'nullable|boolean',
            'maintenance_message' => 'nullable|string',
            'session_lifetime' => 'required|integer|min:30|max:1440',
            'date_format' => 'required|string',
            'time_format' => 'required|string',
            'enable_registration' => 'nullable|boolean',
            'backup_auto_delete_days' => 'required|integer|min:7|max:365',
        ]);

        // Convert checkbox values
        $validated['maintenance_mode'] = $request->has('maintenance_mode') ? '1' : '0';
        $validated['enable_registration'] = $request->has('enable_registration') ? '1' : '0';

        foreach ($validated as $key => $value) {
            $type = 'string';

            if (in_array($key, ['maintenance_mode', 'enable_registration'])) {
                $type = 'boolean';
            } elseif (in_array($key, ['pagination_per_page', 'session_lifetime', 'backup_auto_delete_days'])) {
                $type = 'integer';
            }

            Setting::set($key, $value, $type);
        }

        // Log activity
        ActivityLogger::log('update', 'setting', 'Memperbarui pengaturan sistem');

        return redirect()
            ->route('backend.setting.sistem')
            ->with('success', 'Pengaturan sistem berhasil diperbarui!');
    }

    /**
     * Display Backup & Restore Page
     */
    public function backup()
    {
        return view('backend.v_setting.backup', [
            'judul' => 'Backup & Restore Data'
        ]);
    }

    /**
     * Display Activity Log
     */
    public function log(Request $request)
    {
        // Build query
        $query = ActivityLog::with('user')->latest();

        // Filter by action type
        if ($request->filled('action_type')) {
            $query->where('action_type', $request->action_type);
        }

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by module
        if ($request->filled('module')) {
            $query->where('module', $request->module);
        }

        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        // Paginate
        $logs = $query->paginate(20);

        // Get statistics
        $todayLogs = ActivityLog::whereDate('created_at', today())->count();
        $activeUsersToday = ActivityLog::whereDate('created_at', today())
            ->distinct('user_id')
            ->count('user_id');
        $lastLogin = ActivityLog::where('action_type', 'login')
            ->latest()
            ->first();

        // Get all users for filter
        $users = User::orderBy('nama')->get();

        return view('backend.v_setting.log', [
            'judul' => 'Log Aktivitas',
            'logs' => $logs,
            'todayLogs' => $todayLogs,
            'activeUsersToday' => $activeUsersToday,
            'lastLogin' => $lastLogin,
            'users' => $users,
            'filters' => $request->only(['action_type', 'user_id', 'module', 'date']),
        ]);
    }

    /**
     * Display Account Settings
     */
    public function akun()
    {
        return view('backend.v_setting.akun', [
            'judul' => 'Pengaturan Akun'
        ]);
    }

    /**
     * Display Help & Support Page
     */
    public function bantuan()
    {
        return view('backend.v_setting.bantuan', [
            'judul' => 'Bantuan & Dukungan'
        ]);
    }

    /**
     * Display Notifications Page
     */
    public function notifikasi()
    {
        return view('backend.v_notifikasi.index', [
            'judul' => 'Notifikasi'
        ]);
    }

    /**
     * Display Messages Page
     */
    public function pesan()
    {
        return view('backend.v_pesan.index', [
            'judul' => 'Pesan'
        ]);
    }
}
