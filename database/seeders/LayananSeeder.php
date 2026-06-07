<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Layanan;

class LayananSeeder extends Seeder
{
    public function run(): void
    {
        $layanans = [
            [
                'nama_layanan' => 'Haircut Reguler',
                'deskripsi'    => 'Potong rambut standar menggunakan gunting dan sisir oleh barber profesional. Cocok untuk semua tipe rambut.',
                'harga'        => 35000,
                'durasi_menit' => 30,
                'status'       => 'aktif',
            ],
            [
                'nama_layanan' => 'Haircut + Styling',
                'deskripsi'    => 'Potong rambut lengkap dengan penataan gaya menggunakan pomade atau wax pilihan. Tampil rapi dan stylish.',
                'harga'        => 50000,
                'durasi_menit' => 45,
                'status'       => 'aktif',
            ],
            [
                'nama_layanan' => 'Shave & Beard Trim',
                'deskripsi'    => 'Cukur jenggot dan kumis dengan pisau cukur klasik, dilanjutkan perawatan dengan aftershave untuk kulit segar.',
                'harga'        => 25000,
                'durasi_menit' => 20,
                'status'       => 'aktif',
            ],
            [
                'nama_layanan' => 'Hair Wash + Blow Dry',
                'deskripsi'    => 'Keramas dengan shampo premium pria, pemijatan kepala, dan blow dry hingga rapi sempurna.',
                'harga'        => 30000,
                'durasi_menit' => 30,
                'status'       => 'aktif',
            ],
            [
                'nama_layanan' => 'Creambath',
                'deskripsi'    => 'Perawatan rambut intensif dengan krim bergizi, pijatan kepala yang menenangkan, dan steam untuk hasil maksimal.',
                'harga'        => 75000,
                'durasi_menit' => 60,
                'status'       => 'aktif',
            ],
            [
                'nama_layanan' => 'Hair Coloring',
                'deskripsi'    => 'Pewarnaan rambut profesional dengan cat berkualitas tinggi. Tersedia berbagai pilihan warna natural hingga bold.',
                'harga'        => 150000,
                'durasi_menit' => 90,
                'status'       => 'aktif',
            ],
            [
                'nama_layanan' => 'Paket Full Service',
                'deskripsi'    => 'Paket lengkap meliputi haircut, beard trim, hair wash, creambath, dan styling. Pengalaman grooming paling premium.',
                'harga'        => 200000,
                'durasi_menit' => 120,
                'status'       => 'aktif',
            ],
        ];

        foreach ($layanans as $layanan) {
            Layanan::create($layanan);
        }
    }
}
