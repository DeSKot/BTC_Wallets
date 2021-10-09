<?php

namespace App\Providers\Transactions;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\Transactions\MakingTransactionInterface;
use App\Services\Transactions\MakingTransaction;
use App\Interfaces\Transactions\TransactionServiceInterface;
use App\Services\Transactions\TransactionService;

class TransactionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    public $singletons = [
        TransactionServiceInterface::class => TransactionService::class
    ];
}
