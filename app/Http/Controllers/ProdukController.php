<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\FotoProduk;
use App\Helpers\ImageHelper;
use App\Helpers\ActivityLogger;
use App\Traits\HasPermissionCheck;

class ProdukController extends Controller
{
    use HasPermissionCheck;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check permission
        if ($response = $this->checkPermission('produk.view', 'Anda tidak memiliki izin untuk melihat data produk.')) {
            return $response;
        }

        $produk = Produk::orderBy('updated_at', 'desc')->get();
        return view('backend.v_produk.index', [
            'judul' => 'Data Produk',
            'index' => $produk
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check permission
        if ($response = $this->checkPermission('produk.create', 'Anda tidak memiliki izin untuk menambah produk.')) {
            return $response;
        }

        $kategori = Kategori::orderBy('nama_kategori', 'asc')->get();
        return view('backend.v_produk.create', [
            'judul' => 'Tambah Produk',
            'kategori' => $kategori
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
        public function store(Request $request)
        {
            // Check permission
            if ($response = $this->checkPermission('produk.create', 'Anda tidak memiliki izin untuk menambah produk.')) {
                return $response;
            }

            // Input harga memakai pemisah ribuan ("50.000"). Bersihkan lebih dulu
            // agar aturan numeric|min:0 di bawah menilai angka mentahnya.
            $request->merge(['harga' => str_replace('.', '', (string) $request->input('harga'))]);

            // VALIDASI
            $validatedData = $request->validate([
                'kategori_id' => 'required',
                'nama_produk' => 'required|max:255|unique:produk',
                'detail' => 'required',
                'harga' => 'required|numeric|min:0',
                'berat' => 'required',
                'stok' => 'required',
                'foto' => 'required|image|mimes:jpeg,jpg,png,gif|max:1024',
            ], [
                'foto.image' => 'Format gambar harus jpeg, jpg, png, atau gif.',
                'foto.max'   => 'Ukuran file maksimal 1024 KB.',
                'harga.numeric' => 'Harga harus berupa angka.',
                'harga.min'     => 'Harga tidak boleh bernilai negatif.',
            ]);

            $validatedData['status'] = 0;
            $validatedData['user_id'] = auth()->id();
            $validatedData['berat'] = preg_replace('/[^0-9.]/', '', $validatedData['berat']);
            $validatedData['stok'] = preg_replace('/[^0-9]/', '', $validatedData['stok']);

            // UPLOAD FOTO + THUMBNAIL
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $extension = $file->getClientOriginalExtension();

                // Nama file unik
                $fileName = date('YmdHis') . '_' . uniqid() . '.' . $extension;
                $directory = 'storage/img-produk/';

                // Gambar asli (resize otomatis dari helper)
                ImageHelper::uploadAndResize($file, $directory, $fileName);

                // Thumbnail besar
                ImageHelper::uploadAndResize(
                    $file,
                    $directory,
                    'thumb_lg_' . $fileName,
                    800,
                    null
                );

                // Thumbnail medium
                ImageHelper::uploadAndResize(
                    $file,
                    $directory,
                    'thumb_md_' . $fileName,
                    500,
                    519
                );

                // Thumbnail kecil
                ImageHelper::uploadAndResize(
                    $file,
                    $directory,
                    'thumb_sm_' . $fileName,
                    100,
                    110
                );

                // Simpan nama file
                $validatedData['foto'] = $fileName;
            }

            // SIMPAN KE DATABASE
            $produk = Produk::create($validatedData);

            // Log activity
            ActivityLogger::created('produk', $produk->nama_produk, $produk);

            return redirect()
                ->route('backend.produk.index')
                ->with('success', 'Data berhasil tersimpan');
        }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $produk = Produk::with('gambar')->findOrFail($id);
        $kategori = Kategori::orderBy('nama_kategori', 'asc')->get();
        return view('backend.v_produk.show', [
            'judul' => 'Detail Produk',
            'show' => $produk,
            'kategori' => $kategori
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Check permission
        if ($response = $this->checkPermission('produk.update', 'Anda tidak memiliki izin untuk mengubah data produk.')) {
            return $response;
        }

        $produk   = Produk::findOrFail($id);
        $kategori = Kategori::orderBy('nama_kategori', 'asc')->get();

        return view('backend.v_produk.edit', [
            'judul'    => 'Ubah Produk',
            'edit'     => $produk,
            'kategori' => $kategori,
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Check permission
        if ($response = $this->checkPermission('produk.update', 'Anda tidak memiliki izin untuk mengubah data produk.')) {
            return $response;
        }

        $produk = Produk::findOrFail($id);

        // Save old data for logging
        $oldData = $produk->only(['nama_produk', 'kategori_id', 'harga', 'stok', 'status']);

        // Input harga memakai pemisah ribuan ("50.000"). Bersihkan lebih dulu
        // agar aturan numeric|min:0 di bawah menilai angka mentahnya.
        $request->merge(['harga' => str_replace('.', '', (string) $request->input('harga'))]);

        $rules = [
            'nama_produk' => 'required|max:255|unique:produk,nama_produk,' . $id,
            'kategori_id' => 'required',
            'status'      => 'required',
            'detail'      => 'required',
            'harga'       => 'required|numeric|min:0',
            'berat'       => 'required',
            'stok'        => 'required',
            'foto'        => 'image|mimes:jpeg,jpg,png,gif|max:1024',
        ];

        $messages = [
            'foto.image' => 'Format gambar harus jpeg, jpg, png, atau gif.',
            'foto.max'   => 'Ukuran gambar maksimal 1024 KB.',
            'harga.numeric' => 'Harga harus berupa angka.',
            'harga.min'     => 'Harga tidak boleh bernilai negatif.',
        ];

        // Validasi input
        $validatedData = $request->validate($rules, $messages);

        // Tambahkan user_id
        $validatedData['user_id'] = auth()->id();

        // Bersihkan nilai numerik
        $validatedData['berat'] = preg_replace('/[^0-9.]/', '', $validatedData['berat']);
        $validatedData['stok'] = preg_replace('/[^0-9]/', '', $validatedData['stok']);

        /**
         * PROSES GAMBAR
         */
        if ($request->file('foto')) {

            // Hapus gambar lama beserta thumbnail
            if ($produk->foto) {

                $path = public_path('storage/img-produk/');

                $oldFiles = [
                    $produk->foto,
                    'thumb_lg_' . $produk->foto,
                    'thumb_md_' . $produk->foto,
                    'thumb_sm_' . $produk->foto,
                ];

                foreach ($oldFiles as $oldFile) {
                    $filePath = $path . $oldFile;
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }
            }

            // Upload gambar baru
            $file      = $request->file('foto');
            $extension = $file->getClientOriginalExtension();
            $original  = date('YmdHis') . '_' . uniqid() . '.' . $extension;

            $directory = 'storage/img-produk/';

            // Simpan versi asli
            $fileName = ImageHelper::uploadAndResize($file, $directory, $original);
            $validatedData['foto'] = $fileName;

            // Thumbnail Besar
            ImageHelper::uploadAndResize($file, $directory, 'thumb_lg_' . $original, 800, null);

            // Thumbnail Medium
            ImageHelper::uploadAndResize($file, $directory, 'thumb_md_' . $original, 500, 519);

            // Thumbnail Small
            ImageHelper::uploadAndResize($file, $directory, 'thumb_sm_' . $original, 100, 110);
        }

        // Update database
        $produk->update($validatedData);

        // Log activity
        $newData = $produk->only(['nama_produk', 'kategori_id', 'harga', 'stok', 'status']);
        ActivityLogger::updated('produk', $produk->nama_produk, $produk, $oldData, $newData);

        return redirect()
            ->route('backend.produk.index')
            ->with('success', 'Data berhasil diperbaharui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Check permission
        if ($response = $this->checkPermission('produk.delete', 'Anda tidak memiliki izin untuk menghapus data produk.')) {
            return $response;
        }

        $produk = Produk::findOrFail($id);
        $directory = public_path('storage/img-produk/');

        // Hapus gambar utama dan thumbnail
        if ($produk->foto) {

            // Hapus gambar asli
            $original = $directory . $produk->foto;
            if (file_exists($original)) {
                unlink($original);
            }

            // Hapus thumbnail lg
            $thumbLg = $directory . 'thumb_lg_' . $produk->foto;
            if (file_exists($thumbLg)) {
                unlink($thumbLg);
            }

            // Hapus thumbnail md
            $thumbMd = $directory . 'thumb_md_' . $produk->foto;
            if (file_exists($thumbMd)) {
                unlink($thumbMd);
            }

            // Hapus thumbnail sm
            $thumbSm = $directory . 'thumb_sm_' . $produk->foto;
            if (file_exists($thumbSm)) {
                unlink($thumbSm);
            }
        }

        // Hapus gambar tambahan pada tabel foto_produk
        if ($produk->gambar()->count() > 0) {
            foreach ($produk->gambar as $foto) {
                $fotoPath = $directory . $foto->foto;
                if (file_exists($fotoPath)) {
                    unlink($fotoPath);
                }
                $foto->delete();
            }
        }

        // Log activity before deleting
        $produkName = $produk->nama_produk;
        ActivityLogger::deleted('produk', $produkName, $produk);

        // Hapus data produk dari database
        $produk->delete();

        return redirect()
            ->route('backend.produk.index')
            ->with('success', 'Produk berhasil dihapus.');
    }

    // Method untuk menyimpan foto tambahan
    public function storeFoto(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'produk_id' => 'required|exists:produk,id',
            'foto_produk' => 'required|array',
            'foto_produk.*' => 'image|mimes:jpeg,jpg,png,gif|max:1024',
        ], [
            'foto_produk.required' => 'Pilih minimal satu gambar.',
            'foto_produk.array' => 'Format data tidak valid.',
            'foto_produk.*.image' => 'File harus berupa gambar.',
            'foto_produk.*.mimes' => 'Format gambar harus jpeg, jpg, png, atau gif.',
            'foto_produk.*.max' => 'Ukuran file maksimal 1024 KB.',
        ]);

        if ($request->hasFile('foto_produk')) {
            $files = $request->file('foto_produk');

            foreach ($files as $file) {
                // Buat nama file yang unik dengan microseconds
                $extension = strtolower($file->getClientOriginalExtension());
                $fileName = date('YmdHis') . '_' . uniqid(time(), true) . '.' . $extension;
                $directory = 'storage/img-produk/';

                // Simpan dan resize gambar menggunakan ImageHelper
                ImageHelper::uploadAndResize($file, $directory, $fileName, 800, null);

                // Simpan data ke database
                FotoProduk::create([
                    'produk_id' => $request->produk_id,
                    'foto' => $fileName,
                ]);
            }
        }

        return redirect()->route('backend.produk.show', $request->produk_id)
            ->with('success', 'Foto berhasil ditambahkan.');
    }

    // Method untuk menghapus foto
    public function destroyFoto($id)
    {
        $foto = FotoProduk::findOrFail($id);
        $produkId = $foto->produk_id;

        // Hapus file gambar dari storage
        $imagePath = public_path('storage/img-produk/') . $foto->foto;
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        // Hapus record dari database
        $foto->delete();

        return redirect()->route('backend.produk.show', $produkId)
            ->with('success', 'Foto berhasil dihapus.');
    }

    // Method untuk Form Laporan Produk
    public function formProduk()
    {
        return view('backend.v_produk.form', [
            'judul' => 'Laporan Data Produk',
        ]);
    }

    // Method untuk Cetak Laporan Produk
    public function cetakProduk(Request $request)
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

        $query = Produk::whereBetween('updated_at', [$tanggalAwal . ' 00:00:00', $tanggalAkhir . ' 23:59:59'])
            ->orderBy('id', 'desc');

        $produk = $query->get();
        return view('backend.v_produk.cetak', [
            'judul' => 'Laporan Produk',
            'tanggalAwal' => $tanggalAwal,
            'tanggalAkhir' => $tanggalAkhir,
            'cetak' => $produk
        ]);
    }
}
