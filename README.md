# My Laravel

Install dependencies
`composer install`

Set environment variables
`copy .env.example .env`

Open .env file and input the setting values

Generate Laravel key
`php artisan key:generate`

Migrate DB Master
`php artisan schema:migrate`

Refresh DB with seed data
php artisan migrate:fresh --seed

Practice guide:
- Create [new project](.\notes\CreatePJ.md) and [first migration](.\notes\Migration.md)
- [Authentication by JWT](.\notes\Authentication.md)
- [Use Vue as front-end](.\notes\Vue.md)
- [Apply Repository pattern](.\notes\Repository.md)
