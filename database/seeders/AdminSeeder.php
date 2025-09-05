<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = User::create([
            'name' => 'SuperAdmin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
            'level'=> '1'
        ]);
        $role = Role::create(['name' => 'SuperAdmin', 'level' => 1]);

        $permissions = Permission::where(['level' => 1])->pluck('id', 'id')->all();

        $role->syncPermissions($permissions);

        $superAdmin->assignRole([$role->id]);
    }
}
