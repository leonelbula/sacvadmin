<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte Valor de Inventario</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: center; }
        th { background: #f2f2f2; }
        h2, h4 { text-align: center; margin: 0; }
    </style>
</head>
<body>
    <h2>Reporte del Valor de Inventario</h2>
    <h4>Fecha: {{ now()->format('d/m/Y H:i') }}</h4>

    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Costo Unitario</th>
                <th>Precio Venta</th>
                <th>Total Costo</th>
                <th>Total Venta</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productos as $p)
            <tr>
                <td>{{ $p->code }}</td>
                <td>{{ $p->name }}</td>
                <td>{{ $p->amount }}</td>
                <td>${{ number_format($p->cost, 0, ',', '.') }}</td>
                <td>${{ number_format($p->price, 0, ',', '.') }}</td>
                <td>${{ number_format($p->amount * $p->cost, 0, ',', '.') }}</td>
                <td>${{ number_format($p->amount * $p->price, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="5"><strong>Totales</strong></td>
                <td><strong>${{ number_format($totalCosto, 0, ',', '.') }}</strong></td>
                <td><strong>${{ number_format($totalVenta, 0, ',', '.') }}</strong></td>
            </tr>
        </tbody>
    </table>
</body>
</html>
