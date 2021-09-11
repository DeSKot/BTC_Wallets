<?php

namespace App\Http\Controllers\Transactions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\Transactions\MakingTransactionInterface;

class MakingTransactionController extends Controller
{
    private MakingTransactionInterface $transaction;

    public function __construct(MakingTransactionInterface $makingTransactionInterface)
    {
        $this->transaction = $makingTransactionInterface;
    }

    public function transaction()
    {
        $this->transaction->transaction();
        return view('transactions.transactions');
    }
}
