<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\Barber;
use App\Models\Layanan;
use App\Models\Galeri;
use App\Models\Produk;
use App\Models\Order;

class BerandaController extends Controller
{
    public function berandaBackend()
    {
        // The dashboard aggregates counts across 5 different models (Barber,
        // Layanan, Galeri, Produk, Order), so invalidating this cache on every
        // write in every one of those controllers isn't worth the coupling.
        // A short TTL is enough for a summary screen like this.
        $stats = Cache::remember('admin:dashboard:stats', now()->addMinutes(2), function () {
            return [
                'totalBarber'    => Barber::count(),
                'barberAktif'    => Barber::where('status', 'aktif')->count(),
                'totalLayanan'   => Layanan::count(),
                'layananAktif'   => Layanan::where('status', 'aktif')->count(),
                'totalGaleri'    => Galeri::count(),
                'totalProduk'    => Produk::count(),
                'layananTerbaru' => Layanan::latest()->take(5)->get(),
                'barberTerbaru'  => Barber::where('status', 'aktif')->latest()->take(5)->get(),
                'bookingBaru'    => Order::where('status', 'confirmed')->count(),
                'bookingTerbaru' => Order::with(['customer', 'orderItems'])
                    ->where('status', '!=', 'pending')
                    ->latest()->take(5)->get(),
            ];
        });

        return view('backend.v_beranda.index', array_merge($stats, [
            'judul' => 'Dashboard Barbershop',
            'user'  => Auth::user(),
        ]));
    }
}
