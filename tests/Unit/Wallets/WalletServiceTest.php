<?php

namespace Tests\Unit\Wallets;

use App\Models\Wallet;
use App\Services\Wallets\WalletService;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\Currency\ExchangeCurrencyServiceInterface;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;


class WalletServiceTest extends TestCase
{
     public function setUp():void
     {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
        $this->exchangeCurrencyMock = \Mockery::mock(ExchangeCurrencyServiceInterface::class);
        $this->wallet               = new WalletService($this->exchangeCurrencyMock);
    }
    /**
     * @return void
     */


    public function test_index_AllInfoAboutUserWallets_assertEquals()
    { 
        $auth = new class{
            public $id;
            public function __construct()
            {
                $this->id = 1;
            }
        };
        Auth::shouldReceive('user')->once()->andReturn($auth);
        Wallet::factory()->create();

        $expectedResult = app(Wallet::class)->where('user_id', $auth->id)->get();
        $testMethod     = $this->wallet->index();

        $this->assertEquals($expectedResult, $testMethod);
    }
    
    /**
     * @return void
     */
    public function test_show_oneInfoAboutOneUserWallet_assertEquals(){
        $this->exchangeCurrencyMock->shouldReceive('exchangeCurrency')->once()->andReturn(123456);
        $adrress = '7c88c513-8898-4619-8ff8-3945a02ccba6';
        $wallet  = Wallet::factory()->create ([
            'address' => $adrress,
        ]);
        $amountOfBTC = ((100 / 100000000) *  $wallet->amount_of_satoshi) / 100;

        $testWallet  = [
            'amountOfSatoshi' => $wallet->amount_of_satoshi,
            'amountOfBtc'     => $amountOfBTC,
            'amountOfUsd'     => $amountOfBTC * 123456,
            'address'         => $adrress,
        ];

        $walletArray = $this->wallet->show($adrress);

        $this->assertEquals($testWallet, $walletArray);
    }

    /**
     * @return void
     */
    public function test_create_saveNewWalletInDb_assertDatabaseHas(){
        $auth = new class{
            public $id;
            public function __construct()
            {
                $this->id = 1;
            }
        };
        
        User::factory()->create();
        Auth::shouldReceive('user')->once()->andReturn($auth);
        $walletMock = new Wallet;
        $wallet = Wallet::factory()->create([
            'user_id' => $auth->id,
        ]);

        $this->wallet->create($walletMock);

        $this->assertDatabaseHas('wallets', [
            'amount_of_satoshi' => $wallet->amount_of_satoshi,
            'user_id' => $auth->id,
            'address' => $wallet->address,
        ]);
    }
}
