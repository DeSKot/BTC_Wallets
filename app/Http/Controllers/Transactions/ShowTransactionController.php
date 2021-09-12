<?php

namespace App\Http\Controllers\Transactions;

use App\Http\Controllers\Controller;
use App\Interfaces\Transactions\ShowTransactionInterface;
use Illuminate\Contracts\View\View;

class ShowTransactionController extends Controller
{
    private ShowTransactionInterface $showTransaction;

    public function __construct(ShowTransactionInterface $showTransactionInterface)
    {
        $this->showTransaction = $showTransactionInterface;
    }

    public function show($address): View
    {
        $walletTransactions = $this->showTransaction->show($address);

        return view('transactions.showTransactions', [
            'walletTransactions' => $walletTransactions,
        ]);
    }
}
