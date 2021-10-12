<?php

namespace App\Interfaces\Transactions;

use Illuminate\Database\Eloquent\Collection;

interface TransactionServiceInterface
{
   public function index(): Collection;

   public function show($addres): Collection;
}
