<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSummarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('=== PERMISSION SYSTEM SUMMARY ===');
        
        // Display all permissions by level
        $this->command->info("\n📋 ALL PERMISSIONS BY LEVEL:");
        
        for ($level = 0; $level <= 3; $level++) {
            $permissions = Permission::where('level', $level)->get();
            if ($permissions->count() > 0) {
                $levelName = match($level) {
                    0 => 'System (All Users)',
                    1 => 'Admin',
                    2 => 'Advisor',
                    3 => 'Trainee',
                    default => 'Unknown'
                };
                
                $this->command->info("\n🔹 Level {$level} - {$levelName} ({$permissions->count()} permissions):");
                foreach ($permissions as $permission) {
                    $this->command->info("   • {$permission->name}");
                }
            }
        }
        
        // Display roles and their permissions
        $this->command->info("\n👥 ROLES AND THEIR PERMISSIONS:");
        
        $roles = Role::with('permissions')->get();
        foreach ($roles as $role) {
            $this->command->info("\n🔸 Role: {$role->name}");
            $this->command->info("   Permissions ({$role->permissions->count()}):");
            
            $permissionsByLevel = $role->permissions->groupBy('level');
            foreach ($permissionsByLevel as $level => $permissions) {
                $levelName = match($level) {
                    0 => 'System',
                    1 => 'Admin',
                    2 => 'Advisor',
                    3 => 'Trainee',
                    default => 'Unknown'
                };
                
                $this->command->info("     Level {$level} ({$levelName}):");
                foreach ($permissions as $permission) {
                    $this->command->info("       • {$permission->name}");
                }
            }
        }
        
        // Display permission statistics
        $this->command->info("\n📊 PERMISSION STATISTICS:");
        $this->command->info("Total Permissions: " . Permission::count());
        $this->command->info("Total Roles: " . Role::count());
        
        // Check for any orphaned permissions
        $orphanedPermissions = Permission::whereDoesntHave('roles')->get();
        if ($orphanedPermissions->count() > 0) {
            $this->command->warn("\n⚠️  ORPHANED PERMISSIONS (not assigned to any role):");
            foreach ($orphanedPermissions as $permission) {
                $this->command->warn("   • {$permission->name} (Level {$permission->level})");
            }
        } else {
            $this->command->info("\n✅ All permissions are properly assigned to roles!");
        }
        
        $this->command->info("\n=== END OF PERMISSION SUMMARY ===");
    }
}
