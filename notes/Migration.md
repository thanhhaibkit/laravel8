# DB Migration

```sh
# Create model with migration, seed and factory scripts
php artisan make:model Account --migration --seed --factory

# Create a migration script with file name is create_accounts_table and db table is accounts
php artisan make:migration create_accounts_table --create=accounts

# Create a seed script
php artisan make:seeder AccountSeeder

# Create a factory script
php artisan make:factory AccountFactory --model=Account

# Refresh DB with seed data
php artisan migrate:fresh --seed
```

### Migration script

```php
// File: database\migrations\2010_10_10_000000_create_accounts_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('hashed_code')->nullable()->unique();
            $table->boolean('is_origin')->nullable()->default(false);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
```

### Factory script
```php
// File: database\factories\AccountFactory.php
<?php

namespace Database\Factories;

use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AccountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Account::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => 'acct_' . Str::random(10),
            'name' => $this->faker->company,
            'hashed_code' => Str::random(64)
        ];
    }
}

```

### Seed script
1. Seed script with dummy data

```php
// File: database\seeders\AccountSeeder.php
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
        // Dummy data
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

```

2. Seed script with fake data via factory
```php
// File: database\seeders\FakeSeeder.php
// Nite: Must have UserFactory
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
        // Fake data
        \App\Models\Account::factory(2)->create()->each(function ($account) {
            $account->users()->saveMany(\App\Models\User::factory(3)->make());
        });

    }
}
```

3. Includes seed scripts into seeder

```php
// File: database\seeders\DatabaseSeeder.php
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
```

4. Refresh DB with seed data

```sh
# Refresh DB with seed data
php artisan migrate:fresh --seed
```
