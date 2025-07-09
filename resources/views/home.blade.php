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

  <div class="col-4">
      <div class="card card-default">
          <div class="card-header">
              <h2 class="card-title">Importar art&iacute;culos </h2>
              <img src="{{ asset('admin/dist/img/import.jpg') }}" class="rounded"  width="210">
          </div>
          <div class="card-body">    
              <div class="row">
                  <div class="col">
                    <div>
                        <!-- Botón de opción para importar datos desde SIAC -->                                                    
                            <a href="{{ route('import') }}" class="btn btn-primary" >  Importar art&iacute;culos desde  SIAC <i class="fas fa-spinner fa-spin"></i>  </a>
                            <br>
                            IPv4 : {{ Auth::user()->ip; }}                                                 
                            <p class="text-muted"> <small>
                                
                            Este paso puede realizarse las veces que sea necesario, asegura que todos los productos disponibles en el cat&aacute;logo est&eacute;n actualizados y reflejen la informaci&oacute;n m&aacute;s reciente, incluyendo nuevos articulos, precios y disponibilidad.
                            </small> </p>
                    </div>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <div class="col-4">
      <div class="card card-default">
          <div class="card-header">
              <h2 class="card-title">Importar Im&aacute;genes </h2>
              <img src="{{ asset('admin/dist/img/import-images.jpg') }}" class="rounded"  width="210">
          </div>
          <div class="card-body">    
              <div class="row">
                  <div class="col">
                    <div>
                        <!-- Botón de opción para importar datos desde SIAC -->                                                    
                        @if ($numRegistros > 0)    
                            <a href="{{ route('duplicate') }}" class="btn btn-primary" >  Importar banco de im&aacute;genes <i class="fas fa-file-import"></i>  </a>
                        @endif
                        <div class="alert alert-warning"> Podr&aacute; aplicar este proceso s&oacute;lo una vez</div>
                        <p class="text-muted"> 
                            <small>                                
                                Se importan im&aacute;genes de alta calidad para cada producto, Esto no solo mejora la presentaci&oacute;n visual del cat&aacute;logo, sino que tambi&eacute;n ayuda a los usuarios a identificar r&aacute;pidamente los productos deseados.
                            </small> 
                        </p>
                    </div>
                  </div>
              </div>
          </div>
      </div>
  </div>  

  <div class="col-4">
      <div class="card card-default">
          <div class="card-header">
              <h2 class="card-title"> P&aacute;gina Web </h2>
              <img src="{{ asset('admin/dist/img/webpages.jpg') }}" class="rounded"  width="410">
          </div>
          <div class="card-body">    
              <div class="row">
                  <div class="col">
                    <div>                                                
                        
                        <a href="{{ route('webpages.home') }}" target="_blank" class="btn btn-primary" >  Difusi&oacute;n del cat&aacute;logo en l&iacute;nea <i class="fas fa-file-import"></i>  </a>
                        <p class="text-muted"> 
                            <small>                                
                                Una vez que los productos y las im&aacute;genes se han cargado, los usuarios pueden acceder al cat&aacute;logo digital desde sus equipos dentro de la red DICONSA. Incluye filtros de b&uacute;squeda, categor&iacute;as de productos y opciones para ver m&aacute;s detalles. <a href="http://10.101.21.24/catalogo/public/tienda/home" target="_blank"> visitar p&aacute;gina </a>
                            </small> 
                        </p>                                                    
                    </div>
                  </div>
              </div>
          </div>
      </div>
  </div>  

</div>




@endsection
