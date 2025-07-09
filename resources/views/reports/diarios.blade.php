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
								<h5 class="card-title m-0">Cat&aacute;logo digital con imagenes </h5>								  
								
							</div>
							<div class="card-body">
								<form method="post" action="{{ route('catalogo.pdf') }}" target="_pdf">
									@csrf
									<p>	<img src="{{ asset('admin/dist/img/fondocatalogo.png') }}" class="rounded"  width="120"></p>

									<p>
										<label> Precio venta: </label>
										<select class="form-control" name="artprventa" id="artprventa">																																	
											<option value="NO"> SIN MOSTRAR PRECIO DE VENTA </option>
											<option value="SI"> INCLUIR PRECIO DE VENTA </option>
										</select>
									</p>									

									<p>
										<label> Inventario: </label>
										<select class="form-control" name="artseccion" id="artseccion">
											
											@foreach ($tiposInventarios as $tipoinv)
												<option value="{{ $tipoinv }}"> TIPO DE INVENTARIO: {{ $tipoinv }}</option>
											@endforeach	
										</select>
									</p>
									
									<p> <button type="submit" class="btn btn-primary"> <i class="fas fa-download"></i> Generar catalogo PDF </button>
								</form>
							</div>
						</div>                        

					</div>    
					
					<div class="col-lg-6">
							
						<div class="card card-primary card-outline">
							<div class="card-header">
								<h5 class="card-title m-0"> Cat&aacute;logo de supervisores </h5>
							</div>
							<div class="card-body">								  
								<div class="row">								
									<img src="{{ asset('admin/dist/img/excel.jpg') }}" class="rounded"  width="220">																		
								</div>	
								<div class="row">
									<a href="{{ route('posicion.almacen') }}" class="btn btn-primary"><i class="fas fa-download"></i> Descargar archivo Excel</a>
								</div>									
							</div>
						</div>                        

					</div>					
													
				</div>

          </div>

      </div>

  </div>

</div>
    
@endsection


