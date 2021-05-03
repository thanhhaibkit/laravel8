# Artisan Console

Create a new batch job via artisan command, e.g. CreateSchema, this job to create new schema for a tenant and popular base tables

```sh
php artisan make:command CreateSchema
```

This will generate a file name CreateSchema.php into folder app\Console\Commands 

Update CreateSchema.php

```php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB,Config,Artisan,Log;

class CreateSchema extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schema:create {schema}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new schema and migration DB';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            // Get input argument scheme (name)
            $schema = $this->argument('schema');

            // Check to make sure this schema is not existed
            $checkSchema = DB::table('information_schema.schemata')->where('schema_name', $schema);
            if ($checkSchema->count() > 0) {
                Log::error(printf("[schema:create] The schema %s is existed!", $schema));
                return false;
            }

            // The sql query to create new schema
            $query = "CREATE SCHEMA IF NOT EXISTS {$schema};";

            // Exec sql query
            DB::statement($query);

            // Re-connect to new scheme (so we can popular base tables on new schema)
            $this->connect($schema);

            // Migrate DB tables to new schema
            Artisan::call('migrate', array('--database' => 'tenant', '--path' => 'database/migrations/tenant', '--force' => true));

            // TODO Add SQL triggers and functions
            /*
            $path = storage_path('sql_scripts/trigger_insert_new_user.sql');
            DB::unprepared(file_get_contents($path));
            */

            // TODO Popular seed data

            return true;
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return false;
        }

    }

    /**
     * Connect to (tenant) scheme by its name
     */
    private function connect($schema) {
        Config::set('database.connections.tenant.schema', $schema);
        Config::set('database.default', 'tenant');
        DB::reconnect('tenant');
    }
}
```

Run the command on the console

```sh
php artisan schema:create test_scheme
```

It should create new scheme test_scheme in the DB
