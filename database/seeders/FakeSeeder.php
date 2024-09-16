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
        // Fake 2 records of account, each account has 3 users
        \App\Models\Account::factory(2)->create()->each(function ($account) {
            $account->users()->saveMany(\App\Models\User::factory(3)->make());
        });

        \App\Models\Lead::factory(10)->create();
        \App\Models\Contact::factory(10)->create();
    }
}
