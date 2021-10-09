<?php

namespace Tests\Feature\Wallets;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Interfaces\Wallets\WalletTransactionInterface;
use App\Interfaces\Transactions\TransactionRecordInterface;
use App\Http\Controllers\Wallets\WalletTransactionController;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use Mockery\MockInterface;
use Illuminate\Support\Facades\Auth;

class WalletTransactionControllerTest extends TestCase
{
    public function setUp(): void{

        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
         $this->walletTransactionMock       = $this->createMock(WalletTransactionInterface::class);
         $this->transactionRecordMock       = $this->createMock(TransactionRecordInterface::class);
         $this->requestMock                 = $this->createMock(Request::class);
         $this->transactionMock             = $this->createMock(Transaction::class);
         $this->request                     = new Request;
         $this->walletTransactionController = new WalletTransactionController($this->walletTransactionMock,$this->transactionRecordMock);
    }
    /** 
     * @return void
     */
    public function test_transactionInDbController()
    {

        $auth = new class {
            public $id;
            public function __construct()
            {
                $this->id = 1;
            }
        };

        Auth::shouldReceive('user')->andReturn($auth);

        Wallet::factory()->create([
            'address' => 'abc'
        ]);
        Wallet::factory()->create([
            'address' =>  'asd'
        ]);

        $requestMock = $this->mock(Request::class, function (MockInterface $requestMock) {
            $requestMock->shouldReceive('input')->with('myWallet', '')->andReturn('abc');
            $requestMock->shouldReceive('input')->with('recipientWallet', '')->andReturn('asd');
            $requestMock->shouldReceive('input')->with('amountOfBTC', '')->andReturn(123);
        });

        $this->transactionRecordMock->expects($this->once())->method('createInDB')->with('abc','asd', 123, $this->transactionMock);
        $this->walletTransactionMock->expects($this->once())->method('transactionInDB')->with('abc','asd', 123);
        $this->walletTransactionController->transactionInDB($requestMock,$this->transactionMock);
        
        //test, route name is real
        $response = $this->post('/transaction');
        $response->assertStatus(302);

        $response->assertSessionHas('success', 'Транзакция успешно завершена');
    }
     /** 
     * @return void
     */
    public function test_transactionInDbControllerException(){
        
        $auth = new class {
            public $id;
            public function __construct()
            {
                $this->id = 1;
            }
        };

        Auth::shouldReceive('user')->andReturn($auth);

        Wallet::factory()->create([
            'address' => 'abc'
        ]);
        Wallet::factory()->create([
            'address' =>  'asd'
        ]);

        $this->mock(Request::class, function (MockInterface $requestMock) {
            $requestMock->shouldReceive('input')->with('myWallet', '')->andReturn('abc');
            $requestMock->shouldReceive('input')->with('recipientWallet', '')->andReturn('asd');
            $requestMock->shouldReceive('input')->with('amountOfBTC', '')->andReturn(100000000000);
        });

        $response = $this->post('/transaction');

        $response->assertSessionHas('error', 'Не достаточно BTC на кошельке.Пополните кошелек');
    }
}