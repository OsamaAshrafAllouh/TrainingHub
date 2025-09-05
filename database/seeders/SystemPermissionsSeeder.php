<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class SystemPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Authentication & Basic Access
            ['name' => 'login', 'level' => 0], // All authenticated users
            ['name' => 'logout', 'level' => 0],
            ['name' => 'profile-view', 'level' => 0],
            ['name' => 'profile-edit', 'level' => 0],
            ['name' => 'password-change', 'level' => 0],

            // File Management (Basic)
            ['name' => 'file-upload', 'level' => 0],
            ['name' => 'file-download', 'level' => 0],
            ['name' => 'file-view', 'level' => 0],

            // Notifications (Basic)
            ['name' => 'notification-read', 'level' => 0],
            ['name' => 'notification-mark-read', 'level' => 0],

            // Dashboard Access
            ['name' => 'dashboard-access', 'level' => 0],

            // API Access (if applicable)
            ['name' => 'api-access', 'level' => 0],
            ['name' => 'api-read', 'level' => 0],

            // Export/Import (Basic)
            ['name' => 'export-own-data', 'level' => 0],
            ['name' => 'import-own-data', 'level' => 0],

            // Search & Filter
            ['name' => 'search', 'level' => 0],
            ['name' => 'filter', 'level' => 0],

            // Help & Support
            ['name' => 'help-access', 'level' => 0],
            ['name' => 'support-request', 'level' => 0],

            // System Maintenance (Admin only)
            ['name' => 'system-maintenance', 'level' => 1],
            ['name' => 'system-backup', 'level' => 1],
            ['name' => 'system-restore', 'level' => 1],
            ['name' => 'system-logs', 'level' => 1],
            ['name' => 'system-settings', 'level' => 1],

            // Audit & Compliance
            ['name' => 'audit-logs', 'level' => 1],
            ['name' => 'compliance-reports', 'level' => 1],
            ['name' => 'data-privacy', 'level' => 1],

            // User Management (Admin only)
            ['name' => 'user-management', 'level' => 1],
            ['name' => 'role-management', 'level' => 1],
            ['name' => 'permission-management', 'level' => 1],

            // Content Management
            ['name' => 'content-create', 'level' => 2], // Advisor and above
            ['name' => 'content-edit', 'level' => 2],
            ['name' => 'content-publish', 'level' => 2],
            ['name' => 'content-approve', 'level' => 1], // Admin only

            // Communication
            ['name' => 'message-send', 'level' => 0],
            ['name' => 'message-receive', 'level' => 0],
            ['name' => 'message-delete', 'level' => 0],

            // Calendar & Scheduling
            ['name' => 'calendar-view', 'level' => 0],
            ['name' => 'calendar-edit', 'level' => 2],
            ['name' => 'calendar-manage', 'level' => 1],

            // Reports & Analytics
            ['name' => 'reports-view', 'level' => 0],
            ['name' => 'reports-create', 'level' => 2],
            ['name' => 'reports-manage', 'level' => 1],

            // Integration & API
            ['name' => 'integration-view', 'level' => 1],
            ['name' => 'integration-manage', 'level' => 1],
            ['name' => 'webhook-manage', 'level' => 1],

            // Security & Access Control
            ['name' => 'security-settings', 'level' => 1],
            ['name' => 'access-control', 'level' => 1],
            ['name' => 'session-management', 'level' => 1],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission['name']
            ], [
                'level' => $permission['level']
            ]);
        }

        $this->command->info('System permissions created successfully!');
    }
}
