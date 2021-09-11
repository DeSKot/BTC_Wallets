<?php

namespace App\Http\Controllers\Wallets;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Interfaces\Wallets\CreateWalletInterface;
use Illuminate\Http\RedirectResponse;

class CreateWalletController extends Controller
{
    private CreateWalletInterface $wallet;

    public function __construct(CreateWalletInterface $walletInterface)
    {
        $this->wallet = $walletInterface;
    }

    public function create(Wallet $wallet): RedirectResponse
    {
        try {
            $this->wallet->createWallet($wallet);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
        return redirect()->back()->with('Success', 'Кошелек успешно создан');
    }
}
