<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan roles sudah ada
        $roles = [
            'super_admin' => 'Super Administrator',
            'admin' => 'Administrator',
            'supervisor' => 'Supervisor',
            'pegawai' => 'Pegawai',
            'inventory_manager' => 'Inventory Manager',
        ];

        foreach ($roles as $name => $displayName) {
            Role::firstOrCreate(
                ['name' => $name],
                [
                    'display_name' => $displayName,
                    'description' => "Testing account for $displayName role",
                    'is_active' => true
                ]
            );
        }

        // Buat user testing untuk setiap role
        $testUsers = [
            [
                'nama' => 'Super Admin Test',
                'email' => 'superadmin@test.com',
                'password' => Hash::make('password'),
                'role' => 1, // Fallback role lama
                'status' => 1,
                'hp' => '081234567890',
                'role_name' => 'super_admin'
            ],
            [
                'nama' => 'Admin Test',
                'email' => 'admin@test.com',
                'password' => Hash::make('password'),
                'role' => 1,
                'status' => 1,
                'hp' => '081234567891',
                'role_name' => 'admin'
            ],
            [
                'nama' => 'Supervisor Test',
                'email' => 'supervisor@test.com',
                'password' => Hash::make('password'),
                'role' => 2,
                'status' => 1,
                'hp' => '081234567892',
                'role_name' => 'supervisor'
            ],
            [
                'nama' => 'Pegawai Test',
                'email' => 'pegawai@test.com',
                'password' => Hash::make('password'),
                'role' => 3, // Ubah dari 0 ke 3 untuk pegawai
                'status' => 1,
                'hp' => '081234567893',
                'role_name' => 'pegawai'
            ],
            [
                'nama' => 'Inventory Manager Test',
                'email' => 'inventory@test.com',
                'password' => Hash::make('password'),
                'role' => 2,
                'status' => 1,
                'hp' => '081234567894',
                'role_name' => 'inventory_manager'
            ],
        ];

        foreach ($testUsers as $userData) {
            $roleName = $userData['role_name'];
            unset($userData['role_name']);

            // Buat atau update user
            $user = User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );

            // Assign role
            $role = Role::where('name', $roleName)->first();
            if ($role) {
                // Hapus role lama jika ada, lalu assign role baru
                $user->roles()->sync([$role->id]);
            }

            $this->command->info("Created/Updated user: {$userData['email']} with role: {$roleName}");
        }

        $this->command->info('Test users created successfully!');
        $this->command->info('Login credentials:');
        $this->command->info('Email: superadmin@test.com | Password: password');
        $this->command->info('Email: admin@test.com | Password: password');
        $this->command->info('Email: supervisor@test.com | Password: password');
        $this->command->info('Email: pegawai@test.com | Password: password');
        $this->command->info('Email: inventory@test.com | Password: password');
    }
}
