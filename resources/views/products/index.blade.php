@extends('layouts.admin')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Productos Cat&aacute;logo </h1>
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
              <h3 class="card-title">Listado productos activos</h3>
          </div>

          <div class="card-body">

          <div class="row">
                <div class="col-12 mb-3 d-flex align-items-center">
                    <a 
                    href="{{ route('productos.exportar.csv') }}" 
                    class="btn btn-success me-2">
                    <i class="fa fa-download"></i>
                    Descargar CSV productos
                    </a>

                    <button id="btnSyncInventory" class="btn btn-primary d-flex align-items-center">
                        <span class="me-2">Sincronizar Inventario</span>
                        <i id="spinnerSync" class="fas fa-sync-alt fa-spin d-none"></i>
                    </button>
                    
                </div>
            </div>


              <div class="row">
                  <div class="col">

                    <div class="table-responsive-sm">  
                      <table class="table table-hover" id="table" class="display" style="width:100%">                        
                          <thead>
                              <tr>
                                  <th>Clave SIAC</th>                                  
                                  <th>Descripci&oacute;n</th>
                                  <th>Presentaci&oacute;n</th>
                                  <th>codbarras</th>
                                  <th>Precio</th>
                                  <th>TI</th>
                                  <th>Restos</th>
                                  <th>Familia</th>
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
<!--rutas web apiResource:products-->
<script>
    var indexUrl = '{{ route("products.index") }}';
	var storeUrl = '{{ route("products.store") }}';
    var updateUrl = '{{ route("products.update",["product" => 0]) }}';
	var showUrl = '{{ route("products.show",["product" => 0]) }}';
    var deleteUrl = '{{ route("products.destroy",["product" => 0]) }}';
    var urlCategories = '{{ route("products.categories") }}';
    var urlImageStore = '{{ route("images.store") }}';
</script>
<!--contiene el metodo buscar data tables-->
<script src="{{ asset('js/admin/product.js') }}"></script>
<script src="{{ asset('js/admin/discount.js') }}"></script>
<script src="{{ asset('js/admin/property.js') }}"></script>
<script src="{{ asset('js/admin/image.js') }}"></script>
<script src="{{ asset('js/admin/ganancia.js') }}"></script>

<script>
document.getElementById('btnSyncInventory')
        .addEventListener('click', async () => {

    const btn     = document.getElementById('btnSyncInventory');
    const spinner = document.getElementById('spinnerSync');
    const token   = document.querySelector('meta[name="csrf-token"]').content;

    // UI: activar spinner y deshabilitar botón
    spinner.classList.remove('d-none');
    btn.setAttribute('disabled', 'disabled');

    try {
        const res = await fetch("{{ route('inventory.sync') }}", {
            method : 'POST',
            headers: {
                'X-CSRF-TOKEN': token,
                'Accept'      : 'application/json',
                'Content-Type': 'application/json',
            }
        });

        const data = await res.json();

        if (res.ok && data.success) {
            const afectados = Array.isArray(data.result)
                              ? data.result.length : 0;

            $.notify(
              `✔ Inventario sincronizado Enviados: ${data.synced} ` +
              `Afectados en Supabase: ${afectados} `,
              { className: 'success', autoHideDelay: 6000 }
            );
        } else {
            $.notify(
              `❌ Error: ${data.error || 'ver consola'}`,
              { className: 'error', autoHideDelay: 8000 }
            );
            console.error(data);
        }
    } catch (err) {
        console.error(err);
        $.notify('❌ Error de red o servidor', { className: 'error' });
    } finally {
        // UI: ocultar spinner y habilitar botón
        spinner.classList.add('d-none');
        btn.removeAttribute('disabled');
    }
});
</script>



@endsection

<!--Agregado rapido nuevo producto-->
@section('modal')
    @include('products.modalProduct')
    @include('products.modalDiscount')
    @include('products.modalProperty')	
    @include('products.modalImage')
@endsection


