<?php

namespace App\Services\Transactions;

use App\Interfaces\Transactions\TransactionServiceInterface;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class TransactionService implements TransactionServiceInterface
{

  public function index(): Collection
  {
    return Transaction::where('sender_Id', Auth::user()->id)->get();
  }

  public function show($address): Collection
  {
   return Transaction::where('sender', $address)->get();
  }
}
