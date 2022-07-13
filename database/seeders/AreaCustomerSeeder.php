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
                'area_id' => 1,
                'user_id' => 1,
                'customer_id' => 1,
                'called' => null,
            ],
            [
                'area_id' => 1,
                'user_id' => 1,
                'customer_id' => 2,
                'called' => null,
            ],
            [
                'area_id' => 2,
                'user_id' => 1,
                'customer_id' => 3,
                'called' => null,
            ],
            [
                'area_id' => 2,
                'user_id' => 2,
                'customer_id' => 2,
                'called' => null,
            ],
            [
                'area_id' => 2,
                'user_id' => 2,
                'customer_id' => 3,
                'called' => null,
            ],
        ];

        \DB::table('areas_customers')->insert($data);
    }
}
