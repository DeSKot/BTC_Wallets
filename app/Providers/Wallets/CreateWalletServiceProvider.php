<?php

namespace App\Providers\Wallets;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\Wallets\CreateWalletInterface;
use App\Services\Wallets\CreatingWallet;

class CreateWalletServiceProvider extends ServiceProvider
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
     public $singletons = [
        CreateWalletInterface::class => CreatingWallet::class,
     ];
}
