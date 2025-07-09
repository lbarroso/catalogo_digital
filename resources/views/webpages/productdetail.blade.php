@extends('layouts.webpages')
@section('page-title','Tienda')

@section('content-area')

@php
if(!$product->file_name) {
  $imagen = asset('admin/dist/img/sinfoto.jpg'); 
} else {
  $imagen = asset('storage/'.$product->id.'/'.$product->file_name);
}
@endphp

<div class="container-fluid mb-3">

    <div class="card card-style1">
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <div class="swiper-gallery">
              <div class="swiper-gallery-carousel">
                <div class="swiper-container" id="mainSlider">
                  <div class="swiper-wrapper">
                    <img src="<?php echo $imagen; ?>" data-large="<?php echo $imagen; ?>" alt="{{ isset($product->artdesc) ? substr($product->artdesc, 0, 25) : '' }}" class="swiper-slide">
                  </div>            
                </div>
              </div>       
            </div>
          </div>
          <div class="col-md-6 pt-3 pt-md-0">
            <h4 class="card-title font-weight-normal mb-3">{{ isset($product->artdesc) ? substr($product->artdesc, 0, 25) : '' }}</h4>
            <h3 class="price mb-3">
              <span >${{ isset($product->artprventa) ? number_format($product->artprventa,2) : '' }}</span>
            </h3>
            {{ $product->artpesoum }} 
            <form id="formConsultarExistencia" method="post">

              <div class="form-group">
                <label class="font-weight-bold d-block">Presentaci&oacute;n</label>
                <div class="btn-group btn-group-sm btn-group-toggle " data-toggle="buttons">
                
                  <label class="btn btn-outline-secondary" >
                    {{ isset($product->artpesogrm) ? $product->artpesogrm : '' }}
                      @if(isset($product->artpesoum))
                          @php
                              $parts = explode('/', $product->artpesoum);  
                              $firstPart = $parts[2] ?? null;  
                          @endphp

                          {{ $firstPart }}
                      @endif                                           
                  </label>
                   
                </div>
                <label class="font-weight-bold d-block">Clave</label>
                <div class="btn-group btn-group-sm btn-group-toggle " data-toggle="buttons">                
                  <label class="btn btn-outline-secondary" >
                    {{ isset($product->artcve) ? $product->artcve : '' }}                                        
                  </label>
                </div>

                <label class="font-weight-bold d-block">Codigo de barras</label>
                <div class="btn-group btn-group-sm btn-group-toggle " data-toggle="buttons">                
                  <label class="btn btn-outline-secondary" >
                    {{ isset($product->codbarras) ? $product->codbarras: '' }}                                        
                  </label>
                </div>

              </div>

              <div class="form-row">
                <div class="form-group col-6 col-sm-4 col-md-5 col-lg-4">
                  <label class="d-block font-weight-bold">Cantidad</label>
                  <div class="custom-spinner">
                    <button class="btn btn-icon rounded-circle btn-faded-primary down" type="button"><i class="material-icons">remove</i></button>
                    <input type="number" class="form-control" value="1" min="1" max="999">
                    <button class="btn btn-icon rounded-circle btn-faded-primary up" type="button"><i class="material-icons">add</i></button>
                  </div>
                </div>
                <div class="form-group col-6 col-sm-8 col-md-7 col-lg-8 d-flex align-items-end">
                  <!--
                  <button class="btn rounded-pill btn-primary btn-block atc-demo" type="button" data-title="{{ isset($product->artdesc) ? substr($product->artdesc, 0, 25) : '' }}">Agregar a carrito</button>
                  -->
                </div>
              </div>

              <hr>
              <div class="d-flex align-items-center">
                <span class="text-muted">Compartir</span>
                <button class="btn btn-icon btn-faded-primary btn-sm rounded-circle ml-1" data-toggle="tooltip" title="WhatsApp">
                  <i class="material-icons">chat</i> <!-- Icono de chat -->                
                </button>
              </div>

              <hr>
              <br>
              <div class="form-row">
                <!-- botón "Consultar Existencia" dentro de tu formulario:-->
                <div class="list-inline-block">
                    <button type="button" id="btnConsultarExistencia" class="btn btn-success has-icon"> <i class="material-icons">inventory</i>  Consultar Existencia {{ $empresa->regnom }}</button>
                  </div>
              </div>
              <div class="form-row">
                  <!-- Campo donde se mostrará la existencia -->
                  <div class="form-group">
                      <!-- Loader -->
                      <div id="loader" style="display:none;">
                          <img src="{{ asset('ajax-loader.gif') }} " alt="Cargando..."> Consultando espere...
                      </div>                    
                      <label for="existencia" class="font-weight-bold">Existencia en tiempo real:</label>
                      <input type="text" style="width: 100%;" id="existencia" class="form-control" readonly>
                  </div>                
              </div>

            </form>

          </div>
        </div>
      </div>
    </div>

    <!-- RELATED PRODUCTS -->
    <h4 class="text-center mt-4"> Productos relacionados </h4>
    <div class="d-grid grid-template-col-2 grid-template-col-md-4 grid-gap-1 grid-gap-sm-3 my-3">


      @foreach($relatedProducts as $product)

        @php
          if(!$product->image) {
              $imagen = asset('admin/dist/img/sinfoto.jpg'); 
          } else {
              $file_name = str_replace(' ', '-', $product->image);
              $imagen = asset('storage/'.$product->id.'/conversions/'.$file_name.'-preview.jpg');
          }
        @endphp        

        <div class="card card-product card-style1">
          <div class="card-body">
            <button class="btn btn-icon btn-text-danger rounded-circle btn-wishlist atw-demo" data-toggle="button" title="Add to wishlist"></button>
            <a href="{{ route('webpages.productdetail', ['product_id' => $product->product_id]) }}"><img class="card-img-top" src="<?php echo $imagen; ?>" alt="Card image cap"></a>
            <a href="{{ route('webpages.productdetail', ['product_id' => $product->product_id]) }}" class="card-title card-link">{{ isset($product->artdesc) ? substr($product->artdesc, 0, 25) : '' }}</a>        
            <div class="price">            
              <span class="h5">${{ isset($product->artprventa) ? number_format($product->artprventa,2) : '' }}</span>
            </div>
            <p> {{ $product->artpesoum }} </p>   
          </div>
          <div class="card-footer">
            <!--
            <button class="btn btn-sm rounded-pill btn-faded-primary btn-block atc-demo">Agregar al carrito</button>
        -->
          </div>
        </div>        

      @endforeach

    </div>

    <!-- /RELATED PRODUCTS -->
</div>


@section('scripts')
<script>

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('btnConsultarExistencia').addEventListener('click', function() {
        // Capturar los valores del formulario
        var artcve = "{{ $artcve }}";

        // Mostrar el loader
        document.getElementById('loader').style.display = 'block';

        // Crear la solicitud AJAX
        var xhr = new XMLHttpRequest();
        xhr.open('POST', "{{ route('consultarExistencia') }}", true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.setRequestHeader('X-CSRF-TOKEN', "{{ csrf_token() }}");

        // Manejar la respuesta
        xhr.onload = function() {
            // Ocultar el loader
            document.getElementById('loader').style.display = 'none';

            if (xhr.status >= 200 && xhr.status < 300) {
                // Parsear la respuesta JSON
                var response = JSON.parse(xhr.responseText);
                console.log(response); // Para depuración

                if (response.articulo) {

                  var unidades;
                  
                  // Realizar la división y obtener solo la parte entera usando Math.floor
                  // unidades = Math.floor(response.articulo.er / response.articulo.artcap);
                  unidades =  parseFloat(response.articulo.er);
                  
                  // Asignar el valor de unidades al campo de existencia
                  // Si unidades es mayor que 0, mostrar 'Unidades', de lo contrario 'No disponible'
                  document.getElementById('existencia').value = (unidades > 0 ? unidades + ' Restos' : 'Sin Existencias');
                  

                } else {
                    document.getElementById('existencia').value = 'Conexión No disponible';
                }
            } else {
                // Manejo de errores
                console.error(xhr.statusText);
                alert('Ocurrió un error al consultar la existencia.');
            }
        };

        // Manejar el error de la solicitud
        xhr.onerror = function() {
            // Ocultar el loader
            document.getElementById('loader').style.display = 'none';

                      
            console.error(xhr.statusText);
            alert('Ocurrió un error al consultar la existencia.');
        };

        // Enviar la solicitud con los datos
        var data = 'artcve=' + encodeURIComponent(artcve);
        xhr.send(data);
    });
});

</script>


@endsection

@endsection

