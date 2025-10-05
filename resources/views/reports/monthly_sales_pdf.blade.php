<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Ventas Mensuales</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: center; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>Ventas Agrupadas por Mes</h2>
    <p><strong>Desde:</strong> {{ $start_month }} <strong>Hasta:</strong> {{ $end_month }}</p>

    <table>
        <thead>
            <tr>
                <th>Año</th>
                <th>Mes</th>
                <th>Total Ventas</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ventas as $venta)
            <tr>
                <td>{{ $venta->anio }}</td>
                <td>{{ \Carbon\Carbon::create()->month($venta->mes)->translatedFormat('F') }}</td>
                <td>${{ number_format($venta->total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Total General: ${{ number_format($totalGeneral, 2) }}</h3>
</body>
</html>
