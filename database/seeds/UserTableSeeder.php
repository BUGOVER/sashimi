<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('users')->delete();
        User::create(array(
            'name'     => 'Admin',
            'username' => 'Admin',
            'email'    => '1.aaaaaa@mail.ru',
            'password' => Hash::make('wx223312'),
        ));
    }

}