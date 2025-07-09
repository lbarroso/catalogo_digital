<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Consulta fondo de ahorro</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container">

    <div id="app">
   

        <main class="py-4">

         <h1>Consulta Fondo de Ahorro</h1>

         <form action="{{ route('fondo_ahorro.buscar') }}" method="post">
            @csrf
            <label for="numero_expediente"> N&uacute;mero de expediente </label>
            <input type="number" name="numero_expediente" id="numero_expediente" required>
            <button type="submit"> Buscar  </button> 
         </form>
        
         @isset($fondo)
            <h2>Resultados</h2>
            <table border="1">
                <thead>
                    <tr>
                        <th>ciclo</th>
                        <th>Nombre</th>
                        <th>Aportaci&oacute;n Empleado</th>
                        <th>Aportaci&oacute;n Diconsa</th>
                        <th>Total Aportaciones</th>
                        <th>Interés Ganado</th>
                        <th>Descuento Sindicato</th>
                        <th>Descuento Pensi&oacute;n</th>
                        <th>Total a pagar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td> {{ $fondo->ciclo }} </td>
                        <td> {{ $fondo->empleado }} </td>
                        <td> {{ number_format($fondo->aportacion_empleado, 2) }} </td>
                        <td> {{ number_format($fondo->aportacion_diconsa, 2) }} </td>
                        <td> {{ number_format($fondo->total_aportaciones, 2) }} </td>
                        <td> {{ number_format($fondo->interes_ganado, 2) }} </td>
                        <td> {{ number_format($fondo->descto_sindicato, 2) }} </td>
                        <td> {{ number_format($fondo->descto_pension, 2) }} </td>
                        <td> {{ number_format($fondo->total_pagar, 2) }} </td>
                    </tr>
                </tbody>
            </table>

            <a href="{{ route('fondo_ahorro.pdf', ['id' => $fondo->id ]) }}" target="_blank">
                <button>Imprimir</button>
            </a>
         @endisset
        </main>

    </div>

     
    </div>

</body>

</html>
