<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;

class AreaUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        if (Config::get('local.APP_LOCAL')) {
            // $data = [
            //     [
            //         'id_area' => 2,
            //         'id_user' => 3,
            //     ],
            //     [
            //         'id_area' => 1,
            //         'id_user' => 2,
            //     ],
            //     [
            //         'id_area' => 3,
            //         'id_user' => 3,
            //     ],
            // ];
        }
        \DB::table('areas_users')->insert($data);
    }
}
