@extends('layouts.webpages')
@section('page-title','Tienda')

@section('content-area')

<div class="container-fluid mb-3">
    <div class="row gutters-3">
      <div class="col-md-4 col-lg-3">

        <!-- FILTER MODAL -->
        <div class="modal fade modal-content-left modal-shown-static" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-sm" role="document" style="max-width:300px">
            <div class="modal-content">
              <div class="modal-header border-bottom shadow-sm z-index-1">
                <h5 class="modal-title" id="filterModalLabel">Shop Filters</h5>
                <button class="btn btn-icon btn-sm btn-text-secondary rounded-circle" type="button" data-dismiss="modal">
                  <i class="material-icons">close</i>
                </button>
              </div>
              <div class="modal-body p-0 scrollbar-width-thin">
                <div class="accordion accordion-caret" id="accordionSidebar">
                  <div class="card card-style1">
                    <a class="card-header h6 bg-white" data-toggle="collapse" href="#filter-categories" aria-expanded="true">
                      CATEGORIAS
                    </a>
                    <div id="filter-categories" class="collapse show">
                      <div class="card-body pt-0">
                        <ul class="list-tree">
                          <li>
                            <a href="#" class="has-arrow"> {{ $typeArray[0] }} <small class="text-muted">({{ $categories->sum('count'); }})</small></a>
                            <ul>                              
                            @foreach($categories as $category)
                              <li><a href="{{ route('webpages.shopcategory.type', ['type' => $type, 'category_id' =>$category->id ]) }}"> {{ $category->name }} <small class="text-muted"> ({{ $category->count }}) </small></a></li>
                            @endforeach
                            </ul>
                          </li>
                          <li><a href="{{ route('webpages.shopcategory.type', ['type' => $typeArray[3], 'category_id' =>'0' ]) }}"> {{ $typeArray[1] }}  </a></li>
                          <li><a href="{{ route('webpages.shopcategory.type', ['type' => $typeArray[4], 'category_id' =>'0' ]) }}"> {{ $typeArray[2] }}  </a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /FILTER MODAL -->

      </div>
      <div class="col-md-8 col-lg-9">

        <div class="card card-style1">
          <div class="card-body pb-0 d-block d-md-none">
            <button type="button" data-toggle="modal" data-target="#filterModal" class="btn btn-faded-primary btn-sm has-icon">
              <i class="material-icons mr-2">filter_list</i>0 Filter
            </button>
          </div>
          <!--formulario filtros-->
          <form action="{{ route('webpages.shopcategory.type', ['type' => $type, 'category_id' => $category_id]) }}" method="GET">
          <div class="card-body d-flex align-items-center py-2">
            Ordenar por:            
            <select class="custom-select custom-select-sm w-auto ml-1 mr-auto" name="orden" required onchange="this.form.submit()">
                <option>seleccionar filtro</option>
                <option value="bajo">Bajo - Precio más bajo</option>
                <option value="alto">Alto - Precio más alto</option>
                <option value="az">A - Z Orden</option>
                <option value="za">Z - A Orden</option>
            </select>
          </div>
            <!-- Campos ocultos para mantener type y category_id -->
            <input type="hidden" name="type" value="{{ $type }}">
            <input type="hidden" name="category_id" value="{{ $category_id }}">          
          </form>          
        </div>

        <div class="d-grid grid-template-col-2 grid-template-col-lg-3 grid-template-col-xl-4 grid-gap-1 grid-gap-sm-3 mt-3">
          
            @foreach($products as $product)
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
                      <button class="btn btn-icon btn-text-secondary rounded-circle btn-quickview quickview-demo" type="button" title="{{ substr($product->artdesc,0, 25) }}"><i class="material-icons">zoom_in</i></button>
                      <a href="{{ route('webpages.productdetail', ['product_id' => $product->product_id]) }}">
                        <img class="card-img-top" src="<?php echo $imagen; ?>" alt="{{ substr($product->artdesc,0, 25) }}">
                      </a>
                      <a href="{{ route('webpages.productdetail', ['product_id' => $product->product_id]) }}" class="card-title card-link"> {{ substr($product->artdesc,0, 25) }} </a>
                      <div class="price"><span class="h5">${{ number_format($product->artprventa,2) }}</span></div>
                      <p> {{ $product->artpesoum }} </p>                    
                  </div>
                  <div class="card-footer">
                    <!--
                      <button class="btn btn-sm rounded-pill btn-primary btn-block atc-demo">Agregar al carrito</button>
                    -->  
                  </div>
              </div>              
            @endforeach
  
        </div>

        <div class="card card-style1 mt-3">
          <div class="card-body">
            <ul class="pagination pagination-circle justify-content-center mb-0">
              
              {{ $products->links() }} 
              
            </ul>
          </div>
        </div>

      </div>
    </div>
  </div>

@endsection
