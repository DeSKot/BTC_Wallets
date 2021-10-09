<?php

namespace App\Providers\Currency;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\Currency\ExchangeCurrencyServiceInterface;
use App\Services\Currency\ExchangeCurrencyService;

class CurrencyServiceProvider extends ServiceProvider
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
        ExchangeCurrencyServiceInterface::class => ExchangeCurrencyService::class
    ];
}
