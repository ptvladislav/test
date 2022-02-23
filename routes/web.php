<?php

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
Route::group(['middleware' => ['auth']], function () {
    Route::get('/user/info', [App\Http\Controllers\UserController::class, 'info'])->name('user.info');
    Route::post('/user/logout', [App\Http\Controllers\LoginController::class, 'logout'])->name('logout');
    Route::post('/finance/transfer', [App\Http\Controllers\TransferController::class, 'transfer'])->name('transfer');
    Route::post('/finance/deposit', [App\Http\Controllers\TransferController::class, 'deposit'])->name('deposit');
});

Route::group(['middleware' => ['guest']], function () {
    Route::get('/user/register', [App\Http\Controllers\RegistrationController::class, 'index'])->name('register');
    Route::get('/user/login', [App\Http\Controllers\LoginController::class, 'index'])->name('login');
    Route::post('/user/register', [App\Http\Controllers\RegistrationController::class, 'store'])->name('store.register');
    Route::post('/user/login', [App\Http\Controllers\LoginController::class, 'store'])->name('store.login');
});






