<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FakeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Fake
        \App\Models\Account::factory(2)->create()->each(function ($account) {
            $account->users()->saveMany(\App\Models\User::factory(3)->make());
        });

    }
}
