<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class IsCustomer
{
    /**
     * Cek apakah customer sudah login via session.
     * Jika belum, redirect ke halaman login customer.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Session::has('customer')) {
            return redirect()->route('customer.login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        return $next($request);
    }
}
