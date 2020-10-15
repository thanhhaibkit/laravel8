<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Origin data
        $this->call(AccountSeeder::class);
        $this->call(UserSeeder::class);

        // Fake data
        $this->call(FakeSeeder::class);
    }
}
