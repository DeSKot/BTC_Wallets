<?php

namespace App\Interfaces\Transactions;

interface TransactionServiceInterface
{
   public function index(): mixed;

   public function show($addres): mixed;
}
