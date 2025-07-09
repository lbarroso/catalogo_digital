@extends('layouts.webpages')
@section('page-title','Buscar')

@section('content-area')


<div class="container-fluid mb-3">
    <div class="card card-style1">
      <div class="card-body">

        <h3>Resultado de la busqueda </h3>
        <hr>

        <div class="table-responsive">

        @if($products->isEmpty())
            <div class="alert alert-warning text-center">
                No se encontraron productos disponibles.
            </div>
        @else        
          <table class="table table-bordered text-center table-wishlist">
            <tbody>
            @foreach($products as $product)
                @php
                if(!$product->image) {
                    $imagen = asset('admin/dist/img/sinfoto.jpg'); 
                } else {
                    $file_name = str_replace(' ', '-', $product->image);
                    $imagen = asset('storage/'.$product->id.'/conversions/'.$file_name.'-preview.jpg');
                }
                @endphp               
              <tr>                    
                  <td><a href="{{ route('webpages.productdetail', ['product_id' => $product->product_id]) }}"><img src="<?php echo $imagen; ?>" width="75" height="75" alt="{{ $product->artdesc }}"></a></td>
                  <td><a href="{{ route('webpages.productdetail', ['product_id' => $product->product_id]) }}" class="text-body">{{ $product->artdesc }}</a></td>
                  <!--
                    <button type="button" class="d-inline-block btn btn-faded-primary atc-demo text-white" data-title="#"> agregar al carrito</button>
                  -->
                  <td><strong> {{ $product->artpesoum }} </strong></td>
                  <td><div class="price"><span>${{ number_format($product->artprventa,2) }}</span></div></td>                                
              </tr>
            @endforeach    
            </tbody>
          </table>
        @endif
        </div>

      </div>
    </div>
  </div>

@endsection