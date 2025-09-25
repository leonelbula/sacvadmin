<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Ventas</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background: #f2f2f2; }
        h2, h4 { text-align: center; margin: 0; }
    </style>
</head>
<body>
    <h2>Reporte de Ventas</h2>
    <h4>Desde {{ $fecha_inicio }} hasta {{ $fecha_fin }}</h4>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>Total</th>
                <th>Usuario</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ventas as $i => $venta)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $venta->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $venta->customer->name ?? 'N/A' }}</td>
                <td>${{ number_format($venta->total, 0, ',', '.') }}</td>
                <td>{{ $venta->user->name ?? 'N/A' }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="3" align="right"><strong>Total:</strong></td>
                <td colspan="2"><strong>${{ number_format($total, 0, ',', '.') }}</strong></td>
            </tr>
        </tbody>
    </table>
</body>
</html>
