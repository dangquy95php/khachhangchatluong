<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AreaCustomer extends Seeder
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
                'customer_id' => null,
                'type_call' => null,
                'called' => null,
                'comment' => null,
            ],
            [
                'area_id' => null,
                'customer_id' => null,
                'type_call' => null,
                'called' => null,
                'comment' => null,
            ],
        ];

        \DB::table('area_customers')->insert($data);
    }
}
