<?php

namespace App\Services\Currency;

use App\Interfaces\Currency\ExchangeCurrencyInterface;
use GuzzleHttp\Client;

class ExchangeCurrency implements ExchangeCurrencyInterface
{

  public function exchangeCurrency(): mixed
  {
    $client = new Client([
      'base_uri' => 'https://api.cryptonator.com/api/ticker/btc-usd',
    ]);

    $response = $client->request('GET')->getBody();

    $json = json_decode($response, true);
    return $json['ticker']['price'];
  }
}
