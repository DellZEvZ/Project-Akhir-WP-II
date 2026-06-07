<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $roles = [
            [
                'name' => 'super-admin',
                'display_name' => 'Super Admin',
                'description' => 'Memiliki akses penuh ke semua fitur sistem CAREXIS termasuk manajemen user, kepegawaian, inventaris, dan pelaporan',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'admin',
                'display_name' => 'Admin',
                'description' => 'Akses ke fitur kepegawaian dan inventaris, tidak bisa mengelola user',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'staff-kepegawaian',
                'display_name' => 'Staff Kepegawaian',
                'description' => 'Akses terbatas ke modul kepegawaian (absensi, jadwal, slip gaji)',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'staff-inventaris',
                'display_name' => 'Staff Inventaris',
                'description' => 'Akses terbatas ke modul inventaris (data aset, stok barang)',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'viewer',
                'display_name' => 'Viewer',
                'description' => 'Hanya bisa melihat data tanpa bisa mengedit atau menghapus',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('roles')->insert($roles);
    }
}
