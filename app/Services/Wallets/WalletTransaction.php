<?php

namespace App\Services\Wallets;

use App\Models\Wallet;
use App\Interfaces\Wallets\WalletTransactionInterface;
use App\Exceptions\Transaction\NotEnoughMoneyException;
use App\Exceptions\Transaction\InvalidAddressException;
use App\Exceptions\Transaction\CanNotSendZeroException;
use App\Exceptions\Transaction\CannotSendToTheSameWalletException;
use Illuminate\Support\Facades\DB;

class WalletTransaction implements WalletTransactionInterface
{
  public function transactionInDB(string $myWallet, string $recipientWallet, string $amountOfBTC): void
  {
    throw_unless(Wallet::where('address', $myWallet)->value('address'), InvalidAddressException::class, 'Не коректный адрес кошелька отправителя');
    throw_unless(Wallet::where('address', $recipientWallet)->value('address'), InvalidAddressException::class, 'Не коректный адрес кошелька получателя');
    throw_if($myWallet == $recipientWallet, CannotSendToTheSameWalletException::class, 'Нельзя отправить BTC на тот же кошелек');
    throw_if($amountOfBTC == 0, CanNotSendZeroException::class, 'Невозможно отправить ноль BTC');

    DB::transaction(function () use($myWallet, $recipientWallet, $amountOfBTC)
    {
    Wallet::whereIn('address', [$myWallet, $recipientWallet])->lockForUpdate();
    $percent = $amountOfBTC * 0.15 + $amountOfBTC;
    $wallets = Wallet::whereIn('address', [$myWallet, $recipientWallet])->get();
    $myWalletData = $wallets[0];
    $recipientWalletData = $wallets[1];

    $amountOfMyBTC = $myWalletData["amount_of_satoshi"];
    $userIdOfSender = $myWalletData["user_id"];
    $userIdOfRecipient = $recipientWalletData["user_id"];

    if ($userIdOfSender !== $userIdOfRecipient) 
    {
      throw_if($amountOfMyBTC - $percent < 0, NotEnoughMoneyException::class, 'Не достаточно Satoshi на кошельке.Пополните кошелек');
      Wallet::where('address', $myWallet)->decrement('amount_of_satoshi', $amountOfBTC + $percent);
      Wallet::where('address', $recipientWallet)->increment('amount_of_satoshi', $amountOfBTC);
    } else 
    {
      throw_if($amountOfMyBTC - $amountOfBTC < 0, NotEnoughMoneyException::class, 'Не достаточно Satoshi на кошельке.Пополните кошелек');
      Wallet::where('address', $myWallet)->decrement('amount_of_satoshi', $amountOfBTC);
      Wallet::where('address', $recipientWallet)->increment('amount_of_satoshi', $amountOfBTC);
    }
    });
  }
}
