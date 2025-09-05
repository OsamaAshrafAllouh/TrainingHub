<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class TraineePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            //Home & Dashboard
            ['name' => 'trainee-home'],
            ['name' => 'trainee-dashboard'],
            ['name' => 'trainee-training-program-accepted'],
            ['name' => 'trainee-training-program-join'],
            ['name' => 'trainee-training-program-all'],
            ['name' => 'trainee-training-program-show'],

            //Programs
            ['name' => 'trainee-program-list'],
            ['name' => 'trainee-program-show'],
            ['name' => 'trainee-program-join'],
            ['name' => 'trainee-program-leave'],

            //Tasks
            ['name' => 'trainee-task-list'],
            ['name' => 'trainee-task-create'],
            ['name' => 'trainee-task-edit'],
            ['name' => 'trainee-task-delete'],
            ['name' => 'trainee-task-show'],
            ['name' => 'trainee-task-submit'],

            //Training Tasks
            ['name' => 'trainee-training-task-list'],
            ['name' => 'trainee-training-task-show'],
            ['name' => 'trainee-training-task-submit'],
            ['name' => 'trainee-training-task-edit'],

            //Meetings
            ['name' => 'trainee-meeting-list'],
            ['name' => 'trainee-meeting-create'],
            ['name' => 'trainee-meeting-edit'],
            ['name' => 'trainee-meeting-delete'],
            ['name' => 'trainee-meeting-show'],
            ['name' => 'trainee-meeting-request'],

            //Attendance
            ['name' => 'trainee-attendance-list'],
            ['name' => 'trainee-attendance-create'],
            ['name' => 'trainee-attendance-show'],
            ['name' => 'trainee-attendance-edit'],
            ['name' => 'trainee-attendance-delete'],
            ['name' => 'trainee-attendance-export'],

            //Payments
            ['name' => 'trainee-pay-list'],
            ['name' => 'trainee-pay-create'],
            ['name' => 'trainee-pay-show'],
            ['name' => 'trainee-pay-edit'],
            ['name' => 'trainee-pay-delete'],
            ['name' => 'trainee-pay-export'],

            //File Management
            ['name' => 'trainee-file-upload'],
            ['name' => 'trainee-file-download'],
            ['name' => 'trainee-file-delete'],
            ['name' => 'trainee-file-list'],

            //Notifications
            ['name' => 'trainee-notification-list'],
            ['name' => 'trainee-notification-show'],
            ['name' => 'trainee-notification-mark-read'],

            //Profile Management
            ['name' => 'trainee-profile-edit'],
            ['name' => 'trainee-profile-show'],
            ['name' => 'trainee-profile-list'],
            ['name' => 'trainee-profile-export'],

            //Password Management
            ['name' => 'trainee-password-list'],
            ['name' => 'trainee-password-edit'],
            ['name' => 'trainee-password-show'],

            //Reports
            ['name' => 'trainee-report-progress'],
            ['name' => 'trainee-report-attendance'],
            ['name' => 'trainee-report-payments'],
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission['name'], 'level' => 3]);
        }
    }
}
