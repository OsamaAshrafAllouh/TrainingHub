<?php

namespace Database\Seeders;

use App\Models\Advisor;
use App\Models\AdvisorField;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdvisorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Advisor::create([

                'id' => 1,
                'image' => null,
                'first_name' => 'Abeer',
                'last_name' => 'Abu Mosameh',
                'email' => 'abeermosameh1@gmail.com',
                'phone' => 'Abeer',
                'education' => 'Bachelor Degree',
                'address' => 'test',
                'city' => 'Gaza',
                'language' => 'Arabic',
                'cv' => null,
                'certification' => null,
                'otherFile' => null,
                'is_approved' => 0,
                'password' => bcrypt('123456'),
                'deleted_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);


            $advisor = User::create([
                'name' => 'Abeer Abu Mosameh',
                'email' => 'abeermosameh1@gmail.com',
                'unique_id' => 'Advisor123456',
                'password' => Hash::make('123456'),
                'level'=> '2'
            ]);

        AdvisorField::create([
            'advisor_id' => 1,
            'field_id' => 1,
        ]);

        $notification = Notification::create([
            'message' =>'Abeer is a new Advisor registration',
            'status' => 'unread',
            'level' => 1,

        ]);

        $role = Role::create(['name' => 'advisor', 'level' => 2]);

        $permissions = Permission::where(['level' => 2])->pluck('id', 'id')->all();

        $role->syncPermissions($permissions);

        $advisor->assignRole([$role->id]);

    }
}
