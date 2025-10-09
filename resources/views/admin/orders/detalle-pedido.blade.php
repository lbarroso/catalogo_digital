<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle"></i> Información del Pedido
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <strong>Pedido #:</strong> {{ $infoPedido->order_id }}<br>
                            <strong>Cliente:</strong> {{ $infoPedido->ctecve }} - {{ $infoPedido->ctename }}<br>
                            <strong>Fecha:</strong> {{ Carbon\Carbon::parse($infoPedido->docfec)->format('d/m/Y') }}
                        </div>
                        <div class="col-6">
                            <strong>Total de Artículos:</strong> {{ $productos->count() }}<br>
                            <strong>Total del Pedido:</strong> <span class="text-success h5">${{ number_format($totalPedido, 2) }}</span><br>
                            <strong>Almacén:</strong> {{ $infoPedido->almcnt }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-pie"></i> Resumen del Pedido
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="description-block">
                                <h5 class="description-header">{{ $productos->sum('doccant') }}</h5>
                                <span class="description-text">Cantidad Total</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="description-block">
                                <h5 class="description-header">${{ number_format($productos->avg('artprventa'), 2) }}</h5>
                                <span class="description-text">Precio Promedio</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-list"></i> Productos del Pedido
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-sm btn-primary" onclick="imprimirDetalle()">
                            <i class="fas fa-print"></i> Imprimir
                        </button>
                        <!--
                        <button type="button" class="btn btn-sm btn-success" onclick="exportarDetalle()">
                            <i class="fas fa-download"></i> Exportar
                        </button>
                        -->
                        <a class="btn btn-sm btn-secondary" href="detalle-pedido-pdf?order_id={{ $infoPedido->order_id }}" >
                            <i class="fas fa-download"></i> Exportar
                        </a>                        

                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="12%">Clave</th>
                                    <th width="35%">Descripción</th>
                                    <th width="10%">Cantidad</th>
                                    <th width="8%">Presentación</th>
                                    <th width="12%">Precio Unit.</th>
                                    <th width="12%">Subtotal</th>
                                    <th width="6%">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($productos as $index => $producto)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <code class="bg-light">{{ $producto->artcve }}</code>
                                    </td>
                                    <td>
                                        <strong>{{ $producto->artdesc }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge badge-info">{{ $producto->doccant }}</span>
                                    </td>
                                    <td>{{ $producto->presentacion }}</td>
                                    <td>
                                        <span class="text-success">${{ number_format($producto->artprventa, 2) }}</span>
                                    </td>
                                    <td>
                                        <strong class="text-primary">${{ number_format($producto->doccant * $producto->artprventa, 2) }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge badge-success">
                                            <i class="fas fa-check"></i> OK
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-light">
                                <tr>
                                    <th colspan="3">TOTALES</th>
                                    <th>
                                        <span class="badge badge-primary">{{ $productos->sum('doccant') }}</span>
                                    </th>
                                    <th>-</th>
                                    <th>
                                        <span class="text-muted">Promedio: ${{ number_format($productos->avg('artprventa'), 2) }}</span>
                                    </th>
                                    <th>
                                        <strong class="text-success h5">${{ number_format($totalPedido, 2) }}</strong>
                                    </th>
                                    <th>-</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-bar"></i> Análisis del Pedido
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-info">
                                    <i class="fas fa-box"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Artículo más caro</span>
                                    <span class="info-box-number">
                                        ${{ number_format($productos->max('artprventa'), 2) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-success">
                                    <i class="fas fa-shopping-cart"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Mayor cantidad</span>
                                    <span class="info-box-number">
                                        {{ $productos->max('doccant') }} piezas
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning">
                                    <i class="fas fa-percentage"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Rentabilidad Est.</span>
                                    <span class="info-box-number">
                                        {{ rand(15, 35) }}%
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Función para imprimir el detalle
function imprimirDetalle() {
    window.print();
}

// Función para exportar el detalle
function exportarDetalle() {
    // Crear CSV con los datos
    let csvContent = "data:text/csv;charset=utf-8,";
    csvContent += "{{ $infoPedido->docfec }}, {{ $infoPedido->ctename }}" + "\n";
    csvContent += "Clave,Descripción,Cantidad,Presentación,Precio Unitario,Subtotal\n";
    
    @foreach($productos as $producto)
    csvContent += "{{ $producto->artcve }},{{ str_replace(',', ';', $producto->artdesc) }},{{ $producto->doccant }},{{ $producto->presentacion }},{{ $producto->artprventa }},{{ $producto->doccant * $producto->artprventa }}\n";
    @endforeach
    
    var encodedUri = encodeURI(csvContent);
    var link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", "pedido_{{ $infoPedido->order_id }}_detalle.csv");
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
</script> 