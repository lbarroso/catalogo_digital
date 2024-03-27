@extends('layouts.admin')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0"> Agregar nuevo producto  </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Productos </li>
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
              <h3 class="card-title"> Campos obligatorios (*) </h3>
          </div>

          <div class="card-body">

              <div class="row">
                  <div class="col">
					<form method="post" id="formProductCreate" action="{{ route('product.store') }}"  role="form" enctype="multipart/form-data">
					@csrf
					@if($errors->any())
						<div class="alert alert-danger">
							<ul>
								@foreach($errors->all() as $error)
									<li> <strong> {{ $error }} </strong> </li>
								@endforeach
							</ul>
						</div>
					@endif
					<div class="container">
						
						<div class="row">
						  <div class="col-4">        
							<div class="form-group">
								<div class="mb-3">
									<label for="artcve" class="form-label">Clave SIAC</label>
									<input value="{{ old('artcve') }}" type="text" class="form-control" id="artcve" name="artcve" placeholder="Ingrese codigo SIAC">
								</div>
							</div>
						   </div>
						
							<div class="col-6"> 
								<div class="form-group">
									<div class="mb-3">
										<label for="codbarras" class="form-label">Código de Barras</label>
										<input value="{{ old('codbarras') }}" type="text" class="form-control" id="codbarras" name="codbarras" placeholder="Ingrese el código de barras">
									</div>
								</div>
							</div>
						</div>

					 
						<div class="row">
							<div class="col">
								<div class="form-group">
									<div class="mb-3">
										<label for="artdesc" class="form-label">Descripción del Artículo*</label>
										<input onkeyup="this.value = this.value.toUpperCase();" value="{{ old('artdesc') }}" type="text" class="form-control" id="artdesc" name="artdesc" placeholder="Ingrese la descripción del artículo" >
									</div>			
								</div>            
							</div>
						</div>

						<div class="row mb-3">
							<div class="col-10">
								<div class="form-group">
									<div class="mb-3">
										<label for="codbarras" class="form-label">Categoría*</label>
										<select name="category_id" id="category_id" class="form-control select2bs4" style="width: 100%;">
											<option value="">Selecciona una opción</option>
								
										</select>										
									</div>
								</div>            
							</div>
							<div class="col-2"> v*</div>
						</div>                    

						<div class="row">
							<div class="col">
								<div class="form-group">
									<label for="artmarca" class="form-label">Marca</label>
									<input onkeyup="this.value = this.value.toUpperCase();" value="{{ old('artmarca') }}" type="text" class="form-control" id="artmarca" name="artmarca" placeholder="Ingrese la marca">
								</div>
							</div>
							<div class="col-2">        
								<div class="form-group">
									<label for="artpesogrm" class="form-label">Peso </label>
									<input value="{{ old('artpesogrm') == '' ? '1' : old('artpesogrm') }}" type="number" min="0" step="1" class="form-control" id="artpesogrm" name="artpesogrm" placeholder="Ingrese grm" >
								</div>
							</div>
							<div class="col-2">
								<div class="form-group">
									<label for="artpesoum" class="form-label">U.M.</label>
									<input  onkeyup="this.value = this.value.toUpperCase();" value="{{ old('artpesoum') == '' ? 'PZA' : old('artpesoum') }}" type="text" class="form-control" id="artpesoum" name="artpesoum" placeholder="Ingrese um" value="PZA">
								</div>            
							</div>        
						</div>    

						<div class="row">
							<div class="col">
								<div class="form-group">
									<label for="artprcosto" class="form-label">Precio costo</label>
									<input value="{{ old('artprcosto') == '' ? '0' : old('artprcosto') }}" type="number" min="0" step="0.01" class="form-control" id="artprcosto" name="artprcosto" onchange="ganancia()" value="0.00">
								</div>            
							</div>
							<div class="col-2">
								<div class="form-group">
									<label for="artganancia" class="form-label"> %</label>
									<input value="{{ old('artganancia') == '' ? '0' : old('artganancia') }}" type="number" min="0" step="5" class="form-control" id="artganancia" name="artganancia" onchange="ganancia()" value="15">					  
								</div>            
							</div>
							<div class="col">
								<div class="form-group">
									<label for="artprventa" class="form-label">Precio venta*</label>
									<input value="{{ old('artprventa') == '' ? '0' : old('artprventa') }}" type="number" min="0.01" step="0.01" class="form-control" id="artprventa" name="artprventa"  value="0.00">
								</div>            
							</div>
						</div>    
			

						<div class="row">
							<div class="col-6">
								<div class="form-group">
									<label for="stock" class="form-label">Existencia actual</label>
									<input value="{{ old('stock') == '' ? '0' : old('stock') }}" min="0" type="number" class="form-control" id="stock" name="stock" value="0.00" >														
								</div>            
							</div>
					
										
						</div>    

						<button type="button" id="submitBtn" class="btn btn-primary"> Guardar producto</button>
						<a href="{{ route('products.index') }}" class="btn btn-default">Cancelar</a>
					</div>				  
					<input type="hidden" value="{{  Auth::user()->almcnt }}" name="almcnt" id="almcnt" >
					</form>		  
                  </div>
              </div>

          </div>

      </div>
  </div>
</div>

<!-- modal -->
<div class="modal fade" id="modal-formCreate" data-bs-backdrop="static" data-bs-keyboard="false">
<div class="modal-dialog">
  <div class="modal-content">
	<div class="modal-header">
	  <h4 class="modal-title">Notificación</h4>
	  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	  </button>
	</div>
	<div class="modal-body">
	  <p> &nbsp; </p>
	</div>
	<div class="modal-footer justify-content-between">
	  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	  <button type="button" id="modalBtn" class="btn btn-success">Aceptar</button>

	</div>
  </div>
  <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
    
@endsection

@section('styles')
	<!-- Select2 -->
	<link rel="stylesheet" href="{{ asset('admin/plugins/select2/css/select2.min.css') }}">
	<link rel="stylesheet" href="{{ asset('admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

@endsection

@section('scripts')

	<!--cargar categorias-->
	<script> var urlCategories = '{{ route("products.categories") }}'; </script>
	<script> var urlProductValidation = '{{ route("product.validation") }}'; </script>
	<script src="{{ asset('js/admin/productcreate.js') }}"></script>
	<script src="{{ asset('admin/plugins/select2/js/select2.full.min.js') }}"></script> 
	
	<script>
	// Manejar el evento keypress en formulario
	function manejarKeyPress(event) 
	{
		// Verificar si la tecla presionada es "Enter"
		if (event.key === "Enter") 
		{
			// Obtener el formulario y sus campos
			const formulario = document.getElementById("formProductCreate");
			const codbarrasInput = document.getElementById("codbarras");
			const artdescInput = document.getElementById("artdesc");				
			const artmarca = document.getElementById("artmarca");
			const artpesogrm = document.getElementById("artpesogrm");
			const artpesoum = document.getElementById("artpesoum");
			const artprcosto = document.getElementById("artprcosto");
			const artganancia = document.getElementById("artganancia");
			const artprventa = document.getElementById("artprventa");
			const stock = document.getElementById("stock");
			const eximin = document.getElementById("eximin");
			const eximax = document.getElementById("eximax");
			// submit
			const submitBtn = document.getElementById("submitBtn");

			// Verificar cuál es el campo actual y pasar al siguiente
			switch(document.activeElement)
			{
				case codbarrasInput: 
					// Enter codigo duplicado
					artdescInput.focus();
					artdescInput.select();
				break;
				case artdescInput: category_id.focus(); break;
				case category_id: artmarca.focus(); artmarca.select(); break;
				case artmarca: artpesogrm.focus(); artpesogrm.select(); break;
				case artpesogrm: artpesoum.focus(); artpesoum.select(); break;					
				case artpesoum: artprcosto.focus(); artprcosto.select(); break;
				case artprcosto: 
					ganancia();
					artganancia.focus(); 
					artganancia.select(); 
				break;
				case artganancia:		    
					ganancia();
					artprventa.focus(); 
					artprventa.select();
				break;
				case artprventa: stock.focus(); stock.select(); break;
				case stock: eximin.focus(); eximin.select(); break;
				case eximin: eximax.focus(); eximax.select(); break;
				// submitBtn
				case eximax: 
					submitBtn.focus(); 
					formvalidation(event);
				break;
			}//
			
			// Evitar que se realice la acción por defecto del Enter en un formulario
			event.preventDefault();
		}
	} // function

	// Asignar la función al evento keypress del formulario
	document.getElementById("formProductCreate").addEventListener("keypress", manejarKeyPress);
	</script>

	<script>
		/********************
		* validar formulario
		********************/
		var btn = document.querySelector("#submitBtn"); // btn
		// onclick evento
		btn.addEventListener("click",formvalidation);	
		function formvalidation(e){
			e.preventDefault();
			$.ajax({
				
				type: 'get',
				data: $("#formProductCreate").serialize(),
				url: urlProductValidation,
				success: function(response){
					$('#modal-formCreate').modal({backdrop: 'static', keyboard: false}); // bloquear modal
					$("#modal-formCreate").modal("show"); // abrir modal		
					
					if(response == 'success'){
						$('.modal-body').html('<div class="alert alert-success"> ¿Confirma agregar nuevo producto?</div>'); // success
						$('#modalBtn').prop('disabled', false); // habilitar boton					
					}else{				
						$('.modal-body').html('<div class="alert alert-danger">'+response+'</div>'); // error
						$('#modalBtn').prop('disabled', true); // Deshabilitar botón									
					}
					
				} // success	
				
			}); // $ajax

		} // function 
		
	</script>

	<script>
		/********************
		* enviar formulario
		********************/
			var btn = document.querySelector("#modalBtn"); // btn
			var form = document.querySelector("#formProductCreate"); // form		
			
			// onclick evento
			btn.addEventListener("click",formSubmit);
			
			function formSubmit(e)
			{
				e.preventDefault();			

				form.submit();
		
			}
	</script>

	<script>
	function ganancia()
	{
		var costo = parseFloat(document.getElementById("artprcosto").value);
		var venta = parseFloat(document.getElementById("artprventa").value);
		var ganancia = parseFloat(document.getElementById("artganancia").value);
		venta = (costo * ganancia / 100) + costo;
		document.getElementById("artprventa").value = venta.toFixed(2);	
	}

	</script>

@endsection

