@extends('layouts.admin')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0"> Gestión de Pedidos Importados   </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active"> Sincroniza y administra tus pedidos por almacén en tiempo real.  </li>
            </ol>
        </div>
    </div>
</div>
@endsection


@section('content')

<div class="container mt-4">
  <h1>Pedidos {{ auth()->user()->name }}</h1>

  {{-- Feedback --}}
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  {{-- Botón sincronizar --}}
  <form action="{{ route('orders.sync') }}" method="POST" class="mb-3">
    @csrf
    <button class="btn btn-primary">
    🔄  Sincronizar pedidos
    </button>
  </form>

  {{-- Tabla de pedidos locales --}}
  <table class="table table-striped">
    <thead>
      <tr>
        <th># Pedido</th>
        <th>	Fecha y hora</th>
        <th>	Cliente (ID – Nombre)</th>
        <th>	Artículo (Clave – Descripción)</th>
        <th>Cantidad</th>
        <th>	Precio unitario</th>
        <th>	Importe total</th>
      </tr>
    </thead>
    <tbody>
      @foreach($orders as $o)
      <tr>
        <td>{{ $o->order_id }}</td>
        <td>{{ $o->docfec }}</td>
        <td>{{ $o->ctecve }} - {{ $o->ctename }}</td>
        <td>{{ $o->artcve }} - {{ $o->artdesc }}</td>
        <td>{{ $o->doccant }}</td>
        <td>${{ number_format($o->artprventa,2) }}</td>
        <td>${{ number_format($o->importe,2) }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>

  {{ $orders->links() }}
</div>
@endsection