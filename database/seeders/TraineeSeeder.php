<?php

namespace Database\Seeders;

use App\Models\Advisor;
use App\Models\Notification;
use App\Models\Trainee;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class TraineeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Trainee::create([

            'id' => 1,
            'image' => null,
            'first_name' => 'Tasneem',
            'last_name' => 'Ayesh',
            'email' => 'abeermosameh@gmail.com',
            'phone' => 'Abeer',
            'education' => 'Bachelor Degree',
            'gpa' => 3.9,
            'address' => 'test',
            'city' => 'Gaza',
            'language' => 'Arabic',
            'payment' => 1 ,
            'cv' => null,
            'certification' => null,
            'otherFile' => null,
            'is_approved' => 0,
            'password' => bcrypt('123456'),
            'deleted_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        $user = User::create([
            'name' => 'Abeer Abu Mosameh',
            'email' => 'abeermosameh@gmail.com',
            'unique_id' => 'Trainee123',
            'password' => Hash::make('123456'),
            'level'=> '3'
        ]);

        $notification = Notification::create([
            'message' =>'Tasneem is a new Trainee registration',
            'status' => 'unread',
            'level' => 1,

        ]);

        $role = Role::create(['name' => 'trainee', 'level' => 3]);

        $permissions = Permission::where(['level' => 3])->pluck('id', 'id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);

    }
}
