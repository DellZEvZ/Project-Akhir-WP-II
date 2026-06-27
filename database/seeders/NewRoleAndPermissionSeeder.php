<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

/**
 * Seeder idempotent: hanya menyisipkan role "barber" dan permission-permission
 * baru (barbershop, order, backup, attendance) yang BELUM ADA di database.
 * Aman dijalankan berkali-kali dan aman pada database yang sudah berisi data
 * produksi/lama, karena memakai updateOrInsert (tidak akan duplicate error).
 */
class NewRoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $this->command->info('=== Menambahkan role & permission baru (aman, idempotent) ===');
        $this->command->info('');

        // ============================================
        // 1. ROLE BARU: barber
        // ============================================
        $existingBarberRole = DB::table('roles')->where('name', 'barber')->first();

        if (!$existingBarberRole) {
            DB::table('roles')->insert([
                'name' => 'barber',
                'display_name' => 'Barber',
                'description' => 'Akun untuk barber/pegawai operasional. Hanya bisa melakukan absensi (check-in/check-out) sendiri, tidak memiliki akses ke modul backend lainnya',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            $this->command->info('✓ Role "barber" berhasil ditambahkan.');
        } else {
            $this->command->info('- Role "barber" sudah ada, dilewati.');
        }

        // ============================================
        // 2. PERMISSION BARU
        // ============================================
        $newPermissions = [
            // Attendance (nama yang dipakai kode AttendanceController)
            ['name' => 'attendance.manage-all', 'display_name' => 'Kelola Semua Attendance', 'description' => 'Dapat melihat, approve, edit, dan hapus attendance seluruh pegawai', 'module' => 'kepegawaian'],
            ['name' => 'attendance.own', 'display_name' => 'Absensi Diri Sendiri', 'description' => 'Dapat melakukan check-in/check-out & melihat riwayat absensi sendiri', 'module' => 'kepegawaian'],

            // Barbershop - Barber
            ['name' => 'barber.view', 'display_name' => 'Lihat Barber', 'description' => 'Dapat melihat daftar barber', 'module' => 'barbershop'],
            ['name' => 'barber.create', 'display_name' => 'Tambah Barber', 'description' => 'Dapat menambah barber baru', 'module' => 'barbershop'],
            ['name' => 'barber.update', 'display_name' => 'Edit Barber', 'description' => 'Dapat mengedit data barber', 'module' => 'barbershop'],
            ['name' => 'barber.delete', 'display_name' => 'Hapus Barber', 'description' => 'Dapat menghapus barber', 'module' => 'barbershop'],

            // Barbershop - Layanan
            ['name' => 'layanan.view', 'display_name' => 'Lihat Layanan', 'description' => 'Dapat melihat daftar layanan', 'module' => 'barbershop'],
            ['name' => 'layanan.create', 'display_name' => 'Tambah Layanan', 'description' => 'Dapat menambah layanan baru', 'module' => 'barbershop'],
            ['name' => 'layanan.update', 'display_name' => 'Edit Layanan', 'description' => 'Dapat mengedit data layanan', 'module' => 'barbershop'],
            ['name' => 'layanan.delete', 'display_name' => 'Hapus Layanan', 'description' => 'Dapat menghapus layanan', 'module' => 'barbershop'],

            // Barbershop - Galeri
            ['name' => 'galeri.view', 'display_name' => 'Lihat Galeri', 'description' => 'Dapat melihat galeri foto', 'module' => 'barbershop'],
            ['name' => 'galeri.create', 'display_name' => 'Upload Galeri', 'description' => 'Dapat upload foto ke galeri', 'module' => 'barbershop'],
            ['name' => 'galeri.delete', 'display_name' => 'Hapus Galeri', 'description' => 'Dapat menghapus foto galeri', 'module' => 'barbershop'],

            // Pesanan
            ['name' => 'order.view', 'display_name' => 'Lihat Pesanan', 'description' => 'Dapat melihat daftar pesanan customer', 'module' => 'pesanan'],
            ['name' => 'order.manage', 'display_name' => 'Kelola Pesanan', 'description' => 'Dapat mengubah status pesanan & verifikasi pembayaran', 'module' => 'pesanan'],

            // Backup
            ['name' => 'backup.manage', 'display_name' => 'Kelola Backup', 'description' => 'Dapat membuat, mengunduh, menghapus, dan RESTORE backup database', 'module' => 'settings'],
        ];

        $insertedCount = 0;
        $skippedCount = 0;

        foreach ($newPermissions as $perm) {
            $exists = DB::table('permissions')->where('name', $perm['name'])->exists();

            if (!$exists) {
                DB::table('permissions')->insert([
                    'name' => $perm['name'],
                    'display_name' => $perm['display_name'],
                    'description' => $perm['description'],
                    'module' => $perm['module'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
                $insertedCount++;
                $this->command->info("✓ Permission '{$perm['name']}' ditambahkan.");
            } else {
                $skippedCount++;
            }
        }

        $this->command->info('');
        $this->command->info("Permission baru ditambahkan: {$insertedCount}, dilewati (sudah ada): {$skippedCount}");
        $this->command->info('');

        // ============================================
        // 3. ASSIGN PERMISSION BARU KE ROLE YANG SESUAI
        // ============================================
        $roles = DB::table('roles')->get()->keyBy('name');
        $permissions = DB::table('permissions')->get()->keyBy('name');

        $assignments = [
            'super-admin' => array_column($newPermissions, 'name'), // semua permission baru
            'admin' => [
                'barber.view', 'barber.create', 'barber.update', 'barber.delete',
                'layanan.view', 'layanan.create', 'layanan.update', 'layanan.delete',
                'galeri.view', 'galeri.create', 'galeri.delete',
                'order.view', 'order.manage',
                'backup.manage',
            ],
            'barber' => [
                'attendance.own',
            ],
        ];

        foreach ($assignments as $roleName => $permissionNames) {
            if (!$roles->has($roleName)) {
                $this->command->warn("⚠ Role '{$roleName}' tidak ditemukan, dilewati.");
                continue;
            }

            $roleId = $roles[$roleName]->id;
            $assignedCount = 0;

            foreach ($permissionNames as $permName) {
                if (!$permissions->has($permName)) {
                    continue;
                }

                $permissionId = $permissions[$permName]->id;

                $alreadyAssigned = DB::table('role_permissions')
                    ->where('role_id', $roleId)
                    ->where('permission_id', $permissionId)
                    ->exists();

                if (!$alreadyAssigned) {
                    DB::table('role_permissions')->insert([
                        'role_id' => $roleId,
                        'permission_id' => $permissionId,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                    $assignedCount++;
                }
            }

            $this->command->info("✓ Role '{$roleName}': {$assignedCount} permission baru di-assign.");
        }

        $this->command->info('');
        $this->command->info('=== Selesai! Role "barber" dan semua permission baru sudah siap. ===');
    }
}
