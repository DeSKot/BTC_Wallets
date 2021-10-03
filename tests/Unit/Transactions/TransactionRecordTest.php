<?php

namespace Tests\Unit\Transactions;

use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use App\Services\Transactions\TransactionRecord;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;

class TransactionRecordTest extends TestCase
{
        public function setUp():void
    {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
        $this->transactionRecord = new TransactionRecord();
        $this->transactionModel = new Transaction;
    }
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_createInDB_saveTransactionInDb_()
    {
        $auth = new class{
            public $id;
            public function __construct()
            {
                $this->id = 1;
            }
        };

        $amountOfTransaction = 11111;
        Auth::shouldReceive('user')->once()->andReturn($auth);
        $senderWallet = Wallet::factory()->create();
        $recipientWallet = Wallet::factory()->create();

         $this->transactionRecord->createInDB($senderWallet->address, $recipientWallet->address,$amountOfTransaction, $this->transactionModel );
        
         $this->assertDatabaseHas('transactions', [
            'sender' => $senderWallet->address,
            'recipient' => $recipientWallet->address,
            'amount_of_transaction' => $amountOfTransaction,
            'sender_Id' => $auth->id,
         ]);
    }
}
