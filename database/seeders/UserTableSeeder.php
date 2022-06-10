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
                'status' => 0,
                'name' => '',
                'password' => bcrypt('12345'),
            ],
            [
                'username' => 'username2',
                'role' => 1,
                'status' => 0,
                'name' => '',
                'password' => bcrypt('12345'),
            ],
            [
                'username' => 'admin',
                'role' => 2,
                'status' => 1,
                'name' => '',
                'password' => bcrypt('admin!@#123'),
            ],
            [
                'username' => 'PHANYEN',
                'role' => 2,
                'status' => 1,
                'name' => 'YẾN',
                'password' => bcrypt('160996'),
            ],
            [
                'username' => 'NGUYENTHIEN',
                'role' => 2,
                'status' => 1,
                'name' => 'THIEN',
                'password' => bcrypt('100988'),
            ],
            [
                'username' => 'TLINH',
                'role' => 1,
                'status' => 1,
                'name' => 'TRÚC LINH',
                'password' => bcrypt('5586'),
            ],
            [
                'username' => 'MUI',
                'role' => 1,
                'status' => 1,
                'name' => 'MÙI',
                'password' => bcrypt('5586'),
            ],
            [
                'username' => 'TAM',
                'role' => 1,
                'status' => 1,
                'name' => 'TÂM',
                'password' => bcrypt('5586'),
            ],
            [
                'username' => 'KLUYEN',
                'role' => 1,
                'status' => 1,
                'name' => 'KIM LUYẾN',
                'password' => bcrypt('5586'),
            ],
            [
                'username' => 'HANG',
                'role' => 1,
                'status' => 1,
                'name' => 'HẰNG',
                'password' => bcrypt('5586'),
            ],
            [
                'username' => 'VANH',
                'role' => 1,
                'status' => 1,
                'name' => 'VÂM ANH',
                'password' => bcrypt('5586'),
            ],
            [
                'username' => 'VY',
                'role' => 1,
                'status' => 1,
                'name' => 'VY',
                'password' => bcrypt('5586'),
            ],
            [
                'username' => 'THOA',
                'role' => 1,
                'status' => 1,
                'name' => 'THOA',
                'password' => bcrypt('5586'),
            ],
            [
                'username' => 'LUYEN',
                'role' => 1,
                'status' => 1,
                'name' => 'LUYÊN',
                'password' => bcrypt('5586'),
            ],
            [
                'username' => 'HLINH',
                'role' => 1,
                'status' => 1,
                'name' => 'HUỲNH LINH',
                'password' => bcrypt('5586'),
            ],
            [
                'username' => 'MY',
                'role' => 1,
                'status' => 1,
                'name' => 'MỸ',
                'password' => bcrypt('5586'),
            ],
            [
                'username' => 'HUYEN',
                'role' => 1,
                'status' => 1,
                'name' => 'HUYỀN',
                'password' => bcrypt('5586'),
            ],
            [
                'username' => 'LTUYEN',
                'role' => 1,
                'status' => 1,
                'name' => 'LƯU TUYẾN',
                'password' => bcrypt('5586'),
            ],
        ];
        \DB::table('users')->insert($data);
    }
}
