<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Helpers\ActivityLogger;
use App\Traits\HasPermissionCheck;
use App\Traits\CachesAdminList;

class KategoriController extends Controller
{
    use HasPermissionCheck, CachesAdminList;
    public function index()
    {
        // Check permission
        if ($response = $this->checkPermission('kategori.view', 'Anda tidak memiliki izin untuk melihat data kategori.')) {
            return $response;
        }

        $kategori = $this->rememberAdminList('kategori', 'all', fn () => Kategori::orderBy('nama_kategori', 'asc')->get());

        return view('backend.v_kategori.index', [
            'judul' => 'Kategori',
            'index' => $kategori
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check permission
        if ($response = $this->checkPermission('kategori.create', 'Anda tidak memiliki izin untuk menambah kategori.')) {
            return $response;
        }

        return view('backend.v_kategori.create', [
            'judul' => 'Kategori',
        ]);
    }

    public function store(Request $request)
    {
        // Check permission
        if ($response = $this->checkPermission('kategori.create', 'Anda tidak memiliki izin untuk menambah kategori.')) {
            return $response;
        }

        $validatedData = $request->validate([
            'nama_kategori' => 'required|max:255|unique:kategori,nama_kategori',
        ]);

        $kategori = Kategori::create($validatedData);

        // Log activity
        ActivityLogger::created('kategori', $kategori->nama_kategori, $kategori);
        $this->forgetAdminList('kategori');

        return redirect()
            ->route('backend.kategori.index')
            ->with('success', 'Data berhasil tersimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Check permission
        if ($response = $this->checkPermission('kategori.update', 'Anda tidak memiliki izin untuk mengubah data kategori.')) {
            return $response;
        }

        $kategori = Kategori::findOrFail($id);

        return view('backend.v_kategori.edit', [
            'judul' => 'Kategori',
            'edit'  => $kategori
        ]);
    }

    public function update(Request $request, string $id)
    {
        // Check permission
        if ($response = $this->checkPermission('kategori.update', 'Anda tidak memiliki izin untuk mengubah data kategori.')) {
            return $response;
        }

        $kategori = Kategori::findOrFail($id);

        // Save old data for logging
        $oldData = ['nama_kategori' => $kategori->nama_kategori];

        $rules = [
            // validasi unik, tetapi abaikan ID milik data yang sedang di-edit
            'nama_kategori' => 'required|max:255|unique:kategori,nama_kategori,' . $id,
        ];

        $validatedData = $request->validate($rules);

        $kategori->update($validatedData);

        // Log activity
        $newData = ['nama_kategori' => $kategori->nama_kategori];
        ActivityLogger::updated('kategori', $kategori->nama_kategori, $kategori, $oldData, $newData);
        $this->forgetAdminList('kategori');

        return redirect()
            ->route('backend.kategori.index')
            ->with('success', 'Data berhasil diperbaharui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Check permission
        if ($response = $this->checkPermission('kategori.delete', 'Anda tidak memiliki izin untuk menghapus data kategori.')) {
            return $response;
        }

        $kategori = Kategori::findOrFail($id);

        // Log activity before deleting
        $kategoriName = $kategori->nama_kategori;
        ActivityLogger::deleted('kategori', $kategoriName, $kategori);

        $kategori->delete();
        $this->forgetAdminList('kategori');

        return redirect()
            ->route('backend.kategori.index')
            ->with('success', 'Data berhasil dihapus');
    }
}
