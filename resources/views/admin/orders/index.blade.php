@extends('layouts.admin')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0"><i class="fas fa-shopping-cart"></i> Dashboard de Pedidos</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Análisis inteligente de pedidos y toma de decisiones</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    


    {{-- Filtros Avanzados --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-filter"></i> Filtros Avanzados de Análisis</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <form method="GET" id="filtros-form">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Fecha Desde</label>
                                    <input type="date" class="form-control" name="fecha_desde" 
                                           value="{{ request('fecha_desde') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Fecha Hasta</label>
                                    <input type="date" class="form-control" name="fecha_hasta" 
                                           value="{{ request('fecha_hasta') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Cliente (Clave)</label>
                                    <input type="text" class="form-control" name="cliente_clave" 
                                           placeholder="Ej: 182" value="{{ request('cliente_clave') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Nombre Cliente</label>
                                    <input type="text" class="form-control" name="cliente_nombre" 
                                           placeholder="Buscar por nombre" value="{{ request('cliente_nombre') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Número de Pedido</label>
                                    <input type="text" class="form-control" name="order_id" 
                                           placeholder="Ej: 54" value="{{ request('order_id') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Artículo (Clave)</label>
                                    <input type="text" class="form-control" name="articulo_clave" 
                                           placeholder="Ej: 3336065" value="{{ request('articulo_clave') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Rango de Venta</label>
                                    <select class="form-control" name="rango_venta">
                                        <option value="">Todos los rangos</option>
                                        <option value="0-100" {{ request('rango_venta') == '0-100' ? 'selected' : '' }}>$0 - $100</option>
                                        <option value="100-500" {{ request('rango_venta') == '100-500' ? 'selected' : '' }}>$100 - $500</option>
                                        <option value="500-1000" {{ request('rango_venta') == '500-1000' ? 'selected' : '' }}>$500 - $1,000</option>
                                        <option value="1000+" {{ request('rango_venta') == '1000+' ? 'selected' : '' }}>$1,000+</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Ordenar por</label>
                                    <select class="form-control" name="ordenar">
                                        <option value="fecha_desc" {{ request('ordenar') == 'fecha_desc' ? 'selected' : '' }}>Fecha ↓</option>
                                        <option value="fecha_asc" {{ request('ordenar') == 'fecha_asc' ? 'selected' : '' }}>Fecha ↑</option>
                                        <option value="venta_desc" {{ request('ordenar') == 'venta_desc' ? 'selected' : '' }}>Venta ↓</option>
                                        <option value="venta_asc" {{ request('ordenar') == 'venta_asc' ? 'selected' : '' }}>Venta ↑</option>
                                        <option value="cliente" {{ request('ordenar') == 'cliente' ? 'selected' : '' }}>Cliente</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <div class="d-flex">
                                        <button type="submit" class="btn btn-primary mr-2">
                                            <i class="fas fa-search"></i> Filtrar
                                        </button>
                                        <a href="{{ route('orders.index') }}" class="btn btn-secondary mr-2">
                                            <i class="fas fa-sync-alt"></i> Limpiar
                                        </a>
                                        <button type="button" class="btn btn-success" onclick="exportData()">
                                            <i class="fas fa-download"></i> Exportar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    {{-- Panel de Sincronización --}}
    <div class="row mb-4">
    <div class="col-12">
        <div class="card card-outline card-warning shadow-sm">

            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">
                    <i class="fas fa-sync-alt"></i> Panel de Sincronización
                </h3>
            </div>

            <div class="card-body">

                <!-- Información -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="mb-1 text-muted">Última sincronización:</p>
                        <h5><strong>{{ $ultima_sync ?? 'No disponible' }}</strong></h5>

                        <p class="mb-1 text-muted">Total de registros sincronizados:</p>
                        <h5><strong>{{ $orders->total() }}</strong></h5>
                    </div>

                    <!-- Botón de sincronización general -->
                    <div class="col-md-6 text-md-right text-center align-self-center">
                        <form action="{{ route('orders.sync') }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-warning btn-lg px-4 shadow-sm">
                                <i class="fas fa-retweet"></i> Sincronizar Pedidos
                            </button>
                        </form>
                    </div>
                </div>

                <hr>

                <!-- Sincronización por Cliente -->
                <div class="mt-4">
                    <h5 class="text-warning mb-3">
                        <i class="fas fa-user-tag"></i> Sincronizar Pedidos por Cliente
                    </h5>

                    <form action="{{ route('orders.syncByCliente') }}" method="POST" class="row g-3">
                        @csrf

                        <div class="col-md-4">
                            <label for="ctecve" class="form-label">Clave del Cliente</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white">
                                        <i class="fas fa-user"></i>
                                    </span>
                                </div>
                                <input type="number"
                                       name="ctecve"
                                       id="ctecve"
                                       class="form-control"
                                       placeholder="Ej: 182"
                                       required>
                            </div>
                        </div>

                        <div class="col-md-4 align-self-end">
                            <button type="submit" class="btn btn-primary btn-lg px-4 shadow-sm">
                                <i class="fas fa-sync-alt"></i> Sincronizar Cliente
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
</div>



    {{-- Tabla de Pedidos Agrupados --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-table"></i> Pedidos Agrupados por Cliente</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="table_search" class="form-control float-right" placeholder="Buscar">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr class="bg-light">
                                <th>Pedido #</th>
                                <th>Cliente</th>
                                <th>Artículos</th>
                                <th>Última Compra</th>
                                <th>Total Ventas</th>
                                <th>Frecuencia</th>
                                <th>Ticket Promedio</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders_agrupados as $pedido_data)
                            <tr>
                                <td>
                                    <strong class="text-primary">#{{ $pedido_data['order_id'] }}</strong>
                                </td>
                                <td>
                                    <strong>{{ $pedido_data['ctecve'] }}</strong> - {{ $pedido_data['ctename'] }}
                                </td>
                                <td>
                                    <span class="badge badge-primary">{{ $pedido_data['pedida'] }} artículos</span>
                                </td>
                                <td>{{ $pedido_data['ultima_compra'] }}</td>
                                <td>
                                    <strong>${{ number_format($pedido_data['total_ventas'], 2) }}</strong>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $pedido_data['frecuencia'] >= 5 ? 'success' : ($pedido_data['frecuencia'] >= 3 ? 'warning' : 'danger') }}">
                                        {{ $pedido_data['frecuencia'] }} pedidos/mes
                                    </span>
                                </td>
                                <td>${{ number_format($pedido_data['ticket_promedio'], 2) }}</td>
                                <td>
                                    <button class="btn btn-sm btn-success mr-1" onclick="verDetallePedido({{ $pedido_data['order_id'] }})">
                                        <i class="fas fa-eye"></i> Detalle
                                    </button>
                                    <button class="btn btn-sm btn-info" onclick="verAnalisisCliente({{ $pedido_data['ctecve'] }})">
                                        <i class="fas fa-chart-line"></i> Análisis
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    <div class="float-right">
                        {{ $orders->appends(request()->query())->links() }}
                    </div>
                    <div class="float-left">
                        <small class="text-muted">
                            Mostrando {{ $orders->firstItem() }} al {{ $orders->lastItem() }} de {{ $orders->total() }} registros
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal para Análisis de Cliente --}}
<div class="modal fade" id="modalAnalisisCliente" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Análisis Detallado del Cliente</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="contenido-analisis">
                <div class="text-center">
                    <i class="fas fa-spinner fa-spin fa-3x"></i>
                    <p>Generando análisis...</p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal para Detalle de Pedido --}}
<div class="modal fade" id="modalDetallePedido" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalle del Pedido</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="contenido-detalle-pedido">
                <div class="text-center">
                    <i class="fas fa-spinner fa-spin fa-3x"></i>
                    <p>Cargando productos del pedido...</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="{{ asset('admin/plugins/chart.js/Chart.min.js') }}"></script>
<script>
// Gráfico de Rentabilidad
const ctx = document.getElementById('rentabilidadChart').getContext('2d');
const rentabilidadChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($chart_labels) !!},
        datasets: [{
            label: 'Ventas por Cliente',
            data: {!! json_encode($chart_data) !!},
            backgroundColor: 'rgba(54, 162, 235, 0.8)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return '$' + value.toLocaleString();
                    }
                }
            }
        },
        plugins: {
            legend: {
                display: false
            }
        }
    }
});

// Función para exportar datos
function exportData() {
    const params = new URLSearchParams(window.location.search);
    params.append('export', 'excel');
    window.location.href = '{{ route("orders.index") }}?' + params.toString();
}

// Función para ver análisis de cliente
function verAnalisisCliente(clienteId) {
    $('#modalAnalisisCliente').modal('show');
    
    $.ajax({
        url: '{{ route("orders.analisis-cliente") }}',
        type: 'GET',
        data: { cliente_id: clienteId },
        success: function(response) {
            $('#contenido-analisis').html(response);
        },
        error: function() {
            $('#contenido-analisis').html('<div class="alert alert-danger">Error al cargar el análisis</div>');
        }
    });
}

// Función para ver detalle del pedido
function verDetallePedido(orderId) {
    $('#modalDetallePedido').modal('show');
    
    $.ajax({
        url: '{{ route("orders.detalle-pedido") }}',
        type: 'GET',
        data: { order_id: orderId },
        success: function(response) {
            $('#contenido-detalle-pedido').html(response);
        },
        error: function() {
            $('#contenido-detalle-pedido').html('<div class="alert alert-danger">Error al cargar el detalle del pedido</div>');
        }
    });
}

// Búsqueda en tabla
$('input[name="table_search"]').on('keyup', function() {
    const value = $(this).val().toLowerCase();
    $('table tbody tr:not(.expandable-body)').filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
    });
});

// Actualizar filtros automáticamente
$('#filtros-form input, #filtros-form select').on('change', function() {
    if ($(this).attr('name') !== 'ordenar') {
        // Auto-submit para algunos filtros
        setTimeout(function() {
            $('#filtros-form').submit();
        }, 500);
    }
});
</script>
@endsection

@section('styles')
<style>
.expandable-table-caret {
    cursor: pointer;
}
.small-box h3 {
    font-size: 2rem;
    font-weight: bold;
}
.table-responsive {
    max-height: 400px;
    overflow-y: auto;
}
.badge {
    font-size: 0.9em;
}
</style>
@endsection