<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos desde Supabase</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; border: 1px solid #ccc; font-size: 14px; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>
    <h2>Catálogo de Productos (Supabase)</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Categoría</th>
                <th>Nombre</th>
                <th>Código</th>
                <th>Código de Barras</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Unidad</th>
                <th>Activo</th>
                <th>Creado</th>
            </tr>
        </thead>
        <tbody>
            @forelse($productos as $p)
                <tr>
                    <td>{{ $p->id }}</td>
                    <td>{{ $p->category_id }}</td>
                    <td>{{ $p->name }}</td>
                    <td>{{ $p->code }}</td>
                    <td>{{ $p->barcode }}</td>
                    <td>{{ $p->description }}</td>
                    <td>${{ number_format($p->price, 2) }}</td>
                    <td>{{ $p->stock }}</td>
                    <td>{{ $p->unit }}</td>
                    <td>{{ $p->is_active ? 'Sí' : 'No' }}</td>
                    <td>{{ \Carbon\Carbon::parse($p->created_at)->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr><td colspan="11">No hay productos registrados.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
