<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VerifyPermissionsSeeder extends Seeder
{
    /**
     * Verify permission assignments
     */
    public function run(): void
    {
        $this->command->info('');
        $this->command->info('=== VERIFYING PERMISSIONS SYSTEM ===');
        $this->command->info('');

        // 1. Check Roles
        $this->command->info('1. ROLES:');
        $roles = DB::table('roles')->get();
        $this->command->info("   Total: {$roles->count()} roles");
        foreach ($roles as $role) {
            $this->command->info("   ✓ [{$role->id}] {$role->name} - {$role->display_name}");
        }
        $this->command->info('');

        // 2. Check Permissions
        $this->command->info('2. PERMISSIONS:');
        $permissions = DB::table('permissions')->get();
        $this->command->info("   Total: {$permissions->count()} permissions");
        
        $permissionsByModule = $permissions->groupBy('module');
        foreach ($permissionsByModule as $module => $perms) {
            $this->command->info("   📁 {$module}: {$perms->count()} permissions");
        }
        $this->command->info('');

        // 3. Check Role Permissions
        $this->command->info('3. ROLE PERMISSIONS ASSIGNMENTS:');
        $totalRolePermissions = DB::table('role_permissions')->count();
        $this->command->info("   Total assignments: {$totalRolePermissions}");
        $this->command->info('');
        
        foreach ($roles as $role) {
            $count = DB::table('role_permissions')
                ->where('role_id', $role->id)
                ->count();
            
            $status = $count > 0 ? '✓' : '❌';
            $this->command->info("   {$status} {$role->display_name}: {$count} permissions");
            
            // Show first 5 permissions as sample
            if ($count > 0) {
                $samplePerms = DB::table('role_permissions as rp')
                    ->join('permissions as p', 'rp.permission_id', '=', 'p.id')
                    ->where('rp.role_id', $role->id)
                    ->limit(5)
                    ->pluck('p.name');
                
                foreach ($samplePerms as $perm) {
                    $this->command->info("      - {$perm}");
                }
                
                if ($count > 5) {
                    $this->command->info("      ... and " . ($count - 5) . " more");
                }
            }
            $this->command->info('');
        }

        // 4. Check User Roles
        $this->command->info('4. USER ROLE ASSIGNMENTS:');
        $users = DB::table('users')->get();
        
        foreach ($users as $user) {
            $userRole = DB::table('user_roles as ur')
                ->join('roles as r', 'ur.role_id', '=', 'r.id')
                ->where('ur.user_id', $user->id)
                ->first();
            
            if ($userRole) {
                $permCount = DB::table('role_permissions')
                    ->where('role_id', $userRole->id)
                    ->count();
                
                $this->command->info("   ✓ {$user->email}");
                $this->command->info("      Role: {$userRole->display_name}");
                $this->command->info("      Permissions: {$permCount}");
            } else {
                $this->command->error("   ❌ {$user->email} - NO ROLE ASSIGNED!");
            }
        }
        $this->command->info('');

        // 5. Summary
        $this->command->info('=== SUMMARY ===');
        
        if ($totalRolePermissions == 0) {
            $this->command->error('❌ NO PERMISSIONS ASSIGNED TO ANY ROLE!');
            $this->command->error('   Please run: php artisan db:seed --class=RolePermissionsTableSeeder');
        } else {
            $expectedMin = 84; // Rough estimate
            if ($totalRolePermissions >= $expectedMin) {
                $this->command->info("✓ Permissions system looks good! ({$totalRolePermissions} assignments)");
            } else {
                $this->command->warn("⚠ Only {$totalRolePermissions} permissions assigned (expected ~{$expectedMin})");
                $this->command->warn('   Some roles might be missing permissions.');
            }
        }
        
        $this->command->info('');
    }
}
