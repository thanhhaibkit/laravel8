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

## 3. Register (Inject) via the AppServiceProvider

```php
// File: app\Providers\AppServiceProvider.php
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

## 4. Using

Now we can using by inject the interface at the constructor and service provide will be resolved the implementation

```php
// File: app\Services\Admin\AccountService.php
<?php

namespace App\Services\Admin;

use App\Repositories\AccountRepositoryInterface;

class AccountService
{
    protected $accountRepo;

    public function __construct(
        AccountRepositoryInterface $accountRepo
    ) {
        $this->accountRepo = $accountRepo;
    }

    public function getAccountsWithUsers()
    {
        return $this->accountRepo->getAccountsWithUsers();
    }
}
```

## 5. Testing

Define route and a simple controller for testing

```php
// File: routes\web.php
<?php

use App\Http\Controllers\Admin\AccountController;
use Illuminate\Support\Facades\Route;

Route::get('/admin/accounts', [AccountController::class, 'index'])->name('admin.account.index');
```

```php
// File: app\Http\Controllers\Admin\AccountController.php
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\AccountService;

class AccountController extends Controller {

    protected $accountService;

    public function __construct(
        AccountService $accountService
    ) {
        $this->accountService = $accountService;
    }

    public function index()
    {
        $accounts = $this->accountService->getAccountsWithUsers();

        return view('admin.account.index', ['accounts' => $accounts]);
    }
}
```

```php
// File: resources\views\admin\account\index.blade.php
@extends('layouts.admin')

@push('styles')
@endpush


@section('title', 'Accounts')

@section('header')
    @parent

    <div class="container">
        <div class="row">
            <div class="col-sm-6 offset-sm-3 mb-5">
                <div class="mt-lg-5 text-center">
                    <h2>@lang('account.text.account_list')</h2>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container">
        @if(count($accounts) > 0)
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th>@lang('account.text.account_name')</th>
                                <th>@lang('account.text.users_name')</th>
                                <th class="text-center">@lang('global.text.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($accounts as $account)
                            <tr class="mapping-row">
                                <td>{{ $account->name }}</td>
                                <td>
                                    @if ($totalUser = count($account->users))
                                        @php
                                            $counter  = 1;
                                            $showMax = $totalUser < 2 ?: 2;
                                        @endphp
                                        @foreach ($account->users->take($showMax) as $user)
                                            {{ $user->name }}
                                            @if ($counter++ < $showMax)
                                                ,
                                            @endif
                                        @endforeach
                                        @if ($showMax < $totalUser)
                                            ...
                                        @endif
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a class="btn btn-success" title="{{__('global.button.edit')}}"
                                       href="{{ route('admin.account.index',['account' => $account->id]) }}" >
                                        <i class="far fa-edit"></i>
                                    </a>
                                    <a class="btn btn-danger" title="{{__('global.button.delete')}}"
                                       href="{{ route('admin.account.index', ['account' => $account->id]) }}">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection
```

And now, do testing at below url
> {domain}/admin/accounts
