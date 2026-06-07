<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $permission  Permission name to check
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            abort(403, 'Unauthorized - Please login first.');
        }

        $user = Auth::user();

        // Check if user has the required permission
        if (!$user->hasPermission($permission)) {
            // Return 403 forbidden or redirect with error message
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki izin untuk mengakses halaman ini.',
                    'permission_required' => $permission
                ], 403);
            }

            return redirect()->route('backend.beranda')
                ->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini. Permission yang diperlukan: ' . $permission);
        }

        return $next($request);
    }
}
