<?php

namespace App\Http\Controllers\Wallets;

use App\Http\Controllers\Controller;
use App\Interfaces\Wallets\WalletInterface;
use App\Interfaces\Currency\ExchangeCurrencyInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use App\Models\Wallet;




class WalletController extends Controller
{
    private WalletInterface $wallet;
    private ExchangeCurrencyInterface $exchangeCurrency;

    public function __construct(WalletInterface $walletInterface, ExchangeCurrencyInterface $exchangeCurrencyInterface)
    {
        $this->wallet = $walletInterface;
        $this->exchangeCurrency = $exchangeCurrencyInterface;
    }


    public function index(): View
    {
        $allWallets = $this->wallet->index();
        $currencyUSD = $this->exchangeCurrency->exchangeCurrency();

        return view('wallets.allWallets', [
            'allWallets' => $allWallets,
            'currencyUSD' => $currencyUSD,
        ]);
    }



    public function show($address): View
    {
        $walletArray = $this->wallet->show($address);

        return view('wallets.oneWallet', [
            'address' => $walletArray['address'],
            'amountOfSatoshi' => $walletArray['amountOfSatoshi'],
            'amountOfUsd' => $walletArray['amountOfUsd'],
            'amountOfBtc' => $walletArray['amountOfBtc']
        ]);
    }



    public function create(Wallet $wallet): RedirectResponse
    {
        $this->wallet->create($wallet);

        return redirect()->back()->with('Success', 'Кошелек успешно создан');
    }
}
