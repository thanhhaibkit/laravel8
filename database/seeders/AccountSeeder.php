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
            'hashed_code' => 'ee26b0dd4af7e749aa1a8ee3c10ae9923f618980772e473f8819a5d4940e0db27ac185f8a0e1d5f84f88bc887fd67b143732c304cc5fa9ad8e6f57f50028a8ff',
            'is_origin' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
