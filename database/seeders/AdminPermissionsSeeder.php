<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class AdminPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            //Home & Dashboard
            ['name' => 'admin-home'],
            ['name' => 'admin-dashboard'],
            ['name' => 'admin-reports'],

            //Roles & Permissions
            ['name' => 'role-list'],
            ['name' => 'role-create'],
            ['name' => 'role-edit'],
            ['name' => 'role-delete'],
            ['name' => 'permission-list'],
            ['name' => 'permission-assign'],

            //Trainees
            ['name' => 'admin-trainee-list'],
            ['name' => 'admin-trainee-create'],
            ['name' => 'admin-trainee-accept'],
            ['name' => 'admin-trainee-edit'],
            ['name' => 'admin-trainee-delete'],
            ['name' => 'admin-trainee-show'],
            ['name' => 'admin-trainee-export'],

            //Advisor
            ['name' => 'admin-advisor-list'],
            ['name' => 'admin-advisor-create'],
            ['name' => 'admin-advisor-edit'],
            ['name' => 'admin-advisor-delete'],
            ['name' => 'admin-advisor-accept'],
            ['name' => 'admin-advisor-show'],
            ['name' => 'admin-advisor-export'],

            //Field
            ['name' => 'admin-field-list'],
            ['name' => 'admin-field-create'],
            ['name' => 'admin-field-edit'],
            ['name' => 'admin-field-delete'],
            ['name' => 'admin-field-assign'],

            //Programs
            ['name' => 'admin-program-list'],
            ['name' => 'admin-program-create'],
            ['name' => 'admin-program-edit'],
            ['name' => 'admin-program-delete'],
            ['name' => 'admin-program-accept'],
            ['name' => 'admin-program-show'],
            ['name' => 'admin-program-alltask'],
            ['name' => 'admin-program-alltrainee'],
            ['name' => 'admin-program-export'],

            //Tasks
            ['name' => 'admin-task-list'],
            ['name' => 'admin-task-create'],
            ['name' => 'admin-task-edit'],
            ['name' => 'admin-task-delete'],
            ['name' => 'admin-task-show'],
            ['name' => 'admin-task-export'],

            //Training Tasks
            ['name' => 'admin-training-task-list'],
            ['name' => 'admin-training-task-show'],
            ['name' => 'admin-training-task-export'],

            //Meetings
            ['name' => 'admin-meeting-list'],
            ['name' => 'admin-meeting-show'],
            ['name' => 'admin-meeting-export'],

            //Attendance
            ['name' => 'admin-attendance-list'],
            ['name' => 'admin-attendance-show'],
            ['name' => 'admin-attendance-export'],

            //Payment
            ['name' => 'admin-payment-list'],
            ['name' => 'admin-payment-create'],
            ['name' => 'admin-payment-edit'],
            ['name' => 'admin-payment-delete'],
            ['name' => 'admin-payment-show'],
            ['name' => 'admin-payment-export'],

            //TraineeRequest
            ['name' => 'admin-trainee-requests-list'],
            ['name' => 'admin-trainee-requests-changeStatus'],
            ['name' => 'admin-trainee-requests-show'],

            //BillingIssues
            ['name' => 'admin-BillingIssues-List'],
            ['name' => 'admin-BillingIssues-change'],
            ['name' => 'admin-BillingIssues-show'],

            //Notifications
            ['name' => 'admin-notification-list'],
            ['name' => 'admin-notification-create'],
            ['name' => 'admin-notification-edit'],
            ['name' => 'admin-notification-delete'],
            ['name' => 'admin-notification-show'],

            //System Management
            ['name' => 'admin-password-list'],
            ['name' => 'admin-password-edit'],
            ['name' => 'admin-logfile-download'],
            ['name' => 'admin-system-settings'],
            ['name' => 'admin-backup'],
            ['name' => 'admin-maintenance'],

            //Reports & Analytics
            ['name' => 'admin-report-users'],
            ['name' => 'admin-report-programs'],
            ['name' => 'admin-report-tasks'],
            ['name' => 'admin-report-payments'],
            ['name' => 'admin-report-attendance'],
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission['name'], 'level' => 1]);
        }
    }
}
