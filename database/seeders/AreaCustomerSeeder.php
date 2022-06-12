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
                'area_id' => 2,
                'customer_id' => 3,
            ],
            [
                'area_id' => 1,
                'customer_id' => 4,
            ],
            [
                'area_id' => 3,
                'customer_id' => 10,
            ],
        ];
        \DB::table('areas_customers')->insert($data);
    }
}
