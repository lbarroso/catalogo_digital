<!-- resources/views/productos-imagenes.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Revisión de Imágenes por Código</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 8px; }
        img { max-width: 100px; }
    </style>
</head>
<body>
    <h2>Listado de Productos con sus Imágenes</h2>
    <table>

        <thead>
            <tr>
                <th>id</th>
                <th>category_id</th>
                <th>name</th>
                <th>code</th>
                <th>barcode</th>
                <th>descripcion</th>
                <th>price</th>
                <th>stock</th>
                <th>unit</th>
                <th>is_active</th>
                <th>external_id</th>
                <th>created_at</th>
                <th>updated_at</th>
                <th>almcnt</th>
                <th>image</th>
            </tr>
        </thead>

        <tbody>
            @foreach($productos as $producto)
                <tr>
                    <td>{{ $producto->id }} </td>
                    <td>{{ $producto->category_id }} </td>
                    <td>{{ $producto->artdesc }} </td>
                    <td>{{ $producto->artcve }} </td>
                    <td>{{ $producto->codbarras }} </td>
                    <td>{{ $producto->artdesc }} </td>
                    <td>{{ $producto->artprventa }} </td>                    
                    <td>{{ $producto->stock }}</td>
                    <td>{{ $producto->artpesoum }} </td>
                    <td> 1 </td>
                    <td>{{ $producto->id }} </td>
                    <td>2025-06-20 </td>
                    <td>2025-06-20</td>
                    <td>{{ $producto->almcnt }}</td>

                    <td>
                        @if($producto->hasMedia('images'))
                            {{ $producto->artcve . '.' . pathinfo($producto->getFirstMediaPath('images'), PATHINFO_EXTENSION) }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
