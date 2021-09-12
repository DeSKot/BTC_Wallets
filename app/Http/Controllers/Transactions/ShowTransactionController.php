<?php

namespace App\Http\Controllers\Transactions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\Transactions\ShowTransactionInterface;

class ShowTransactionController extends Controller
{
    private ShowTransactionInterface $showTransaction;
    private  $address;

    public function __construct(ShowTransactionInterface $showTransactionInterface)
    {
        $this->showTransaction = $showTransactionInterface;
    }

    public function show($address)
    {
        $walletTransactions = $this->showTransaction->show($address);

        return view('transactions.showTransactions', [
            'walletTransactions' => $walletTransactions,
        ]);
    }
}
