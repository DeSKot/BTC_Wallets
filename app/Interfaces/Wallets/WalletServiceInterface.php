<?php

namespace App\Interfaces\Wallets;

use App\Models\Wallet;
use Illuminate\Database\Eloquent\Collection;

interface WalletServiceInterface 
{
  public function index(): Collection;

  public function show($address): array;

  public function create(Wallet $wallet): void;
}