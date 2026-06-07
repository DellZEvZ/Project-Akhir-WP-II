<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $this->command->info('Creating permissions...');

        $permissions = [
            // ============================================
            // 1. USER MANAGEMENT (4 permissions)
            // ============================================
            ['name' => 'user.view', 'display_name' => 'Lihat User', 'description' => 'Dapat melihat daftar user', 'module' => 'user-management', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'user.create', 'display_name' => 'Tambah User', 'description' => 'Dapat menambah user baru', 'module' => 'user-management', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'user.update', 'display_name' => 'Edit User', 'description' => 'Dapat mengedit data user', 'module' => 'user-management', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'user.delete', 'display_name' => 'Hapus User', 'description' => 'Dapat menghapus user', 'module' => 'user-management', 'created_at' => $now, 'updated_at' => $now],

            // ============================================
            // 2. KEPEGAWAIAN - DATA PEGAWAI (4 permissions)
            // ============================================
            ['name' => 'pegawai.view', 'display_name' => 'Lihat Pegawai', 'description' => 'Dapat melihat daftar pegawai', 'module' => 'kepegawaian', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'pegawai.create', 'display_name' => 'Tambah Pegawai', 'description' => 'Dapat menambah pegawai baru', 'module' => 'kepegawaian', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'pegawai.update', 'display_name' => 'Edit Pegawai', 'description' => 'Dapat mengedit data pegawai', 'module' => 'kepegawaian', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'pegawai.delete', 'display_name' => 'Hapus Pegawai', 'description' => 'Dapat menghapus pegawai', 'module' => 'kepegawaian', 'created_at' => $now, 'updated_at' => $now],

            // ============================================
            // 3. KEPEGAWAIAN - ABSENSI (4 permissions)
            // ============================================
            ['name' => 'absensi.view', 'display_name' => 'Lihat Absensi', 'description' => 'Dapat melihat data absensi', 'module' => 'kepegawaian', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'absensi.create', 'display_name' => 'Input Absensi', 'description' => 'Dapat melakukan absensi', 'module' => 'kepegawaian', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'absensi.update', 'display_name' => 'Edit Absensi', 'description' => 'Dapat mengedit data absensi', 'module' => 'kepegawaian', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'absensi.delete', 'display_name' => 'Hapus Absensi', 'description' => 'Dapat menghapus data absensi', 'module' => 'kepegawaian', 'created_at' => $now, 'updated_at' => $now],

            // ============================================
            // 4. KEPEGAWAIAN - JADWAL (4 permissions)
            // ============================================
            ['name' => 'jadwal.view', 'display_name' => 'Lihat Jadwal', 'description' => 'Dapat melihat jadwal kerja', 'module' => 'kepegawaian', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'jadwal.create', 'display_name' => 'Buat Jadwal', 'description' => 'Dapat membuat jadwal kerja', 'module' => 'kepegawaian', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'jadwal.update', 'display_name' => 'Edit Jadwal', 'description' => 'Dapat mengedit jadwal kerja', 'module' => 'kepegawaian', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'jadwal.delete', 'display_name' => 'Hapus Jadwal', 'description' => 'Dapat menghapus jadwal kerja', 'module' => 'kepegawaian', 'created_at' => $now, 'updated_at' => $now],

            // ============================================
            // 5. KEPEGAWAIAN - GAJI (3 permissions)
            // ============================================
            ['name' => 'gaji.view', 'display_name' => 'Lihat Gaji', 'description' => 'Dapat melihat slip gaji', 'module' => 'kepegawaian', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'gaji.create', 'display_name' => 'Input Gaji', 'description' => 'Dapat input data gaji', 'module' => 'kepegawaian', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'gaji.update', 'display_name' => 'Edit Gaji', 'description' => 'Dapat mengedit data gaji', 'module' => 'kepegawaian', 'created_at' => $now, 'updated_at' => $now],

            // ============================================
            // 6. INVENTARIS - ASET (4 permissions)
            // ============================================
            ['name' => 'aset.view', 'display_name' => 'Lihat Aset', 'description' => 'Dapat melihat daftar aset', 'module' => 'inventaris', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'aset.create', 'display_name' => 'Tambah Aset', 'description' => 'Dapat menambah aset baru', 'module' => 'inventaris', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'aset.update', 'display_name' => 'Edit Aset', 'description' => 'Dapat mengedit data aset', 'module' => 'inventaris', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'aset.delete', 'display_name' => 'Hapus Aset', 'description' => 'Dapat menghapus aset', 'module' => 'inventaris', 'created_at' => $now, 'updated_at' => $now],

            // ============================================
            // 7. INVENTARIS - KATEGORI (4 permissions)
            // ============================================
            ['name' => 'kategori.view', 'display_name' => 'Lihat Kategori', 'description' => 'Dapat melihat kategori produk', 'module' => 'inventaris', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'kategori.create', 'display_name' => 'Tambah Kategori', 'description' => 'Dapat menambah kategori', 'module' => 'inventaris', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'kategori.update', 'display_name' => 'Edit Kategori', 'description' => 'Dapat mengedit kategori', 'module' => 'inventaris', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'kategori.delete', 'display_name' => 'Hapus Kategori', 'description' => 'Dapat menghapus kategori', 'module' => 'inventaris', 'created_at' => $now, 'updated_at' => $now],

            // ============================================
            // 8. INVENTARIS - PRODUK/STOK (4 permissions)
            // ============================================
            ['name' => 'produk.view', 'display_name' => 'Lihat Produk', 'description' => 'Dapat melihat daftar produk/stok', 'module' => 'inventaris', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'produk.create', 'display_name' => 'Tambah Produk', 'description' => 'Dapat menambah produk/stok', 'module' => 'inventaris', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'produk.update', 'display_name' => 'Edit Produk', 'description' => 'Dapat mengedit produk/stok', 'module' => 'inventaris', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'produk.delete', 'display_name' => 'Hapus Produk', 'description' => 'Dapat menghapus produk/stok', 'module' => 'inventaris', 'created_at' => $now, 'updated_at' => $now],

            // ============================================
            // 9. PELAPORAN (3 permissions)
            // ============================================
            ['name' => 'laporan.kepegawaian', 'display_name' => 'Laporan Kepegawaian', 'description' => 'Dapat melihat dan export laporan kepegawaian', 'module' => 'pelaporan', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'laporan.inventaris', 'display_name' => 'Laporan Inventaris', 'description' => 'Dapat melihat dan export laporan inventaris', 'module' => 'pelaporan', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'laporan.keuangan', 'display_name' => 'Laporan Keuangan', 'description' => 'Dapat melihat dan export laporan keuangan', 'module' => 'pelaporan', 'created_at' => $now, 'updated_at' => $now],

            // ============================================
            // 10. SETTINGS (2 permissions)
            // ============================================
            ['name' => 'settings.view', 'display_name' => 'Lihat Pengaturan', 'description' => 'Dapat melihat pengaturan sistem', 'module' => 'settings', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'settings.update', 'display_name' => 'Edit Pengaturan', 'description' => 'Dapat mengubah pengaturan sistem', 'module' => 'settings', 'created_at' => $now, 'updated_at' => $now],
        ];

        // Insert permissions
        DB::table('permissions')->insert($permissions);

        $this->command->info('✓ Created ' . count($permissions) . ' permissions successfully!');
        $this->command->info('');
        
        // Show summary
        $this->command->info('=== PERMISSIONS SUMMARY ===');
        $this->command->info('1. User Management:    4 permissions');
        $this->command->info('2. Pegawai:            4 permissions');
        $this->command->info('3. Absensi:            4 permissions');
        $this->command->info('4. Jadwal:             4 permissions');
        $this->command->info('5. Gaji:               3 permissions');
        $this->command->info('6. Aset:               4 permissions');
        $this->command->info('7. Kategori:           4 permissions');
        $this->command->info('8. Produk:             4 permissions');
        $this->command->info('9. Pelaporan:          3 permissions');
        $this->command->info('10. Settings:          2 permissions');
        $this->command->info('───────────────────────────');
        $this->command->info('TOTAL:                38 permissions');
    }
}