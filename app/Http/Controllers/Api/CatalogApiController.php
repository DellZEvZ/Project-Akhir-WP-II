<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use App\Models\Produk;
use App\Models\Barber;
use App\Models\Galeri;
use Illuminate\Http\Request;

class CatalogApiController extends Controller
{
    private function ok($data, string $message = 'OK')
    {
        return response()->json(['success' => true, 'data' => $data, 'message' => $message]);
    }

    private function img(?string $folder, ?string $foto): ?string
    {
        if (!$foto) return null;
        if (str_starts_with($foto, 'http')) return $foto;
        return asset("storage/{$folder}/{$foto}");
    }

    public function layanan(Request $request)
    {
        $query = Layanan::where('status', 'aktif');
        if ($request->filled('search')) {
            $query->where('nama_layanan', 'like', '%' . $request->search . '%');
        }

        $data = $query->orderBy('harga')->get()->map(fn ($l) => [
            'id'        => $l->id,
            'nama'      => $l->nama_layanan,
            'harga'     => (int) $l->harga,
            'durasi'    => $l->durasi_menit,
            'deskripsi' => $l->deskripsi,
            'gambar'    => $this->img('img-layanan', $l->foto),
        ]);

        return $this->ok($data);
    }

    public function layananShow($id)
    {
        $l = Layanan::where('status', 'aktif')->find($id);
        if (!$l) {
            return response()->json(['success' => false, 'message' => 'Layanan tidak ditemukan'], 404);
        }

        return $this->ok([
            'id'        => $l->id,
            'nama'      => $l->nama_layanan,
            'harga'     => (int) $l->harga,
            'durasi'    => $l->durasi_menit,
            'deskripsi' => $l->deskripsi,
            'gambar'    => $this->img('img-layanan', $l->foto),
        ]);
    }

    public function produk(Request $request)
    {
        $query = Produk::where('status', 1);
        if ($request->filled('search')) {
            $query->where('nama_produk', 'like', '%' . $request->search . '%');
        }

        $data = $query->with('kategori')->latest()->get()->map(fn ($p) => [
            'id'        => $p->id,
            'nama'      => $p->nama_produk,
            'harga'     => (int) $p->harga,
            'stok'      => $p->stok,
            'kategori'  => $p->kategori->nama_kategori ?? '-',
            'deskripsi' => $p->detail,
            'gambar'    => $this->img('img-produk', $p->foto),
        ]);

        return $this->ok($data);
    }

    public function produkShow($id)
    {
        $p = Produk::where('status', 1)->find($id);
        if (!$p) {
            return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan'], 404);
        }

        return $this->ok([
            'id'        => $p->id,
            'nama'      => $p->nama_produk,
            'harga'     => (int) $p->harga,
            'stok'      => $p->stok,
            'berat'     => $p->berat,
            'kategori'  => $p->kategori->nama_kategori ?? '-',
            'deskripsi' => $p->detail,
            'gambar'    => $this->img('img-produk', $p->foto),
        ]);
    }

    public function barber()
    {
        $data = Barber::where('status', 'aktif')->orderBy('nama')->get()->map(fn ($b) => [
            'id'           => $b->id,
            'nama'         => $b->nama,
            'spesialisasi' => $b->spesialisasi,
            'pengalaman'   => $b->pengalaman_tahun,
            'gambar'       => $this->img('img-barber', $b->foto),
        ]);

        return $this->ok($data);
    }

    public function galeri()
    {
        $data = Galeri::latest()->get()->map(fn ($g) => [
            'id'         => $g->id,
            'judul'      => $g->judul,
            'tipe'       => $g->tipe,
            'keterangan' => $g->keterangan,
            'gambar'     => $this->img('img-galeri', $g->foto),
        ]);

        return $this->ok($data);
    }
}
