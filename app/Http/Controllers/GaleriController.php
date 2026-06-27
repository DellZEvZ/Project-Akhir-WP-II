<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Galeri;
use App\Helpers\ImageHelper;
use App\Traits\HasPermissionCheck;

class GaleriController extends Controller
{
    use HasPermissionCheck;

    public function index(Request $request)
    {
        if ($response = $this->checkPermission('galeri.view', 'Anda tidak memiliki izin untuk melihat galeri.')) {
            return $response;
        }

        $query = Galeri::query();

        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        $galeris = $query->latest()->paginate(18);

        return view('backend.v_galeri.index', [
            'judul'   => 'Galeri Foto',
            'galeris' => $galeris,
        ]);
    }

    public function create()
    {
        if ($response = $this->checkPermission('galeri.create', 'Anda tidak memiliki izin untuk upload galeri.')) {
            return $response;
        }

        return view('backend.v_galeri.create', ['judul' => 'Upload Foto Galeri']);
    }

    public function store(Request $request)
    {
        if ($response = $this->checkPermission('galeri.create', 'Anda tidak memiliki izin untuk upload galeri.')) {
            return $response;
        }

        $request->validate([
            'judul'      => 'required|string|max:100',
            'foto'       => 'required|image|mimes:jpg,jpeg,png|max:3072',
            'keterangan' => 'nullable|string',
            'tipe'       => 'required|in:hairstyle,haircut,beard',
        ]);

        $file     = $request->file('foto');
        $fileName = 'galeri_' . time() . '.' . $file->getClientOriginalExtension();
        ImageHelper::storeImage($file, 'img-galeri', $fileName);

        Galeri::create([
            'judul'      => $request->judul,
            'foto'       => $fileName,
            'keterangan' => $request->keterangan,
            'tipe'       => $request->tipe,
        ]);

        return redirect()->route('backend.galeri.index')
            ->with('success', 'Foto berhasil diupload ke galeri.');
    }

    public function destroy(Galeri $galeri)
    {
        if ($response = $this->checkPermission('galeri.delete', 'Anda tidak memiliki izin untuk menghapus galeri.')) {
            return $response;
        }

        ImageHelper::deleteImage($galeri->foto, 'img-galeri');
        $galeri->delete();

        return redirect()->route('backend.galeri.index')
            ->with('success', 'Foto galeri berhasil dihapus.');
    }
}
