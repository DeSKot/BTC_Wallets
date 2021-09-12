<?php

namespace App\Http\Controllers\Wallets;

use App\Http\Controllers\Controller;
use App\Interfaces\Wallets\ShowWalletInterface;
use App\Interfaces\Currency\ExchangeCurrencyInterface;


use Illuminate\Contracts\View\View;

class ShowWalletsController extends Controller
{
    private ShowWalletInterface $wallet;
    private ExchangeCurrencyInterface $currency;

    public $address;

    public function __construct(ShowWalletInterface $showWalletInterface, ExchangeCurrencyInterface $exchangeCurrencyInterface)
    {
        $this->wallet = $showWalletInterface;
        $this->currency = $exchangeCurrencyInterface;
    }

    public function index(): View
    {
        try {
            $allWallets = $this->wallet->index();
            $currencyUSD = $this->currency->exchangeCurrency();
        } catch (\Throwable $th) {
            //throw $th;
        }
        return view('wallets.allWallets', [
            'allWallets' => $allWallets,
            'currencyUSD' => round($currencyUSD, 2),
        ]);
    }
    public function show($address): View
    {
        try {
            $walletArray = $this->wallet->show($address);
            $currencyUSD = $this->currency->exchangeCurrency();
        } catch (\Throwable $th) {
            //throw $th;
        }
        return view('wallets.oneWallet', [
            'address' => $walletArray['address'],
            'amount_of_BTC' => $walletArray['amount_of_BTC'],
            'amount_of_USD' => round($currencyUSD, 2),
        ]);
    }
}
