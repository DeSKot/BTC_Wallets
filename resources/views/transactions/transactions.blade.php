@extends ('layouts.appBootST')

@section('title', 'Транзакция Денег')

@section('content')

<div class="container">
  <div class="row mt-5">
    <div class="col-lg-6">
      <label for="exampleDataList" class="form-label">Datalist example</label>
      <input class="form-control" list="datalistOptions" id="exampleDataList" placeholder="Type to search...">
      <datalist id="datalistOptions">
        <option value="San Francisco">
        <option value="New York">
        <option value="Seattle">
        <option value="Los Angeles">
        <option value="Chicago">
      </datalist>
    </div>
  </div>
</div>