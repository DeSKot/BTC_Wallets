<?php

namespace Tests\Feature\Wallets;

use App\Models\User;
use App\Models\Wallet;
use App\Services\Wallets\WalletService;
use App\Interfaces\Currency\ExchangeCurrencyInterface;
use App\Services\Currency\ExchangeCurrency;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class WalletControllerTest extends TestCase
{
    public function setup():void
    {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
        $this->exchangeCurrencyMock = \Mockery::mock(ExchangeCurrencyInterface::class);
        $this->wallet = new WalletService($this->exchangeCurrencyMock);
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_indexScreenCanBeRendered()
    {   
         
        $auth = new class {
            public $id;
            public function __construct()
            {
                $this->id = 1;
            }
        };
        $exchangeCurrency = new ExchangeCurrency;
        $user = User::factory()->create();
        Auth::shouldReceive('user')->once()->andReturn($auth);
        Wallet::factory()->create();

        $wallets = $this->wallet->index();

        $view = $this->view('wallets.allWallets', [
            'allWallets' => $wallets,
            'currencyUSD' => $exchangeCurrency->exchangeCurrency()
        ]);

        foreach($wallets as $wallet){
            $view->assertSee($wallet['address']);
        }
    }
}
