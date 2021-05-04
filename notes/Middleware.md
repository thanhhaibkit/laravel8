# Middleware

> [Laravel middle document](https://laravel.com/docs/8.x/middleware#introduction)


### Example: create middleware to check access right of user by their role and permission

Create middleware via artisan console

```sh
php artisan make:middleware
```

```php
// File: \Http\Middleware\RoleMiddleware.php
<?php

namespace Henry\Permission\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role, $permission = null)
    {
        // Use must has the required role
        if (!$request->user()->hasRole($role)) {
            abort(404);
        }

        // Use must has the required permission
        if ($permission !== null && !$request->user()->can($permission)) {
            abort(404);
        }

        return $next($request);
    }
}
```

Use middle at router

```php
Route::group(['middleware' => 'role:admin'], function() {
    Route::get('/admin', function() {
        return 'Welcome Admin';
    });
});
```
