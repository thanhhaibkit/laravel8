<?php

namespace Henry\Permission;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register('Henry\\Permission\\Providers\\PermissionServiceProvider');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishResources();
        }
    }

    protected function publishResources()
    {
        $this->publishes([
            __DIR__ . '/../database/seeds/PermisionSeeder.php' => database_path('seeds/PermisionSeeder.php'),
        ], 'permission-seeds');
    }
}
