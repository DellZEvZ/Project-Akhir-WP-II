<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Layanan;
use App\Helpers\ImageHelper;

class LayananController extends Controller
{
    public function index(Request $request)
    {
        $query = Layanan::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_layanan', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        $layanans = $query->orderBy('harga')->paginate(15);

        return view('backend.v_layanan.index', [
            'judul'    => 'Data Layanan',
            'layanans' => $layanans,
        ]);
    }

    public function create()
    {
        return view('backend.v_layanan.create', ['judul' => 'Tambah Layanan']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_layanan'  => 'required|string|max:100',
            'deskripsi'     => 'nullable|string',
            'harga'         => 'required|numeric|min:0',
            'durasi_menit'  => 'required|integer|min:1',
            'status'        => 'required|in:aktif,nonaktif',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['nama_layanan', 'deskripsi', 'harga', 'durasi_menit', 'status']);

        if ($request->hasFile('foto')) {
            $file     = $request->file('foto');
            $fileName = 'layanan_' . time() . '.' . $file->getClientOriginalExtension();
            ImageHelper::storeImage($file, 'img-layanan', $fileName);
            $data['foto'] = $fileName;
        }

        Layanan::create($data);

        return redirect()->route('backend.layanan.index')
            ->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function show(Layanan $layanan)
    {
        return view('backend.v_layanan.show', [
            'judul'   => 'Detail Layanan',
            'layanan' => $layanan,
        ]);
    }

    public function edit(Layanan $layanan)
    {
        return view('backend.v_layanan.edit', [
            'judul'   => 'Edit Layanan',
            'layanan' => $layanan,
        ]);
    }

    public function update(Request $request, Layanan $layanan)
    {
        $request->validate([
            'nama_layanan'  => 'required|string|max:100',
            'deskripsi'     => 'nullable|string',
            'harga'         => 'required|numeric|min:0',
            'durasi_menit'  => 'required|integer|min:1',
            'status'        => 'required|in:aktif,nonaktif',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['nama_layanan', 'deskripsi', 'harga', 'durasi_menit', 'status']);

        if ($request->hasFile('foto')) {
            if ($layanan->foto) {
                ImageHelper::deleteImage($layanan->foto, 'img-layanan');
            }
            $file     = $request->file('foto');
            $fileName = 'layanan_' . time() . '.' . $file->getClientOriginalExtension();
            ImageHelper::storeImage($file, 'img-layanan', $fileName);
            $data['foto'] = $fileName;
        }

        $layanan->update($data);

        return redirect()->route('backend.layanan.index')
            ->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy(Layanan $layanan)
    {
        if ($layanan->foto) {
            ImageHelper::deleteImage($layanan->foto, 'img-layanan');
        }

        $layanan->delete();

        return redirect()->route('backend.layanan.index')
            ->with('success', 'Layanan berhasil dihapus.');
    }
}
