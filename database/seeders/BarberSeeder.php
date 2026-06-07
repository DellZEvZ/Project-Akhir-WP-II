<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Barber;

class BarberSeeder extends Seeder
{
    public function run(): void
    {
        $barbers = [
            ['nama' => 'Aldi Pratama',    'spesialisasi' => 'Classic Cut & Shave',      'pengalaman_tahun' => 7, 'no_hp' => '081234567001', 'status' => 'aktif'],
            ['nama' => 'Rizky Firmansyah','spesialisasi' => 'Fade & Modern Style',       'pengalaman_tahun' => 5, 'no_hp' => '081234567002', 'status' => 'aktif'],
            ['nama' => 'Doni Setiawan',   'spesialisasi' => 'Beard Grooming & Coloring', 'pengalaman_tahun' => 4, 'no_hp' => '081234567003', 'status' => 'aktif'],
            ['nama' => 'Hendra Kusuma',   'spesialisasi' => 'Hair Treatment & Spa',      'pengalaman_tahun' => 6, 'no_hp' => '081234567004', 'status' => 'aktif'],
            ['nama' => 'Bagas Nugroho',   'spesialisasi' => 'Skin Fade & Design',        'pengalaman_tahun' => 3, 'no_hp' => '081234567005', 'status' => 'aktif'],
        ];

        foreach ($barbers as $barber) {
            Barber::create($barber);
        }
    }
}
