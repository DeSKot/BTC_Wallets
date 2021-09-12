<?php

namespace App\Interfaces\Wallets;

use App\Models\Wallet;

interface CreateWalletInterface {
  public function createWallet(Wallet $wallet): void;
}