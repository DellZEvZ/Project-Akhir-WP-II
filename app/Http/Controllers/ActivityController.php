<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * Feed traffic / aktivitas web untuk supervisor/pemilik:
     * login pelanggan, pendaftaran, booking/pembelian, pembayaran, absensi pegawai,
     * serta aksi admin (CRUD).
     */
    public function index(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        if ($request->filled('module')) {
            $query->where('module', $request->module);
        }
        if ($request->filled('action')) {
            $query->where('action_type', $request->action);
        }

        $logs = $query->paginate(25)->withQueryString();

        $modules = ActivityLog::query()->select('module')->distinct()->pluck('module');

        $stats = [
            'hari_ini'    => ActivityLog::whereDate('created_at', today())->count(),
            'pelanggan'   => ActivityLog::where('module', 'pelanggan')->count(),
            'transaksi'   => ActivityLog::whereIn('module', ['pesanan', 'pembayaran'])->count(),
            'absensi'     => ActivityLog::where('module', 'absensi')->count(),
        ];

        return view('backend.v_activity.index', [
            'judul'   => 'Traffic & Aktivitas',
            'logs'    => $logs,
            'modules' => $modules,
            'stats'   => $stats,
        ]);
    }
}
