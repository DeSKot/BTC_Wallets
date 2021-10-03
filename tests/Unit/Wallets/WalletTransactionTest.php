<?php

namespace Tests\Unit\Wallets;

//use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use App\Models\Wallet;
use Illuminate\Support\Facades\Artisan;
use App\Services\Wallets\WalletTransaction;
use App\Exceptions\Transaction\CannotSendToTheSameWalletException;
use App\Exceptions\Transaction\CanNotSendZeroException;
use App\Exceptions\Transaction\NotEnoughMoneyException;



class WalletTransactionTest extends TestCase
{
         public function setUp():void
     {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
        $this->senderWallet = Wallet::factory()->create();
        $this->walletTransaction = new WalletTransaction();
    }
    /**
     * @return void
     */
    public function test_transactionInDb_makeTransactionWalletOnSameUser_saveChanges()
    {   
        $resepientWallet = Wallet::factory()->create([
            'user_id' => 1
        ]);
        // Variables for test
        $satoshiAmount = 11111;
        $senderAddress = $this->senderWallet->address;
        $resepientAddress = $resepientWallet->address;
         //Make calculation of Fake Wallet
        $changeAmoundOfSender = $this->senderWallet->amount_of_satoshi - $satoshiAmount;
        $changeAmountOfResepient = $resepientWallet->amount_of_satoshi + $satoshiAmount;
         // Call  transaction method
        $this->walletTransaction->transactionInDB($senderAddress,$resepientAddress,$satoshiAmount);
         //check assert changes wallets in DB
        $this->assertDatabaseHas('wallets', [
            'amount_of_satoshi' => $changeAmoundOfSender,
            'amount_of_satoshi' => $changeAmountOfResepient,
        ]);
    }
    /**
     * @return void
     */
    public function test_transactionInDb_makeTransactionWalletOnAnotherUser_saveChanges()
    {   
        $resepientWallet = Wallet::factory()->create();
        // Variables for test
        $satoshiAmount = 11111;
        $percent = $satoshiAmount * 0.15 + $satoshiAmount;
         //Make calculation of Fake Wallet
        $changeAmoundOfSender = $this->senderWallet->amount_of_satoshi - $satoshiAmount + $percent;
        $changeAmountOfResepient = $resepientWallet->amount_of_satoshi + $satoshiAmount;
         // Call  transactionInDB method
        $this->walletTransaction->transactionInDB($this->senderWallet->address,$resepientWallet->address,$satoshiAmount);
         //check assert changes wallets in DB
        $this->assertDatabaseHas('wallets', [
            'amount_of_satoshi' => $changeAmoundOfSender,
            'amount_of_satoshi' => $changeAmountOfResepient,
        ]);
    }
    /**
     * @return void
     */
    public function test_transactionInDb_expectCannotSendToTheSameWalletException_throwException(){
        $this->expectException(CannotSendToTheSameWalletException::class);
        $this->walletTransaction->transactionInDB($this->senderWallet->address,$this->senderWallet->address, 11111);
    }   
     /**
     * @return void
     */
    public function test_transactionInDb_expectCanNotSendZeroException_throwException(){
        $resepientWallet = Wallet::factory()->create();
        $this->expectException(CanNotSendZeroException::class);
        $this->walletTransaction->transactionInDB($this->senderWallet->address,$resepientWallet->address, 0);
    }    
    /**
     * @return void
     */
    public function test_transactionInDb_expectInvalidAddressExceptionMessageAboutSender_throwException(){
        $resepientWallet = Wallet::factory()->create();
        $this->expectExceptionMessage('Не коректный адрес кошелька отправителя');
        $this->walletTransaction->transactionInDB('address',$resepientWallet->address, 11111);
    }
    /**
     * @return void
     */
    public function test_transactionInDb_expectInvalidAddressExceptionMessageAboutResepient_throwException(){
        $this->expectExceptionMessage('Не коректный адрес кошелька получателя');
        $this->walletTransaction->transactionInDB($this->senderWallet->address,'address', 11111);
    }
    /**
     * @return void
     */
    public function test_transactionInDb_expectNotEnoughMoneyException_throwException(){
        $resepientWallet = Wallet::factory()->create();
         $this->expectException( NotEnoughMoneyException::class);
        $this->walletTransaction->transactionInDB($this->senderWallet->address,$resepientWallet->address, 9999999);
    }
}
