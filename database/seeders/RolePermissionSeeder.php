<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles if they don't exist
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $advisorRole = Role::firstOrCreate(['name' => 'advisor']);
        $traineeRole = Role::firstOrCreate(['name' => 'trainee']);

        // Get all permissions by level
        $adminPermissions = Permission::where('level', 1)->get();
        $advisorPermissions = Permission::where('level', 2)->get();
        $traineePermissions = Permission::where('level', 3)->get();

        // Assign admin permissions
        $adminRole->syncPermissions($adminPermissions);

        // Assign advisor permissions
        $advisorRole->syncPermissions($advisorPermissions);

        // Assign trainee permissions
        $traineeRole->syncPermissions($traineePermissions);

        // Additional cross-role permissions (if needed)
        // For example, advisors might need some trainee permissions for viewing their trainees' data
        $advisorRole->givePermissionTo([
            'trainee-profile-show',
            'trainee-attendance-list',
            'trainee-attendance-show',
            'trainee-task-list',
            'trainee-task-show',
            'trainee-training-task-list',
            'trainee-training-task-show',
        ]);

        // Trainees might need some basic advisor permissions for viewing their own advisor's info
        $traineeRole->givePermissionTo([
            'advisor-profile-show',
        ]);

        $this->command->info('Roles and permissions assigned successfully!');
        $this->command->info('Admin permissions: ' . $adminPermissions->count());
        $this->command->info('Advisor permissions: ' . $advisorPermissions->count());
        $this->command->info('Trainee permissions: ' . $traineePermissions->count());
    }
}
