<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Base Account
        DB::table('accounts')->insert([
            'code' => 'ht',
            'name' => 'HT Holdings PLC',
            'is_origin' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
