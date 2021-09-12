<?php

namespace App\Http\Controllers\Wallets;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\Wallets\ShowWalletInterface;
use Illuminate\Contracts\View\Factory;

use Illuminate\Contracts\View\View;

class ShowWalletsController extends Controller
{
    private ShowWalletInterface $wallet;

    public $address;

    public function __construct(ShowWalletInterface $showWalletInterface)
    {
        $this->wallet = $showWalletInterface;
    }

    public function index(): View
    {
        try {
            $allWallets = $this->wallet->index();
        } catch (\Throwable $th) {
            //throw $th;
        }
        return view('wallets.allWallets', [
            'allWallets' => $allWallets,
        ]);
    }
    public function show($address)
    {
        try {
            $wallet_array = $this->wallet->show($address);
        } catch (\Throwable $th) {
            //throw $th;
        }
        return view('wallets.oneWallet', [
            'address' => $wallet_array['address'],
            'amount_of_BTC' => $wallet_array['amount_of_BTC'],
            'amount_of_USD' => $wallet_array['amount_of_USD']
        ]);
    }
}
