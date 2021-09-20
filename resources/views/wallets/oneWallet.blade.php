@extends ('layouts.appBootST')

@section('title', 'Транзакция Денег')

@section('content')

<div class="conteiner">
  <div class="row align-middle">
    <div class="col-lg-12 ">
      <table class="table">
        <thead>
          <tr>
            <th class="align-middle">Address</th>
            <th class="align-middle">Amount in Satoshi</th>
            <th class="align-middle">Amount in BTC</th>
            <th class="align-middle">Amount in USD</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th class="align-middle">{{$address}}</th>
            <th class="align-middle">{{$amountOfSatoshi}}</th>
            <th class="align-middle">{{$amountOfBtc}}</th>
            <th class="align-middle">{{$amountOfUsd}}</th>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>