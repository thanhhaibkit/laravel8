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
            'name' => 'Create Users',
            'slug' => 'create-users',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('permissions')->insert([
            'name' => 'View Users',
            'slug' => 'read-users',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Users',
            'slug' => 'update-users',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('permissions')->insert([
            'name' => 'Delete Users',
            'slug' => 'delete-users',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
