<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $role = array(
            'name'=>'Administrator',
            'slug'=>'admin',
        );
        $user = array(
            'name'=>'System Admin',
            'username'=>'admin',
            'password'=>Hash::make('123456'),
            'role_id'=>1,
            'secret'=>'123456',
            'phone'=>'12345678901',
            'address'=>'Bhuyanpur',
            'nid'=>'789456123',
            'created_by'=>0
        );
        \App\Models\Role::create($role);

        \App\Models\User::create($user);
    }
}
