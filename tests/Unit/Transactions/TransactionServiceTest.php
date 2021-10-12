<?php

namespace Tests\Unit\Transactions;

use App\Models\Transaction;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use App\Services\Transactions\TransactionService;
use Tests\TestAuthCase;

class TransactionServiceTest extends TestCase
{
    public function setUp():void
    {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
        $this->transactionService = new TransactionService;
        $this->testAuth           = new TestAuthCase;
    }
    /**
     * @return void
     */
    public function test_show_getArrayOfAllWalletTransactionsOfUser()
    {
        Transaction::factory()->count(5)->create();
        Auth::shouldReceive('user')->once()->andReturn($this->testAuth);

        $expectedResult = app(Transaction::class)->where('sender_Id',$this->testAuth->id)->get();
        $testMethod = $this->transactionService->index();

        $this->assertEquals($expectedResult,$testMethod);
    }
    /**
     * @return void
     */
    public function test_show_getArrayOfOneWalletTransactionsOfUser()
    {   //make variables
        $address = 'address';
        //make fake model
        Transaction::factory()->count(5)->create([
            'sender' => $address,
        ]);
        //call fake db and call testing method 
        $expectedResult = app(Transaction::class)->where('sender', $address)->get();
        $testMethod = $this->transactionService->show($address);
        
        $this->assertEquals($expectedResult,$testMethod);
    }
}
