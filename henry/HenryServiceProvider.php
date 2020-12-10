<?php

namespace Henry;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class HenryServiceProvider extends ServiceProvider
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
        $modules = array_map('basename', File::directories(__DIR__));

        foreach ($modules as $module) {
            $moduleDir = __DIR__ . '/' . $module;

            // config
            if (is_dir($configDir = $moduleDir . '/config')) {
                $files = File::files($configDir);
                foreach ($files as $file) {
                    $fileName = $file->getFilenameWithoutExtension();
                    $this->mergeConfigFrom($file, $fileName);
                }
            }

            // route
            if (is_dir($configDir = $moduleDir . '/routes')) {
                $files = File::files($configDir);
                foreach ($files as $file) {
                    $this->loadRoutesFrom($file);
                }
            }

            // service provider
            if (file_exists($moduleDir . '/ServiceProvider.php')) {
                $this->app->register('Henry\\' . ucfirst($module) . '\\' . 'ServiceProvider');
            } else {
                Log::error('ServiceProvider.php not found in module ' . $module);
                continue;
            }
        }
    }
}
