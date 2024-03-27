@extends('layouts.admin')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Productos</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Productos</li>
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
              <h3 class="card-title">Productos</h3>
          </div>

          <div class="card-body">
              <div class="row">
                  <div class="col-12 mb-3">
                      <button class="btn btn-primary" data-id="0" data-toggle="modal" data-target="#modal-product">Nuevo</button>
                  </div>
              </div>


              <div class="row">
                  <div class="col-12">
                      <table class="table table-hover" id="table">
                          <thead>
                              <tr>
                                  <th>Id</th>
                                  
                                  <th>Descripcion</th>
                                  <th>Marca</th>
                                  <th>codbarras</th>
                                  <th>Precio</th>
                                  <th>Stock</th>
                                  <th>Categoria</th>
                                  <th>Acciones</th>
                              </tr>
                          </thead>
                        
                      </table>
                  </div>
              </div>
          </div>

      </div>

  </div>
</div>
    
@endsection


@section('styles')

<link rel="stylesheet" href="{{ asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

@endsection

@section('scripts')
<script src="{{ asset('admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('admin/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

<script>
    var indexUrl = '{{ route("products.index") }}';
	var storeUrl = '{{ route("products.store") }}';
    var updateUrl = '{{ route("products.update",["product" => 0]) }}';
	var showUrl = '{{ route("products.show",["product" => 0]) }}';
    var deleteUrl = '{{ route("products.destroy",["product" => 0]) }}';
    var urlCategories = '{{ route("products.categories") }}';
</script>

<script src="{{ asset('js/admin/product.js') }}"></script>
@endsection

@section('modal')
    @include('test.modalProduct')
    
@endsection
