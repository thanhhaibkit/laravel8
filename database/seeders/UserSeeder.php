<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // God User
        DB::table('users')->insert([
            'account_id' => DB::table('accounts')->where('is_origin', true)->first()->id,
            'username' => 'thanhhai',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'email' => 'thanhhai@mail.com',
            'is_god' => true,
            'name' => 'Henry Truong'
        ]);
    }
}
