<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
         $data = [
            [
                'username' => 'username1',
                'role' => 1,
                'password' => bcrypt('12345'),
            ],
            [
                'username' => 'username2',
                'role' => 1,
                'password' => bcrypt('12345'),
            ],
            [
                'username' => 'admin',
                'role' => 2,
                'password' => bcrypt('admin!@#123'),
            ],
        ];
        \DB::table('users')->insert($data);
    }
}