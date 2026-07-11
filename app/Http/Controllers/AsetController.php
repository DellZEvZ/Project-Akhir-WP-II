<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aset;
use App\Helpers\ImageHelper;
use App\Helpers\ActivityLogger;
use App\Traits\HasPermissionCheck;
use App\Traits\CachesAdminList;

class AsetController extends Controller
{
    use HasPermissionCheck, CachesAdminList;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Check permission
        if ($response = $this->checkPermission('aset.view', 'Anda tidak memiliki izin untuk melihat data aset.')) {
            return $response;
        }

        $fetch = fn () => Aset::query()
            ->when($request->filled('status'), fn ($q) => $q->where('status_aset', $request->status))
            ->when($request->filled('kategori'), fn ($q) => $q->where('kategori', $request->kategori))
            ->when($request->filled('lokasi'), fn ($q) => $q->where('lokasi', $request->lokasi))
            ->when($request->filled('search'), function ($q) use ($request) {
                $search = $request->search;
                $q->where(function ($qq) use ($search) {
                    $qq->where('nama_aset', 'like', "%{$search}%")
                       ->orWhere('kode_aset', 'like', "%{$search}%")
                       ->orWhere('supplier', 'like', "%{$search}%")
                       ->orWhere('lokasi', 'like', "%{$search}%");
                });
            })
            ->orderBy('updated_at', 'desc')->paginate(15);

        $hasFilter = $request->filled('status') || $request->filled('kategori')
            || $request->filled('lokasi') || $request->filled('search');

        $aset = $hasFilter
            ? $fetch()
            : $this->rememberAdminList('aset', 'p' . $request->integer('page', 1), $fetch);

        return view('backend.v_aset.index', [
            'judul' => 'Data Aset / Inventaris',
            'aset' => $aset
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check permission
        if ($response = $this->checkPermission('aset.create', 'Anda tidak memiliki izin untuk menambah aset.')) {
            return $response;
        }

        return view('backend.v_aset.create', [
            'judul' => 'Tambah Aset',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check permission
        if ($response = $this->checkPermission('aset.create', 'Anda tidak memiliki izin untuk menambah aset.')) {
            return $response;
        }

        // VALIDASI
        $validatedData = $request->validate([
            'nama_aset' => 'required|max:255',
            'kode_aset' => 'required|unique:asets,kode_aset|max:255',
            'deskripsi' => 'nullable',
            'kategori' => 'required|max:255',
            'supplier' => 'nullable|max:255',
            'tanggal_pembelian' => 'required|date',
            'harga_perolehan' => 'required|numeric|min:0',
            'nilai_saat_ini' => 'required|numeric|min:0',
            'status_aset' => 'required|in:aktif,rusak,hilang,dijual',
            'lokasi' => 'nullable|max:255',
            'foto_aset' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:1024',
            'last_maintenance' => 'nullable|date',
            'next_maintenance' => 'nullable|date|after_or_equal:last_maintenance',
        ], [
            'foto_aset.image' => 'Format gambar harus jpeg, jpg, png, atau gif.',
            'foto_aset.max' => 'Ukuran file maksimal 1024 KB.',
            'kode_aset.unique' => 'Kode aset sudah terdaftar.',
            'next_maintenance.after_or_equal' => 'Tanggal maintenance selanjutnya harus setelah atau sama dengan maintenance terakhir.',
        ]);

        // Bersihkan nilai numeric
        $validatedData['harga_perolehan'] = str_replace('.', '', $validatedData['harga_perolehan']);
        $validatedData['nilai_saat_ini'] = str_replace('.', '', $validatedData['nilai_saat_ini']);

        // UPLOAD FOTO
        if ($request->hasFile('foto_aset')) {
            $file = $request->file('foto_aset');
            $extension = $file->getClientOriginalExtension();

            // Nama file unik
            $fileName = date('YmdHis') . '_' . uniqid() . '.' . $extension;
            $directory = 'storage/img-aset/';

            // Gambar asli (resize otomatis dari helper)
            ImageHelper::uploadAndResize($file, $directory, $fileName, 800, null);

            // Thumbnail
            ImageHelper::uploadAndResize(
                $file,
                $directory,
                'thumb_' . $fileName,
                200,
                200
            );

            // Simpan nama file
            $validatedData['foto_aset'] = $fileName;
        }

        // SIMPAN KE DATABASE
        $aset = Aset::create($validatedData);

        // Log activity
        ActivityLogger::created('aset', $aset->nama_aset, $aset);
        $this->forgetAdminList('aset');

        return redirect()
            ->route('backend.aset.index')
            ->with('success', 'Data aset berhasil tersimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $aset = Aset::findOrFail($id);
        return view('backend.v_aset.show', [
            'judul' => 'Detail Aset',
            'aset' => $aset
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Check permission
        if ($response = $this->checkPermission('aset.update', 'Anda tidak memiliki izin untuk mengubah data aset.')) {
            return $response;
        }

        $aset = Aset::findOrFail($id);

        return view('backend.v_aset.edit', [
            'judul' => 'Ubah Aset',
            'aset' => $aset
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Check permission
        if ($response = $this->checkPermission('aset.update', 'Anda tidak memiliki izin untuk mengubah data aset.')) {
            return $response;
        }

        $aset = Aset::findOrFail($id);

        // Save old data for logging
        $oldData = $aset->only(['nama_aset', 'kode_aset', 'kategori', 'status_aset', 'lokasi']);

        $rules = [
            'nama_aset' => 'required|max:255',
            'kode_aset' => 'required|unique:asets,kode_aset,' . $id . '|max:255',
            'deskripsi' => 'nullable',
            'kategori' => 'required|max:255',
            'supplier' => 'nullable|max:255',
            'tanggal_pembelian' => 'required|date',
            'harga_perolehan' => 'required|numeric|min:0',
            'nilai_saat_ini' => 'required|numeric|min:0',
            'status_aset' => 'required|in:aktif,rusak,hilang,dijual',
            'lokasi' => 'nullable|max:255',
            'foto_aset' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:1024',
            'last_maintenance' => 'nullable|date',
            'next_maintenance' => 'nullable|date|after_or_equal:last_maintenance',
        ];

        $messages = [
            'foto_aset.image' => 'Format gambar harus jpeg, jpg, png, atau gif.',
            'foto_aset.max' => 'Ukuran gambar maksimal 1024 KB.',
            'kode_aset.unique' => 'Kode aset sudah terdaftar.',
            'next_maintenance.after_or_equal' => 'Tanggal maintenance selanjutnya harus setelah atau sama dengan maintenance terakhir.',
        ];

        // Validasi input
        $validatedData = $request->validate($rules, $messages);

        // Bersihkan nilai numeric
        $validatedData['harga_perolehan'] = str_replace('.', '', $validatedData['harga_perolehan']);
        $validatedData['nilai_saat_ini'] = str_replace('.', '', $validatedData['nilai_saat_ini']);

        // PROSES GAMBAR
        if ($request->file('foto_aset')) {
            // Hapus gambar lama beserta thumbnail
            if ($aset->foto_aset) {
                $path = public_path('storage/img-aset/');

                $oldFiles = [
                    $aset->foto_aset,
                    'thumb_' . $aset->foto_aset,
                ];

                foreach ($oldFiles as $oldFile) {
                    $filePath = $path . $oldFile;
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }
            }

            // Upload gambar baru
            $file = $request->file('foto_aset');
            $extension = $file->getClientOriginalExtension();
            $original = date('YmdHis') . '_' . uniqid() . '.' . $extension;

            $directory = 'storage/img-aset/';

            // Simpan versi asli
            $fileName = ImageHelper::uploadAndResize($file, $directory, $original, 800, null);
            $validatedData['foto_aset'] = $fileName;

            // Thumbnail
            ImageHelper::uploadAndResize($file, $directory, 'thumb_' . $original, 200, 200);
        }

        // Update database
        $aset->update($validatedData);

        // Log activity
        $newData = $aset->only(['nama_aset', 'kode_aset', 'kategori', 'status_aset', 'lokasi']);
        ActivityLogger::updated('aset', $aset->nama_aset, $aset, $oldData, $newData);
        $this->forgetAdminList('aset');

        return redirect()
            ->route('backend.aset.index')
            ->with('success', 'Data aset berhasil diperbaharui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Check permission
        if ($response = $this->checkPermission('aset.delete', 'Anda tidak memiliki izin untuk menghapus data aset.')) {
            return $response;
        }

        $aset = Aset::findOrFail($id);
        $directory = public_path('storage/img-aset/');

        // Hapus gambar utama dan thumbnail
        if ($aset->foto_aset) {
            // Hapus gambar asli
            $original = $directory . $aset->foto_aset;
            if (file_exists($original)) {
                unlink($original);
            }

            // Hapus thumbnail
            $thumb = $directory . 'thumb_' . $aset->foto_aset;
            if (file_exists($thumb)) {
                unlink($thumb);
            }
        }

        // Log activity before deleting
        $asetName = $aset->nama_aset;
        ActivityLogger::deleted('aset', $asetName, $aset);

        // Hapus data aset dari database
        $aset->delete();
        $this->forgetAdminList('aset');

        return redirect()
            ->route('backend.aset.index')
            ->with('success', 'Data aset berhasil dihapus.');
    }

    /**
     * Method untuk Form Laporan Aset
     */
    public function formAset()
    {
        return view('backend.v_aset.form', [
            'judul' => 'Laporan Data Aset',
        ]);
    }

    /**
     * Method untuk Cetak Laporan Aset
     */
    public function cetakAset(Request $request)
    {
        // Menambahkan aturan validasi
        $request->validate([
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
        ], [
            'tanggal_awal.required' => 'Tanggal Awal harus diisi.',
            'tanggal_akhir.required' => 'Tanggal Akhir harus diisi.',
            'tanggal_akhir.after_or_equal' => 'Tanggal Akhir harus lebih besar atau sama dengan Tanggal Awal.',
        ]);

        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');

        $query = Aset::whereBetween('tanggal_pembelian', [$tanggalAwal, $tanggalAkhir])
            ->orderBy('id', 'desc');

        // Filter berdasarkan status jika ada
        if ($request->has('status') && $request->status != '') {
            $query->where('status_aset', $request->status);
        }

        // Filter berdasarkan kategori jika ada
        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori', $request->kategori);
        }

        $aset = $query->get();

        return view('backend.v_aset.cetak', [
            'judul' => 'Laporan Aset',
            'tanggalAwal' => $tanggalAwal,
            'tanggalAkhir' => $tanggalAkhir,
            'cetak' => $aset
        ]);
    }

    /**
     * Method untuk mendapatkan statistik aset
     */
    public function statistik()
    {
        $totalAset = Aset::count();
        $asetAktif = Aset::aktif()->count();
        $asetRusak = Aset::rusak()->count();
        $asetHilang = Aset::hilang()->count();
        $asetDijual = Aset::dijual()->count();

        // Total nilai aset
        $totalNilaiPerolehan = Aset::sum('harga_perolehan');
        $totalNilaiSaatIni = Aset::sum('nilai_saat_ini');

        // Aset yang perlu maintenance
        $asetNeedMaintenance = Aset::whereNotNull('next_maintenance')
            ->whereDate('next_maintenance', '<=', now())
            ->count();

        return view('backend.v_aset.statistik', [
            'judul' => 'Statistik Aset',
            'totalAset' => $totalAset,
            'asetAktif' => $asetAktif,
            'asetRusak' => $asetRusak,
            'asetHilang' => $asetHilang,
            'asetDijual' => $asetDijual,
            'totalNilaiPerolehan' => $totalNilaiPerolehan,
            'totalNilaiSaatIni' => $totalNilaiSaatIni,
            'asetNeedMaintenance' => $asetNeedMaintenance,
        ]);
    }

    /**
     * Method untuk update maintenance
     */
    public function updateMaintenance(Request $request, $id)
    {
        $aset = Aset::findOrFail($id);

        $validatedData = $request->validate([
            'last_maintenance' => 'required|date',
            'next_maintenance' => 'required|date|after:last_maintenance',
        ], [
            'next_maintenance.after' => 'Tanggal maintenance selanjutnya harus setelah maintenance terakhir.',
        ]);

        $aset->update($validatedData);

        return redirect()
            ->route('backend.aset.show', $id)
            ->with('success', 'Jadwal maintenance berhasil diperbaharui');
    }

    /**
     * Method untuk mendapatkan list aset yang perlu maintenance
     */
    public function maintenanceList()
    {
        // Aset yang perlu maintenance sekarang
        $asetOverdue = Aset::whereNotNull('next_maintenance')
            ->whereDate('next_maintenance', '<', now())
            ->orderBy('next_maintenance', 'asc')
            ->get();

        // Aset yang akan maintenance dalam 7 hari
        $asetUpcoming = Aset::whereNotNull('next_maintenance')
            ->whereDate('next_maintenance', '>=', now())
            ->whereDate('next_maintenance', '<=', now()->addDays(7))
            ->orderBy('next_maintenance', 'asc')
            ->get();

        return view('backend.v_aset.maintenance', [
            'judul' => 'Jadwal Maintenance Aset',
            'asetOverdue' => $asetOverdue,
            'asetUpcoming' => $asetUpcoming
        ]);
    }
}
