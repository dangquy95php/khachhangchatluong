<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UserTableSeeder;
use Database\Seeders\AreaSeeder;
use Database\Seeders\AreaUserSeeder;
use Database\Seeders\AreaCustomerSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            UserTableSeeder::class,
        ]);

        $this->call([
            AreaSeeder::class,
        ]);

        $this->call([
            AreaUserSeeder::class,
        ]);

        $this->call([
            AreaCustomerSeeder::class,
        ]);
    }
}
