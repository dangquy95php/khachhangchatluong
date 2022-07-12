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
                'type_call' => null,
                'called' => null,
                'comment' => null,
                'so_hop_dong' => 1235,
            ],
            [
                'area_id' => 1,
                'user_id' => 1,
                'customer_id' => 2,
                'type_call' => null,
                'called' => null,
                'comment' => null,
                'so_hop_dong' => 23122,
            ],
            [
                'area_id' => 2,
                'user_id' => 1,
                'customer_id' => 3,
                'type_call' => null,
                'called' => null,
                'comment' => null,
                'so_hop_dong' => 23145,
            ],
            [
                'area_id' => 2,
                'user_id' => 2,
                'customer_id' => 2,
                'type_call' => null,
                'called' => null,
                'comment' => null,
                'so_hop_dong' => 45673,
            ],
            [
                'area_id' => 2,
                'user_id' => 2,
                'customer_id' => 3,
                'type_call' => null,
                'called' => null,
                'comment' => null,
                'so_hop_dong' => 54672,
            ],
        ];

        \DB::table('areas_customers')->insert($data);
    }
}
