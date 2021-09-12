@extends ('layouts.appBootST')

@section('title', 'Транзакция Денег')

@section('content')

<div class="container">
  <div class="row mt-5">
    @if(session('success'))
    <div class="bg-success p-5 rounded" role="alert">
      <h4>{{ session('success') }}</h4>
    </div>
    @endif
    @if(session('error'))
    <div class="bg-danger p-5 rounded" role="alert">
      <h4>{{ session('error') }}</h4>
    </div>
    @endif
  </div>
  <div class="row mt-5">
    <div class="col-lg-12">
      <form action="{{ route('transaction') }}" method="POST">
        @csrf
        <label for="exampleDataList" class="form-label">Select Wallet</label>
        <input class="form-control" list="datalistOptions" id="exampleDataList" placeholder="Type to search..." name="myWallet">
        <datalist id="datalistOptions">
          @foreach($allWallets as $wallet)
          <option value="{{$wallet->address}}">
            @endforeach
        </datalist>
        <div class="mb-3 mt-2">
          <label for="formGroupExampleInput" class="form-label">Select recipient wallet</label>
          <input type="text" class="form-control" id="formGroupExampleInput" name="recipientWallet">
        </div>
        <div class="mb-3 mt-2">
          <label for="formGroupExampleInput" class="form-label">Amount of BTC</label>
          <input type="number" class="form-control" id="formGroupExampleInput" name="amountOfBTC">
        </div>
        <div class="col-auto mt-2">
          <button type="submit" class="btn btn-primary mb-3">Send BTC</button>
        </div>
      </form>
    </div>
  </div>
  <div class="row m-3">
    <div class="col-lg-6">
      Information about Transactions
    </div>
  </div>
  <table class="table">
    <thead>
      <tr>
        <th scope="col">Sender</th>
        <th scope="col">Recipient</th>
        <th scope="col">Amount of transaction</th>
        <th scope="col">Transaction time</th>
      </tr>
    </thead>
    <tbody>
      @foreach($allTransactions as $transaction)
      <tr>
        <td>{{$transaction->sender}}</td>
        <td>{{$transaction->recipient}}</td>
        <td>{{$transaction->amount_of_transaction}}</td>
        <td>{{$transaction->updated_at}}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>