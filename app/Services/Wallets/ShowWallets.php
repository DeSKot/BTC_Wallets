<?php

namespace App\Services\Wallets;

use App\Interfaces\Wallets\ShowWalletInterface;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShowWallets implements ShowWalletInterface
{

  public function index(): mixed
  {
    $allWallets =  Wallet::where('id_of_user', Auth::user()->id)->get();

    return $allWallets;
  }

  public function show($address): array
  {
    $wallet_array = [
      'amount_of_BTC' => Wallet::where('address', $address)->value('amount_of_BTC'),
      'amount_of_USD' => Wallet::where('address', $address)->value('amount_of_USD'),
      'address' => $address
    ];

    return $wallet_array;
  }
}
