<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('Starting database seeding...');
        $this->command->info('');

        // Jalankan semua seeder dalam urutan yang benar
        $this->call([
            // 1. Seed roles dan permissions DULU
            RolesTableSeeder::class,
            PermissionsTableSeeder::class,
            RolePermissionsTableSeeder::class,
            
            // 2. Seed users (setelah roles ada)
            UserSeeder::class,
            
            // 3. Data Master lainnya
            PegawaiSeeder::class,
            AsetSeeder::class,

            // 4. Data Barbershop
            BarberSeeder::class,
            LayananSeeder::class,
            
            // 5. Verify seeding
            VerifyPermissionsSeeder::class,
        ]);

        $this->command->info('');
        $this->command->info('=== Database Seeding Completed! ===');
        $this->command->info('All seeders have been executed successfully.');
        $this->command->info('');
        $this->command->info('Default Login Credentials:');
        $this->command->info('Email: superadmin@gmail.com');
        $this->command->info('Password: P@55word');
    }
}