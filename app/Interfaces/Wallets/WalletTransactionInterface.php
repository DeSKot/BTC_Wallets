<?php

namespace App\Interfaces\Wallets;

interface WalletTransactionInterface {
  public function transactionInDB(string $myWallet, string $recipientWallet, string $amountOfBTC): void;
}