<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

Use Illuminate\Support\Facades\DB;
Use Illuminate\Support\Facades\Hash;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        
    DB::table('users')->insert([
       'name' => 'ray',
       'email' => 'ray_radian@yahoo.co.id',
       'password' => Hash::make('1221')
    ]);

    }
}
