<?php

namespace App\Services\Currency;

use App\Interfaces\Currency\ExchangeCurrencyInterface;

class ExchangeCurrency implements ExchangeCurrencyInterface
{

  public function exchangeCurrency(): mixed
  {
    // initialize CURL:
    $ch = curl_init('https://api.cryptonator.com/api/ticker/btc-usd');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // get the (still encoded) JSON data:
    $json = curl_exec($ch);
    curl_close($ch);

    // Decode JSON response:
    $conversionResult = json_decode($json, true);

    // access the conversion result
    return $conversionResult;
  }
}
