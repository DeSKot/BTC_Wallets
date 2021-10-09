<?php

namespace App\Http\Controllers\Wallets;

use App\Http\Controllers\Controller;
use App\Interfaces\Wallets\WalletServiceInterface;
use App\Interfaces\Currency\ExchangeCurrencyServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use App\Models\Wallet;




class WalletController extends Controller
{
    private WalletServiceInterface $walletService;
    private ExchangeCurrencyServiceInterface $exchangeCurrency;

    public function __construct(WalletServiceInterface $walletServiceInterface, ExchangeCurrencyServiceInterface $exchangeCurrencyInterface)
    {
        $this->walletService = $walletServiceInterface;
        $this->exchangeCurrency = $exchangeCurrencyInterface;
    }


    public function index(): View
    {
        return view('wallets.allWallets', [
            'allWallets' => $this->walletService->index(),
            'currencyUSD' => $this->exchangeCurrency->exchangeCurrency(),
        ]);
    }

    public function show($address): View
    {
        $walletArray = $this->walletService->show($address);

        return view('wallets.oneWallet', [
            'address' => $walletArray['address'],
            'amountOfSatoshi' => $walletArray['amountOfSatoshi'],
            'amountOfUsd' => $walletArray['amountOfUsd'],
            'amountOfBtc' => $walletArray['amountOfBtc']
        ]);
    }

    public function create(Wallet $wallet): RedirectResponse
    {
        try {
            $this->walletService->create($wallet);
        } catch (\Throwable $th) {
             return redirect()->back()->with('Error', $th->getMessage());
        }
        return redirect()->back()->with('Success', 'Кошелек успешно создан');
    }
}
