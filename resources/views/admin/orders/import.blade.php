@extends('layouts.admin')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0"> Importar CSV de Pedidos</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active"> pedidos </li>
            </ol>
        </div>
    </div>
</div>
@endsection


@section('content')
<div class="container">

  @if(session('msg'))
    <div class="alert alert-success">{{ session('msg') }}</div>
  @endif

  <form action="{{ route('orders.import') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
      <label>Archivo CSV</label>
      <input type="file" name="csv" class="form-control" required>
    </div>
    <button class="btn btn-primary mt-3">Importar</button>
  </form>
</div>
@endsection