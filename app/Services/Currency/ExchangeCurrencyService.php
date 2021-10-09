<?php

namespace App\Services\Currency;

use App\Interfaces\Currency\ExchangeCurrencyServiceInterface;
use GuzzleHttp\Client;

class ExchangeCurrencyService implements ExchangeCurrencyServiceInterface
{

  public function exchangeCurrency(): float
  {
    $client = new Client([
      'base_uri' => 'https://api.cryptonator.com/api/ticker/btc-usd',
    ]);

    $response = $client->request('GET')->getBody();

    $json = json_decode($response, true);
    return $json['ticker']['price'];
  }
}
