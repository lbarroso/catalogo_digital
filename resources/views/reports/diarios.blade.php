@extends('layouts.admin')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Reportes </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Reportes</li>
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
              <h3 class="card-title">Reportes diarios</h3>
          </div>

          <div class="card-body">

              <div class="row">
                
         

                        <div class="col-lg-6">
							
							<div class="card card-primary card-outline">
								<div class="card-header">
								  <h5 class="card-title m-0">Catalogo digital con imagenes </h5>								  
								  
								</div>
								<div class="card-body">
									<p>
										<img src="{{ asset('admin/dist/img/fondocatalogo.png') }}" class="rounded"  width="120">
									</p>
									
								  	<p>
										<a href="{{ route('catalogo.pdf') }}" target="_pdf" class="btn btn-primary"><i class="fas fa-download"></i> Generar catalogo PDF</a>
									</p>
								</div>
							</div>                        

						</div>                  

						<div class="col-lg-6">
							
							<div class="card card-primary card-outline">
								<div class="card-header">
								  <h5 class="card-title m-0">Posici&oacute;n de almacen </h5>
								</div>
								<div class="card-body">
								  
									<p>
										<img src="{{ asset('admin/dist/img/excel.jpg') }}" class="rounded"  width="120">
									</p>													
									<p>
								 		<a href="{{ route('posicion.almacen') }}" class="btn btn-primary"><i class="fas fa-download"></i> Descargar archivo Excel</a>
									</p>
									<div class="alert alert-danger"> <a href="{{ route('home') }}"> Importar datos desde SIAC, para actualizar existencias</a> </div>
								</div>
							</div>                        

						</div>

				  
              </div>

          </div>

      </div>

  </div>
</div>
    
@endsection


