<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing role permissions
        DB::table('role_permissions')->truncate();

        $this->command->info('Assigning permissions to roles...');

        // ============================================
        // SUPER ADMIN - Full Access ke SEMUA
        // ============================================
        $superAdmin = Role::where('name', 'super-admin')->first();
        if ($superAdmin) {
            $allPermissions = Permission::all()->pluck('id')->toArray();
            $superAdmin->permissions()->sync($allPermissions);
            $this->command->info("✓ Super Admin: " . count($allPermissions) . " permissions");
        }

        // ============================================
        // ADMIN - View semua, Full access User & Kategori
        // ============================================
        $admin = Role::where('name', 'admin')->first();
        if ($admin) {
            $adminPermissions = Permission::whereIn('name', [
                // View ALL
                'user.view', 'pegawai.view', 'aset.view', 'kategori.view', 'produk.view',
                // Full access User Management
                'user.create', 'user.update', 'user.delete',
                // Full access Kategori
                'kategori.create', 'kategori.update', 'kategori.delete',
                // Attendance Management
                'attendance.manage-all',
            ])->pluck('id')->toArray();
            $admin->permissions()->sync($adminPermissions);
            $this->command->info("✓ Admin: " . count($adminPermissions) . " permissions");
        }

        // ============================================
        // STAFF KEPEGAWAIAN - Full access Pegawai & Attendance
        // ============================================
        $staffKepegawaian = Role::where('name', 'staff-kepegawaian')->first();
        if ($staffKepegawaian) {
            $staffKepegawaianPermissions = Permission::whereIn('name', [
                // View
                'pegawai.view', 'aset.view', 'kategori.view', 'produk.view',
                // Full access Pegawai
                'pegawai.create', 'pegawai.update', 'pegawai.delete',
                // Attendance management
                'attendance.manage-all',
            ])->pluck('id')->toArray();
            $staffKepegawaian->permissions()->sync($staffKepegawaianPermissions);
            $this->command->info("✓ Staff Kepegawaian: " . count($staffKepegawaianPermissions) . " permissions");
        }

        // ============================================
        // STAFF INVENTARIS - Full access Aset & Produk
        // ============================================
        $staffInventaris = Role::where('name', 'staff-inventaris')->first();
        if ($staffInventaris) {
            $staffInventarisPermissions = Permission::whereIn('name', [
                // View
                'pegawai.view', 'aset.view', 'kategori.view', 'produk.view',
                // Full access Aset
                'aset.create', 'aset.update', 'aset.delete',
                // Full access Produk
                'produk.create', 'produk.update', 'produk.delete',
            ])->pluck('id')->toArray();
            $staffInventaris->permissions()->sync($staffInventarisPermissions);
            $this->command->info("✓ Staff Inventaris: " . count($staffInventarisPermissions) . " permissions");
        }

        // ============================================
        // VIEWER - View ONLY semua modul
        // ============================================
        $viewer = Role::where('name', 'viewer')->first();
        if ($viewer) {
            $viewerPermissions = Permission::whereIn('name', [
                'user.view', 'pegawai.view', 'aset.view', 'kategori.view', 'produk.view',
            ])->pluck('id')->toArray();
            $viewer->permissions()->sync($viewerPermissions);
            $this->command->info("✓ Viewer: " . count($viewerPermissions) . " permissions (View Only)");
        }

        $this->command->info('');
        $this->command->info('Role permissions assigned successfully!');
        $this->command->info('');
        $this->command->info('Summary:');
        $this->command->info('- Super Admin: Full access to everything');
        $this->command->info('- Admin: View all, Manage users, categories & attendance');
        $this->command->info('- Staff Kepegawaian: Manage employees & attendance');
        $this->command->info('- Staff Inventaris: Manage assets & products');
        $this->command->info('- Viewer: View only (read-only access)');
    }
}
