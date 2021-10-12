<?php

namespace Tests\Unit\Wallets;

use App\Models\Wallet;
use App\Services\Wallets\WalletService;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\Currency\ExchangeCurrencyServiceInterface;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;
use Tests\TestAuthCase;
use App\Exceptions\Wallet\ToManyWalletsException;

class WalletServiceTest extends TestCase
{
     public function setUp():void
     {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
        $this->exchangeCurrencyMock = \Mockery::mock(ExchangeCurrencyServiceInterface::class);
        $this->wallet               = new WalletService($this->exchangeCurrencyMock);
        $this->testAuth             = new TestAuthCase;
    }
    /**
     * @return void
     */
    public function test_index_AllInfoAboutUserWallets()
    { 
        Auth::shouldReceive('user')->andReturn($this->testAuth);
        Wallet::factory()->create();

        $expectedResult = app(Wallet::class)->where('user_id', $this->testAuth->id)->get();
        $expectedErrorResult = app(Wallet::class)->where('user_id', 12)->get();
        $testMethod     = $this->wallet->index();

        $this->assertEquals($expectedResult, $testMethod);
        $this->assertNotEquals($expectedErrorResult, $testMethod);
    }
    /**
     * @return void
     */
    public function test_show_oneInfoAboutOneUserWallet()
    {
        $this->exchangeCurrencyMock->shouldReceive('exchangeCurrency')->andReturn(123456);
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
    public function test_create_saveNewWalletInDb()
    {
        User::factory()->create();
        Auth::shouldReceive('user')->andReturn($this->testAuth);
        $walletMock = new Wallet;
        $wallet = Wallet::factory()->create([
            'user_id' => $this->testAuth->id,
        ]);

        $this->wallet->create($walletMock);

        $this->assertDatabaseHas('wallets', [
            'amount_of_satoshi' => $wallet->amount_of_satoshi,
            'user_id' => $this->testAuth->id,
            'address' => $wallet->address,
        ]);

        $wallet = Wallet::factory()->count(10)->create([
            'user_id' => $this->testAuth->id,
        ]);
        
        $this->expectException(ToManyWalletsException::class);
        $this->wallet->create($walletMock);
    }
}
