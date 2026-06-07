<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'app_name',
                'value' => 'CAREXIS',
                'type' => 'string',
                'description' => 'Nama sistem informasi manajemen terintegrasi'
            ],
            [
                'key' => 'app_version',
                'value' => '1.0.0',
                'type' => 'string',
                'description' => 'Versi aplikasi saat ini'
            ],
            [
                'key' => 'app_timezone',
                'value' => 'Asia/Jakarta',
                'type' => 'string',
                'description' => 'Zona waktu untuk sistem'
            ],
            [
                'key' => 'pagination_per_page',
                'value' => '15',
                'type' => 'integer',
                'description' => 'Jumlah baris data yang ditampilkan per halaman'
            ],
            [
                'key' => 'maintenance_mode',
                'value' => '0',
                'type' => 'boolean',
                'description' => 'Mode maintenance untuk membatasi akses sistem'
            ],
            [
                'key' => 'maintenance_message',
                'value' => 'Sistem sedang dalam perbaikan. Mohon maaf atas ketidaknyamanannya.',
                'type' => 'string',
                'description' => 'Pesan yang ditampilkan saat mode maintenance aktif'
            ],
            [
                'key' => 'session_lifetime',
                'value' => '120',
                'type' => 'integer',
                'description' => 'Durasi sesi pengguna (dalam menit)'
            ],
            [
                'key' => 'date_format',
                'value' => 'd-m-Y',
                'type' => 'string',
                'description' => 'Format tanggal yang digunakan di seluruh sistem'
            ],
            [
                'key' => 'time_format',
                'value' => 'H:i:s',
                'type' => 'string',
                'description' => 'Format waktu yang digunakan di seluruh sistem'
            ],
            [
                'key' => 'enable_registration',
                'value' => '0',
                'type' => 'boolean',
                'description' => 'Izinkan pendaftaran user baru'
            ],
            [
                'key' => 'backup_auto_delete_days',
                'value' => '30',
                'type' => 'integer',
                'description' => 'Hapus backup otomatis setelah (hari)'
            ],
        ];

        foreach ($settings as $setting) {
            \App\Models\Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
