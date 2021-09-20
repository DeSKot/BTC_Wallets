<?php

namespace App\Interfaces\Wallets;

interface WalletTransactionInterface {
  public function transaction(string $myWallet, string $recipientWallet, string $amountOfBTC): void;
}