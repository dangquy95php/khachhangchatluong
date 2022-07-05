<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AreaUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'area_id' => null,
                'user_id' => null,
            ],
            [
                'area_id' => null,
                'user_id' => null,
            ],
        ];

        \DB::table('area_users')->insert($data);
    }
}
