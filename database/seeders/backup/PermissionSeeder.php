<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // User Management
            [
                'name' => 'user.view',
                'display_name' => 'View Users',
                'description' => 'View user list',
                'module' => 'user_management'
            ],
            [
                'name' => 'user.create',
                'display_name' => 'Create User',
                'description' => 'Add new user',
                'module' => 'user_management'
            ],
            [
                'name' => 'user.update',
                'display_name' => 'Update User',
                'description' => 'Edit user data',
                'module' => 'user_management'
            ],
            [
                'name' => 'user.delete',
                'display_name' => 'Delete User',
                'description' => 'Remove user',
                'module' => 'user_management'
            ],

            // Pegawai Management
            [
                'name' => 'pegawai.view',
                'display_name' => 'View Pegawai',
                'description' => 'View employee data',
                'module' => 'kepegawaian'
            ],
            [
                'name' => 'pegawai.create',
                'display_name' => 'Create Pegawai',
                'description' => 'Add new employee',
                'module' => 'kepegawaian'
            ],
            [
                'name' => 'pegawai.update',
                'display_name' => 'Update Pegawai',
                'description' => 'Edit employee data',
                'module' => 'kepegawaian'
            ],
            [
                'name' => 'pegawai.delete',
                'display_name' => 'Delete Pegawai',
                'description' => 'Remove employee',
                'module' => 'kepegawaian'
            ],

            // Aset Management
            [
                'name' => 'aset.view',
                'display_name' => 'View Aset',
                'description' => 'View asset data',
                'module' => 'inventaris'
            ],
            [
                'name' => 'aset.create',
                'display_name' => 'Create Aset',
                'description' => 'Add new asset',
                'module' => 'inventaris'
            ],
            [
                'name' => 'aset.update',
                'display_name' => 'Update Aset',
                'description' => 'Edit asset data',
                'module' => 'inventaris'
            ],
            [
                'name' => 'aset.delete',
                'display_name' => 'Delete Aset',
                'description' => 'Remove asset',
                'module' => 'inventaris'
            ],

            // Kategori Management
            [
                'name' => 'kategori.view',
                'display_name' => 'View Kategori',
                'description' => 'View categories',
                'module' => 'kategori'
            ],
            [
                'name' => 'kategori.create',
                'display_name' => 'Create Kategori',
                'description' => 'Add new category',
                'module' => 'kategori'
            ],
            [
                'name' => 'kategori.update',
                'display_name' => 'Update Kategori',
                'description' => 'Edit category',
                'module' => 'kategori'
            ],
            [
                'name' => 'kategori.delete',
                'display_name' => 'Delete Kategori',
                'description' => 'Remove category',
                'module' => 'kategori'
            ],

            // Produk Management
            [
                'name' => 'produk.view',
                'display_name' => 'View Produk',
                'description' => 'View products',
                'module' => 'produk'
            ],
            [
                'name' => 'produk.create',
                'display_name' => 'Create Produk',
                'description' => 'Add new product',
                'module' => 'produk'
            ],
            [
                'name' => 'produk.update',
                'display_name' => 'Update Produk',
                'description' => 'Edit product',
                'module' => 'produk'
            ],
            [
                'name' => 'produk.delete',
                'display_name' => 'Delete Produk',
                'description' => 'Remove product',
                'module' => 'produk'
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission['name']],
                $permission
            );
        }

        $this->command->info('Permissions created successfully!');
    }
}
