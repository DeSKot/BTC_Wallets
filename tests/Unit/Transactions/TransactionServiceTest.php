<?php

namespace Tests\Unit\Transactions;

use App\Models\Transaction;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use App\Services\Transactions\TransactionService;

class TransactionServiceTest extends TestCase
{
    public function setUp():void
    {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
        $this->transactionService = new TransactionService();
    }
    /**
     * @return void
     */
    public function test_show_getArrayOfAllWalletTransactionsOfUser_assertEquals()
    {
        $auth = new class{
            public $id;
            public function __construct()
            {
                $this->id = 1;
            }
        };

        Transaction::factory()->count(5)->create();
        Auth::shouldReceive('user')->once()->andReturn($auth);

        $expectedResult = app(Transaction::class)->where('sender_Id',$auth->id)->get();
        $testMethod = $this->transactionService->index();

        $this->assertEquals($expectedResult,$testMethod);
    }
    /**
     * @return void
     */
    public function test_show_getArrayOfOneWalletTransactionsOfUser_assertEquals()
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
