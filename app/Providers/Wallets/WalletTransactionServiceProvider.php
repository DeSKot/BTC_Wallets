<?php

namespace App\Providers\Wallets;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\Wallets\WalletTransactionInterface;
use App\Services\Wallets\WalletTransaction;

class WalletTransactionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

   public  $singletons = [
        WalletTransactionInterface::class => WalletTransaction::class,
   ];
}
