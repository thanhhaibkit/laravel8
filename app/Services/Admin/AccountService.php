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
