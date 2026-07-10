<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Layanan;
use App\Models\Barber;
use App\Models\Galeri;
use App\Models\Produk;
use App\Models\Kategori;

class FrontController extends Controller
{
    /**
     * Cache data katalog publik selama 10 menit.
     *
     * Database berada di server terpisah dengan latensi ~1 detik per query,
     * sehingga tiap query menyumbang beberapa detik pada waktu muat halaman.
     * Data katalog jarang berubah, jadi aman di-cache. Perubahan dari panel
     * admin tampil paling lambat 10 menit (atau setelah `php artisan cache:clear`).
     *
     * Hanya dipakai untuk tampilan default; hasil pencarian/filter TIDAK
     * di-cache karena kombinasinya banyak dan jarang berulang.
     */
    private function ingat(string $key, \Closure $fn)
    {
        return Cache::remember($key, now()->addMinutes(10), $fn);
    }

    // Homepage
    public function index()
    {
        $data = $this->ingat('front:beranda', fn () => [
            'layananUnggulan' => Layanan::where('status', 'aktif')->latest()->take(6)->get(),
            'barbers'         => Barber::where('status', 'aktif')->take(4)->get(),
            'galeris'         => Galeri::latest()->take(8)->get(),
            'produkUnggulan'  => Produk::where('status', 1)->latest()->take(4)->get(),
        ]);

        return view('frontend.v_beranda.index', $data);
    }

    // Semua layanan + pencarian
    public function layanan(Request $request)
    {
        $ambil = fn () => Layanan::where('status', 'aktif')
            ->when($request->filled('search'), fn ($q) => $q->where('nama_layanan', 'like', '%' . $request->search . '%'))
            ->orderBy('harga')
            ->paginate(9)
            ->withQueryString();

        $layanans = $request->filled('search')
            ? $ambil()
            : $this->ingat('front:layanan:p' . $request->integer('page', 1), $ambil);

        return view('frontend.v_layanan.index', [
            'layanans' => $layanans,
            'search'   => $request->search,
        ]);
    }

    // Detail layanan
    public function layananDetail($id)
    {
        $key  = "front:layanan:detail:{$id}";
        $data = $this->ingat($key, fn () => [
            'layanan' => Layanan::where('status', 'aktif')->find($id),
            'lainnya' => Layanan::where('status', 'aktif')->where('id', '!=', $id)->take(3)->get(),
        ]);

        if (! $data['layanan']) {
            Cache::forget($key); // jangan simpan hasil "tidak ditemukan"
            abort(404);
        }

        return view('frontend.v_layanan.detail', $data);
    }

    // Tim barber
    public function barber()
    {
        $barbers = $this->ingat(
            'front:barber',
            fn () => Barber::where('status', 'aktif')->orderBy('nama')->get()
        );

        return view('frontend.v_barber.index', compact('barbers'));
    }

    // Galeri
    public function galeri(Request $request)
    {
        $ambil = fn () => Galeri::query()
            ->when($request->filled('tipe'), fn ($q) => $q->where('tipe', $request->tipe))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $galeris = $request->filled('tipe')
            ? $ambil()
            : $this->ingat('front:galeri:p' . $request->integer('page', 1), $ambil);

        return view('frontend.v_galeri.index', [
            'galeris' => $galeris,
            'tipe'    => $request->tipe,
        ]);
    }

    // Katalog produk
    public function produk(Request $request)
    {
        $adaFilter = $request->filled('search') || $request->filled('kategori');

        $ambil = fn () => Produk::where('status', 1)
            ->when($request->filled('search'), fn ($q) => $q->where('nama_produk', 'like', '%' . $request->search . '%'))
            ->when($request->filled('kategori'), fn ($q) => $q->where('kategori_id', $request->kategori))
            ->latest()
            ->paginate(9)
            ->withQueryString();

        $produks = $adaFilter
            ? $ambil()
            : $this->ingat('front:produk:p' . $request->integer('page', 1), $ambil);

        $kategoris = $this->ingat('front:kategori', fn () => Kategori::all());

        return view('frontend.v_produk.index', [
            'produks'   => $produks,
            'kategoris' => $kategoris,
            'search'    => $request->search,
        ]);
    }

    // Detail produk
    public function produkDetail($id)
    {
        $key  = "front:produk:detail:{$id}";
        $data = $this->ingat($key, fn () => [
            'produk'  => Produk::where('status', 1)->find($id),
            'lainnya' => Produk::where('status', 1)->where('id', '!=', $id)->take(4)->get(),
        ]);

        if (! $data['produk']) {
            Cache::forget($key); // jangan simpan hasil "tidak ditemukan"
            abort(404);
        }

        return view('frontend.v_produk.detail', $data);
    }

    // Katalog gabungan: layanan + produk dalam satu halaman
    public function catalog(Request $request)
    {
        $search = $request->search;
        $tab    = $request->get('tab', 'layanan');

        $ambilLayanan = fn () => Layanan::where('status', 'aktif')
            ->when($search, fn ($q) => $q->where('nama_layanan', 'like', "%{$search}%"))
            ->orderBy('harga')
            ->get();

        $ambilProduk = fn () => Produk::where('status', 1)
            ->when($search, fn ($q) => $q->where('nama_produk', 'like', "%{$search}%"))
            ->latest()
            ->get();

        $layanans = $search ? $ambilLayanan() : $this->ingat('front:catalog:layanan', $ambilLayanan);
        $produks  = $search ? $ambilProduk()  : $this->ingat('front:catalog:produk', $ambilProduk);

        return view('frontend.v_catalog.index', compact('layanans', 'produks', 'search', 'tab'));
    }
}
