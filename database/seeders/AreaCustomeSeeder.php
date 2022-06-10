<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AreaCustomerSeeder extends Seeder
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
                'id_area' => 2,
                'id_customer' => 3,
            ],
            [
                'id_area' => 1,
                'id_customer' => 4,
            ],
            [
                'id_area' => 3,
                'id_customer' => 10,
            ],
        ];
        \DB::table('areas_customers')->insert($data);
    }
}
