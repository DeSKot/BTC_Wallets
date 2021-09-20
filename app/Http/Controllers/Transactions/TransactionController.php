<?php

namespace App\Http\Controllers\Transactions;

use App\Http\Controllers\Controller;
use App\Interfaces\Transactions\TransactionInterface;
use App\Interfaces\Wallets\WalletInterface;
use Illuminate\Contracts\View\View;

class TransactionController extends Controller
{

    private TransactionInterface $transaction;
    private WalletInterface $wallet;

    public function __construct(TransactionInterface $transactionInterface, WalletInterface $walletInterface)
    {
        $this->transaction = $transactionInterface;
        $this->wallet = $walletInterface;
    }

    public function index(): View
    {
        $allWallets = $this->wallet->index();
        $allTransactions = $this->transaction->index();

        return view('transactions.transactions', [
            'allWallets' => $allWallets,
            'allTransactions' => $allTransactions
        ]);
    }

    public function show($address): View
    {
        $walletTransactions = $this->transaction->show($address);

        return view('transactions.showTransactions', [
            'walletTransactions' => $walletTransactions,
        ]);
    }
}
