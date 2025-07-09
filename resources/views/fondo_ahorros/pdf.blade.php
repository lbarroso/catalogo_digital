<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estado de Cuenta</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        .header, .footer {
            text-align: center;
            margin-bottom: 20px;
        }
        .header {
            font-size: 16px;
            font-weight: bold;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .table th, .table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #f2f2f2;
        }
        .signature {
            text-align: center;
            margin-top: 40px;
        }
        .signature-line {
            margin-top: 50px;
            border-top: 1px solid #000;
            width: 50%;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Estado de Cuenta del Fondo de Ahorro</h2>
    </div>

    <table class="table">
        <tr>
            <th>Número de Expediente:</th>
            <td>{{ $fondo->expediente }}</td>
        </tr>
        <tr>
            <th>Nombre del Participante:</th>
            <td>{{ $fondo->empleado }}</td>
        </tr>
        <tr>
            <th>Aportación Empleado:</th>
            <td>${{ number_format($fondo->aportacion_empleado, 2) }}</td>
        </tr>
        <tr>
            <th>Aportación Diconsa:</th>
            <td>${{ number_format($fondo->aportacion_diconsa, 2) }}</td>
        </tr>
        <tr>
            <th>Total Aportaciones:</th>
            <td>${{ number_format($fondo->total_aportaciones, 2) }}</td>
        </tr>
        <tr>
            <th>Interés Ganado:</th>
            <td>${{ number_format($fondo->interes_ganado ?? 0, 2) }}</td>
        </tr>
        <tr>
            <th>Descuento Sindicato:</th>
            <td>${{ number_format($fondo->descto_sindicato ?? 0, 2) }}</td>
        </tr>
        <tr>
            <th>Descuento Pensión:</th>
            <td>${{ number_format($fondo->descto_pension ?? 0, 2) }}</td>
        </tr>
        <tr>
            <th>Total a Pagar:</th>
            <td><strong>${{ number_format($fondo->total_pagar ?? 0, 2) }}</strong></td>
        </tr>
        <tr>
            <th>Situación:</th>
            <td>{{ $fondo->situacion ?? 'Sin definir' }}</td>
        </tr>
    </table>

    <div class="signature">
        <h3>RECIBÍ</h3>
        <div class="signature-line"></div>
        <p>Nombre y Firma</p>
    </div>
</body>
</html>