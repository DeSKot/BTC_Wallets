<?php

namespace Tests\Feature\Wallets;

use App\Http\Controllers\Wallets\WalletController;
use App\Models\Wallet;
use App\Interfaces\Currency\ExchangeCurrencyServiceInterface;
use App\Interfaces\Wallets\WalletServiceInterface;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class WalletControllerTest extends TestCase
{
    protected function setup():void
    {
        parent::setUp();
        
        $this->exchangeCurrencyMock = $this->createMock(ExchangeCurrencyServiceInterface::class);
        $this->walletServiceMock    = $this->createMock(WalletServiceInterface::class);
        $this->wallet               = $this->createMock(Wallet::class);
        $this->walletController     = new WalletController($this->walletServiceMock, $this->exchangeCurrencyMock);
    }
    /**
     *
     * @return void
     */
    public function test_indexScreenCanBeRendered()
    {   
        ob_end_flush();
        
        $auth = new class {
            public $id;
            public function __construct()
            {
                $this->id = 1;
            }
        };
        Auth::shouldReceive('user')->once()->andReturn($auth);
        //testing route name is real
        $response = $this->get('/wallets');
        $response->assertStatus(200);

        //test call this methodes in testing method
        $this->walletServiceMock->expects($this->once())->method('index');
        $this->exchangeCurrencyMock->expects($this->once())->method('exchangeCurrency');
        $this->walletController->index();

        //test use info from the methode on the page 
            
        $view = $this->view('wallets.allWallets', [
            'allWallets' =>  collect([
            new class{
                public $address;
                public $amount_of_satoshi;
                public function __construct()
                {
                $this->address = 'qwerty';
                $this->amount_of_satoshi = 123;
                }
            }
            ]),
            'currencyUSD' => 456,
        ]);

        $view->assertSee(123);
        $view->assertSee('qwerty');
        ob_get_clean();
    }
    /**
     * @return void
     */
    public function test_showScreenCanBeRendered(){

        ob_get_clean();

         $this->walletServiceMock->method('show')->willReturn([
            'amountOfSatoshi' => 100000,
            'amountOfUsd'     => 4500000,
            'amountOfBtc'     => 1,
            'address'         => 'abc'
        ]);

        //test, call service method "show" in WalletController show method 
         $this->walletServiceMock->expects($this->once())->method('show')->with('abc');
         $this->walletController->show('abc');

        //test, route name is real
        $response = $this->get("/wallets/abc");
        $response->assertStatus(200);

        //test, use info from the methode on the page 
        $view = $this->view('wallets.oneWallet',[
            'address'         => 'abc',
            'amountOfSatoshi' => 10000,
            'amountOfUsd'     => 4500000,
            'amountOfBtc'     => 1
        ]);

        $view->assertSee(10000);
        $view->assertSee(4500000);
        $view->assertSee(1);
        $view->assertSee('abc');

        ob_get_clean();
    }

    /**
     * @return void
     */
    public function test_create_ScreenCanBeRendered(){
        $auth = new class {
            public $id;

            public function __construct()
            {
                $this->id = 1;
            }
        };
        Auth::shouldReceive('user')->once()->andReturn($auth);
        //test route name is real
        $response = $this->get('/create_wallet');
        $response->assertStatus(302);

        //test call service method "create" in WalletController create method 
        $this->walletServiceMock->expects($this->once())->method('create')->with($this->wallet);
        $this->walletController->create($this->wallet);
        //test redirection
        $response->assertSessionHas('Success', 'Кошелек успешно создан');
    }
    /**
     * @return void
     */
    public function test_create_ScreenCanBeRendered_Exception(){
                $auth = new class {
            public $id;

            public function __construct()
            {
                $this->id = 1;
            }
        };
        Auth::shouldReceive('user')->once()->andReturn($auth);
        Wallet::factory()->count(10)->create([
            'user_id' => 1
        ]);
        //test route name is real
        $response = $this->get('/create_wallet');
        $response->assertStatus(302);

        //test call service method "create" in WalletController create method 
        $this->walletServiceMock->expects($this->once())->method('create')->with($this->wallet);
        $this->walletController->create($this->wallet);
        //test redirection
        $response->assertSessionHas('Error', 'У вас слишком много кошельков, дозволено максимум 10');
    }
}

