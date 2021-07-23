<?php

namespace App\Console\Commands\Helper;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ResetCacheCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:cache:flush';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Flush cache after deploy';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $cacheResources = [
            \App\Models\Account::class,
            \App\Models\Permission::class,
            \App\Models\Service::class,
        ];

        $tags = [];

        foreach ($cacheResources as $class) {
            if (defined($class . '::CACHE_TAGS')) {
                $tags = array_merge($tags, $class::CACHE_TAGS);
                continue;
            }
        }

        Cache::tags($tags)->flush();
    }
}
