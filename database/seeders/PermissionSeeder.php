<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            'name' => 'Create Accounts',
            'slug' => 'create-accounts',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('permissions')->insert([
            'name' => 'View Accounts',
            'slug' => 'read-accounts',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Accounts',
            'slug' => 'update-accounts',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('permissions')->insert([
            'name' => 'Delete Accounts',
            'slug' => 'delete-accounts',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
