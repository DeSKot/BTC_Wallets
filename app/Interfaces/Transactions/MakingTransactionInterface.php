<?php

namespace App\Interfaces\Transactions;

interface MakingTransactionInterface {
  public function transaction(string $myWallet, string $recipientWallet, string $amountOfBTC): void;
}