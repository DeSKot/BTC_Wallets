<?php

namespace App\Services\Transactions;

use App\Interfaces\Transactions\MakingTransactionInterface;
use App\Models\Wallet;
use App\Exceptions\Transaction\NotEnoughMoney;
use App\Exceptions\Transaction\InvalidAddressException;
use App\Exceptions\Transaction\CanNotSendZeroException;

class MakingTransaction implements MakingTransactionInterface
{

  public function transaction(string $myWallet, string $recipientWallet, string $amountOfBTC)
  {
    $amount_of_my_BTC = Wallet::where('address', $myWallet)->value('amount_of_BTC');
    $amount_of_recipient_BTC = Wallet::where('address', $recipientWallet)->value('amount_of_BTC');
    $user_id_of_sender = Wallet::where('address', $myWallet)->value('id_of_user');
    $user_id_of_recipient = Wallet::where('address', $recipientWallet)->value('id_of_user');

    throw_unless(Wallet::where('address', $myWallet)->value('address'), InvalidAddressException::class, 'Не коректный адрес кошелька отправителя');
    throw_unless(Wallet::where('address', $recipientWallet)->value('address'), InvalidAddressException::class, 'Не коректный адрес кошелька получателя');
    throw_if($amountOfBTC == 0, CanNotSendZeroException::class, 'Невозможно отправить ноль BTC');

    if ($user_id_of_sender !== $user_id_of_recipient) {
      throw_if($amount_of_my_BTC - ($amountOfBTC * 0.15 + $amountOfBTC) < 0, NotEnoughMoney::class, 'Не достаточно BTC на кошельке.Пополните кошелек');
      Wallet::where('address', $myWallet)->update(['amount_of_BTC' => $amount_of_my_BTC - ($amountOfBTC * 0.15 + $amountOfBTC)]);
      Wallet::where('address', $recipientWallet)->update(['amount_of_BTC' => $amountOfBTC + $amount_of_recipient_BTC]);
    } else {
      throw_if($amount_of_my_BTC - $amountOfBTC < 0, NotEnoughMoney::class, 'Не достаточно BTC на кошельке.Пополните кошелек');
      Wallet::where('address', $myWallet)->update(['amount_of_BTC' => $amount_of_my_BTC - $amountOfBTC]);
      Wallet::where('address', $recipientWallet)->update(['amount_of_BTC' => $amountOfBTC + $amount_of_recipient_BTC]);
    }
  }
}
