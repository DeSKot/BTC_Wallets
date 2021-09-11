<?php

namespace App\Providers\Wallets;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\Wallets\ShowWalletInterface;
use App\Services\Wallets\ShowWallets;

class ShowWalletsServiceProvider extends ServiceProvider
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
        ShowWalletInterface::class => ShowWallets::class,
   ];
}
