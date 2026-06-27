<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RolePermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $this->command->info('Starting role permissions assignment...');
        $this->command->info('');

        // Clear existing role permissions
        DB::table('role_permissions')->truncate();
        $this->command->info('✓ Cleared existing role permissions');

        // Get all roles and permissions
        $roles = DB::table('roles')->get()->keyBy('name');
        $permissions = DB::table('permissions')->get()->keyBy('name');

        $this->command->info("✓ Found {$roles->count()} roles");
        $this->command->info("✓ Found {$permissions->count()} permissions");
        $this->command->info('');

        // Helper function to safely get permission ID
        $getPermissionId = function($permissionName) use ($permissions) {
            if (isset($permissions[$permissionName])) {
                return $permissions[$permissionName]->id;
            }
            $this->command->warn("⚠ Permission not found: {$permissionName}");
            return null;
        };

        // ============================================
        // SUPER ADMIN - Full Access ke SEMUA (38 permissions)
        // ============================================
        if ($roles->has('super-admin')) {
            $superAdminPermissions = [];
            foreach ($permissions as $permission) {
                $superAdminPermissions[] = [
                    'role_id' => $roles['super-admin']->id,
                    'permission_id' => $permission->id,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
            
            if (!empty($superAdminPermissions)) {
                DB::table('role_permissions')->insert($superAdminPermissions);
                $this->command->info("✓ Super Admin: " . count($superAdminPermissions) . " permissions (FULL ACCESS)");
            }
        } else {
            $this->command->error('✗ Super Admin role not found!');
        }

        // ============================================
        // ADMIN - Semua KECUALI User Management (34 permissions)
        // Access: Pegawai, Absensi, Jadwal, Gaji, Aset, Kategori, Produk, Laporan, Settings
        // ============================================
        if ($roles->has('admin')) {
            $adminPermissionNames = [
                // Kepegawaian - Full Access
                'pegawai.view', 'pegawai.create', 'pegawai.update', 'pegawai.delete',
                
                // Absensi - Full Access
                'absensi.view', 'absensi.create', 'absensi.update', 'absensi.delete',
                
                // Jadwal - Full Access
                'jadwal.view', 'jadwal.create', 'jadwal.update', 'jadwal.delete',
                
                // Gaji - Full Access (kecuali delete)
                'gaji.view', 'gaji.create', 'gaji.update',
                
                // Inventaris - Aset - Full Access
                'aset.view', 'aset.create', 'aset.update', 'aset.delete',
                
                // Inventaris - Kategori - Full Access
                'kategori.view', 'kategori.create', 'kategori.update', 'kategori.delete',
                
                // Inventaris - Produk - Full Access
                'produk.view', 'produk.create', 'produk.update', 'produk.delete',
                
                // Pelaporan - Full Access
                'laporan.kepegawaian', 'laporan.inventaris', 'laporan.keuangan',
                
                // Settings - View Only
                'settings.view', 'settings.update',

                // Barbershop - Full Access
                'barber.view', 'barber.create', 'barber.update', 'barber.delete',
                'layanan.view', 'layanan.create', 'layanan.update', 'layanan.delete',
                'galeri.view', 'galeri.create', 'galeri.delete',

                // Pesanan - Full Access
                'order.view', 'order.manage',

                // Backup - Full Access (sensitif, hanya admin & super-admin)
                'backup.manage',
            ];

            $adminPermissions = [];
            $foundCount = 0;
            foreach ($adminPermissionNames as $permName) {
                $permId = $getPermissionId($permName);
                if ($permId) {
                    $adminPermissions[] = [
                        'role_id' => $roles['admin']->id,
                        'permission_id' => $permId,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                    $foundCount++;
                }
            }

            if (!empty($adminPermissions)) {
                DB::table('role_permissions')->insert($adminPermissions);
                $this->command->info("✓ Admin: {$foundCount} permissions (ALL EXCEPT User Management)");
            }
        } else {
            $this->command->error('✗ Admin role not found!');
        }

        // ============================================
        // STAFF KEPEGAWAIAN - Akses Kepegawaian Terbatas (15 permissions)
        // ============================================
        if ($roles->has('staff-kepegawaian')) {
            $staffKepegawaianPermissionNames = [
                // Pegawai - Full Access
                'pegawai.view', 'pegawai.create', 'pegawai.update', 'pegawai.delete',
                
                // Absensi - Full Access
                'absensi.view', 'absensi.create', 'absensi.update', 'absensi.delete',
                
                // Jadwal - Full Access
                'jadwal.view', 'jadwal.create', 'jadwal.update', 'jadwal.delete',
                
                // Gaji - View and Update only
                'gaji.view', 'gaji.create', 'gaji.update',
                
                // Laporan Kepegawaian
                'laporan.kepegawaian',
            ];

            $staffKepegawaianPermissions = [];
            $foundCount = 0;
            foreach ($staffKepegawaianPermissionNames as $permName) {
                $permId = $getPermissionId($permName);
                if ($permId) {
                    $staffKepegawaianPermissions[] = [
                        'role_id' => $roles['staff-kepegawaian']->id,
                        'permission_id' => $permId,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                    $foundCount++;
                }
            }

            if (!empty($staffKepegawaianPermissions)) {
                DB::table('role_permissions')->insert($staffKepegawaianPermissions);
                $this->command->info("✓ Staff Kepegawaian: {$foundCount} permissions (KEPEGAWAIAN LIMITED)");
            }
        } else {
            $this->command->error('✗ Staff Kepegawaian role not found!');
        }

        // ============================================
        // STAFF INVENTARIS - Akses Inventaris Full (17 permissions)
        // ============================================
        if ($roles->has('staff-inventaris')) {
            $staffInventarisPermissionNames = [
                // Aset - Full Access
                'aset.view', 'aset.create', 'aset.update', 'aset.delete',
                
                // Kategori - Full Access
                'kategori.view', 'kategori.create', 'kategori.update', 'kategori.delete',
                
                // Produk - Full Access
                'produk.view', 'produk.create', 'produk.update', 'produk.delete',
                
                // Pegawai - View Only (untuk referensi)
                'pegawai.view',
                
                // Laporan Inventaris
                'laporan.inventaris',
                
                // Settings - View Only
                'settings.view',
            ];

            $staffInventarisPermissions = [];
            $foundCount = 0;
            foreach ($staffInventarisPermissionNames as $permName) {
                $permId = $getPermissionId($permName);
                if ($permId) {
                    $staffInventarisPermissions[] = [
                        'role_id' => $roles['staff-inventaris']->id,
                        'permission_id' => $permId,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                    $foundCount++;
                }
            }

            if (!empty($staffInventarisPermissions)) {
                DB::table('role_permissions')->insert($staffInventarisPermissions);
                $this->command->info("✓ Staff Inventaris: {$foundCount} permissions (INVENTARIS FULL ACCESS)");
            }
        } else {
            $this->command->error('✗ Staff Inventaris role not found!');
        }

        // ============================================
        // VIEWER - View Only SEMUA Modul (10 permissions)
        // ============================================
        if ($roles->has('viewer')) {
            $viewerPermissionNames = [
                'pegawai.view',
                'absensi.view',
                'jadwal.view',
                'gaji.view',
                'aset.view',
                'kategori.view',
                'produk.view',
                'laporan.kepegawaian',
                'laporan.inventaris',
                'settings.view',
            ];

            $viewerPermissions = [];
            $foundCount = 0;
            foreach ($viewerPermissionNames as $permName) {
                $permId = $getPermissionId($permName);
                if ($permId) {
                    $viewerPermissions[] = [
                        'role_id' => $roles['viewer']->id,
                        'permission_id' => $permId,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                    $foundCount++;
                }
            }

            if (!empty($viewerPermissions)) {
                DB::table('role_permissions')->insert($viewerPermissions);
                $this->command->info("✓ Viewer: {$foundCount} permissions (VIEW ONLY)");
            }
        } else {
            $this->command->error('✗ Viewer role not found!');
        }

        // ============================================
        // BARBER - Hanya Absensi Diri Sendiri (1 permission)
        // ============================================
        if ($roles->has('barber')) {
            $barberPermissionNames = [
                'attendance.own',
            ];

            $barberPermissions = [];
            $foundCount = 0;
            foreach ($barberPermissionNames as $permName) {
                $permId = $getPermissionId($permName);
                if ($permId) {
                    $barberPermissions[] = [
                        'role_id' => $roles['barber']->id,
                        'permission_id' => $permId,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                    $foundCount++;
                }
            }

            if (!empty($barberPermissions)) {
                DB::table('role_permissions')->insert($barberPermissions);
                $this->command->info("✓ Barber: {$foundCount} permission (SELF ATTENDANCE ONLY)");
            }
        } else {
            $this->command->error('✗ Barber role not found!');
        }

        $this->command->info('');
        $this->command->info('=== Role Permissions Assignment Completed ===');
        
        // Verification
        $totalAssigned = DB::table('role_permissions')->count();
        $this->command->info("Total permissions assigned: {$totalAssigned}");
        
        // Show summary per role
        $this->command->info('');
        $this->command->info('=== SUMMARY PER ROLE ===');
        foreach ($roles as $role) {
            $count = DB::table('role_permissions')
                ->where('role_id', $role->id)
                ->count();
            
            $description = '';
            switch($role->name) {
                case 'super-admin':
                    $description = '(Full Access - SEMUA)';
                    break;
                case 'admin':
                    $description = '(All except User Management)';
                    break;
                case 'staff-kepegawaian':
                    $description = '(Kepegawaian Full Access)';
                    break;
                case 'staff-inventaris':
                    $description = '(Inventaris Full Access)';
                    break;
                case 'viewer':
                    $description = '(View Only)';
                    break;
                case 'barber':
                    $description = '(Self Attendance Only)';
                    break;
            }
            
            $this->command->info("  - {$role->display_name}: {$count} permissions {$description}");
        }
    }
}