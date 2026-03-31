<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Stock Minino de Productos</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
        }
        .header small {
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table th, table td {
            border: 1px solid #ccc;
            padding: 6px;
            text-align: left;
        }
        table th {
            background-color: #f2f2f2;
        }
        .low-stock {
            background-color: #ffe5e5;
        }
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #777;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>Reporte de Stock de Productos</h2>
        <small>Fecha de generación: {{ date('d/m/Y') }}</small>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Código</th>
                <th>Producto</th>
                <th>Stock Actual</th>
                <th>Stock Mínimo</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $index => $product)
                <tr class="{{ $product->stock <= $product->min_stock ? 'low-stock' : '' }}">
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $product->code }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->amount }}</td>
                    <td>{{ $product->minimum_amount }}</td>
                    <td>
                        {{ $product->amount <= $product->minimum_amount ? 'Stock Bajo' : 'Disponible' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <span>Sistema de Ventas - Reporte de Inventario</span>
    </div>

</body>
</html>
