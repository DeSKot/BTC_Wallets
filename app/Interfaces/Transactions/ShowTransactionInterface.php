<?php

namespace App\Interfaces\Transactions;

interface ShowTransactionInterface
{
   public function index(): mixed;

   public function show($addres): mixed;
}
