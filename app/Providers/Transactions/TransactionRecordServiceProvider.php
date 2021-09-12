<?php

namespace App\Providers\Transactions;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\Transactions\TransactionRecordInterface;
use App\Services\Transactions\TransactionRecord;

class TransactionRecordServiceProvider extends ServiceProvider
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
        TransactionRecordInterface::class => TransactionRecord::class,
    ];
}
