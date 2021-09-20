<?php

namespace App\Http\Controllers\Currency;

use App\Http\Controllers\Controller;
use App\Interfaces\Currency\ExchangeCurrencyInterface;

class ExchangeCurrencyController extends Controller
{
    private ExchangeCurrencyInterface $exchangeCurrency;

    public function __construct(ExchangeCurrencyInterface $exchangeCurrencyInterface)
    {
        $this->exchangeCurrency = $exchangeCurrencyInterface;
    }

    public function exchangeCurrency():mixed
    {

        $arrayExchangeCurrency = $this->exchangeCurrency->exchangeCurrency();

        return $arrayExchangeCurrency;
    }
}
