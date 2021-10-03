<?php

namespace App\Http\Controllers\Wallets;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use App\Interfaces\Wallets\WalletTransactionInterface;
use App\Interfaces\Transactions\TransactionRecordInterface;

class WalletTransactionController extends Controller
{

    private WalletTransactionInterface $wallet;
    private TransactionRecordInterface $recordTransaction;

    public function __construct(WalletTransactionInterface $walletInterface, TransactionRecordInterface $transactionRecordInterface)
    {
        $this->wallet = $walletInterface;
        $this->recordTransaction = $transactionRecordInterface;
    }
    public function transactionInDB(Request $request, Transaction $transaction): RedirectResponse
    {
        $myWallet = $request->input('myWallet', '');
        $recipientWallet = $request->input('recipientWallet', '');
        $amountOfBTC = $request->input('amountOfBTC', '');

        try {
            $this->wallet->transactionInDB($myWallet, $recipientWallet, $amountOfBTC);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }

        $this->recordTransaction->createInDB($myWallet, $recipientWallet, $amountOfBTC, $transaction);

        return redirect()->back()->with('success', 'Транзакция успешно завершена');
    }
}
