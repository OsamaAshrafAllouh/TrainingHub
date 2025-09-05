<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdvisorPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            //Home & Dashboard
            ['name' => 'advisor-home'],
            ['name' => 'advisor-dashboard'],
            ['name' => 'a-home'],

            //Trainees
            ['name' => 'advisor-trainee-list'],
            ['name' => 'advisor-trainee-edit'],
            ['name' => 'advisor-trainee-delete'],
            ['name' => 'advisor-trainee-show'],
            ['name' => 'advisor-trainee-create'],
            ['name' => 'advisor-trainee-export'],

            //Programs
            ['name' => 'advisor-program-list'],
            ['name' => 'advisor-program-show'],
            ['name' => 'advisor-program-create'],
            ['name' => 'advisor-program-edit'],
            ['name' => 'advisor-program-delete'],
            ['name' => 'advisor-program-trainees'],
            ['name' => 'advisor-program-trainees-list'],
            ['name' => 'advisor-program-export'],

            //Tasks
            ['name' => 'advisor-task-list'],
            ['name' => 'advisor-task-create'],
            ['name' => 'advisor-task-edit'],
            ['name' => 'advisor-task-delete'],
            ['name' => 'advisor-task-mark'],
            ['name' => 'advisor-task-show'],
            ['name' => 'advisor-task-solution'],
            ['name' => 'advisor-task-export'],

            //Training Tasks
            ['name' => 'advisor-training-task-list'],
            ['name' => 'advisor-training-task-show'],
            ['name' => 'advisor-training-task-mark'],
            ['name' => 'advisor-training-task-export'],

            //Meetings
            ['name' => 'advisor-meeting-accept'],
            ['name' => 'advisor-meeting-list'],
            ['name' => 'advisor-meeting-create'],
            ['name' => 'advisor-meeting-show'],
            ['name' => 'advisor-meeting-edit'],
            ['name' => 'advisor-meeting-delete'],
            ['name' => 'advisor-meeting-export'],

            //Attendance
            ['name' => 'advisor-attendance-list'],
            ['name' => 'advisor-attendance-show'],
            ['name' => 'advisor-attendance-export'],

            //File Management
            ['name' => 'advisor-file-upload'],
            ['name' => 'advisor-file-download'],
            ['name' => 'advisor-file-delete'],

            //Notifications
            ['name' => 'advisor-notification-list'],
            ['name' => 'advisor-notification-show'],
            ['name' => 'advisor-notification-mark-read'],

            //Profile Management
            ['name' => 'advisor-profile-edit'],
            ['name' => 'advisor-profile-show'],
            ['name' => 'advisor-profile-list'],
            ['name' => 'advisor-profile-export'],

            //Password Management
            ['name' => 'advisor-password-list'],
            ['name' => 'advisor-password-edit'],
            ['name' => 'advisor-password-show'],

            //Reports
            ['name' => 'advisor-report-trainees'],
            ['name' => 'advisor-report-tasks'],
            ['name' => 'advisor-report-attendance'],
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission['name'], 'level' => 2]);
        }
    }
}
