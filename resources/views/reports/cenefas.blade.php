@extends('layouts.admin')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">  Cenefas </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active"> Cenefas </li>
            </ol>
        </div>
    </div>
</div>
@endsection


@section('content')

<div class="row">

  <div class="col-12">

      <div class="card card-default">
          <div class="card-header">
              <h3 class="card-title">Imprimir Cenefas PDF</h3>
          </div>

          <div class="card-body">

              <!-- Fila para los formularios -->
              <div class="row">
                
                <!-- Card para Cenefa con precio -->
                <div class="col-lg-6">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="card-title m-0">Cenefas con precio</h5>
                        </div>
                        <div class="card-body">
                            <p>
                                <img src="{{ asset('admin/dist/img/cenefa-blanco345x200.jpg') }}" class="rounded" width="220">
                            </p>
                            <form method="post" action="{{ route('cenefas.precio.pdf') }}" target="_cenefas">
                                @csrf
                                <div class="form-group">
                                    <label for="category_id">Familia:</label>
                                    <select class="form-control" name="category_id" id="category_id">
                                        <option value="0">Seleccionar Todas las Familias</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="artseccion">Inventario:</label>
                                    <select class="form-control" name="artseccion" id="artseccion">
                                        @foreach ($tiposInventarios as $tipoinv)
                                            <option value="{{ $tipoinv }}">Tipo de Inventario: {{ $tipoinv }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                                                        
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-download"></i> Generar Cenefas con Precio
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Card para Cenefa en blanco -->
                <div class="col-lg-6">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="card-title m-0">Cenefas en Blanco</h5>
                        </div>
                        <div class="card-body">
                            <p>
                                <a href="{{ route('cenefa.blanco.pdf') }}" target="_cenefa" class="btn btn-primary">
                                    <i class="fas fa-download"></i> Descargar Cenefas en Blanco PDF
                                </a>
                            </p>
                        </div>
                    </div>
                </div>

              </div> <!-- End row -->

              <!-- Fila para los filtros de búsqueda -->
              <div class="row">
                
                <!-- Card para el Formulario de Filtros -->
                <div class="col-lg-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="card-title m-0">Generar cenefas de una factura</h5>
                        </div>
                        <div class="card-body">

                            <!-- Formulario de Filtros -->
                            <form action="{{ route('cenefas.factura') }}" method="GET" target="_blank">

                                <div class="row">
                                    
                                    <!-- Filtro Número de Factura -->
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="docnumdoc">Número de Factura</label>
                                            <input type="text" class="form-control" id="docnumdoc" name="docnumdoc" placeholder="Número de Factura">
                                        </div>
                                    </div>

                                    <!-- Botón de Enviar -->
                                    <div class="col-md-3 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary btn-block">Generar cenefas de la factura</button>
                                    </div>
                                    
                                </div>



                            
                            </form>

                        </div>
                    </div>
                </div>

              </div> <!-- End row -->

          </div>
      </div>
  </div>
</div>

@endsection


