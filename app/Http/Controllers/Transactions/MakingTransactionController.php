<?php

namespace App\Http\Controllers\Transactions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Models\Transaction;
use App\Interfaces\Transactions\MakingTransactionInterface;
use App\Interfaces\Wallets\ShowWalletInterface;
use App\Interfaces\Transactions\TransactionRecordInterface;
use App\Interfaces\Transactions\ShowTransactionInterface;


class MakingTransactionController extends Controller
{
    private MakingTransactionInterface $makeTransaction;
    private ShowWalletInterface $showWallets;
    private TransactionRecordInterface $recordTransaction;
    private ShowTransactionInterface $showTransaction;

    public function __construct(ShowTransactionInterface $showTransactionInterface, MakingTransactionInterface $makingTransactionInterface, ShowWalletInterface $showWalletInterface, TransactionRecordInterface $transactionRecordInterface)
    {
        $this->makeTransaction = $makingTransactionInterface;
        $this->showWallets = $showWalletInterface;
        $this->recordTransaction = $transactionRecordInterface;
        $this->showTransaction = $showTransactionInterface;
    }

    public function index()
    {
        $allWallets = $this->showWallets->index();
        $allTransactions = $this->showTransaction->index();

        return view('transactions.transactions', [
            'allWallets' => $allWallets,
            'allTransactions' => $allTransactions
        ]);
    }

    public function transaction(Request $request, Transaction $transaction)
    {
        try {
            $this->makeTransaction->transaction($request->input('myWallet', ''), $request->input('recipientWallet', ''), $request->input('amountOfBTC', ''));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
        try {
            $this->recordTransaction->create($request->input('myWallet', ''), $request->input('recipientWallet', ''), $request->input('amountOfBTC', ''), $transaction);
        } catch (\Throwable $th) {
            //throw $th;
        }
        return redirect()->back()->with('success', 'Транзакция успешно завершена');
    }
}
