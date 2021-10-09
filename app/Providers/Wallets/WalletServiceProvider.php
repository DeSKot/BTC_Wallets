<?php

namespace App\Providers\Wallets;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\Wallets\WalletServiceInterface;
use App\Services\Wallets\WalletService;

class WalletServiceProvider extends ServiceProvider
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
        WalletServiceInterface::class => WalletService::class,
    ];
}
