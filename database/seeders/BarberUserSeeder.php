<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Pegawai;
use Carbon\Carbon;

class BarberUserSeeder extends Seeder
{
    /**
     * Membuat akun User + data Pegawai untuk role "barber".
     * Akun ini hanya bisa mengakses halaman absensi sendiri
     * (lihat App\Http\Middleware\RedirectBarberToAttendance).
     */
    public function run(): void
    {
        $barberRole = DB::table('roles')->where('name', 'barber')->first();

        if (!$barberRole) {
            $this->command->error('✗ Role "barber" tidak ditemukan. Jalankan RolesTableSeeder terlebih dahulu.');
            return;
        }

        $barberUsers = [
            [
                'nama'  => 'Rizky Maulana',
                'email' => 'barber1@gmail.com',
                'no_hp' => '081234560001',
                'spesialisasi' => 'Fade & Tapper',
            ],
            [
                'nama'  => 'Doni Saputra',
                'email' => 'barber2@gmail.com',
                'no_hp' => '081234560002',
                'spesialisasi' => 'Classic Haircut',
            ],
        ];

        foreach ($barberUsers as $b) {
            // Buat User (kalau belum ada)
            $user = User::firstOrCreate(
                ['email' => $b['email']],
                [
                    'nama'     => $b['nama'],
                    'status'   => 1,
                    'hp'       => $b['no_hp'],
                    'password' => Hash::make('P@55word'),
                ]
            );

            // Assign role barber (idempotent)
            $user->assignRole('barber');

            // Buat data Pegawai terkait (kalau belum ada)
            Pegawai::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'nama'            => $b['nama'],
                    'email'           => $b['email'],
                    'no_hp'           => $b['no_hp'],
                    'alamat'          => 'Belum diisi',
                    'jabatan'         => 'Barber',
                    'departemen'      => 'Operasional',
                    'status_pegawai'  => 'aktif',
                    'tanggal_masuk'   => Carbon::now()->subMonths(6),
                    'tanggal_lahir'   => Carbon::now()->subYears(25),
                    'jenis_kelamin'   => 'laki-laki',
                    'gaji_pokok'      => 4000000,
                ]
            );

            $this->command->info("✓ Barber user created: {$b['email']} (password: P@55word)");
        }

        $this->command->info('');
        $this->command->info('Barber Login Credentials:');
        $this->command->info('  barber1@gmail.com / P@55word (Rizky Maulana)');
        $this->command->info('  barber2@gmail.com / P@55word (Doni Saputra)');
        $this->command->info('Akun ini hanya bisa mengakses halaman Absensi setelah login ke backend.');
    }
}
