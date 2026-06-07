<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Layanan;
use App\Models\Barber;
use App\Models\Galeri;
use App\Models\Produk;
use App\Models\Kategori;

class FrontController extends Controller
{
    // Homepage
    public function index()
    {
        $layananUnggulan = Layanan::where('status', 'aktif')->latest()->take(6)->get();
        $barbers         = Barber::where('status', 'aktif')->take(4)->get();
        $galeris         = Galeri::latest()->take(8)->get();
        $produkUnggulan  = Produk::where('status', 1)->latest()->take(4)->get();

        return view('frontend.v_beranda.index', compact(
            'layananUnggulan', 'barbers', 'galeris', 'produkUnggulan'
        ));
    }

    // Semua layanan + pencarian
    public function layanan(Request $request)
    {
        $query = Layanan::where('status', 'aktif');

        if ($request->filled('search')) {
            $query->where('nama_layanan', 'like', '%' . $request->search . '%');
        }

        $layanans = $query->orderBy('harga')->paginate(9)->withQueryString();

        return view('frontend.v_layanan.index', [
            'layanans' => $layanans,
            'search'   => $request->search,
        ]);
    }

    // Detail layanan
    public function layananDetail($id)
    {
        $layanan = Layanan::where('status', 'aktif')->findOrFail($id);
        $lainnya = Layanan::where('status', 'aktif')->where('id', '!=', $id)->take(3)->get();

        return view('frontend.v_layanan.detail', compact('layanan', 'lainnya'));
    }

    // Tim barber
    public function barber()
    {
        $barbers = Barber::where('status', 'aktif')->orderBy('nama')->get();
        return view('frontend.v_barber.index', compact('barbers'));
    }

    // Galeri
    public function galeri(Request $request)
    {
        $query = Galeri::query();

        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }

        $galeris = $query->latest()->paginate(12)->withQueryString();

        return view('frontend.v_galeri.index', [
            'galeris' => $galeris,
            'tipe'    => $request->tipe,
        ]);
    }

    // Katalog produk
    public function produk(Request $request)
    {
        $query = Produk::where('status', 1);

        if ($request->filled('search')) {
            $query->where('nama_produk', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        $produks   = $query->latest()->paginate(9)->withQueryString();
        $kategoris = Kategori::all();

        return view('frontend.v_produk.index', [
            'produks'   => $produks,
            'kategoris' => $kategoris,
            'search'    => $request->search,
        ]);
    }

    // Detail produk
    public function produkDetail($id)
    {
        $produk  = Produk::where('status', 1)->findOrFail($id);
        $lainnya = Produk::where('status', 1)->where('id', '!=', $id)->take(4)->get();

        return view('frontend.v_produk.detail', compact('produk', 'lainnya'));
    }

    // Katalog gabungan: layanan + produk dalam satu halaman
    public function catalog(Request $request)
    {
        $search = $request->search;
        $tab    = $request->get('tab', 'layanan');

        $layanans = Layanan::where('status', 'aktif')
            ->when($search, fn ($q) => $q->where('nama_layanan', 'like', "%{$search}%"))
            ->orderBy('harga')
            ->get();

        $produks = Produk::where('status', 1)
            ->when($search, fn ($q) => $q->where('nama_produk', 'like', "%{$search}%"))
            ->latest()
            ->get();

        return view('frontend.v_catalog.index', compact('layanans', 'produks', 'search', 'tab'));
    }
}
