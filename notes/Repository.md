# Repository Pattern

## 1. Create RepositoryInterface & BaseRepository

### RepositoryInterface

Define the base methods

```php
// File: app\Repositories\RepositoryInterface.php
<?php

namespace App\Repositories;

interface RepositoryInterface
{
    /**
     * Get all
     * @return mixed
     */
    public function getAll();

    /**
     * Get one
     * @param $id
     * @return mixed
     */
    public function find($id);

    /**
     * Create
     * @param array $attributes
     * @return mixed
     */
    public function create($attributes = []);

    /**
     * Update
     * @param $id
     * @param array $attributes
     * @return mixed
     */
    public function update($id, $attributes = []);

    /**
     * Delete
     * @param $id
     * @return mixed
     */
    public function delete($id);
}
```

### BaseRepository

An abstract class that implements the RepositoryInterface

```php
// File: app\Repositories\Impls\BaseRepository.php
<?php

namespace App\Repositories\Impls;

use App\Repositories\RepositoryInterface;

abstract class BaseRepository implements RepositoryInterface
{
    // The associated model
    protected $model;

    public function __construct()
    {
        $this->setModel();
    }

    // Get the associated model, all extended classes must be implement this function
    abstract public function getModel();

    /**
     * Set model
     */
    public function setModel()
    {
        $this->model = app()->make(
            $this->getModel()
        );
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create($attributes = [])
    {
        return $this->model->create($attributes);
    }

    public function update($id, $attributes = [])
    {
        $result = $this->find($id);
        if ($result) {
            $result->update($attributes);
            return $result;
        }

        return false;
    }

    public function delete($id)
    {
        $result = $this->find($id);
        if ($result) {
            $result->delete();

            return true;
        }

        return false;
    }
}
```

## 2. Define the Interface and its implementation for each model

### AccountRepositoryInterface

```php
// File: app\Repositories\AccountRepositoryInterface.php
<?php
namespace App\Repositories;

use App\Repositories\RepositoryInterface;

interface AccountRepositoryInterface extends RepositoryInterface
{
    // Get accounts and its users
    public function getAccountsWithUsers();
}
```

### 
```php
// File: app\Repositories\Impls\AccountRepository.php
<?php
namespace App\Repositories\Impls;

use App\Repositories\AccountRepositoryInterface;
use App\Repositories\Impls\BaseRepository;

class AccountRepository extends BaseRepository implements AccountRepositoryInterface
{
    // Get the associated model
    public function getModel()
    {
        return \App\Models\Account::class;
    }

    public function getAccountsWithUsers()
    {
        return $this->model->with('users')->get();
    }
}
```

## 3. Register (Inject) via the 

```php
// File:
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Register repositories
        $this->app->singleton(
            \App\Repositories\AccountRepositoryInterface::class,
            \App\Repositories\Impls\AccountRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
```
