<?php

namespace Henry\Chatter\Providers;

use Illuminate\Support\ServiceProvider;

class ChatterServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'henry-chatter');
    }
}
