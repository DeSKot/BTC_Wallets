<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Wallets\WalletController;
use App\Http\Controllers\Transactions\TransactionController;
use App\Http\Controllers\Wallets\WalletTransactionController;


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

    Route::get('/create_wallet', [WalletController::class, 'create'])->name('create_wallet');

    Route::get('/wallets', [WalletController::class, 'index'])->name('wallets');

    Route::get('/wallets/{address}', [WalletController::class, 'show'])->name('wallet');

    Route::get('/wallets/{address}/transaction', [TransactionController::class, 'show'])->name('showTransaction');

    Route::get('/transaction', [TransactionController::class, 'index'])->name('indexTransaction');

    Route::post('/transaction', [WalletTransactionController::class, 'transaction'])->name('transaction');
});

require __DIR__ . '/auth.php';
