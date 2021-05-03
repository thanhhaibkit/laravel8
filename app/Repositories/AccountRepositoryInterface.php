<?php
namespace App\Repositories;

use App\Repositories\RepositoryInterface;

interface AccountRepositoryInterface extends RepositoryInterface
{
    // Get accounts and its users (Eager loading)
    public function getAccountsWithUsers();
}
