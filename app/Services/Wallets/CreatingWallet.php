<?php

namespace App\Services\Wallets;

use App\Models\Wallet;
use App\Interfaces\Wallets\CreateWalletInterface;
use App\Interfaces\Currency\ExchangeCurrencyInterface;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\Wallet\ToManyWalletsException;

class CreatingWallet implements CreateWalletInterface
{
  private ExchangeCurrencyInterface $exchange;

  public function __construct(ExchangeCurrencyInterface $exchangeCurrencyInterface)
  {
    $this->exchange = $exchangeCurrencyInterface;
  }
  //$this->exchange->exchangeCurrency();


  public function createWallet(Wallet $wallet): void
  {
    $userID = Auth::user()->id;
    $countOfWallets = count(Wallet::where('id_of_user', '=', $userID)->get());
    $exchangeCurrencyToUSD = $this->exchange->exchangeCurrency();

    throw_if($countOfWallets >= 10, ToManyWalletsException::class, 'У вас слишком много кошельков, дозволено максимум 10');

    $wallet->amount_of_BTC = 1;
    $wallet->amount_of_USD = $exchangeCurrencyToUSD;
    $wallet->id_of_user = $userID;
    $wallet->address = sprintf(
      '%04X-%04X-%04X-%04X',
      mt_rand(0, 65535),
      mt_rand(0, 65535),
      mt_rand(0, 65535),
      mt_rand(0, 65535),
    );

    $wallet->save();
  }
}
