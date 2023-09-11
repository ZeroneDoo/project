<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $seeder = [
            CabangSeeder::class,
            RoleSeeder::class,
            KkjSeeder::class,
            UserSeeder::class,
            PendetaSeeder::class,
        ];

        $this->call($seeder);
    }
}
