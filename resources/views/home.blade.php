@extends('layouts.admin')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0"> Importar datos para actualizar {{ config('app.name', 'Laravel') }} </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('content')


<div class="row">

  <div class="col-6">
      <div class="card card-default">
          <div class="card-header">
              <h2 class="card-title">Importar articulos </h2>
              <img src="{{ asset('admin/dist/img/import.jpg') }}" class="rounded"  width="210">
          </div>
          <div class="card-body">    
              <div class="row">
                  <div class="col">
                    <div>
                        <!-- Botón de opción para importar datos desde SIAC -->                                                    
                            <a href="{{ route('import') }}" class="btn btn-primary" >  Importar articulos desde  SIAC <i class="fas fa-spinner fa-spin"></i>  </a>
                            <br>
                            IPv4 : {{ Auth::user()->ip; }}                     
                            
                    </div>
                  </div>
              </div>
          </div>
      </div>
  </div>


  <div class="col-6">
      <div class="card card-default">
          <div class="card-header">
              <h2 class="card-title">Importar Imagenes </h2>
              <img src="{{ asset('admin/dist/img/import-images.jpg') }}" class="rounded"  width="210">
          </div>
          <div class="card-body">    
              <div class="row">
                  <div class="col">
                    <div>
                        <!-- Botón de opción para importar datos desde SIAC -->                                                    
                        @if ($numRegistros > 0)    
                            <a href="{{ route('duplicate') }}" class="btn btn-primary" >  Importar banco de imagenes <i class="fas fa-file-import"></i>  </a>
                        @endif
                        <div class="alert alert-warning"> Podr&aacute; aplicar este proceso s&oacute;lo una vez</div>
                            
                    </div>
                  </div>
              </div>
          </div>
      </div>
  </div>  

</div>


@endsection
