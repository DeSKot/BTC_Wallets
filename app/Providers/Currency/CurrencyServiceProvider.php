<?php

namespace App\Providers\Currency;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\Currency\ExchangeCurrencyInterface;
use App\Services\Currency\ExchangeCurrency;

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
        ExchangeCurrencyInterface::class => ExchangeCurrency::class
    ];
}
