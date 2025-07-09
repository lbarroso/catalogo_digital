@extends('layouts.webpages')
@section('page-title','Categorias')

@section('content-area')

<div class="container-fluid mb-3">

<!-- CATEGORIES GRID 1 -->
<div class="d-grid grid-template-col-2 grid-template-col-md-3 grid-gap-1 grid-gap-sm-3 mt-3">
  <div class="img img-zoom-in grid-column-start-1 grid-column-end-3 grid-column-end-sm-2 grid-row-start-sm-1 grid-row-end-sm-3">
    <div data-cover="../../img/categories/1.jpeg" data-height="150px 276px 250px 325px 400px"></div>
    <div class="overlay overlay-show bg-dark"></div>
    <div class="overlay-content overlay-show">
      <a href="{{ route('webpages.shopcategory.type', ['type' => $categories[0]->type, 'category_id' => $categories[0]->id ]) }}" class="card-link h3 text-white font-condensed font-weight-bold stretched-link">{{ $categories[0]->name }}</a>
    </div>
  </div>
  <div class="img img-zoom-in">
    <div data-cover="../../img/categories/2.jpeg" data-height="125px 100% 100% 100% 100%"></div>
    <div class="overlay overlay-show bg-dark"></div>
    <div class="overlay-content overlay-show">
      <a href="{{ route('webpages.shopcategory.type', ['type' => $categories[1]->type, 'category_id' => $categories[1]->id ]) }}" class="card-link h3 text-white font-condensed stretched-link text-center px-3">{{ $categories[1]->name }}</a>
    </div>
  </div>
  <div class="img img-zoom-in">
    <div data-cover="../../img/categories/3.jpeg" data-height="125px 100% 100% 100% 100%"></div>
    <div class="overlay overlay-show bg-dark"></div>
    <div class="overlay-content overlay-show">
      <a href="{{ route('webpages.shopcategory.type', ['type' => $categories[2]->type, 'category_id' => $categories[2]->id ]) }}" class="card-link h3 text-white font-condensed stretched-link text-center px-3">{{ $categories[2]->name }}</a>
    </div>
  </div>
  <div class="img img-zoom-in">
    <div data-cover="../../img/categories/4.jpeg" data-height="125px 130px 100% 100% 100%"></div>
    <div class="overlay overlay-show bg-dark"></div>
    <div class="overlay-content overlay-show">
      <a href="{{ route('webpages.shopcategory.type', ['type' => $categories[3]->type, 'category_id' => $categories[3]->id ]) }}" class="card-link h3 text-white font-condensed stretched-link text-center px-3">{{ $categories[3]->name }}</a>
    </div>
  </div>
  <div class="img img-zoom-in">
    <div data-cover="../../img/categories/5.jpeg" data-height="125px 130px 100% 100% 100%"></div>
    <div class="overlay overlay-show bg-dark"></div>
    <div class="overlay-content overlay-show">
      <a href="{{ route('webpages.shopcategory.type', ['type' => $categories[4]->type, 'category_id' => $categories[4]->id ]) }}" class="card-link h3 text-white font-condensed stretched-link text-center px-3">{{ $categories[4]->name }}</a>
    </div>
  </div>
</div>
<!-- /CATEGORIES GRID 1 -->

<!-- CATEGORIES GRID 2 -->
<div class="d-grid grid-template-col-2 grid-template-col-md-3 grid-gap-1 grid-gap-sm-3 grid-gap-md-2 grid-gap-lg-3 mt-3">
  <div class="card border-0 shadow-sm">
    <a href="{{ route('webpages.shopcategory.type', ['type' => 'basicos', 'category_id' =>'0']) }}" class="card-link">
      <img class="card-img-top" src="{{ asset('mimity-retail/img/categories/ProductosAlimenticiosyBebidas.jpg') }}" alt="ProductosAlimenticiosyBebidas">
      <div class="card-body bg-primary-faded text-white">
        <h5 class="mb-0">Alimentos b&aacute;sicos </h5>
      </div>
    </a>
    <div class="list-group list-group-sms list-group-no-border list-group-flush">
        @foreach($foodAndBeverages as $category)
        <a href="{{ route('webpages.shopcategory.type', ['type' => 'basicos', 'category_id' =>$category->id ]) }}" class="list-group-item list-group-item-action text-lowercase ">{{ $category->name }}</a>
        @endforeach
        <a href="{{ route('webpages.shopcategory.type', ['type' => 'basicos', 'category_id' =>'0']) }}" class="list-group-item list-group-item-action">M&aacute;s &raquo;</a>
    </div>    
  </div>
  
  <div class="card border-0 shadow-sm">
    <a href="{{ route('webpages.shopcategory.type', ['type' => 'higiene', 'category_id' =>'0']) }}" class="card-link">
      <img class="card-img-top" src="{{ asset('mimity-retail/img/categories/ProductosparaelHogaryCuidadoPersonal.jpg') }} " alt="ProductosparaelHogaryCuidadoPersonal">
      <div class="card-body bg-danger-faded text-primary">
        <h5 class="mb-0">Higiene y Cuidado Personal</h5>
      </div>
    </a>
    <div class="list-group list-group-sms list-group-no-border list-group-flush">
        @foreach($homeAndPersonalCare as $category)
        <a href="{{ route('webpages.shopcategory.type', ['type' => $category->type, 'category_id' =>$category->id ]) }}" class="list-group-item list-group-item-action text-lowercase">{{ $category->name }}</a>
        @endforeach
        <a href="{{ route('webpages.shopcategory.type', ['type' => 'higiene', 'category_id' =>'0']) }}" class="list-group-item list-group-item-action">M&aacute;s &raquo;</a>
    </div>
  </div>
  <div class="card border-0 shadow-sm">
    <a href="{{ route('webpages.shopcategory.type', ['type' => 'accesorios', 'category_id' =>'0']) }}" class="card-link">
      <img class="card-img-top" src="{{ asset('mimity-retail/img/categories/AccesoriosyArtículosparaelHogar.jpg') }} " alt="AccesoriosyArtículosparaelHogar">
      <div class="card-body bg-success-faded text-success">
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
<!-- /CATEGORIES GRID 2 -->

<!-- CATEGORIES GRID 3 -->
<div class="d-grid grid-template-col-2 grid-template-col-md-3 grid-gap-1 grid-gap-sm-3 mt-3">
  <div class="img img-zoom-in grid-column-start-1 grid-column-end-3 grid-row-start-sm-1 grid-row-end-sm-3 grid-column-start-sm-2 grid-column-end-sm-3">
    <div data-cover="../../img/categories/6.jpeg" data-height="150px 276px 250px 325px 400px"></div>
    <div class="overlay overlay-show bg-dark"></div>
    <div class="overlay-content overlay-show">
      <a href="{{ route('webpages.shopcategory.type', ['type' => $categories[5]->type, 'category_id' => $categories[5]->id ]) }}" class="card-link h3 text-white font-condensed font-weight-bold stretched-link">{{ $categories[5]->name }}</a>
    </div>
  </div>
  <div class="img img-zoom-in">
    <div data-cover="../../img/categories/7.jpeg" data-height="125px 100% 100% 100% 100%"></div>
    <div class="overlay overlay-show bg-dark"></div>
    <div class="overlay-content overlay-show">
      <a href="{{ route('webpages.shopcategory.type', ['type' => $categories[6]->type, 'category_id' => $categories[6]->id ]) }}" class="card-link h3 text-white font-condensed stretched-link text-center px-3">{{ $categories[6]->name }}</a>
    </div>
  </div>
  <div class="img img-zoom-in">
    <div data-cover="../../img/categories/8.jpeg" data-height="125px 100% 100% 100% 100%"></div>
    <div class="overlay overlay-show bg-dark"></div>
    <div class="overlay-content overlay-show">
      <a href="{{ route('webpages.shopcategory.type', ['type' => $categories[7]->type, 'category_id' => $categories[7]->id ]) }}" class="card-link h3 text-white font-condensed stretched-link text-center px-3">{{ $categories[7]->name }}</a>
    </div>
  </div>
  <div class="img img-zoom-in">
    <div data-cover="../../img/categories/9.jpeg" data-height="125px 130px 100% 100% 100%"></div>
    <div class="overlay overlay-show bg-dark"></div>
    <div class="overlay-content overlay-show">
      <a href="{{ route('webpages.shopcategory.type', ['type' => $categories[8]->type, 'category_id' => $categories[8]->id ]) }}" class="card-link h3 text-white font-condensed stretched-link text-center px-3">{{ $categories[8]->name }}</a>
    </div>
  </div>
  <div class="img img-zoom-in">
    <div data-cover="../../img/categories/10.jpeg" data-height="125px 130px 100% 100% 100%"></div>
    <div class="overlay overlay-show bg-dark"></div>
    <div class="overlay-content overlay-show">
      <a href="{{ route('webpages.shopcategory.type', ['type' => $categories[9]->type, 'category_id' => $categories[9]->id ]) }}" class="card-link h3 text-white font-condensed stretched-link text-center px-3">{{ $categories[9]->name }}</a>
    </div>
  </div>
</div>
<!-- /CATEGORIES GRID 3 -->

</div>

@endsection