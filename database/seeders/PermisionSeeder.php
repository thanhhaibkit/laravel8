<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permisssions')->insert([
            'name' => 'Create Accounts',
            'slug' => 'create-accounts',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('permisssions')->insert([
            'name' => 'View Accounts',
            'slug' => 'read-accounts',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('permisssions')->insert([
            'name' => 'Edit Accounts',
            'slug' => 'update-accounts',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('permisssions')->insert([
            'name' => 'Delete Accounts',
            'slug' => 'delete-accounts',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
