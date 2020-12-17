# Role & Pemission
---

Refer: [User Roles and Permissions tutorial](https://www.codechief.org/article/user-roles-and-permissions-tutorial-in-laravel-without-packages)

## Step 1: Migration
#### 1.1 Create Permission & Role DB and Model

```sh
php artisan make:model Permission --migration --seed --factory
php artisan make:model Role --migration --seed --factory
```

- Edit migration files
```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g. edit posts
            $table->string('slug'); // e.g. edit-posts
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permissions');
    }
}
```

```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g. Java Developer
            $table->string('slug'); // e.g. develop
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
```

#### 1.2 Adding pivot tables
- User can be has specific Permissions: users_permissions
- User has Roles: users_roles
- Under a particular Role, User may have specific Permission: roles_permissions

```sh
php artisan make:migration create_users_permissions_table --create=users_permissions
php artisan make:migration create_users_roles_table --create=users_roles
php artisan make:migration create_roles_permissions_table --create=roles_permissions
```

```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_permissions', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('permission_id');

            // Foreign key contraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');

            // Setting the primary keys
            $table->primary(['user_id','permission_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_permissions');
    }
}
```

```php
class CreateUsersRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_roles', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('role_id');

            // Foreign key contraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');

            // Setting the primary keys
            $table->primary(['user_id','role_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_roles');
    }
}
```

```php
class CreateRolesPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles_permissions', function (Blueprint $table) {
            $table->unsignedInteger('role_id');
            $table->unsignedInteger('permission_id');

            // Foreign key contraints
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');

            // Setting the primary keys
            $table->primary(['role_id','permission_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles_permissions');
    }
}
```

#### Step 1.3 Setting up the relationships
##### App/Role.php
```php
public function permissions() {
   return $this->belongsToMany(Permission::class,'roles_permissions');
}

public function users() {
   return $this->belongsToMany(User::class,'users_roles');
}
```
##### App/Permission.php
```php
public function roles() {
   return $this->belongsToMany(Role::class,'roles_permissions');
}

public function users() {
   return $this->belongsToMany(User::class,'users_permissions');
}
```

## Step 2: Creating a Trait
##### App/Permissions/HasPermissionsTrait.php
```php
namespace App\Permissions;

use App\Permission;
use App\Role;

trait HasPermissionsTrait {

   public function givePermissionsTo(... $permissions) {

    $permissions = $this->getAllPermissions($permissions);
    dd($permissions);
    if($permissions === null) {
      return $this;
    }
    $this->permissions()->saveMany($permissions);
    return $this;
  }

  public function withdrawPermissionsTo( ... $permissions ) {

    $permissions = $this->getAllPermissions($permissions);
    $this->permissions()->detach($permissions);
    return $this;

  }

  public function refreshPermissions( ... $permissions ) {

    $this->permissions()->detach();
    return $this->givePermissionsTo($permissions);
  }

  public function hasPermissionTo($permission) {

    return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);
  }

  public function hasPermissionThroughRole($permission) {

    foreach ($permission->roles as $role){
      if($this->roles->contains($role)) {
        return true;
      }
    }
    return false;
  }

  public function hasRole( ... $roles ) {

    foreach ($roles as $role) {
      if ($this->roles->contains('slug', $role)) {
        return true;
      }
    }
    return false;
  }

  public function roles() {

    return $this->belongsToMany(Role::class,'users_roles');

  }
  public function permissions() {

    return $this->belongsToMany(Permission::class,'users_permissions');

  }
  protected function hasPermission($permission) {

    return (bool) $this->permissions->where('slug', $permission->slug)->count();
  }

  protected function getAllPermissions(array $permissions) {

    return Permission::whereIn('slug',$permissions)->get();
    
  }

}
```

Add to 
###### app/User.php
```php
namespace App;

use App\Permissions\HasPermissionsTrait;

class User extends Authenticatable
{
    use HasPermissionsTrait; //Import The Trait
}
```

- Create custom Provider
```sh
php artisan make:provider PermissionsServiceProvider
```

```php
// file: config\app.php
'providers' => [
    App\Providers\PermissionsServiceProvider::class,
 ],
 ```

- Setup middleware
```sh
php artisan make:middleware RoleMiddleware
```

App\Http\Middleware\RoleMiddleware.php
```php
namespace App\Http\Middleware;

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
        if (!$request->user()->hasRole($role)) {
            abort(404);
        }

        if ($permission !== null && !$request->user()->can($permission)) {
            abort(404);
        }

        return $next($request);
    }
}
```
