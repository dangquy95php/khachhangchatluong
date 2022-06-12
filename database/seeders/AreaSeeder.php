<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
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
                'name' => 'username1',
                'status' => 1,
                'note' => 'Khu vực có nhiều người trẻ'
            ],
            [
                'name' => 'username2',
                'status' => 1,
                'note' => 'Khu vực có tiềm năng cao'
            ],
            [
                'name' => 'Bình Chuẩn',
                'status' => 1,
                'note' => 'Khu vực đông người đăng ký bảo hiểm'
            ],
        ];
        \DB::table('areas')->insert($data);
    }
}
