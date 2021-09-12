<?php

namespace App\Interfaces\Transactions;

use App\Models\Transaction;

interface TransactionRecordInterface
{
  public function create(string $myWallet, string $recipientWallet, string $amountOfBTC, Transaction $transaction):void;
}
