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
