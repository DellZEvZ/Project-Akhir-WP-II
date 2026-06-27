<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barber;
use App\Helpers\ImageHelper;
use App\Traits\HasPermissionCheck;

class BarberController extends Controller
{
    use HasPermissionCheck;

    public function index(Request $request)
    {
        if ($response = $this->checkPermission('barber.view', 'Anda tidak memiliki izin untuk melihat data barber.')) {
            return $response;
        }

        $query = Barber::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('spesialisasi', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%");
            });
        }

        $barbers = $query->orderBy('nama')->paginate(15);

        return view('backend.v_barber.index', [
            'judul'   => 'Data Barber',
            'barbers' => $barbers,
        ]);
    }

    public function create()
    {
        if ($response = $this->checkPermission('barber.create', 'Anda tidak memiliki izin untuk menambah barber.')) {
            return $response;
        }

        return view('backend.v_barber.create', ['judul' => 'Tambah Barber']);
    }

    public function store(Request $request)
    {
        if ($response = $this->checkPermission('barber.create', 'Anda tidak memiliki izin untuk menambah barber.')) {
            return $response;
        }

        $request->validate([
            'nama'              => 'required|string|max:100',
            'spesialisasi'      => 'required|string|max:100',
            'pengalaman_tahun'  => 'required|integer|min:0',
            'no_hp'             => 'nullable|string|max:20',
            'status'            => 'required|in:aktif,nonaktif',
            'foto'              => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['nama', 'spesialisasi', 'pengalaman_tahun', 'no_hp', 'status']);

        if ($request->hasFile('foto')) {
            $file     = $request->file('foto');
            $fileName = 'barber_' . time() . '.' . $file->getClientOriginalExtension();
            ImageHelper::storeImage($file, 'img-barber', $fileName);
            $data['foto'] = $fileName;
        }

        Barber::create($data);

        return redirect()->route('backend.barber.index')
            ->with('success', 'Barber berhasil ditambahkan.');
    }

    public function show(Barber $barber)
    {
        return view('backend.v_barber.show', [
            'judul'  => 'Detail Barber',
            'barber' => $barber,
        ]);
    }

    public function edit(Barber $barber)
    {
        if ($response = $this->checkPermission('barber.update', 'Anda tidak memiliki izin untuk mengubah data barber.')) {
            return $response;
        }

        return view('backend.v_barber.edit', [
            'judul'  => 'Edit Barber',
            'barber' => $barber,
        ]);
    }

    public function update(Request $request, Barber $barber)
    {
        if ($response = $this->checkPermission('barber.update', 'Anda tidak memiliki izin untuk mengubah data barber.')) {
            return $response;
        }

        $request->validate([
            'nama'              => 'required|string|max:100',
            'spesialisasi'      => 'required|string|max:100',
            'pengalaman_tahun'  => 'required|integer|min:0',
            'no_hp'             => 'nullable|string|max:20',
            'status'            => 'required|in:aktif,nonaktif',
            'foto'              => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['nama', 'spesialisasi', 'pengalaman_tahun', 'no_hp', 'status']);

        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($barber->foto) {
                ImageHelper::deleteImage($barber->foto, 'img-barber');
            }
            $file     = $request->file('foto');
            $fileName = 'barber_' . time() . '.' . $file->getClientOriginalExtension();
            ImageHelper::storeImage($file, 'img-barber', $fileName);
            $data['foto'] = $fileName;
        }

        $barber->update($data);

        return redirect()->route('backend.barber.index')
            ->with('success', 'Data barber berhasil diperbarui.');
    }

    public function destroy(Barber $barber)
    {
        if ($response = $this->checkPermission('barber.delete', 'Anda tidak memiliki izin untuk menghapus barber.')) {
            return $response;
        }

        if ($barber->foto) {
            ImageHelper::deleteImage($barber->foto, 'img-barber');
        }

        $barber->delete();

        return redirect()->route('backend.barber.index')
            ->with('success', 'Barber berhasil dihapus.');
    }
}
