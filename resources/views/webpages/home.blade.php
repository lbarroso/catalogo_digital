@extends('layouts.webpages')
@section('page-title','Inicio')

@section('content-area')

  <div class="container-fluid mt-3">
        <div class="d-grid grid-template-col-2 grid-template-col-lg-3 grid-gap-1 grid-gap-sm-3">
    
          <!-- HOME SLIDER -->
          <div class="swiper-container grid-column-start-1 grid-column-end-3 grid-row-start-1 grid-row-end-3" id="homeSlider">
            <div class="swiper-wrapper">
              <div class="swiper-slide" data-cover="{{ asset('mimity-retail/img/slider/1.jpg') }}" data-height="220px 320px 350px 470px 420px">
                <div class="overlay-content overlay-show align-items-end text-white">
                  <div class="text-center">
                  <h2 class="bg-primary text-white d-inline-block p-1 animated" data-animate="fadeDown">Productos </h2>
                    <h1 class="animated font-weight-bold text-light" data-animate="fadeDown"> esenciales para tu hogar </h1>
                 
                  </div>
                </div>
              </div>
              <div class="swiper-slide" data-cover="{{ asset('mimity-retail/img/slider/2.jpg') }}" data-height="220px 320px 350px 470px 420px">
                <div class="overlay-content overlay-show align-items-start text-white">
                  <div class="text-center">
                    <h2 class="bg-primary text-white d-inline-block p-1 animated" data-animate="fadeDown"> Hogar y cuidado personal</h2>
                    <h1 class="animated font-weight-bold text-light" data-animate="fadeDown">artículos de limpieza</h1>
                    
                  </div>
                </div>
              </div>
              <div class="swiper-slide" data-cover="{{ asset('mimity-retail/img/slider/3.jpg') }}" data-height="220px 320px 350px 470px 420px">
                <div class="overlay-content overlay-show align-items-end text-white">
                  <div class="text-center">
                    <h2 class="bg-primary text-white d-inline-block p-1 animated" data-animate="fadeDown"> Cat&aacute;logo </h2>
                    <h1 class="animated font-weight-bold text-light" data-animate="fadeDown">encuetra todo lo que necesites</h1>
                    
                  </div>
                </div>
              </div>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev autohide"><i class="material-icons">chevron_left</i></div>
            <div class="swiper-button-next autohide"><i class="material-icons">chevron_right</i></div>
          </div>
          <!-- /HOME SLIDER -->
    
          <!-- TOP CATEGORIES 1 -->
          <div class="card card-style1 overflow-hidden">
            <div class="d-grid grid-template-row-2 grid-template-row-md-none grid-template-col-md-2">
              <div data-cover="{{ asset('mimity-retail/img/categories/basicos.jpg') }}" class="order-md-2"></div>
              <div class="text-center p-3 order-md-1">
                <h3>Alimentos b&aacute;sicos</h3>
                <p class="text-center d-none d-md-block"> Arroz, frijol, ma&iacute;z, aceite comestible</p>
                <a href="{{ route('webpages.shopcategory.type', ['type' => 'basicos', 'category_id' =>'0']) }}" class="btn btn-outline-primary rounded-pill stretched-link">ver m&aacute;s</a>
              </div>
            </div>
          </div>
          <div class="card card-style1 overflow-hidden">
            <div class="d-grid grid-template-row-2 grid-template-row-md-none grid-template-col-md-2">
              <div data-cover="{{ asset('mimity-retail/img/categories/higiene.jpg') }}" class="order-md-2"></div>
              <div class="text-center p-3 order-md-1">
                <h3>Higiene y Cuidado Personal</h3>
                <p class="text-center d-none d-md-block"> Jabon de tocador, shampoo, enjuagues.</p>
                <a href="{{ route('webpages.shopcategory.type', ['type' => 'higiene', 'category_id' =>'0']) }}" class="btn btn-outline-primary rounded-pill stretched-link">ver m&aacute;s</a>
              </div>
            </div>
          </div>
          <!-- /TOP CATEGORIES 1 -->
    
        </div>
    
        <!-- SERVICES BLOCK -->
        <div class="d-grid grid-template-col-sm-2 grid-template-col-xl-4 column-gap-3 row-gap-4 mt-5 mb-5">
          <div class="media">
            <button class="btn btn-icon btn-lg rounded-circle btn-faded-primary active" type="button">
              <i class="material-icons">store</i>
            </button>
            <div class="media-body ml-3">
              <h6> VARIEDAD DE PRODUCTOS </h6>
              <span class="text-secondary font-condensed"> Explora nuestro catálogo, que abarca desde alimentos básicos hasta productos de higiene personal y utensilios del hogar. </span>
            </div>
          </div>
          <div class="media">
            <button class="btn btn-icon btn-lg rounded-circle btn-faded-primary active" type="button">
              <i class="material-icons">search</i>
            </button>
            <div class="media-body ml-3">
              <h6> NAVEGACI&Oacute;N Y BUSQUEDA </h6>
              <span class="text-secondary font-condensed"> Utiliza el buscador para acceder rápidamente a todos los productos disponibles.  </span>
            </div>
          </div>
          <div class="media">
            <button class="btn btn-icon btn-lg rounded-circle btn-faded-primary active" type="button">
              <i class="material-icons">info</i>
            </button>
            <div class="media-body ml-3">
              <h6> INFORMACI&Oacute;N DETALLADA </h6>
              <span class="text-secondary font-condensed"> Conoce nuestros productos que se comercializan en tiendas físicas. </span>
            </div>
          </div>
          <div class="media">
            <button class="btn btn-icon btn-lg rounded-circle btn-faded-primary active" type="button">
              <i class="material-icons">update</i>
            </button>
            <div class="media-body ml-3">
              <h6> CAT&Aacute;LOGO ACTUALIZADO REGULARMENTE</h6>
              <span class="text-secondary font-condensed">   Actualización continua del catálogo para una mejor selección de productos disponibles en existencia. </span>
            </div>
          </div>
        </div>
        <!-- /SERVICES BLOCK -->
    
        <!-- DISCOVER -->
        <h4 class="mt-4 text-center"> Categorias </h4>
        <div class="d-grid grid-template-col-2 grid-template-col-lg-4 grid-gap-1 grid-gap-sm-3 mt-3">
          @foreach($categories as $category)
          <div class="img img-zoom-in">
            <div data-cover="{{ asset('mimity-retail/img/discover/1.jpg') }}" data-height="125px 130px 150px 120px 150px"></div>
            <div class="overlay overlay-show bg-dark"></div>
            <div class="overlay-content overlay-show">
              <a href="{{ route('webpages.shopcategory.type', ['type' => $category->type, 'category_id' => $category->id ]) }}" class="card-link h3 text-white font-condensed stretched-link text-center px-3"> {{ $category->name }} </a>
            </div>
          </div>   
          @endforeach
        </div>
        <div class="text-right mt-3">
          <a href="{{ route('webpages.categories') }}" class="btn btn-light rounded-pill has-icon"> Todas <i class="material-icons">arrow_right</i></a>
        </div>
        <!-- /DISCOVER -->
    
        <!-- FLASH DEALS -->
        <div class="card card-style1 mt-5">
          <div class="card-body">
            <h5 class="card-title">
              <i class="material-icons align-bottom text-warning">flash_on</i>
              Productos Novedades <samll> {{ $empresa->regnom }} </samll>
            </h5>      
            
            <div class="swiper-container" id="dealSlider2">
              <div class="swiper-wrapper">

                <!--novedades-->
                @if($releases)

                  @foreach($releases as $product)    

                    @php
                    if(!$product->file_name) {
                      $imagen = asset('admin/dist/img/sinfoto.jpg'); 
                    } else {
                      $imagen = asset('storage/'.$product->id.'/'.$product->file_name);
                    }
                    @endphp
                                     
                    <div class="swiper-slide card card-product">
                      <div class="card-body">                        
                        <a href="{{ route('webpages.productdetail', ['product_id' => $product->product_id]) }}"> 
                          <img class="card-img-top" src="<?php echo $imagen; ?>" alt="{{ substr($product->artdesc,0, 25) }}" >
                        </a>
                        <a href="#" class="card-title card-link"> {{ substr($product->artdesc,0, 25) }}  </a>                        
                        <div class="price">
                          <span class="h4">${{ number_format($product->artprventa,2) }}  </span>
                        </div>
                      </div>
                      <div class="card-footer">
                        <!--
                        <button class="btn btn-sm rounded-pill btn-faded-primary btn-block atc-demo">Agregar a carrito</button>
                        -->
                      </div>
                    </div>

                  @endforeach

                @endif              

                @foreach($sellers as $product)
                  <?php                        
                      if(!$product->image) $imagen = 'http://10.101.21.24/catalogo/public/admin/dist/img/sinfoto.jpg'; 
                      else{
                          $file_name = str_replace(' ', '-', $product->image);
                          $imagen = 'http://10.101.21.24/catalogo/public/storage/'.$product->id.'/conversions'.'/'.$file_name.'-preview.jpg';
                      }                    
                  ?>

                  <div class="swiper-slide card card-product">
                    <div class="card-body">
                      <button class="btn btn-icon btn-text-danger rounded-circle btn-wishlist atw-demo" data-toggle="button" title="{{ substr($product->artdesc,0, 25) }}"></button>
                      <a href="{{ route('webpages.productdetail', ['product_id' => $product->product_id]) }}"> 
                        <img class="card-img-top" src="<?php echo $imagen; ?>" alt="{{ substr($product->artdesc,0, 25) }}" style="height: 320px;" >
                      </a>
                      <a href="#" class="card-title card-link"> {{ substr($product->artdesc,0, 25) }} </a>                      
                      <div class="price">
                        <span class="h4">${{ number_format($product->artprventa,2) }}</span>
                      </div>
                    </div>
                    <div class="card-footer">
                      <!--
                        <button class="btn btn-sm rounded-pill btn-faded-primary btn-block atc-demo">Agregar a carrito</button>
                    -->  
                    </div>
                  </div>
                @endforeach

              </div>

              <div class="swiper-button-prev"><i class="material-icons">chevron_left</i></div>
              <div class="swiper-button-next"><i class="material-icons">chevron_right</i></div>

            </div>

          </div>
        </div>
        <!-- /FLASH DEALS -->
    
        <!-- BRANDS SLIDER -->
        <h4 class="mt-4 text-center">Marcas Destacadas</h4>
        <div class="card mt-3 border-0">
          <div class="card-body pb-0">
            <div class="swiper-container" id="brandSlider">
              <div class="swiper-wrapper pb-5">
                <div class="swiper-slide card p-3">
                  <a href="#" class="stretched-link">
                    <img src="{{ asset('mimity-retail/img/brands/69.jpg') }}" alt="brand1" class="card-img-top" height="130px">
                  </a>
                </div>
                <div class="swiper-slide card p-3">
                  <a href="#" class="stretched-link">
                    <img src="{{ asset('mimity-retail/img/brands/217.jpg') }}" alt="brand2" class="card-img-top" height="130px">
                  </a>
                </div>
                <div class="swiper-slide card p-3">
                  <a href="#" class="stretched-link">
                    <img src="{{ asset('mimity-retail/img/brands/346.jpg') }}" alt="brand3" class="card-img-top" height="130px">
                  </a>
                </div>
                <div class="swiper-slide card p-3">
                  <a href="#" class="stretched-link">
                    <img src="{{ asset('mimity-retail/img/brands/1369.jpg') }}" alt="brand4" class="card-img-top" height="130px">
                  </a>
                </div>
                <div class="swiper-slide card p-3">
                  <a href="#" class="stretched-link">
                    <img src="{{ asset('mimity-retail/img/brands/288.jpg') }}" alt="brand5" class="card-img-top" height="130px">
                  </a>
                </div>
                <div class="swiper-slide card p-3">
                  <a href="#" class="stretched-link">
                    <img src="{{ asset('mimity-retail/img/brands/312.jpg') }}" alt="brand1" class="card-img-top" height="130px">
                  </a>
                </div>
                <div class="swiper-slide card p-3">
                  <a href="#" class="stretched-link">
                    <img src="{{ asset('mimity-retail/img/brands/343.jpg') }}" alt="brand1" class="card-img-top" height="130px">
                  </a>
                </div>
                <div class="swiper-slide card p-3">
                  <a href="#" class="stretched-link">
                    <img src="{{ asset('mimity-retail/img/brands/452.jpg') }}" alt="brand1" class="card-img-top" height="130px">
                  </a>
                </div>
                <div class="swiper-slide card p-3">
                  <a href="#" class="stretched-link">
                    <img src="{{ asset('mimity-retail/img/brands/3578.jpg') }}" alt="brand1" class="card-img-top" height="130px">
                  </a>
                </div>                               

              </div>
              <div class="swiper-pagination"></div>
            </div>
          </div>
        </div>
        <!-- /BRANDS SLIDER -->
    
        <!-- BEST SELLERS & TOP CATEGORIES 2 -->
        <div class="d-grid grid-template-col-2 grid-template-col-lg-5 grid-template-col-xl-4 grid-gap-2 grid-gap-xl-3 mt-4 mb-3">
          <div class="card card-style1 grid-column-start-1 grid-column-end-3 grid-column-end-sm-2 grid-column-end-lg-3 grid-column-end-xl-2">
            <div class="card-body">
              <h5 class="card-title">M&aacute;s vendidos</h5>              
              <ul class="list-group list-group-flush list-group-sms">
              @foreach($sellers as $product)
                <?php                        
                  $file_name = str_replace(' ', '-', $product->image);
                  $imagen = 'http://10.101.21.24/catalogo/public/storage/'.$product->id.'/conversions'.'/'.$file_name.'-preview.jpg';      
                ?>
                <li class="list-group-item px-0">
                  <div class="media">
                    <a href="{{ route('webpages.productdetail', ['product_id' => $product->product_id]) }}">
                      <img src="<?php echo $imagen; ?>" width="75" alt="product">
                    </a>
                    <div class="media-body ml-3">
                      <a href="{{ route('webpages.productdetail', ['product_id' => $product->product_id]) }}" class="card-link text-secondary"> {{ substr($product->artdesc,0, 25) }} </a>
                      <div class="price"><span>${{ number_format($product->artprventa,2) }}</span></div>
                    </div>
                  </div>
                </li>
              @endforeach
              </ul>
            </div>
          </div>

          <div class="card card-style1">
            <a href="{{ route('webpages.shopcategory.type', ['type' => 'basicos', 'category_id' =>'0']) }}" class="card-link">
              <img class="card-img-top" src="{{ asset('mimity-retail/img/categories/ProductosAlimenticiosyBebidas.jpg') }} " alt="ProductosAlimenticiosyBebidas">
              <div class="card-body bg-primary-faded text-white">
                <h5 class="mb-0">Alimentos y Bebidas</h5>
              </div>
            </a>
            <div class="list-group list-group-sms list-group-no-border list-group-flush">
              @foreach($foodAndBeverages as $category)
                <a href="{{ route('webpages.shopcategory.type', ['type' => 'basicos', 'category_id' =>$category->id ]) }}" class="list-group-item list-group-item-action text-lowercase ">{{ $category->name }}</a>
              @endforeach
              <a href="{{ route('webpages.shopcategory.type', ['type' => 'basicos', 'category_id' =>'0']) }}" class="list-group-item list-group-item-action">M&aacute;s &raquo;</a>
            </div>
          </div>

          <div class="card card-style1">
            <a href="{{ route('webpages.shopcategory.type', ['type' => 'higiene', 'category_id' =>'0']) }}" class="card-link">
              <img class="card-img-top" src="{{ asset('mimity-retail/img/categories/ProductosparaelHogaryCuidadoPersonal.jpg') }} " alt="ProductosparaelHogaryCuidadoPersonal">
              <div class="card-body bg-primary-faded text-white">
                <h5 class="mb-0">Hogar y Cuidado Personal</h5>
              </div>
            </a>
            <div class="list-group list-group-sms list-group-no-border list-group-flush">
              @foreach($homeAndPersonalCare as $category)
                <a href="{{ route('webpages.shopcategory.type', ['type' => 'higiene', 'category_id' =>$category->id ]) }}" class="list-group-item list-group-item-action text-lowercase">{{ $category->name }}</a>
              @endforeach
              <a href="{{ route('webpages.shopcategory.type', ['type' => 'higiene', 'category_id' =>'0']) }}" class="list-group-item list-group-item-action">M&aacute;s &raquo;</a>
            </div>
          </div>

          <div class="card card-style1 grid-column-start-1 grid-column-end-3 grid-column-start-sm-2 grid-column-end-sm-3
          grid-column-start-lg-5 grid-column-end-lg-6 grid-column-start-xl-4 grid-column-end-xl-5">
            <a href="{{ route('webpages.shopcategory.type', ['type' => 'accesorios', 'category_id' =>'0']) }}" class="card-link">
              <img class="card-img-top" src="{{ asset('mimity-retail/img/categories/AccesoriosyArtículosparaelHogar.jpg') }} " alt="AccesoriosyArtículosparaelHogar">
              <div class="card-body bg-primary-faded text-white">
                <h5 class="mb-0">Artículos para el Hogar y Otros</h5>
              </div>
            </a>
            <div class="list-group list-group-sms list-group-no-border list-group-flush">
              @foreach($householdItems as $category)
                <a href="{{ route('webpages.shopcategory.type', ['type' => 'accesorios', 'category_id' =>$category->id ]) }}" class="list-group-item list-group-item-action text-lowercase">{{ $category->name }}</a>
              @endforeach
              <a href="{{ route('webpages.shopcategory.type', ['type' => 'accesorios', 'category_id' =>'0']) }}" class="list-group-item list-group-item-action">M&aacute;s &raquo;</a>
            </div>
          </div>
        </div>
        <!-- /BEST SELLERS & TOP CATEGORIES 2 -->
    
    </div>

@endsection




    
