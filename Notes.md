# Create a Laravel project
## Create new
laravel new project_name
## In existed folder
laravel new

# DB Migration
```
php artisan migrate:fresh --seed

php artisan make:model Account --migration --seed --factory
php artisan make:migration create_accounts_table --create=accounts
php artisan make:seeder AccountSeeder
php artisan make:factory AccountFactory --model=Account


```

php artisan make:migration create_blocks_table --create=blocks
