<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\User;
use App\Helpers\ImageHelper;
use App\Helpers\ActivityLogger;
use App\Traits\HasPermissionCheck;

class PegawaiController extends Controller
{
    use HasPermissionCheck;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Check permission
        if ($response = $this->checkPermission('pegawai.view', 'Anda tidak memiliki izin untuk melihat data pegawai.')) {
            return $response;
        }

        $query = Pegawai::with('user');

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('status_pegawai', $request->status);
        }

        // Filter berdasarkan departemen
        if ($request->has('departemen') && $request->departemen != '') {
            $query->where('departemen', $request->departemen);
        }

        // Search berdasarkan nama, email, atau jabatan
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('jabatan', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%");
            });
        }

        $pegawai = $query->orderBy('updated_at', 'desc')->paginate(15);

        return view('backend.v_pegawai.index', [
            'judul' => 'Data Pegawai',
            'pegawai' => $pegawai
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check permission
        if ($response = $this->checkPermission('pegawai.create', 'Anda tidak memiliki izin untuk menambah pegawai.')) {
            return $response;
        }

        $users = User::orderBy('nama', 'asc')->get();
        return view('backend.v_pegawai.create', [
            'judul' => 'Tambah Pegawai',
            'users' => $users
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check permission
        if ($response = $this->checkPermission('pegawai.create', 'Anda tidak memiliki izin untuk menambah pegawai.')) {
            return $response;
        }

        // VALIDASI
        $validatedData = $request->validate([
            'nama' => 'required|max:255',
            'email' => 'required|email|unique:pegawais,email',
            'no_hp' => 'nullable|max:20',
            'alamat' => 'nullable',
            'jabatan' => 'required|max:255',
            'departemen' => 'required|max:255',
            'status_pegawai' => 'required|in:aktif,cuti,resign',
            'tanggal_masuk' => 'required|date',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:1024',
            'user_id' => 'nullable|exists:users,id',
            'gaji_pokok' => 'required|numeric|min:0',
        ], [
            'foto.image' => 'Format gambar harus jpeg, jpg, png, atau gif.',
            'foto.max' => 'Ukuran file maksimal 1024 KB.',
            'email.unique' => 'Email sudah terdaftar.',
        ]);

        // Bersihkan nilai gaji
        $validatedData['gaji_pokok'] = str_replace('.', '', $validatedData['gaji_pokok']);

        // UPLOAD FOTO
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $extension = $file->getClientOriginalExtension();

            // Nama file unik
            $fileName = date('YmdHis') . '_' . uniqid() . '.' . $extension;
            $directory = 'storage/img-pegawai/';

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
            $validatedData['foto'] = $fileName;
        }

        // SIMPAN KE DATABASE
        $pegawai = Pegawai::create($validatedData);

        // Log activity
        ActivityLogger::created('pegawai', $pegawai->nama, $pegawai);

        return redirect()
            ->route('backend.pegawai.index')
            ->with('success', 'Data pegawai berhasil tersimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pegawai = Pegawai::with('user')->findOrFail($id);
        return view('backend.v_pegawai.show', [
            'judul' => 'Detail Pegawai',
            'pegawai' => $pegawai
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Check permission
        if ($response = $this->checkPermission('pegawai.update', 'Anda tidak memiliki izin untuk mengubah data pegawai.')) {
            return $response;
        }

        $pegawai = Pegawai::findOrFail($id);
        $users = User::orderBy('nama', 'asc')->get();

        return view('backend.v_pegawai.edit', [
            'judul' => 'Ubah Pegawai',
            'pegawai' => $pegawai,
            'users' => $users
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Check permission
        if ($response = $this->checkPermission('pegawai.update', 'Anda tidak memiliki izin untuk mengubah data pegawai.')) {
            return $response;
        }

        $pegawai = Pegawai::findOrFail($id);

        // Save old data for logging
        $oldData = $pegawai->only(['nama', 'email', 'jabatan', 'departemen', 'status_pegawai']);

        $rules = [
            'nama' => 'required|max:255',
            'email' => 'required|email|unique:pegawais,email,' . $id,
            'no_hp' => 'nullable|max:20',
            'alamat' => 'nullable',
            'jabatan' => 'required|max:255',
            'departemen' => 'required|max:255',
            'status_pegawai' => 'required|in:aktif,cuti,resign',
            'tanggal_masuk' => 'required|date',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:1024',
            'user_id' => 'nullable|exists:users,id',
            'gaji_pokok' => 'required|numeric|min:0',
        ];

        $messages = [
            'foto.image' => 'Format gambar harus jpeg, jpg, png, atau gif.',
            'foto.max' => 'Ukuran gambar maksimal 1024 KB.',
            'email.unique' => 'Email sudah terdaftar.',
        ];

        // Validasi input
        $validatedData = $request->validate($rules, $messages);

        // Bersihkan nilai gaji
        $validatedData['gaji_pokok'] = str_replace('.', '', $validatedData['gaji_pokok']);

        // PROSES GAMBAR
        if ($request->file('foto')) {
            // Hapus gambar lama beserta thumbnail
            if ($pegawai->foto) {
                $path = public_path('storage/img-pegawai/');

                $oldFiles = [
                    $pegawai->foto,
                    'thumb_' . $pegawai->foto,
                ];

                foreach ($oldFiles as $oldFile) {
                    $filePath = $path . $oldFile;
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }
            }

            // Upload gambar baru
            $file = $request->file('foto');
            $extension = $file->getClientOriginalExtension();
            $original = date('YmdHis') . '_' . uniqid() . '.' . $extension;

            $directory = 'storage/img-pegawai/';

            // Simpan versi asli
            $fileName = ImageHelper::uploadAndResize($file, $directory, $original, 800, null);
            $validatedData['foto'] = $fileName;

            // Thumbnail
            ImageHelper::uploadAndResize($file, $directory, 'thumb_' . $original, 200, 200);
        }

        // Update database
        $pegawai->update($validatedData);

        // Log activity
        $newData = $pegawai->only(['nama', 'email', 'jabatan', 'departemen', 'status_pegawai']);
        ActivityLogger::updated('pegawai', $pegawai->nama, $pegawai, $oldData, $newData);

        return redirect()
            ->route('backend.pegawai.index')
            ->with('success', 'Data pegawai berhasil diperbaharui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Check permission
        if ($response = $this->checkPermission('pegawai.delete', 'Anda tidak memiliki izin untuk menghapus data pegawai.')) {
            return $response;
        }

        $pegawai = Pegawai::findOrFail($id);
        $directory = public_path('storage/img-pegawai/');

        // Hapus gambar utama dan thumbnail
        if ($pegawai->foto) {
            // Hapus gambar asli
            $original = $directory . $pegawai->foto;
            if (file_exists($original)) {
                unlink($original);
            }

            // Hapus thumbnail
            $thumb = $directory . 'thumb_' . $pegawai->foto;
            if (file_exists($thumb)) {
                unlink($thumb);
            }
        }

        // Log activity before deleting
        $pegawaiName = $pegawai->nama;
        ActivityLogger::deleted('pegawai', $pegawaiName, $pegawai);

        // Hapus data pegawai dari database
        $pegawai->delete();

        return redirect()
            ->route('backend.pegawai.index')
            ->with('success', 'Data pegawai berhasil dihapus.');
    }

    /**
     * Method untuk Form Laporan Pegawai
     */
    public function formPegawai()
    {
        return view('backend.v_pegawai.form', [
            'judul' => 'Laporan Data Pegawai',
        ]);
    }

    /**
     * Method untuk Cetak Laporan Pegawai
     */
    public function cetakPegawai(Request $request)
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

        $query = Pegawai::whereBetween('tanggal_masuk', [$tanggalAwal, $tanggalAkhir])
            ->orderBy('id', 'desc');

        // Filter berdasarkan status jika ada
        if ($request->has('status') && $request->status != '') {
            $query->where('status_pegawai', $request->status);
        }

        // Filter berdasarkan departemen jika ada
        if ($request->has('departemen') && $request->departemen != '') {
            $query->where('departemen', $request->departemen);
        }

        $pegawai = $query->get();

        return view('backend.v_pegawai.cetak', [
            'judul' => 'Laporan Pegawai',
            'tanggalAwal' => $tanggalAwal,
            'tanggalAkhir' => $tanggalAkhir,
            'cetak' => $pegawai
        ]);
    }

    /**
     * Method untuk mendapatkan statistik pegawai
     */
    public function statistik()
    {
        $totalPegawai = Pegawai::count();
        $pegawaiAktif = Pegawai::aktif()->count();
        $pegawaiCuti = Pegawai::cuti()->count();
        $pegawaiResign = Pegawai::resign()->count();

        return view('backend.v_pegawai.statistik', [
            'judul' => 'Statistik Pegawai',
            'totalPegawai' => $totalPegawai,
            'pegawaiAktif' => $pegawaiAktif,
            'pegawaiCuti' => $pegawaiCuti,
            'pegawaiResign' => $pegawaiResign,
        ]);
    }
}
