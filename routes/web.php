<?php

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Chartjs\DemoChartController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/accounts', [AccountController::class, 'index'])->name('admin.account.index');

Route::get('/chartjs/demo', [DemoChartController::class, 'index']);

/*
Route::get('/{any?}', function () {
    return view('welcome');
});
*/

/*
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');
*/

//require __DIR__.'/auth.php';
