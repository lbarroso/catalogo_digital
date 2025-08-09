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
                <div class="col-12 mb-4">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-tools"></i> Herramientas de Gestión de Productos
                            </h3>
                            <div class="card-tools">
                                <span class="badge badge-info">
                                    <i class="fas fa-database me-1"></i>
                                    Inventario sincronizado: 557 productos
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="d-grid">
                                        <button id="btnImportSiac" 
                                                class="btn btn-primary btn-lg d-flex align-items-center justify-content-center"
                                                title="Importa y sincroniza todos los artículos desde el sistema SIAC"
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="top">
                                            <i class="fas fa-download me-2"></i>
                                            <span id="txtImportSiac">Importar desde SIAC</span>
                                            <i id="spinnerImport" class="fas fa-spinner fa-spin d-none ms-2"></i>
                                        </button>
                                        <small class="text-muted mt-1">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Sincroniza artículos del sistema SIAC
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="d-grid">
                                        <button id="btnSyncInventory" 
                                                class="btn btn-info btn-lg d-flex align-items-center justify-content-center"
                                                title="Sincroniza el inventario actual con la base de datos Supabase"
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="top">
                                            <i class="fas fa-sync-alt me-2"></i>
                                            <span class="me-2">Sincronizar Inventario</span>
                                            <i id="spinnerSync" class="fas fa-sync-alt fa-spin d-none"></i>
                                        </button>
                                        <small class="text-muted mt-1">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Actualiza inventario en aplicaci&oacute;n pedidos
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="d-grid">

                                    <a href="{{ route('productos.exportar.csv') }}"
                                        class="btn btn-secondary btn-lg d-flex align-items-center justify-content-center"
                                        title="Descargar archivo csv productos"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top">
                                        <i class="fas fa-sync-alt me-2"></i>
                                        <span class="me-2">CSV Productos</span>
                                        <i id="spinnerSync" class="fas fa-sync-alt fa-spin d-none"></i>
                                    </a>
                                    <small class="text-muted mt-1">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Descargar archivo csv productos de primera vez
                                    </small>                                    


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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

<style>
/* Estilos mejorados para los botones de herramientas */
.btn-lg {
    padding: 12px 20px;
    font-size: 1.1rem;
    border-radius: 8px;
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.btn-lg:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

.btn-lg:disabled {
    transform: none;
    opacity: 0.7;
    cursor: not-allowed;
}

/* Efectos para los iconos */
.btn-lg i {
    transition: transform 0.3s ease;
}

.btn-lg:hover i:not(.fa-spin) {
    transform: scale(1.1);
}

/* Estilo para las descripciones */
.text-muted {
    font-size: 0.85rem;
    font-style: italic;
}

/* Animación para el spinner de importación */
@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.5; }
    100% { opacity: 1; }
}

.btn:disabled .fa-spinner {
    animation: pulse 1s infinite;
}

/* Mejorar el aspecto de las tarjetas */
.card-outline.card-primary {
    border-top: 3px solid #007bff;
}

.card-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 1px solid #dee2e6;
}

/* Espaciado mejorado */
.d-grid {
    display: grid;
    gap: 0.5rem;
}

/* Estilo para el badge de estado */
.badge-info {
    background-color: #17a2b8;
    color: white;
    padding: 6px 12px;
    border-radius: 12px;
    font-size: 0.9rem;
    font-weight: 500;
}

/* Responsividad mejorada */
@media (max-width: 768px) {
    .btn-lg {
        padding: 10px 15px;
        font-size: 1rem;
    }
    
    .col-md-4 {
        margin-bottom: 1rem;
    }
    
    .badge-info {
        font-size: 0.8rem;
        padding: 4px 8px;
    }
}
</style>

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
// Inicializar tooltips de Bootstrap
$(document).ready(function() {
    $('[data-bs-toggle="tooltip"]').tooltip();
});

// Funcionalidad para el botón de Importar desde SIAC
document.getElementById('btnImportSiac')
        .addEventListener('click', async (e) => {
    e.preventDefault();
    
    const btn     = document.getElementById('btnImportSiac');
    const spinner = document.getElementById('spinnerImport');
    const txtBtn  = document.getElementById('txtImportSiac');
    const originalText = txtBtn.textContent;

    // Confirmar acción con el usuario
    const confirmed = confirm('¿Está seguro de que desea importar artículos desde SIAC? Este proceso puede tardar varios minutos.');
    
    if (!confirmed) {
        return;
    }

    // UI: activar spinner y deshabilitar botón
    spinner.classList.remove('d-none');
    btn.setAttribute('disabled', 'disabled');
    txtBtn.textContent = 'Importando...';

    // Mostrar notificación inicial
    $.notify(
        '🔄 Iniciando importación desde SIAC... Por favor espere.',
        { className: 'info', autoHideDelay: 4000 }
    );

    try {
        // Pequeño delay para mostrar las notificaciones
        await new Promise(resolve => setTimeout(resolve, 1500));
        
        // Redirigir a la ruta de importación
        window.location.href = "{{ route('import') }}";
        
    } catch (err) {
        console.error(err);
        $.notify('❌ Error al iniciar la importación', { className: 'error' });
        
        // UI: restaurar estado del botón en caso de error
        spinner.classList.add('d-none');
        btn.removeAttribute('disabled');
        txtBtn.textContent = originalText;
    }
});

// Funcionalidad para el botón de Sincronizar Inventario
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


