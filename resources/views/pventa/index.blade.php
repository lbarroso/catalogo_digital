@extends('layouts.pv')

<!-- Main content -->
@section('content')

<section class="content">
  <div class="container-fluid">
	<div class="row">
	  <div class="col-12">
		<!-- Default box -->
		<div class="card">              
		  <div class="card-body">               
		   
			<div id="container">
				<div id="product-list">
					<div id="barcode-section">
						<!-- Campo de entrada para el código de barras -->
						<form id="formCodigo">					
							<div class="input-group input-group-lg">
								<input type="text" name="codigo" id="codigo" placeholder="Introduce el código de barras del producto" onKeyPress="return enterCodigo(event)" class="form-control">
								<span class="input-group-append">
									<button type="button" class="btn btn-info btn-flat"> <i class="fa fa-search"></i> </button>
								</span>
							</div>												
						</form>
						<br>
						  <!--listado productos solo encabazados-->	
						  <div class="table-responsive-sm">
						  <table class="table table-hover" id="table" class="display" style="width:100%">                        
							  <thead>
								  <tr>
									  <th>#</th>                                  
									  <th>Descripci&oacute;n</th>                                  
									  <th>Cantidad</th>
									  <th>Precio</th>
									  <th>Descto</th>
									  <th>Importe</th>
									  <th>Acciones</th>
								  </tr>
							  </thead>
							  <!-- tbody:datatable /puntoventa.js -->
						  </table>
						  </div>
					  
					</div>
				</div>

				<div id="total-section">
					<div id="total">
						Total: $25.00
					</div>
					
					<!-- Agrega anuncios aquí -->
					<div id="ad-container">
						<img class="ad" src="{{ asset('admin/dist/img/credit/visa.png') }}" alt="Anuncio 1">
						<!-- Agrega más anuncios según sea necesario -->
					</div>

					<img id="logo" src="{{ asset('admin/dist/img/credit/visa.png') }}" alt="Logo de la Empresa">
				</div>
			</div>
						
		  </div>
		  <!-- /.card-body -->
		  <div class="card-footer">
			Footer
		  </div>
		  <!-- /.card-footer-->
		</div>
		<!-- /.card -->
	  </div>
	</div>
  </div>
</section>

@endsection
<!-- /.content -->

@section('styles')
<link rel="stylesheet" href="{{ asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('admin/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<!--rutas web apiResource:docdetas-->
<script>
    var indexUrl = '{{ route("pvproducts.index") }}';
	var storeUrl = '{{ route("pvproducts.store") }}';
	var showUrl = '{{ route("pvproducts.show",["pvproduct" => 0]) }}';
    var updateUrl = '{{ route("pvproducts.update",["pvproduct" => 0]) }}';	
    var deleteUrl = '{{ route("pvproducts.destroy",["pvproduct" => 0]) }}';	
</script>
<!--contiene el metodo buscar data tables-->
<script src="{{ asset('js/pventa/pvproduct.js') }}"></script>
<!--interactuar con el teclado-->
<script  src="{{ asset('js/pventa/codigo.js') }}"> </script>
@endsection

<!--buscar producto-->
@section('modal')
    @include('pventa.modalProduct')
	@include('pventa.modalFindProduct')
    @include('pventa.modalConfirmVenta')
@endsection