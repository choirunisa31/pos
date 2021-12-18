<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin123@gmail.com',
            'password' => Hash::make('12345678'),
            'level' => 'Admin',
            'address' => 'Jatihandap',
            'phone' => '082893940393',
            'image' => '/images/users/1.jpg',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('users')->insert([
            'id' => 2,
            'name' => 'Kasir',
            'username' => 'kasir',
            'email' => 'kasir123@gmail.com',
            'password' => Hash::make('kasir123'),
            'level' => 'Kasir', 
            'address' => 'Cikutra',
            'phone' => '085678393827',
            'image' => '/images/users/blus_hitam.jpg',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}