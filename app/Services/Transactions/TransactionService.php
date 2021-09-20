<?php

namespace App\Services\Transactions;

use App\Interfaces\Transactions\TransactionInterface;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionService implements TransactionInterface
{

  public function index(): mixed
  {
    $allTransactions = Transaction::where('sender_Id', Auth::user()->id)->get();;

    return $allTransactions;
  }

  public function show($address): mixed
  {

    $walletTransactions = Transaction::where('sender', $address)->get();

    return $walletTransactions;
  }
}
