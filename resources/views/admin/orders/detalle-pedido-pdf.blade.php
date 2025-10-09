<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Detalle de Pedido #{{ $infoPedido->order_id }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 9px;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 12px;
            margin: 0;
            padding: 0;
        }
        .info-section {
            width: 100%;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            padding: 10px;
            box-sizing: border-box;
            background-color: #f9f9f9;
        }
        .info-section h3 {
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            margin-top: 0;
            font-size: 11px;
        }
        .info-details {
            width: 50%;
            float: left;
        }
        .info-details:last-child {
            width: 50%;
        }
        .info-details p {
            margin: 5px 0;
        }
        .clear {
            clear: both;
        }
        .table-section {
            width: 100%;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #343a40;
            color: white;
            font-size: 10px;
        }
        td {
            font-size: 7px;
        }
        .text-right {
            text-align: right;
        }
        .footer-total {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .total-box {
            border: 1px solid #ccc;
            padding: 10px;
            margin-top: 20px;
            background-color: #eaf6ff;
            text-align: right;
        }
        .total-box h4 {
            font-size: 12px;
            margin: 0;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Detalle de Pedido #{{ $infoPedido->order_id }}</h1>
        <p>Cliente: {{ $infoPedido->ctecve }} - {{ $infoPedido->ctename }}</p>
        <p>Fecha: {{ Carbon\Carbon::parse($infoPedido->docfec)->format('d/m/Y') }}</p>
    </div>

    <div class="info-section">
        <div class="info-details">
            <p><strong>Pedido #:</strong> {{ $infoPedido->order_id }}</p>
            <p><strong>Cliente:</strong> {{ $infoPedido->ctecve }} - {{ $infoPedido->ctename }}</p>
            <p><strong>Fecha:</strong> {{ Carbon\Carbon::parse($infoPedido->docfec)->format('d/m/Y') }}</p>
        </div>
        <div class="info-details">
            <p><strong>Total de Artículos:</strong> {{ $productos->count() }}</p>
            <p><strong>Total del Pedido:</strong> ${{ number_format($totalPedido, 2) }}</p>
            <p><strong>Almacén:</strong> {{ $infoPedido->almcnt }}</p>
        </div>
        <div class="clear"></div>
    </div>

    <div class="table-section">
        <h3>Productos del Pedido</h3>
        <table>
            <thead>
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
                    <td>{{ $producto->artcve }}</td>
                    <td>{{ $producto->artdesc }}</td>
                    <td>{{ $producto->doccant }}</td>
                    <td>{{ $producto->presentacion }}</td>
                    <td>${{ number_format($producto->artprventa, 2) }}</td>
                    <td>${{ number_format($producto->doccant * $producto->artprventa, 2) }}</td>
                    <td>OK</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="footer-total">
                <tr>
                    <td colspan="3"><strong>TOTALES</strong></td>
                    <td><strong>{{ $productos->sum('doccant') }}</strong></td>
                    <td>-</td>
                    <td class="text-right"><strong>Promedio: ${{ number_format($productos->avg('artprventa'), 2) }}</strong></td>
                    <td><strong>${{ number_format($totalPedido, 2) }}</strong></td>
                    <td>-</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="total-box">
        <h4>TOTAL DEL PEDIDO: ${{ number_format($totalPedido, 2) }}</h4>
    </div>

</body>
</html>