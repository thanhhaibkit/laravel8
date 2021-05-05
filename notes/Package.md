# Package (Module)

Sometimes, we implement some features that can be re-use in other PJs, e.g. the mini chat tool or permission module.
Easiest, we copy & paste the code from the old PJ to new PJ.
For better, we can package the re-useable code to a module and deploy it to other PJs.


The technical we use here are Autoloading and Service Provider
Refer the following links for more infomation

1. Autoloading 
   1. [PSR-4: Autoloader](https://www.php-fig.org/psr/psr-4/)
   2. [Laravel lifecycle](https://laravel.com/docs/8.x/lifecycle)
2. [Service Provider](https://laravel.com/docs/8.x/providers)
   
## Example

### 1. Load a package by autoload

Assume we have the package chatter that we have already put under the folder henry. To load this package into the PJ, we update the composer.json at autoload area.

```json
// File: composer.json
{
    //...
    "autoload": {
        "psr-4": {
            "App\\": "app/",
            //...
            "Henry\\Chatter\\": "henry/chatter/src",
        }
    },
    //...
}
```

- "Henry\\Chatter\\" : the namespace of package
- "henry/chatter/src": the path to base folder the store the ServiProvider.php file or composer.json file


### 2. Service Provider

There are two main methods in Service Provide is register and boot

- Register: You should only bind things into the service container.
- Boot: This method is called after all other service providers have been registered. It oftens use to run set up data, configuration,...

Example:

```php
<?php

namespace Henry\Chatter;

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
        $this->app->register('Henry\\Chatter\\Providers\\ChatterServiceProvider');
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
        // Publish the seed data
        $this->publishes([
            __DIR__ . '/../database/seeds/ChatterSeeder.php' => database_path('seeds/ChatterSeeder.php'),
        ], 'permission-seeds');
    }
}
```

Now, we can use chatter in our code :)

### 3. Include many packages

We can define a "mother" Service Provide to control loading all package


```json
// File: composer.json
{
    //...
    "autoload": {
        "psr-4": {
            "App\\": "app/",
            //...
            "Henry\\": "henry/",
            "Henry\\Chatter\\": "henry/chatter/src",
            "Henry\\Permission\\": "henry/permission/src"
        }
    },
    //...
}
```

```php
// File: config\app.php
<?php

return [
    // ...

    'providers' => [

        // ...

        /*
         * Custom Service Provider
         */
        Henry\HenryServiceProvider::class,

    ],

    // ...
]
```

```php
// File: henry\HenryServiceProvider.php
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
        $modules = array_map('basename', File::directories(__DIR__));

        foreach ($modules as $module) {
            $moduleDir = __DIR__ . '/' . $module;

            // service provider
            if (file_exists($moduleDir . '/src/ServiceProvider.php')) {
                $this->app->register('Henry\\' . ucfirst($module) . '\\' . 'ServiceProvider');
            } else {
                Log::error('ServiceProvider.php not found in module ' . $module);
                continue;
            }
        }
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

            // migrations
            if (is_dir($migrationsDir = $moduleDir . '/database/migrations')) {
                $this->loadMigrationsFrom($migrationsDir);
            }

            // routes
            if (is_dir($routesDir = $moduleDir . '/routes')) {
                $files = File::files($routesDir);
                foreach ($files as $file) {
                    $this->loadRoutesFrom($file);
                }
            }

            // ....
        }
    }
}
```
