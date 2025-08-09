<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user"></i> Información del Cliente
                    </h3>
                </div>
                <div class="card-body">
                    <h4>{{ $cliente->ctename }}</h4>
                    <p><strong>Clave:</strong> {{ $cliente->ctecve }}</p>
                    <p><strong>Última compra:</strong> {{ Carbon\Carbon::parse($estadisticas->ultima_compra)->format('d/m/Y') }}</p>
                    <p><strong>Primera compra:</strong> {{ Carbon\Carbon::parse($estadisticas->primera_compra)->format('d/m/Y') }}</p>
                    <p><strong>Antigüedad:</strong> {{ Carbon\Carbon::parse($estadisticas->primera_compra)->diffForHumans() }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-line"></i> Estadísticas de Compra
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="description-block">
                                <h5 class="description-header">${{ number_format($estadisticas->total_gastado, 2) }}</h5>
                                <span class="description-text">Total Gastado</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="description-block">
                                <h5 class="description-header">{{ $estadisticas->total_ordenes }}</h5>
                                <span class="description-text">Total Órdenes</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="description-block">
                                <h5 class="description-header">${{ number_format($estadisticas->promedio_orden, 2) }}</h5>
                                <span class="description-text">Promedio por Orden</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="description-block">
                                <h5 class="description-header">
                                    @php
                                        $frecuencia = Carbon\Carbon::parse($estadisticas->primera_compra)->diffInMonths(Carbon\Carbon::now());
                                        $frecuencia = $frecuencia > 0 ? round($estadisticas->total_ordenes / $frecuencia, 1) : 0;
                                    @endphp
                                    {{ $frecuencia }}
                                </h5>
                                <span class="description-text">Órdenes/Mes</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
    
        <div class="col-md-12">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-star"></i> Productos Favoritos
                    </h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($productos_top as $producto)
                            <tr>
                                <td>
                                    <small><code>{{ $producto->artcve }}</code></small><br>
                                    <strong>{{ Str::limit($producto->artdesc, 25) }}</strong>
                                </td>
                                <td>{{ $producto->total_cantidad }}</td>
                                <td>${{ number_format($producto->total_importe, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-lightbulb"></i> Recomendaciones de Negocio
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="alert alert-info">
                                <h5><i class="fas fa-info-circle"></i> Perfil del Cliente</h5>
                                @if($estadisticas->promedio_orden > 500)
                                    <p><strong>Cliente Premium:</strong> Alto ticket promedio</p>
                                @elseif($estadisticas->promedio_orden > 200)
                                    <p><strong>Cliente Estándar:</strong> Ticket promedio medio</p>
                                @else
                                    <p><strong>Cliente Básico:</strong> Ticket promedio bajo</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="alert alert-warning">
                                <h5><i class="fas fa-exclamation-triangle"></i> Frecuencia</h5>
                                @if($frecuencia >= 3)
                                    <p><strong>Cliente Frecuente:</strong> Compra regularmente</p>
                                @elseif($frecuencia >= 1)
                                    <p><strong>Cliente Ocasional:</strong> Compra ocasionalmente</p>
                                @else
                                    <p><strong>Cliente Esporádico:</strong> Compra muy poco</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="alert alert-success">
                                <h5><i class="fas fa-trophy"></i> Valor del Cliente</h5>
                                @if($estadisticas->total_gastado > 10000)
                                    <p><strong>Cliente VIP:</strong> Alto valor de vida</p>
                                @elseif($estadisticas->total_gastado > 5000)
                                    <p><strong>Cliente Valioso:</strong> Valor medio</p>
                                @else
                                    <p><strong>Cliente Nuevo:</strong> Desarrollar relación</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-bar"></i> Ventas por Mes
                    </h3>
                </div>
                <div class="card-body">
                    <canvas id="tendenciaChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Gráfico de tendencia
const ctxTendencia = document.getElementById('tendenciaChart').getContext('2d');
const tendenciaChart = new Chart(ctxTendencia, {
    type: 'line',
    data: {
        labels: [
            @foreach($tendencia as $mes)
                '{{ $mes->mes }}/{{ $mes->año }}',
            @endforeach
        ],
        datasets: [{
            label: 'Ventas Mensuales',
            data: [
                @foreach($tendencia as $mes)
                    {{ $mes->total }},
                @endforeach
            ],
            borderColor: 'rgb(75, 192, 192)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            tension: 0.1
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
        }
    }
});
</script> 