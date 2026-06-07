<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class QuickLoginController extends Controller
{
    /**
     * Get users list for quick login (API endpoint)
     */
    public function getUsersList()
    {
        // Only allow in debug mode
        if (!config('app.debug')) {
            return response()->json(['error' => 'Quick login is only available in debug mode.'], 403);
        }

        // Get all active users with their roles and permissions
        $users = User::with(['roles.permissions', 'pegawai'])
            ->where('status', 1)
            ->get()
            ->map(function($user) {
                $role = $user->roles->first();
                return [
                    'id' => $user->id,
                    'nama' => $user->nama,
                    'email' => $user->email,
                    'role' => $role ? [
                        'name' => $role->name,
                        'display_name' => $role->display_name,
                        'description' => $role->description,
                        'permissions_count' => $role->permissions()->count()
                    ] : null,
                    'pegawai' => $user->pegawai ? [
                        'jabatan' => $user->pegawai->jabatan
                    ] : null,
                ];
            });

        return response()->json([
            'success' => true,
            'users' => $users
        ]);
    }

    /**
     * Show quick login page
     */
    public function index()
    {
        // Only allow in debug mode
        if (!config('app.debug')) {
            abort(403, 'Quick login is only available in debug mode.');
        }

        // Get all users with their roles, permissions, and pegawai data
        $users = User::with([
            'roles.permissions', // Eager load roles and their permissions
            'pegawai'           // Eager load pegawai data
        ])->get();

        // Get currently logged in user with roles and permissions
        $currentUser = Auth::user();
        if ($currentUser) {
            $currentUser->load('roles.permissions');
        }

        return view('backend.v_quick_login.index', [
            'judul' => 'Login Cepat - Testing',
            'users' => $users,
            'currentUser' => $currentUser
        ]);
    }

    /**
     * Quick login as specific user
     */
    public function loginAs($userId)
    {
        // Only allow in development/testing mode
        if (!config('app.debug')) {
            abort(403, 'Quick login is only available in debug mode.');
        }

        $user = User::with('roles.permissions')->findOrFail($userId);

        // Check if user is active
        if ($user->status == 0) {
            return redirect()->route('backend.quick-login.index')
                ->with('error', "User {$user->nama} tidak aktif. Aktifkan user terlebih dahulu.");
        }

        // Login the user
        Auth::login($user);

        // Update last login
        $user->update([
            'last_login' => now()
        ]);

        // Get role name for message
        $roleName = $user->roles->first()->display_name ?? 'No Role';
        $permissionCount = $user->roles->first()->permissions()->count() ?? 0;

        return redirect()->route('backend.beranda')
            ->with('success', "Berhasil login sebagai {$user->nama} ({$roleName} - {$permissionCount} permissions)");
    }

    /**
     * Show current user info (JSON API)
     */
    public function currentUser()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'error' => 'Not authenticated'
            ], 401);
        }

        // Load relationships
        $user->load('roles.permissions');

        // Get all permissions through roles
        $permissions = [];
        foreach ($user->roles as $role) {
            foreach ($role->permissions as $permission) {
                $permissions[] = $permission->name;
            }
        }

        return response()->json([
            'id' => $user->id,
            'nama' => $user->nama,
            'email' => $user->email,
            'status' => $user->status == 1 ? 'Aktif' : 'Nonaktif',
            'roles' => $user->roles->map(function($role) {
                return [
                    'id' => $role->id,
                    'name' => $role->name,
                    'display_name' => $role->display_name,
                    'description' => $role->description,
                    'permissions_count' => $role->permissions()->count()
                ];
            }),
            'permissions' => array_unique($permissions),
            'total_permissions' => count(array_unique($permissions)),
            'last_login' => $user->last_login ? $user->last_login->toDateTimeString() : null,
        ]);
    }

    /**
     * Get role statistics (JSON API)
     */
    public function roleStats()
    {
        // Only allow in debug mode
        if (!config('app.debug')) {
            abort(403);
        }

        $roles = \App\Models\Role::with('permissions')->get();

        $stats = $roles->map(function($role) {
            return [
                'name' => $role->name,
                'display_name' => $role->display_name,
                'description' => $role->description,
                'total_permissions' => $role->permissions()->count(),
                'users_count' => $role->users()->count(),
                'is_active' => $role->is_active,
            ];
        });

        return response()->json([
            'total_roles' => $roles->count(),
            'roles' => $stats
        ]);
    }

    /**
     * Test user permissions (JSON API)
     */
    public function testPermissions($userId, $permissionName)
    {
        // Only allow in debug mode
        if (!config('app.debug')) {
            abort(403);
        }

        $user = User::with('roles.permissions')->findOrFail($userId);

        // Check if user has permission
        $hasPermission = false;
        foreach ($user->roles as $role) {
            if ($role->permissions()->where('name', $permissionName)->exists()) {
                $hasPermission = true;
                break;
            }
        }

        return response()->json([
            'user' => [
                'id' => $user->id,
                'nama' => $user->nama,
                'email' => $user->email,
            ],
            'permission' => $permissionName,
            'has_permission' => $hasPermission,
            'roles' => $user->roles->pluck('display_name'),
        ]);
    }
}