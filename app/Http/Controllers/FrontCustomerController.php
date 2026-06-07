<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use App\Models\Customer;
use App\Models\Order;
use App\Helpers\ImageHelper;

class FrontCustomerController extends Controller
{
    // Halaman login & register
    public function loginPage()
    {
        if (Session::has('customer')) {
            return redirect()->route('beranda');
        }
        return view('frontend.v_customer.login');
    }

    // Proses register
    public function register(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|unique:customers,email',
            'password' => 'required|min:6|confirmed',
        ], [
            'email.unique'       => 'Email sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $customer = Customer::create([
            'nama'     => $request->nama,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Session::put('customer', $customer);

        return redirect()->route('beranda')
            ->with('success', 'Registrasi berhasil! Selamat datang, ' . $customer->nama . '.');
    }

    // Proses login
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $customer = Customer::where('email', $request->email)->first();

        if (!$customer || !$customer->password || !Hash::check($request->password, $customer->password)) {
            return back()
                ->withInput($request->only('email'))
                ->with('login_error', 'Email atau password salah.');
        }

        Session::put('customer', $customer);

        return redirect()->route('beranda')
            ->with('success', 'Selamat datang kembali, ' . $customer->nama . '!');
    }

    // Redirect ke halaman login Google
    public function googleRedirect()
    {
        return Socialite::driver('google')->redirect();
    }

    // Callback setelah login Google
    public function googleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $customer = Customer::updateOrCreate(
                ['google_id' => $googleUser->getId()],
                [
                    'nama'  => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'foto'  => $googleUser->getAvatar(),
                ]
            );

            Session::put('customer', $customer);

            return redirect()->route('beranda')
                ->with('success', 'Berhasil login dengan Google! Selamat datang, ' . $customer->nama . '.');
        } catch (\Exception $e) {
            return redirect()->route('customer.login')
                ->with('error', 'Login Google gagal, silakan coba lagi.');
        }
    }

    // Logout
    public function logout()
    {
        Session::forget('customer');
        return redirect()->route('beranda')->with('success', 'Anda telah logout.');
    }

    // Halaman akun + riwayat booking
    public function akun()
    {
        $customer = Customer::findOrFail(Session::get('customer')->id);

        $orders = Order::with('orderItems.layanan', 'orderItems.produk')
            ->where('customer_id', $customer->id)
            ->where('status', '!=', 'pending')
            ->latest()
            ->get();

        return view('frontend.v_customer.akun', compact('customer', 'orders'));
    }

    // Update akun
    public function updateAkun(Request $request)
    {
        $customer = Customer::findOrFail(Session::get('customer')->id);

        $request->validate([
            'nama'   => 'required|string|max:255',
            'no_hp'  => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:500',
            'foto'   => 'nullable|image|mimes:jpeg,jpg,png|max:1024',
        ]);

        $data = $request->only(['nama', 'no_hp', 'alamat']);

        if ($request->hasFile('foto')) {
            if ($customer->foto && !str_starts_with($customer->foto, 'http')) {
                ImageHelper::deleteImage($customer->foto, 'img-customer');
            }
            $file     = $request->file('foto');
            $fileName = 'cust_' . time() . '.' . $file->getClientOriginalExtension();
            ImageHelper::storeImage($file, 'img-customer', $fileName);
            $data['foto'] = $fileName;
        }

        $customer->update($data);
        Session::put('customer', $customer->fresh());

        return redirect()->route('customer.akun')->with('success', 'Akun berhasil diperbarui.');
    }
}
