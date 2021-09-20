<?php

namespace App\Services\Wallets;

use App\Interfaces\Wallets\WalletInterface;
use App\Interfaces\Currency\ExchangeCurrencyInterface;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\Wallet\ToManyWalletsException;
use Ramsey\Uuid\Uuid;

class WalletService implements WalletInterface
{

  private ExchangeCurrencyInterface $exchangeCurrency;

  public function __construct(ExchangeCurrencyInterface $exchangeCurrencyInterface)
  {
    $this->exchangeCurrency = $exchangeCurrencyInterface;
  }


  public function index(): mixed
  {
    $allWallets =  Wallet::where('id_of_user', Auth::user()->id)->get();

    return $allWallets;
  }



  public function show($address): array
  {
    $currencyUSD = $this->exchangeCurrency->exchangeCurrency();
    $amountOfSatoshi = Wallet::where('address', $address)->value('amount_of_satoshi');
    $amountOfBtc = ((100 / 100000000) * $amountOfSatoshi) / 100;
    $amountOfUsd = $amountOfBtc * $currencyUSD;


    $walletArray = [
      'amountOfSatoshi' => $amountOfSatoshi,
      'amountOfUsd' => $amountOfUsd,
      'amountOfBtc' => $amountOfBtc,
      'address' => $address
    ];

    return $walletArray;
  }


  public function create(Wallet $wallet): void
  {
    $userID = Auth::user()->id;
    $countOfWallets = count(Wallet::where('id_of_user', '=', $userID)->get());

    throw_if($countOfWallets >= 10, ToManyWalletsException::class, 'У вас слишком много кошельков, дозволено максимум 10');

    $wallet->amount_of_satoshi = 100000000;
    $wallet->id_of_user = $userID;
    $wallet->address = Uuid::uuid4();

    $wallet->save();
  }
}
