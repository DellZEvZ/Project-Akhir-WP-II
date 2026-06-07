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
        $superAdmin = Role::where('name', 'super_admin')->first();
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
            ])->pluck('id')->toArray();
            $admin->permissions()->sync($adminPermissions);
            $this->command->info("✓ Admin: " . count($adminPermissions) . " permissions");
        }

        // ============================================
        // SUPERVISOR - View semua, Full access Pegawai & Aset
        // ============================================
        $supervisor = Role::where('name', 'supervisor')->first();
        if ($supervisor) {
            $supervisorPermissions = Permission::whereIn('name', [
                // View ALL
                'user.view', 'pegawai.view', 'aset.view', 'kategori.view', 'produk.view',
                // Full access Pegawai
                'pegawai.create', 'pegawai.update', 'pegawai.delete',
                // Full access Aset
                'aset.create', 'aset.update', 'aset.delete',
            ])->pluck('id')->toArray();
            $supervisor->permissions()->sync($supervisorPermissions);
            $this->command->info("✓ Supervisor: " . count($supervisorPermissions) . " permissions");
        }

        // ============================================
        // PEGAWAI - View ONLY semua modul
        // ============================================
        $pegawai = Role::where('name', 'pegawai')->first();
        if ($pegawai) {
            $pegawaiPermissions = Permission::whereIn('name', [
                'user.view', 'pegawai.view', 'aset.view', 'kategori.view', 'produk.view',
            ])->pluck('id')->toArray();
            $pegawai->permissions()->sync($pegawaiPermissions);
            $this->command->info("✓ Pegawai: " . count($pegawaiPermissions) . " permissions (View Only)");
        }

        // ============================================
        // INVENTORY MANAGER - View semua, Full access Aset & Produk
        // ============================================
        $inventoryManager = Role::where('name', 'inventory_manager')->first();
        if ($inventoryManager) {
            $inventoryPermissions = Permission::whereIn('name', [
                // View ALL
                'user.view', 'pegawai.view', 'aset.view', 'kategori.view', 'produk.view',
                // Full access Aset
                'aset.create', 'aset.update', 'aset.delete',
                // Full access Produk
                'produk.create', 'produk.update', 'produk.delete',
            ])->pluck('id')->toArray();
            $inventoryManager->permissions()->sync($inventoryPermissions);
            $this->command->info("✓ Inventory Manager: " . count($inventoryPermissions) . " permissions");
        }

        $this->command->info('');
        $this->command->info('Role permissions assigned successfully!');
        $this->command->info('');
        $this->command->info('Summary:');
        $this->command->info('- Super Admin: Full access to everything');
        $this->command->info('- Admin: View all, Manage users & categories');
        $this->command->info('- Supervisor: View all, Manage employees & assets');
        $this->command->info('- Pegawai: View only (read-only access)');
        $this->command->info('- Inventory Manager: View all, Manage assets & products');
    }
}
