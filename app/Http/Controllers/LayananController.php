<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Layanan;
use App\Helpers\ImageHelper;
use App\Traits\HasPermissionCheck;
use App\Traits\CachesAdminList;

class LayananController extends Controller
{
    use HasPermissionCheck, CachesAdminList;

    public function index(Request $request)
    {
        if ($response = $this->checkPermission('layanan.view', 'Anda tidak memiliki izin untuk melihat data layanan.')) {
            return $response;
        }

        $fetch = fn () => Layanan::query()
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->when($request->filled('search'), function ($q) use ($request) {
                $search = $request->search;
                $q->where(function ($qq) use ($search) {
                    $qq->where('nama_layanan', 'like', "%{$search}%")
                       ->orWhere('deskripsi', 'like', "%{$search}%");
                });
            })
            ->orderBy('harga')->paginate(15);

        $hasFilter = $request->filled('status') || $request->filled('search');

        $layanans = $hasFilter
            ? $fetch()
            : $this->rememberAdminList('layanan', 'p' . $request->integer('page', 1), $fetch);

        return view('backend.v_layanan.index', [
            'judul'    => 'Data Layanan',
            'layanans' => $layanans,
        ]);
    }

    public function create()
    {
        if ($response = $this->checkPermission('layanan.create', 'Anda tidak memiliki izin untuk menambah layanan.')) {
            return $response;
        }

        return view('backend.v_layanan.create', ['judul' => 'Tambah Layanan']);
    }

    public function store(Request $request)
    {
        if ($response = $this->checkPermission('layanan.create', 'Anda tidak memiliki izin untuk menambah layanan.')) {
            return $response;
        }

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
        $this->forgetAdminList('layanan');

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
        if ($response = $this->checkPermission('layanan.update', 'Anda tidak memiliki izin untuk mengubah data layanan.')) {
            return $response;
        }

        return view('backend.v_layanan.edit', [
            'judul'   => 'Edit Layanan',
            'layanan' => $layanan,
        ]);
    }

    public function update(Request $request, Layanan $layanan)
    {
        if ($response = $this->checkPermission('layanan.update', 'Anda tidak memiliki izin untuk mengubah data layanan.')) {
            return $response;
        }

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
        $this->forgetAdminList('layanan');

        return redirect()->route('backend.layanan.index')
            ->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy(Layanan $layanan)
    {
        if ($response = $this->checkPermission('layanan.delete', 'Anda tidak memiliki izin untuk menghapus layanan.')) {
            return $response;
        }

        if ($layanan->foto) {
            ImageHelper::deleteImage($layanan->foto, 'img-layanan');
        }

        $layanan->delete();
        $this->forgetAdminList('layanan');

        return redirect()->route('backend.layanan.index')
            ->with('success', 'Layanan berhasil dihapus.');
    }
}
