<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

/**
 * Mengunci akses backend khusus untuk role "barber".
 *
 * Barber hanya boleh mengakses halaman absensi miliknya sendiri
 * (attendance.index, attendance.checkin, attendance.checkout,
 * attendance.history, attendance.export) serta halaman profil &
 * logout. Semua rute backend lainnya akan di-redirect ke halaman
 * absensi dengan pesan penjelasan.
 */
class RedirectBarberToAttendance
{
    /**
     * Rute yang TETAP boleh diakses oleh role barber.
     */
    private array $allowedRouteNames = [
        'attendance.index',
        'attendance.checkin',
        'attendance.checkout',
        'attendance.history',
        'attendance.export',
        'backend.profil.index',
        'backend.profil.update',
        'backend.profil.password',
        'backend.logout',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user && $user->hasRole('barber')) {
            $routeName = $request->route()?->getName();

            if (! in_array($routeName, $this->allowedRouteNames, true)) {
                return redirect()->route('attendance.index')
                    ->with('error', 'Akun Barber hanya memiliki akses ke halaman Absensi.');
            }
        }

        return $next($request);
    }
}
