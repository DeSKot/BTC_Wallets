<?php

namespace App\Http\Controllers\Transactions;

use App\Http\Controllers\Controller;
use App\Interfaces\Transactions\TransactionServiceInterface;
use App\Interfaces\Wallets\WalletServiceInterface;
use Illuminate\Contracts\View\View;

class TransactionController extends Controller
{

    private TransactionServiceInterface $transactionService;
    private WalletServiceInterface $walletService;

    public function __construct(TransactionServiceInterface $transactionInterface, WalletServiceInterface $walletServiceInterface)
    {
        $this->transactionService = $transactionInterface;
        $this->walletService = $walletServiceInterface;
    }

    public function index(): View
    {
        return view('transactions.transactions', [
            'allWallets' => $this->walletService->index(),
            'allTransactions' => $this->transactionService->index()
        ]);
    }

    public function show($address): View
    {
        return view('transactions.showTransactions', [
            'walletTransactions' => $this->transactionService->show($address),
        ]);
    }
}
