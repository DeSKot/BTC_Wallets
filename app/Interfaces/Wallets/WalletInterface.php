<?php

namespace App\Interfaces\Wallets;

use App\Models\Wallet;

interface WalletInterface {
  public function index(): mixed ;

  public function show($address): array ;

  public function create(Wallet $wallet): void;
}