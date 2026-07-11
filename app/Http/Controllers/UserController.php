<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Helpers\ImageHelper;
use App\Helpers\ActivityLogger;
use App\Traits\HasPermissionCheck;
use App\Traits\CachesAdminList;

class UserController extends Controller
{
    use HasPermissionCheck, CachesAdminList;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check permission
        if ($response = $this->checkPermission('user.view', 'Anda tidak memiliki izin untuk melihat data user.')) {
            return $response;
        }

        $judul = 'Data User';
        $index = $this->rememberAdminList('user', 'all', fn () => User::with('roles')->orderBy('updated_at', 'desc')->get());

        // Add roles for permission management tab (only if super-admin)
        $roles = [];
        if (auth()->user()->hasRole('super-admin')) {
            $roles = \App\Models\Role::where('is_active', true)->orderBy('display_name')->get();
        }

        return view('backend.v_user.index', compact('judul', 'index', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check permission
        if ($response = $this->checkPermission('user.create', 'Anda tidak memiliki izin untuk menambah user.')) {
            return $response;
        }

        $roles = \App\Models\Role::where('is_active', true)->orderBy('display_name')->get();
        return view('backend.v_user.create', [
            'judul' => 'Tambah User',
            'roles' => $roles,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check permission
        if ($response = $this->checkPermission('user.create', 'Anda tidak memiliki izin untuk menambah user.')) {
            return $response;
        }

        $validatedData = $request->validate([
            'nama' => 'required|max:255',
            'email' => 'required|max:255|email|unique:user',
            'role_id' => 'required|exists:roles,id',
            'hp' => 'required|min:10|max:13',
            'password' => 'required|min:4|confirmed',
            'foto' => 'image|mimes:jpeg,jpg,png,gif|file|max:1024',
        ], [
            'foto.image' => 'Format gambar gunakan file dengan ekstensi jpeg, jpg, png, atau gif.',
            'foto.max' => 'Ukuran file gambar Maksimal adalah 1024 KB.',
            'role_id.required' => 'Role harus dipilih.',
            'role_id.exists' => 'Role yang dipilih tidak valid.',
        ]);

        $validatedData['status'] = 0; // Default nonaktif
        $validatedData['role'] = 0; // Keep old role field for compatibility

        // Upload foto jika ada
        if ($request->file('foto')) {
            $file = $request->file('foto');
            $extension = $file->getClientOriginalExtension();
            $originalFileName = date('YmdHis') . '_' . uniqid() . '.' . $extension;
            $directory = 'storage/img-user/';
            ImageHelper::uploadAndResize($file, $directory, $originalFileName, 385, 400);
            $validatedData['foto'] = $originalFileName;
        }

        // Validasi kombinasi password
        $password = $request->input('password');
        $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/';

        if (preg_match($pattern, $password)) {
            $validatedData['password'] = Hash::make($validatedData['password']);

            // Create user
            $user = User::create($validatedData);

            // Assign role menggunakan RBAC
            $user->assignRole($request->role_id, auth()->id());

            // Create pegawai if checkbox is checked
            if ($request->has('buat_pegawai') && $request->buat_pegawai == '1') {
                $pegawaiData = $request->validate([
                    'alamat' => 'nullable|string',
                    'tanggal_lahir' => 'nullable|date',
                    'jenis_kelamin' => 'required|in:laki-laki,perempuan',
                    'tanggal_masuk' => 'nullable|date',
                    'departemen' => 'nullable|string|max:100',
                    'jabatan' => 'nullable|string|max:100',
                    'gaji_pokok' => 'nullable|numeric|min:0',
                ]);

                $pegawaiData['user_id'] = $user->id;
                $pegawaiData['nama'] = $user->nama;
                $pegawaiData['email'] = $user->email;
                $pegawaiData['no_hp'] = $user->hp;
                $pegawaiData['status_pegawai'] = 'aktif';

                // Set defaults if not provided
                $pegawaiData['alamat'] = $pegawaiData['alamat'] ?? 'Belum diisi';
                $pegawaiData['tanggal_lahir'] = $pegawaiData['tanggal_lahir'] ?? now()->subYears(25);
                $pegawaiData['tanggal_masuk'] = $pegawaiData['tanggal_masuk'] ?? now();
                $pegawaiData['departemen'] = $pegawaiData['departemen'] ?? 'General';
                $pegawaiData['jabatan'] = $pegawaiData['jabatan'] ?? 'Staff';
                $pegawaiData['gaji_pokok'] = $pegawaiData['gaji_pokok'] ?? 5000000;

                \App\Models\Pegawai::create($pegawaiData);
                $this->forgetAdminList('user');

                return redirect()->route('backend.user.index')->with('success', 'Data user dan pegawai berhasil tersimpan');
            }

            $this->forgetAdminList('user');

            return redirect()->route('backend.user.index')->with('success', 'Data user berhasil tersimpan');
        } else {
            return redirect()->back()->withErrors(['password' => 'Password harus terdiri dari kombinasi huruf besar, huruf kecil, angka, dan simbol karakter.'])->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Check permission
        if ($response = $this->checkPermission('user.update', 'Anda tidak memiliki izin untuk mengubah data user.')) {
            return $response;
        }

        $user = User::with('roles')->findOrFail($id);
        $roles = \App\Models\Role::where('is_active', true)->orderBy('display_name')->get();
        return view('backend.v_user.edit', [
            'judul' => 'Ubah User',
            'edit' => $user,
            'roles' => $roles,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Check permission
        if ($response = $this->checkPermission('user.update', 'Anda tidak memiliki izin untuk mengubah data user.')) {
            return $response;
        }

        $user = User::findOrFail($id);

        $rules = [
            'nama' => 'required|max:255',
            'role_id' => 'required|exists:roles,id',
            'status' => 'required',
            'hp' => 'required|min:10|max:13',
            'foto' => 'image|mimes:jpeg,jpg,png,gif|file|max:1024',
        ];

        $messages = [
            'foto.image' => 'Format gambar gunakan file dengan ekstensi jpeg, jpg, png, atau gif.',
            'foto.max' => 'Ukuran file gambar Maksimal adalah 1024 KB.',
            'role_id.required' => 'Role harus dipilih.',
            'role_id.exists' => 'Role yang dipilih tidak valid.',
        ];

        // Validasi unik email jika diganti
        if ($request->email != $user->email) {
            $rules['email'] = 'required|max:255|email|unique:user';
        }

        $validatedData = $request->validate($rules, $messages);

        // Upload foto baru jika ada
        if ($request->file('foto')) {
            // hapus foto lama
            if ($user->foto) {
                $oldImagePath = public_path('storage/img-user/') . $user->foto;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $file = $request->file('foto');
            $extension = $file->getClientOriginalExtension();
            $originalFileName = date('YmdHis') . '_' . uniqid() . '.' . $extension;
            $directory = 'storage/img-user/';
            ImageHelper::uploadAndResize($file, $directory, $originalFileName, 385, 400);
            $validatedData['foto'] = $originalFileName;
        }

        $user->update($validatedData);

        // Update role menggunakan RBAC
        $user->syncRoles([$request->role_id], auth()->id());
        $this->forgetAdminList('user');

        return redirect()->route('backend.user.index')->with('success', 'Data berhasil diperbaharui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Check permission
        if ($response = $this->checkPermission('user.delete', 'Anda tidak memiliki izin untuk menghapus data user.')) {
            return $response;
        }

        $user = User::findOrFail($id);

        if ($user->foto) {
            $oldImagePath = public_path('storage/img-user/') . $user->foto;
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }

        $user->delete();
        $this->forgetAdminList('user');
        return redirect()->route('backend.user.index')->with('success', 'Data berhasil dihapus');
    }

    /**
     * Show the form for generating user reports.
     */
    public function formUser()
    {
        return view('backend.v_user.form', [
            'judul' => 'Laporan Data User',
        ]);
    }

    /**
     * Generate and display user report based on date range.
     */
    public function cetakUser(Request $request)
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

        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');

        $users = User::whereBetween('created_at', [$tanggal_awal . ' 00:00:00', $tanggal_akhir . ' 23:59:59'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('backend.v_user.cetak', [
            'judul' => 'Laporan Data User',
            'users' => $users,
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
        ]);
    }

    /**
     * Get permissions for a specific role (AJAX endpoint)
     */
    public function getRolePermissions($roleId)
    {
        // Check super-admin permission
        if (!auth()->user()->hasRole('super-admin')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Only super-admin can manage permissions.'
            ], 403);
        }

        try {
            // Get role with permissions
            $role = \App\Models\Role::with('permissions')->findOrFail($roleId);

            // Get all permissions grouped by module
            $allPermissions = \App\Models\Permission::orderBy('module')
                                        ->orderBy('name')
                                        ->get();

            // Get IDs of permissions currently assigned to this role
            $rolePermissionIds = $role->permissions->pluck('id')->toArray();

            return response()->json([
                'success' => true,
                'role' => [
                    'id' => $role->id,
                    'name' => $role->name,
                    'display_name' => $role->display_name,
                ],
                'permissions' => $allPermissions,
                'rolePermissions' => $rolePermissionIds,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load role permissions: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update role permissions (AJAX endpoint)
     */
    public function updateRolePermissions(Request $request, $roleId)
    {
        // Check super-admin permission
        if (!auth()->user()->hasRole('super-admin')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Only super-admin can manage permissions.'
            ], 403);
        }

        // Validate input
        $validated = $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        try {
            $role = \App\Models\Role::findOrFail($roleId);

            // Prevent modifying super-admin role
            if ($role->name === 'super-admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot modify super-admin permissions for security reasons.'
                ], 403);
            }

            // Sync permissions
            $permissions = $request->input('permissions', []);
            $role->permissions()->sync($permissions);

            // Log activity
            $permissionNames = \App\Models\Permission::whereIn('id', $permissions)->pluck('display_name')->toArray();
            ActivityLogger::permissionUpdated($role->display_name, $permissionNames);

            \Log::info('Role permissions updated', [
                'role_id' => $roleId,
                'role_name' => $role->name,
                'permission_count' => count($permissions),
                'updated_by' => auth()->id(),
            ]);

            return response()->json([
                'success' => true,
                'message' => "Permissions untuk '{$role->display_name}' berhasil diupdate.",
                'permission_count' => count($permissions),
            ]);

        } catch (\Exception $e) {
            \Log::error('Failed to update role permissions', [
                'role_id' => $roleId,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update permissions: ' . $e->getMessage()
            ], 500);
        }
    }
}
