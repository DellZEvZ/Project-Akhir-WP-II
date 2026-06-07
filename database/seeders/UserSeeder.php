<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get role IDs
        $superAdminRole = DB::table('roles')->where('name', 'super-admin')->first();
        $adminRole = DB::table('roles')->where('name', 'admin')->first();
        $staffKepegawaianRole = DB::table('roles')->where('name', 'staff-kepegawaian')->first();
        $staffInventarisRole = DB::table('roles')->where('name', 'staff-inventaris')->first();
        $viewerRole = DB::table('roles')->where('name', 'viewer')->first();

        // Create users
        $users = [
            [
                'nama' => 'Super Administrator',
                'email' => 'superadmin@gmail.com',
                'status' => 1,
                'hp' => '081234567890',
                'password' => Hash::make('P@55word'),
                'role_id' => $superAdminRole->id ?? null,
            ],
            [
                'nama' => 'Administrator',
                'email' => 'admin@gmail.com',
                'status' => 1,
                'hp' => '081234567891',
                'password' => Hash::make('P@55word'),
                'role_id' => $adminRole->id ?? null,
            ],
            [
                'nama' => 'Staff Kepegawaian',
                'email' => 'staff-kepegawaian@gmail.com',
                'status' => 1,
                'hp' => '081234567892',
                'password' => Hash::make('P@55word'),
                'role_id' => $staffKepegawaianRole->id ?? null,
            ],
            [
                'nama' => 'Staff Inventaris',
                'email' => 'staff-inventaris@gmail.com',
                'status' => 1,
                'hp' => '081234567893',
                'password' => Hash::make('P@55word'),
                'role_id' => $staffInventarisRole->id ?? null,
            ],
            [
                'nama' => 'User Viewer',
                'email' => 'viewer@gmail.com',
                'status' => 1,
                'hp' => '081234567894',
                'password' => Hash::make('P@55word'),
                'role_id' => $viewerRole->id ?? null,
            ],
            [
                'nama' => 'Sopian Aji',
                'email' => 'sopian4ji@gmail.com',
                'status' => 1,
                'hp' => '081234567895',
                'password' => Hash::make('P@55word'),
                'role_id' => $viewerRole->id ?? null,
            ],
        ];

        foreach ($users as $userData) {
            $roleId = $userData['role_id'];
            unset($userData['role_id']);
            
            // Check if 'role' column exists in users table
            $columns = DB::getSchemaBuilder()->getColumnListing('users');
            
            // If 'role' column exists and is required, set a default value
            if (in_array('role', $columns)) {
                // Set default role value (adjust based on your schema)
                // Assuming: 1 = admin, 2 = staff, 3 = user
                $userData['role'] = 1; // Default to basic role
            }
            
            $user = User::create($userData);
            
            // Assign role to user using pivot table if role exists
            if ($roleId) {
                // Check if user_roles table exists
                $tables = DB::select("SHOW TABLES LIKE 'user_roles'");
                
                if (!empty($tables)) {
                    DB::table('user_roles')->insert([
                        'user_id' => $user->id,
                        'role_id' => $roleId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
            
            $this->command->info("✓ Created user: {$userData['email']}");
        }

        $this->command->info('');
        $this->command->info('Users created successfully!');
        $this->command->info('');
        $this->command->info('Login Credentials:');
        $this->command->info('Super Admin - Email: superadmin@gmail.com | Password: P@55word');
        $this->command->info('Admin       - Email: admin@gmail.com | Password: P@55word');
        $this->command->info('Staff Kep.  - Email: staff-kepegawaian@gmail.com | Password: P@55word');
        $this->command->info('Staff Inv.  - Email: staff-inventaris@gmail.com | Password: P@55word');
        $this->command->info('Viewer      - Email: viewer@gmail.com | Password: P@55word');
    }
}