<?php

namespace Tests\Unit\Transactions;

use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use App\Services\Transactions\TransactionRecord;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;
use Tests\TestAuthCase;

class TransactionRecordTest extends TestCase
{

    public function setUp():void
    {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
        $this->transactionRecord = new TransactionRecord();
        $this->transactionModel  = new Transaction;
        $this->testAuth          = new TestAuthCase;
    }
    /**
     * @return void
     */
    public function test_createInDB_saveTransactionInDb()
    {
        $amountOfTransaction = 11111;
        Auth::shouldReceive('user')->once()->andReturn($this->testAuth);
        $senderWallet = Wallet::factory()->create();
        $recipientWallet = Wallet::factory()->create();

        $this->transactionRecord->createInDB($senderWallet->address, $recipientWallet->address, $amountOfTransaction, $this->transactionModel);

        $this->assertDatabaseHas('transactions', [
            'sender' => $senderWallet->address,
            'recipient' => $recipientWallet->address,
            'amount_of_transaction' => $amountOfTransaction,
            'sender_Id' => $this->testAuth->id,
        ]);
    }
}
