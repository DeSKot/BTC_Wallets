<?php

namespace App\Services\Transactions;

use App\Interfaces\Transactions\TransactionInterface;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionService implements TransactionInterface
{

  public function index(): mixed
  {
    return Transaction::where('sender_Id', Auth::user()->id)->get();
  }

  public function show($address): mixed
  {
   return Transaction::where('sender', $address)->get();
  }
}
