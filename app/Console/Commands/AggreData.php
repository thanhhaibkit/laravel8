<?php

namespace App\Console\Commands;

use App\Models\Lead;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class AggreData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:aggre';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Aggregation data';

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
     * @return int
     */
    public function handle()
    {
        echo "Hello World!!\n";
        $schemas = ['laravel1', 'laravel2'];
        $integratedLeads = new Collection();
        foreach ($schemas as $schema) {
            echo "$schema\n";

            config(['database.connections.pgsql.schema' => $schema]);
            DB::reconnect('pgsql');

            $leads = Lead::select('email', 'firstName', 'lastName')->get()->toArray();
            print_r($leads);

            config(['database.connections.pgsql.schema' => 'public']);
            DB::reconnect('pgsql');

            Lead::insert($leads);
        }

        return 0;
    }
}
