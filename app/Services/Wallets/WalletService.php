<?php

namespace App\Services\Wallets;

use App\Interfaces\Wallets\WalletServiceInterface;
use App\Interfaces\Currency\ExchangeCurrencyServiceInterface;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\Wallet\ToManyWalletsException;
use Illuminate\Database\Eloquent\Collection;
use Ramsey\Uuid\Uuid;
class WalletService implements WalletServiceInterface
{
  private ExchangeCurrencyServiceInterface $exchangeCurrencyService;

  public function __construct(ExchangeCurrencyServiceInterface $exchangeCurrencyService)
  {
    $this->exchangeCurrencyService = $exchangeCurrencyService;
  }

  public function index(): Collection
  {
    return Wallet::where('user_id', Auth::user()->id)->get();
  }
  
  public function show($address): array
  {
    $currencyUSD = $this->exchangeCurrencyService->exchangeCurrency();
    $amountOfSatoshi = Wallet::where('address', $address)->value('amount_of_satoshi');
    $amountOfBtc = ((100 / 100000000) * $amountOfSatoshi) / 100;
    $amountOfUsd = $amountOfBtc * $currencyUSD;

    return  [
      'amountOfSatoshi' => $amountOfSatoshi,
      'amountOfUsd' => $amountOfUsd,
      'amountOfBtc' => $amountOfBtc,
      'address' => $address
    ];
  }

  public function create(Wallet $wallet): void
  {
    $userID = Auth::user()->id;
    $countOfWallets = Wallet::query()->where('user_id', '=', $userID)->count();

    throw_if($countOfWallets >= 10, ToManyWalletsException::class, 'У вас слишком много кошельков, дозволено максимум 10');

    $wallet->amount_of_satoshi = 100000000;
    $wallet->user_id = $userID;
    $wallet->address = Uuid::uuid4();

    $wallet->save();
  }
}
