@extends ('layouts.appBootST')

@section('title', 'Транзакция Денег')

@section('content')

<div class="conteiner">
  <div class="row text-center">
    <div class="col-lg-12">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">Address</th>
            <th scope="col">Amount in Satoshi</th>
            <th scope="col">Amount in BTC</th>
            <th scope="col">Amount in USD</th>
          </tr>
        </thead>
        <tbody>
          @foreach($allWallets as $wallet)
          <tr>
            <th><a href="/wallets/{{$wallet->address}}">{{$wallet->address}}</a></th>
            <th>{{$wallet->amount_of_satoshi}}</th>
            <th>{{((100/100000000) * $wallet->amount_of_satoshi) / 100}}</th>
            <th>{{((100/100000000) * $wallet->amount_of_satoshi) / 100 * $currencyUSD}}</th>
            <th><button type="button" class="btn btn-light"><a href="/wallets/{{$wallet->address}}/transaction">Transaction information</a></button></th>
            @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>