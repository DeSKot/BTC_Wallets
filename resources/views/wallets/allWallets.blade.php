@extends ('layouts.appBootST')

@section('title', 'Транзакция Денег')

@section('content')

<div class="conteiner">
  <div class="row text-center">
    <div class="col-lg-6">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">Address</th>
            <th scope="col">Amount in BTC</th>
            <th scope="col">Amount in USD</th>
          </tr>
        </thead>
        <tbody>
          @foreach($allWallets as $wallet)
          <tr>
            <th><a href="/wallets/{{$wallet->address}}">{{$wallet->address}}</a></th>
            <th>{{$wallet->amount_of_BTC}}</th>
            <th>{{$wallet->amount_of_USD}}</th>
            <th><button type="button" class="btn btn-light"><a href="/wallets/{{$wallet->address}}/transaction">Transaction information</a></button></th>
            @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>