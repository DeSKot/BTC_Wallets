<?php

namespace App\Interfaces\Transactions;

interface TransactionInterface
{
   public function index(): mixed;

   public function show($addres): mixed;
}
