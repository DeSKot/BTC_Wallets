<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Wallets\CreateWalletController;
use App\Http\Controllers\Currency\ExchangeCurrencyController;
use App\Http\Controllers\Wallets\ShowWalletsController;
use App\Http\Controllers\Transactions\MakingTransactionController;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::group(array('before' => 'auth'), function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/create_wallet', [CreateWalletController::class, 'create'])->name('create_wallet');

    Route::get('/currency', [ExchangeCurrencyController::class, 'exchangeCurrency'])->name('currency');

    Route::get('/wallets', [ShowWalletsController::class, 'index'])->name('wallets');

    Route::get('/wallets/{address}', [ShowWalletsController::class, 'show'])->name('wallet');

    Route::get('/transaction', [MakingTransactionController::class, 'transaction'])->name('transaction');
});

require __DIR__ . '/auth.php';
