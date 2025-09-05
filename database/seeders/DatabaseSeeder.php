<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Advisor;
use App\Models\Trainee;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // Seed basic data first
            FieldSeeder::class,
            PaymentSeeder::class,
            
            // Create all permissions (role-specific and system-wide)
            AdminPermissionsSeeder::class,
            AdvisorPermissionsSeeder::class,
            TraineePermissionsSeeder::class,
            SystemPermissionsSeeder::class,
            
            // Create roles and assign permissions
            RolePermissionSeeder::class,
            
            // Create users with roles
            AdminSeeder::class,
            AdvisorSeeder::class,
            TraineeSeeder::class,
            
            // Seed additional data
            ProgramSeeder::class,
            TaskSeeder::class,
            TrainingTaskSeeder::class,
            MeetingRequestSeeder::class,
            NotificationSeeder::class,
            TrainingAttendanceSeeder::class,
            TrainingProgramSeeder::class,
            PaymentInformationSeeder::class,
            AdvisorFieldSeeder::class,
            
            // Display permission summary for verification
            PermissionSummarySeeder::class,
        ]);
    }
}
