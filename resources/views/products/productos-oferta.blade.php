@extends('layouts.admin')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">
                <i class="fas fa-tags text-warning"></i>
                Productos en Oferta
            </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Productos</a></li>
                <li class="breadcrumb-item active">Ofertas</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    
    {{-- Panel de Control --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card card-outline card-warning">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-percent"></i>
                        Gestión de Productos en Oferta
                    </h3>
                    <div class="card-tools">
                        <span class="badge badge-warning">
                            <i class="fas fa-box me-1"></i>
                            Total: {{ $productos->total() }} productos
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <p class="mb-2">
                                <i class="fas fa-info-circle text-info me-2"></i>
                                Administra los productos que están disponibles con precios especiales
                            </p>
                            <p class="text-muted mb-0">
                                <small>
                                    • Agrega productos por clave (artcve) para incluirlos en ofertas<br>
                                    • Elimina productos para quitarlos de las ofertas<br>
                                    • Los productos en oferta se muestran destacados en el catálogo
                                </small>
                            </p>
                        </div>
                        <div class="col-md-4 text-right">
                            <button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#modalAgregarProducto">
                                <i class="fas fa-plus me-2"></i>
                                Agregar Producto a Oferta
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabla de Productos en Oferta --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-list"></i>
                        Listado de Productos en Oferta
                    </h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 200px;">
                            <input type="text" name="table_search" class="form-control float-right" placeholder="Buscar producto...">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body table-responsive p-0">
                    @if($productos->count() > 0)
                        <table class="table table-hover text-nowrap">
                            <thead class="bg-light">
                                <tr>
                                    <th width="80">Imagen</th>
                                    <th>Clave</th>
                                    <th>Descripción</th>
                                    <th>Presentación</th>
                                    <th>Precio</th>
                                    <th>Stock</th>
                                    <th>Código de Barras</th>
                                    <th width="100">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($productos as $producto)
                                <tr>
                                    <td>
                                        <div class="product-image-container">
                                            @if($producto->getFirstMediaUrl('images'))
                                                <img src="{{ $producto->getFirstMediaUrl('images', 'thumb') }}" 
                                                     alt="{{ $producto->artdesc }}" 
                                                     class="product-image img-thumbnail"
                                                     data-toggle="tooltip" 
                                                     title="{{ $producto->artdesc }}">
                                            @else
                                                <div class="no-image-placeholder">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <strong class="text-primary">{{ $producto->artcve }}</strong>
                                    </td>
                                    <td>
                                        <span class="product-title" data-toggle="tooltip" title="{{ $producto->artdesc }}">
                                            {{ Str::limit($producto->artdesc, 50) }}
                                        </span>
                                        @if($producto->artmarca)
                                            <br><small class="text-muted">{{ $producto->artmarca }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-info">{{ $producto->artpesogrm }} {{ $producto->artpesoum }}</span>
                                    </td>
                                    <td>
                                        <strong class="text-success">${{ number_format($producto->artprventa, 2) }}</strong>
                                        @if($producto->artprcosto > 0)
                                            <br><small class="text-muted">Costo: ${{ number_format($producto->artprcosto, 2) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($producto->stock > 10)
                                            <span class="badge badge-success">{{ $producto->stock }} pzs</span>
                                        @elseif($producto->stock > 0)
                                            <span class="badge badge-warning">{{ $producto->stock }} pzs</span>
                                        @else
                                            <span class="badge badge-danger">Sin stock</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $producto->codbarras ?: 'N/A' }}</small>
                                    </td>
                                    <td>
                                        <button type="button" 
                                                class="btn btn-danger btn-sm" 
                                                onclick="eliminarDeOferta({{ $producto->id }}, '{{ $producto->artcve }}', '{{ Str::limit($producto->artdesc, 30) }}')"
                                                title="Quitar de ofertas">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">No hay productos en oferta</h4>
                            <p class="text-muted">Agrega productos usando el botón "Agregar Producto a Oferta"</p>
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalAgregarProducto">
                                <i class="fas fa-plus me-2"></i>
                                Agregar Primer Producto
                            </button>
                        </div>
                    @endif
                </div>

                @if($productos->count() > 0)
                <div class="card-footer clearfix">
                    <div class="float-right">
                        {{ $productos->links() }}
                    </div>
                    <div class="float-left">
                        <small class="text-muted">
                            Mostrando {{ $productos->firstItem() }} al {{ $productos->lastItem() }} 
                            de {{ $productos->total() }} productos en oferta
                        </small>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Modal para Agregar Producto --}}
<div class="modal fade" id="modalAgregarProducto" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="fas fa-plus me-2"></i>
                    Agregar Producto a Oferta
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="formAgregarProducto">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="artcve" class="form-label">
                            <i class="fas fa-barcode me-1"></i>
                            Clave del Producto (artcve)
                        </label>
                        <input type="text" 
                               class="form-control form-control-lg" 
                               id="artcve" 
                               name="artcve" 
                               placeholder="Ejemplo: 3336065" 
                               required
                               autocomplete="off">
                        <small class="form-text text-muted">
                            Ingresa la clave exacta del producto que deseas agregar a ofertas
                        </small>
                        <div class="invalid-feedback" id="error-artcve"></div>
                    </div>
                    
                    <div id="producto-preview" class="d-none">
                        <div class="alert alert-info">
                            <h6><i class="fas fa-info-circle me-1"></i> Vista previa del producto:</h6>
                            <div id="preview-content"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times me-1"></i>
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-success" id="btnAgregar">
                        <i class="fas fa-plus me-1"></i>
                        <span>Agregar a Oferta</span>
                        <i class="fas fa-spinner fa-spin d-none" id="spinnerAgregar"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('styles')
<!-- Toastr CSS -->
<link rel="stylesheet" href="{{ asset('admin/plugins/toastr/toastr.min.css') }}">
<style>
/* Estilos para la imagen del producto */
.product-image-container {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    overflow: hidden;
    background-color: #f8f9fa;
}

.product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 6px;
}

.no-image-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #e9ecef;
    border: 1px dashed #ced4da;
    border-radius: 6px;
}

/* Título del producto */
.product-title {
    font-weight: 500;
    color: #495057;
}

/* Badges mejorados */
.badge {
    font-size: 0.75rem;
    padding: 4px 8px;
}

/* Botones */
.btn-sm {
    padding: 4px 8px;
    font-size: 0.875rem;
}

/* Hover effects */
.table-hover tbody tr:hover {
    background-color: #f8f9fa;
}

/* Modal */
.modal-header.bg-success {
    border-bottom: 1px solid #28a745;
}

/* Form controls */
.form-control-lg {
    padding: 12px 16px;
    font-size: 1.1rem;
}

/* Badge de estado del inventario */
.badge-warning {
    background-color: #ffc107;
    color: #212529;
}

/* Búsqueda */
input[name="table_search"] {
    border-radius: 4px 0 0 4px;
}

/* Preview del producto */
#producto-preview {
    border-radius: 8px;
    margin-top: 15px;
}

/* Responsivo */
@media (max-width: 768px) {
    .table-responsive {
        font-size: 0.875rem;
    }
    
    .product-image-container {
        width: 50px;
        height: 50px;
    }
    
    .btn-lg {
        padding: 10px 15px;
        font-size: 1rem;
    }
}

/* Loading state */
.btn-loading {
    pointer-events: none;
    opacity: 0.7;
}
</style>
@endsection

@section('scripts')
<!-- Toastr JS -->
<script src="{{ asset('admin/plugins/toastr/toastr.min.js') }}"></script>
<script>
$(document).ready(function() {
    // Inicializar tooltips
    $('[data-toggle="tooltip"]').tooltip();
    
    // Búsqueda en tabla
    $('input[name="table_search"]').on('keyup', function() {
        const value = $(this).val().toLowerCase();
        $('tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
});

// Función para agregar producto a oferta
$('#formAgregarProducto').on('submit', function(e) {
    e.preventDefault();
    
    const artcve = $('#artcve').val().trim();
    const btn = $('#btnAgregar');
    const spinner = $('#spinnerAgregar');
    const btnText = btn.find('span');
    
    if (!artcve) {
        $('#artcve').addClass('is-invalid');
        $('#error-artcve').text('La clave del producto es requerida');
        return;
    }
    
    // UI: Mostrar loading
    btn.addClass('btn-loading').prop('disabled', true);
    spinner.removeClass('d-none');
    btnText.text('Agregando...');
    
    $.ajax({
        url: '{{ route("productos.oferta.agregar") }}',
        method: 'POST',
        data: {
            artcve: artcve,
            _token: $('input[name="_token"]').val()
        },
        success: function(response) {
            if (response.success) {
                // Mostrar mensaje de éxito
                toastr.success(response.message, 'Producto Agregado');
                
                // Cerrar modal y recargar página
                $('#modalAgregarProducto').modal('hide');
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            }
        },
        error: function(xhr) {
            let errorMessage = 'Error al agregar el producto';
            
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }
            
            toastr.error(errorMessage, 'Error');
            
            // Mostrar error en el campo
            $('#artcve').addClass('is-invalid');
            $('#error-artcve').text(errorMessage);
        },
        complete: function() {
            // UI: Restaurar estado del botón
            btn.removeClass('btn-loading').prop('disabled', false);
            spinner.addClass('d-none');
            btnText.text('Agregar a Oferta');
        }
    });
});

// Limpiar errores al escribir
$('#artcve').on('input', function() {
    $(this).removeClass('is-invalid');
    $('#error-artcve').text('');
    $('#producto-preview').addClass('d-none');
});

// Limpiar modal al cerrar
$('#modalAgregarProducto').on('hidden.bs.modal', function() {
    $('#formAgregarProducto')[0].reset();
    $('#artcve').removeClass('is-invalid');
    $('#error-artcve').text('');
    $('#producto-preview').addClass('d-none');
});

// Función para eliminar producto de oferta
function eliminarDeOferta(id, artcve, descripcion) {
    if (!confirm(`¿Estás seguro de que deseas quitar "${descripcion}" (${artcve}) de las ofertas?`)) {
        return;
    }
    
    $.ajax({
        url: '{{ route("productos.oferta.eliminar") }}',
        method: 'POST',
        data: {
            id: id,
            _token: $('input[name="_token"]').val()
        },
        success: function(response) {
            if (response.success) {
                toastr.success(response.message, 'Producto Eliminado');
                
                // Recargar página después de 1 segundo
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            }
        },
        error: function(xhr) {
            let errorMessage = 'Error al eliminar el producto de ofertas';
            
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }
            
            toastr.error(errorMessage, 'Error');
        }
    });
}
</script>
@endsection 