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
