<?php

namespace App\Interfaces\Wallets;

use App\Models\Wallet;

interface WalletServiceInterface {
  public function index(): mixed ;

  public function show($address): array ;

  public function create(Wallet $wallet): void;
}