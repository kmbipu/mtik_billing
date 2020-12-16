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
            'name'=>'Administrator',
            'username'=>'admin',
            'password'=>Hash::make('password'),
            'role_id'=>1,
            'secret'=>'password',
            'phone'=>'12345678901',
            'address'=>'Bhuyanpur',
            'nid'=>'789456123'
        );
        \App\Models\Role::create($role);

        \App\Models\User::create($user);
    }
}
