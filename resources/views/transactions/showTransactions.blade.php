@extends ('layouts.appBootST')

@section('title', 'Транзакции кошелька')

@section('content')

<div class="conteiner">
  <div class="row text-center">
    <div class="col-lg-6">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">Sender</th>
            <th scope="col">Recipient</th>
            <th scope="col">Amount of transaction</th>
            <th scope="col">Updated at</th>
          </tr>
        </thead>
        <tbody>
          @foreach($walletTransactions as $transaction)
          <tr>
            <th>{{ $transaction->sender }}</th>
            <th>{{ $transaction->recipient}}</th>
            <th>{{ $transaction->amount_of_transaction}}</th>
            <th>{{ $transaction->updated_at}}</th>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>