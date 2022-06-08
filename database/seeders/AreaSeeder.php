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
                'name' => 'Lái thiêu',
                'status' => 1,
                'note' => 'Khu vực có nhiều người trẻ'
            ],
            [
                'name' => 'Gò công',
                'status' => 1,
                'note' => 'Khu vực có tiềm năng cao'
            ],
        ];
        \DB::table('areas')->insert($data);
    }
}
