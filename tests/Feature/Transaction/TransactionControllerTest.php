<?php

namespace Tests\Feature\Transaction;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\Transactions\TransactionServiceInterface;
use App\Interfaces\Wallets\WalletServiceInterface;
use App\Http\Controllers\Transactions\TransactionController;
use Tests\TestCase;

class TransactionControllerTest extends TestCase
{
    public function setUp():void{
        parent::setUp();

        $this->transactionServiceMock    = $this->createMock(TransactionServiceInterface::class);
        $this->waletServiceMock          = $this->createMock(WalletServiceInterface::class);
        $this->transactionControllerMock = new TransactionController($this->transactionServiceMock,$this->waletServiceMock);
    }
    /**
     * @return void
     */
    public function test_indexTransactionController()
    {
        ob_end_flush();
        
        $auth = new class {
            public $id;
            public function __construct()
            {
                $this->id = 1;
            }
        };

        Auth::shouldReceive('user')->andReturn($auth);
        //test. route name is real
        $response = $this->get('/transaction');
        $response->assertStatus(200);
        //test, check call methodes in method Index  TransactionController
        $this->transactionServiceMock->expects($this->once())->method('index');
        $this->waletServiceMock->expects($this->once())->method('index');

        $this->transactionControllerMock->index();
        //test, check view and do we you use info on the page from INDEX method TransactionServiceInterface
        $view = $this->view('transactions.transactions',[
            'allWallets' => collect([
                new class {
                    public $address;
                    public function __construct(){
                        $this->address = 'qwerty';
                    }
                },
            ]),
            'allTransactions' => collect([
                new class{
                    public $sender;
                    public $recipient;
                    public $amount_of_transaction;
                    public $updated_at;
                    public function __construct()
                    {
                        $this->sender = 'asdfg';
                        $this->recipient = 'zxcvb';
                        $this->amount_of_transaction = 100;
                        $this->updated_at = '12.12.12';
                    }
                }
            ])
        ]);

        $view->assertSee('qwerty');
        $view->assertSee('asdfg');
        $view->assertSee('zxcvb');
        $view->assertSee(100);
        $view->assertSee('12.12.12');

        ob_get_clean();
    }
        /**
     * @return void
     */
    public function test_showTransactionController(){
        ob_end_flush();
        //test, check call methode show in method show TransactionController
        $this->transactionServiceMock->expects($this->once())->method('show');

        $this->transactionControllerMock->show('abc');
        //test. route name is real
        $response = $this->get('/wallets/abc/transaction');
        $response->assertStatus(200);
        //test, check view and do we use info on the page from SHOW method TransactionServiceInterface
        $view = $this->view('transactions.showTransactions',[
            'walletTransactions' => collect([
                            new class{
                    public $sender;
                    public $recipient;
                    public $amount_of_transaction;
                    public $updated_at;
                    public function __construct()
                    {
                        $this->sender = 'abc';
                        $this->recipient = 'asd';
                        $this->amount_of_transaction = 100;
                        $this->updated_at = '12/12/12';
                    }
                }
        ])
        ]);
        $view->assertSee('abc');
        $view->assertSee('asd');
        $view->assertSee(100);
        $view->assertSee('12/12/12');

        ob_get_clean();
    }
}
