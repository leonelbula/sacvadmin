<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Ganancias y Pérdidas</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: center; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>Reporte de Ganancias y Pérdidas</h2>
    <p><strong>Desde:</strong> {{ $start_date }} <strong>Hasta:</strong> {{ $end_date }}</p>

    <table>
        <tr>
            <th>Total Ventas</th>
            <td>${{ number_format($ventas, 2) }}</td>
        </tr>
        <tr>
            <th>Total Devoluciones</th>
            <td>-${{ number_format($devoluciones, 2) }}</td>
        </tr>
        <tr>
            <th>Total Gastos</th>
            <td>-${{ number_format($gastos, 2) }}</td>
        </tr>
        <tr>
            <th>Ganancia / Pérdida Neta</th>
            <td><strong>${{ number_format($gananciaNeta, 2) }}</strong></td>
        </tr>
    </table>
</body>
</html>
