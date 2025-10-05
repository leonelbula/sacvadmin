<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Ganancias y Pérdidas</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 13px; }
        table { width: 50%; margin: 20px auto; border-collapse: collapse; }
        th, td { padding: 8px; border: 1px solid #000; text-align: right; }
        th { background: #f2f2f2; text-align: left; }
        h2, h4 { text-align: center; margin: 0; }
    </style>
</head>
<body>
    <h2>Reporte de Ganancias y Pérdidas</h2>
    <h4>Del {{ $fecha_inicio }} al {{ $fecha_fin }}</h4>

    <table>
        <tr>
            <th>Ingresos por Ventas</th>
            <td>${{ number_format($ventas, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>(-) Devoluciones</th>
            <td>${{ number_format($devoluciones, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>(-) Gastos</th>
            <td>${{ number_format($gastos, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th><strong>Resultado Neto</strong></th>
            <td><strong>${{ number_format($resultado, 0, ',', '.') }}</strong></td>
        </tr>
    </table>
</body>
</html>
