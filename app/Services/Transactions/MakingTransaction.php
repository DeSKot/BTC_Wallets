<?php

namespace App\Services\Transactions;

use App\Interfaces\Transactions\MakingTransactionInterface;
use App\Models\Wallet;
use App\Exceptions\Transaction\NotEnoughMoney;
use App\Exceptions\Transaction\InvalidAddressException;
use App\Exceptions\Transaction\CanNotSendZeroException;
use App\Exceptions\Transaction\CannotSendToTheSameWalletException;

class MakingTransaction implements MakingTransactionInterface
{

  public function transaction(string $myWallet, string $recipientWallet, string $amountOfBTC): void
  {
    $amountOfMyBTC = Wallet::where('address', $myWallet)->value('amount_of_BTC');
    $amountOfRecipientBTC = Wallet::where('address', $recipientWallet)->value('amount_of_BTC');
    $userIdOfSender = Wallet::where('address', $myWallet)->value('id_of_user');
    $userIdOfRecipient = Wallet::where('address', $recipientWallet)->value('id_of_user');

    throw_unless(Wallet::where('address', $myWallet)->value('address'), InvalidAddressException::class, 'Не коректный адрес кошелька отправителя');
    throw_unless(Wallet::where('address', $recipientWallet)->value('address'), InvalidAddressException::class, 'Не коректный адрес кошелька получателя');
    throw_if($myWallet == $recipientWallet, CannotSendToTheSameWalletException::class, 'Нельзя отправить BTC на тот же кошелек');
    throw_if($amountOfBTC == 0, CanNotSendZeroException::class, 'Невозможно отправить ноль BTC');

    if ($userIdOfSender !== $userIdOfRecipient) { //я думаю нада розделить еще на два сервиса но я не уверен по сути можно сделать 1) для процентов 2) между собой) 3) реализация условия
      throw_if($amountOfMyBTC - ($amountOfBTC * 0.15 + $amountOfBTC) < 0, NotEnoughMoney::class, 'Не достаточно BTC на кошельке.Пополните кошелек');
      Wallet::where('address', $myWallet)->update(['amount_of_BTC' => $amountOfMyBTC - ($amountOfBTC * 0.15 + $amountOfBTC)]);
      Wallet::where('address', $recipientWallet)->update(['amount_of_BTC' => $amountOfBTC + $amountOfRecipientBTC]);
    } else {
      throw_if($amountOfMyBTC - $amountOfBTC < 0, NotEnoughMoney::class, 'Не достаточно BTC на кошельке.Пополните кошелек');
      Wallet::where('address', $myWallet)->update(['amount_of_BTC' => $amountOfMyBTC - $amountOfBTC]);
      Wallet::where('address', $recipientWallet)->update(['amount_of_BTC' => $amountOfBTC + $amountOfRecipientBTC]);
    }
  }
}
