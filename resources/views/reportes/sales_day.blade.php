<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte Totales por Día</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: center; }
        th { background: #f2f2f2; }
        h2, h4 { text-align: center; margin: 0; }
    </style>
</head>
<body>
    <h2>Reporte de Ventas - Totales por Día</h2>
    <h4>Desde {{ $fecha_inicio }} hasta {{ $fecha_fin }}</h4>

    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Total Ventas</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ventas as $venta)
            <tr>
                <td>{{ \Carbon\Carbon::parse($venta->fecha)->format('d/m/Y') }}</td>
                <td>${{ number_format($venta->total, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            <tr>
                <td><strong>Gran Total</strong></td>
                <td><strong>${{ number_format($granTotal, 0, ',', '.') }}</strong></td>
            </tr>
        </tbody>
    </table>
</body>
</html>
