<?php

namespace App\Providers\Transactions;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\Transactions\MakingTransactionInterface;
use App\Services\Transactions\MakingTransaction;
use App\Interfaces\Transactions\ShowTransactionInterface;
use App\Services\Transactions\ShowTransactions;

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
        MakingTransactionInterface::class => MakingTransaction::class,
        ShowTransactionInterface::class => ShowTransactions::class
    ];
}
