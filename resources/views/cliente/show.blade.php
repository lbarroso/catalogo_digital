@extends('layouts.admin')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0"> Detalle cliente </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active"> Clientes </li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Información de cliente </span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('clientes.index') }}"> regresar atrás </a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Cliente nombre:</strong>
                            {{ $cliente->ctenom }}
                        </div>
						
                        
                        <div class="form-group">
                            <strong>Dirección:</strong>
                            {{ $cliente->ctedir }}
                        </div>
                        <div class="form-group">
                            <strong>Correo electrónico:</strong>
                            {{ $cliente->cteemail }}
                        </div>
                        <div class="form-group">
                            <strong>Teléfono:</strong>
                            {{ $cliente->ctetel }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
