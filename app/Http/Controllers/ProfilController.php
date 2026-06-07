<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Helpers\ImageHelper;

class ProfilController extends Controller
{
    /**
     * Display user profile page
     */
    public function index()
    {
        $user = Auth::user();

        return view('backend.v_profil.index', [
            'judul' => 'Profil Saya',
            'user' => $user
        ]);
    }

    /**
     * Update user profile information
     */
    public function updateProfil(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'nama' => 'required|max:255',
            'email' => 'required|email|unique:user,email,' . $user->id,
            'hp' => 'nullable|max:20',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:1024',
        ], [
            'foto.image' => 'Format gambar harus jpeg, jpg, png, atau gif.',
            'foto.max' => 'Ukuran file maksimal 1024 KB.',
            'email.unique' => 'Email sudah terdaftar.',
        ]);

        // Handle foto upload
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($user->foto && $user->foto != 'img-default.jpg') {
                $path = public_path('storage/img-user/');
                $oldFiles = [
                    $user->foto,
                    'thumb_' . $user->foto,
                ];

                foreach ($oldFiles as $oldFile) {
                    $filePath = $path . $oldFile;
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }
            }

            // Upload foto baru
            $file = $request->file('foto');
            $extension = $file->getClientOriginalExtension();
            $fileName = date('YmdHis') . '_' . uniqid() . '.' . $extension;
            $directory = 'storage/img-user/';

            // Gambar asli
            ImageHelper::uploadAndResize($file, $directory, $fileName, 800, null);

            // Thumbnail
            ImageHelper::uploadAndResize($file, $directory, 'thumb_' . $fileName, 200, 200);

            $validatedData['foto'] = $fileName;
        }

        // Update user
        $user->update($validatedData);

        return redirect()->route('backend.profil.index')
            ->with('success', 'Profil berhasil diperbaharui');
    }

    /**
     * Update user password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:8|confirmed',
        ], [
            'password_lama.required' => 'Password lama harus diisi',
            'password_baru.required' => 'Password baru harus diisi',
            'password_baru.min' => 'Password baru minimal 8 karakter',
            'password_baru.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        $user = Auth::user();

        // Check old password
        if (!Hash::check($request->password_lama, $user->password)) {
            return redirect()->back()
                ->with('error', 'Password lama tidak sesuai');
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->password_baru)
        ]);

        return redirect()->route('backend.profil.index')
            ->with('success', 'Password berhasil diperbaharui');
    }
}
