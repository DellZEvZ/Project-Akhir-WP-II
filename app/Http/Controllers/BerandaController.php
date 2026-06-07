<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Barber;
use App\Models\Layanan;
use App\Models\Galeri;
use App\Models\Produk;
use App\Models\Order;

class BerandaController extends Controller
{
    public function berandaBackend()
    {
        $totalBarber    = Barber::count();
        $barberAktif    = Barber::where('status', 'aktif')->count();
        $totalLayanan   = Layanan::count();
        $layananAktif   = Layanan::where('status', 'aktif')->count();
        $totalGaleri    = Galeri::count();
        $totalProduk    = Produk::count();

        // Layanan terbaru (5 item)
        $layananTerbaru = Layanan::latest()->take(5)->get();

        // Barber aktif terbaru
        $barberTerbaru  = Barber::where('status', 'aktif')->latest()->take(5)->get();

        // Booking
        $bookingBaru    = Order::where('status', 'confirmed')->count();
        $bookingTerbaru = Order::with(['customer', 'orderItems'])
            ->where('status', '!=', 'pending')
            ->latest()->take(5)->get();

        return view('backend.v_beranda.index', [
            'judul'          => 'Dashboard Barbershop',
            'user'           => Auth::user(),
            'totalBarber'    => $totalBarber,
            'barberAktif'    => $barberAktif,
            'totalLayanan'   => $totalLayanan,
            'layananAktif'   => $layananAktif,
            'totalGaleri'    => $totalGaleri,
            'totalProduk'    => $totalProduk,
            'layananTerbaru' => $layananTerbaru,
            'barberTerbaru'  => $barberTerbaru,
            'bookingBaru'    => $bookingBaru,
            'bookingTerbaru' => $bookingTerbaru,
        ]);
    }
}
