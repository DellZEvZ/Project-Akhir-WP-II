<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Pegawai;
use Illuminate\Support\Str;

class UserPegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Create pegawai data for users who don't have one yet
     */
    public function run(): void
    {
        $this->command->info('Creating pegawai data for users without pegawai...');

        // Get all users who don't have pegawai data
        $usersWithoutPegawai = User::whereDoesntHave('pegawai')->get();

        if ($usersWithoutPegawai->isEmpty()) {
            $this->command->info('All users already have pegawai data!');
            return;
        }

        $created = 0;
        foreach ($usersWithoutPegawai as $user) {
            // Skip if user email contains 'admin' or 'super' (admin accounts might not need pegawai data)
            // But we'll create for all to be safe

            $pegawai = Pegawai::create([
                'user_id' => $user->id,
                'nama' => $user->nama ?? 'Pegawai ' . $user->email,
                'email' => $user->email,
                'no_hp' => $user->hp ?? '-',
                'alamat' => 'Belum diisi',
                'tanggal_lahir' => now()->subYears(25), // Default age 25
                'jenis_kelamin' => 'laki-laki', // Default male
                'tanggal_masuk' => now(),
                'status_pegawai' => 'aktif', // Active status
                'departemen' => 'General', // Default department
                'jabatan' => 'Staff', // Default position
                'gaji_pokok' => 5000000, // Default salary
            ]);

            $created++;
            $this->command->info("✓ Created pegawai for: {$user->nama} ({$user->email})");
        }

        $this->command->info('');
        $this->command->info("Successfully created {$created} pegawai records!");
        $this->command->info('Note: Please update pegawai data (NIK, personal info, etc.) through Data Pegawai menu.');
    }
}
