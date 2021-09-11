<?php

namespace App\Interfaces\Wallets;

interface ShowWalletInterface {
  public function index(): mixed;

  public function show($address): array;
}