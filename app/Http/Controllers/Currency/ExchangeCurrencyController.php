<?php

namespace App\Http\Controllers\Currency;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\Currency\ExchangeCurrencyInterface;

class ExchangeCurrencyController extends Controller
{
    private ExchangeCurrencyInterface $exchange;

    public function __construct(ExchangeCurrencyInterface $exchangeCurrencyInterface)
    {
        $this->exchange = $exchangeCurrencyInterface;
    }

    public function exchangeCurrency()
    {

        $arrayExchangeCurrency = $this->exchange->exchangeCurrency()['ticker']['price'];

        return $arrayExchangeCurrency;
    }
}
