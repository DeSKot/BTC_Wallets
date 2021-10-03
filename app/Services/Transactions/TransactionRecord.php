<?php

namespace App\Services\Transactions;

use App\Interfaces\Transactions\TransactionRecordInterface;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionRecord implements TransactionRecordInterface
{
  public function createInDB(string $myWallet, string $recipientWallet, string $amountOfBTC, Transaction $transaction):void
  {
    $transaction->sender = $myWallet;
    $transaction->recipient = $recipientWallet;
    $transaction->amount_of_transaction = $amountOfBTC;
    $transaction->sender_Id = Auth::user()->id;
    $transaction->save();
  }
}
