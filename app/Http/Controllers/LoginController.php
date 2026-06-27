<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ActivityLogger;

class LoginController extends Controller
{
    /**
     * Show the backend login page
     */
    public function loginBackend()
    {
        return view('backend.v_login.login');
    }

    /**
     * Handle authentication for backend users
     */
    public function authenticateBackend(Request $request)
    {
        // ✅ Validate input fields (case 1 & 2)
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'email.required' => 'Bidang isian email wajib diisi.',
            'email.email' => 'Isian email harus berupa alamat email yang valid.',
            'password.required' => 'Bidang isian password wajib diisi.'
        ]);

        // ✅ Attempt login (case 3 & 4)
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // ✅ Check if user is inactive (case 5)
            if ($user->status == 0) {
                Auth::logout();
                return back()->with('error', [
                    'title' => 'Akun Tidak Aktif!',
                    'message' => 'Status akun Anda tidak aktif. Silakan hubungi administrator untuk mengaktifkan akun Anda.',
                    'type' => 'warning'
                ])->withInput();
            }

            // ✅ If valid and active (case 6)
            // Log successful login
            ActivityLogger::login($user->nama . ' (' . $user->email . ')');

            // Set success message for sweet alert
            session()->flash('success', 'Selamat datang, ' . $user->nama);

            // Akun barber hanya memiliki akses ke halaman Absensi.
            if ($user->hasRole('barber')) {
                return redirect()->route('attendance.index');
            }

            return redirect()->route('backend.beranda');
        }

        // ❌ If login fails
        return back()->with('error', [
            'title' => 'Login Gagal!',
            'message' => 'Email atau password yang Anda masukkan salah. Silakan coba lagi.',
            'type' => 'error'
        ])->withInput();
    }

    /**
     * Handle logout
     */
    public function logoutBackend()
    {
        $user = Auth::user();

        // Log logout before actually logging out
        if ($user) {
            ActivityLogger::logout($user->nama . ' (' . $user->email . ')');
        }

        Auth::logout();
        return redirect()->route('backend.login');
    }
}
