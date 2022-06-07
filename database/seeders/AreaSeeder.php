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
            ],
            [
                'name' => 'Gò công',
                'status' => 0,
            ],
        ];
        \DB::table('areas')->insert($data);
    }
}
