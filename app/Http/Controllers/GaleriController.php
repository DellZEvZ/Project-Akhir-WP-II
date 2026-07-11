<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Galeri;
use App\Helpers\ImageHelper;
use App\Traits\HasPermissionCheck;
use App\Traits\CachesAdminList;

class GaleriController extends Controller
{
    use HasPermissionCheck, CachesAdminList;

    public function index(Request $request)
    {
        if ($response = $this->checkPermission('galeri.view', 'Anda tidak memiliki izin untuk melihat galeri.')) {
            return $response;
        }

        $fetch = fn () => Galeri::query()
            ->when($request->filled('tipe'), fn ($q) => $q->where('tipe', $request->tipe))
            ->when($request->filled('search'), function ($q) use ($request) {
                $search = $request->search;
                $q->where(function ($qq) use ($search) {
                    $qq->where('judul', 'like', "%{$search}%")
                       ->orWhere('keterangan', 'like', "%{$search}%");
                });
            })
            ->latest()->paginate(18);

        $hasFilter = $request->filled('tipe') || $request->filled('search');

        $galeris = $hasFilter
            ? $fetch()
            : $this->rememberAdminList('galeri', 'p' . $request->integer('page', 1), $fetch);

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

        $this->forgetAdminList('galeri');

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
        $this->forgetAdminList('galeri');

        return redirect()->route('backend.galeri.index')
            ->with('success', 'Foto galeri berhasil dihapus.');
    }
}
