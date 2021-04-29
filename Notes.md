# Create a Laravel project
## Create fresh new
> \> laravel new project_name
## From an existed folder
> existed_folder> laravel new

# DB Migration

```
php artisan migrate:fresh --seed

php artisan make:model Account --migration --seed --factory
php artisan make:migration create_accounts_table --create=accounts
php artisan make:seeder AccountSeeder
php artisan make:factory AccountFactory --model=Account


```

---

# Authenticate by JWT

[jwt-auth > Laravel Installation](https://jwt-auth.readthedocs.io/en/docs/laravel-installation)

#### Install via composer
Run the following command to pull in the latest version:
```
$ composer require tymon/jwt-auth
```

#### Add service provider
Add the service provider to the providers array in the config/app.php config file as follows:
```
'providers' => [  
    ...
    Tymon\JWTAuth\Providers\LaravelServiceProvider::class,
]
...
'aliases' => [
    ...
    'JWTAuth' => Tymon\JWTAuth\Facades\JWTAuth::class,
    'JWTFactory' => Tymon\JWTAuth\Facades\JWTFactory::class,
]
```

#### Publish the config
Run the following command to publish the package config file:
```
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
```
You should now have a config/jwt.php file that allows you to configure the basics of this package.

#### Generate secret key
Use helper command to generate a key for you:
```
php artisan jwt:secret
```
This will update your .env file with something like JWT_SECRET=foobar


#### Apply to code
Create Auth controller
```
php artisan make:controller JwtAuthController
```
Add api router
```

```
