<?php

namespace App\Services\Transactions;

use App\Interfaces\Transactions\ShowTransactionInterface;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class ShowTransactions implements ShowTransactionInterface
{

  public function index()
  {
    $allTransactions = Transaction::where('sender_Id', Auth::user()->id)->get();;

    return $allTransactions;
  }

  public function show($address)
  {

    $walletTransactions = Transaction::where('sender', $address)->get();

     /*$transaction_array = [
      'updated_at' => Transaction::where('sender' , $address)->value('updated_at'),
      'recipient' => Transaction::where('sender' , $address)->value('recipient')->get(), 
      'amount_of_transaction' => Transaction::where('sender' , $address)->value('amount_of_transaction'),
      'sender' => $address
    ];*/

    return $walletTransactions;
  }
}
