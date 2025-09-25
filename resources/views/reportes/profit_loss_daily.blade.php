<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte Diario de Ganancias y Pérdidas</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #000; padding: 4px; text-align: right; }
        th { background: #f2f2f2; }
        td.text-left { text-align: left; }
    </style>
</head>
<body>
    <h2>Reporte Diario de Ganancias y Pérdidas</h2>
    <p><strong>Desde:</strong> {{ $start }} <strong>Hasta:</strong> {{ $end }}</p>

    <table>
        <thead>
            <tr>
                <th class="text-left">Fecha</th>
                <th>Ventas</th>
                <th>Costos</th>
                <th>Utilidad Ventas</th>
                <th>Devoluciones</th>
                <th>Costos Devueltos</th>
                <th>Utilidad Devuelta</th>
                <th>Gastos</th>
                <th>Ingresos Netos</th>
                <th>Utilidad Bruta</th>
                <th>Utilidad Operativa</th>
            </tr>
        </thead>
        <tbody>
            @foreach($report as $row)
                <tr>
                    <td class="text-left">{{ $row['date'] }}</td>
                    <td>{{ number_format($row['totalSales'], 2) }}</td>
                    <td>{{ number_format($row['totalSalesCost'], 2) }}</td>
                    <td>{{ number_format($row['totalSalesUtil'], 2) }}</td>
                    <td>{{ number_format($row['totalReturns'], 2) }}</td>
                    <td>{{ number_format($row['totalReturnsCost'], 2) }}</td>
                    <td>{{ number_format($row['totalReturnsUtil'], 2) }}</td>
                    <td>{{ number_format($row['totalSpents'], 2) }}</td>
                    <td>{{ number_format($row['ingresosNetos'], 2) }}</td>
                    <td>{{ number_format($row['utilidadBruta'], 2) }}</td>
                    <td>{{ number_format($row['utilidadOperativa'], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Resumen del período</h3>
    <table>
        <tr><th class="text-left">Ventas</th><td>{{ number_format($summary['totalSales'], 2) }}</td></tr>
        <tr><th class="text-left">Costos</th><td>{{ number_format($summary['totalSalesCost'], 2) }}</td></tr>
        <tr><th class="text-left">Utilidad de Ventas</th><td>{{ number_format($summary['totalSalesUtil'], 2) }}</td></tr>
        <tr><th class="text-left">Devoluciones</th><td>{{ number_format($summary['totalReturns'], 2) }}</td></tr>
        <tr><th class="text-left">Costos Devueltos</th><td>{{ number_format($summary['totalReturnsCost'], 2) }}</td></tr>
        <tr><th class="text-left">Utilidad Devuelta</th><td>{{ number_format($summary['totalReturnsUtil'], 2) }}</td></tr>
        <tr><th class="text-left">Gastos</th><td>{{ number_format($summary['totalSpents'], 2) }}</td></tr>
        <tr><th class="text-left">Ingresos Netos</th><td>{{ number_format($summary['ingresosNetos'], 2) }}</td></tr>
        <tr><th class="text-left">Utilidad Bruta</th><td>{{ number_format($summary['utilidadBruta'], 2) }}</td></tr>
        <tr><th class="text-left">Utilidad Operativa</th><td>{{ number_format($summary['utilidadOperativa'], 2) }}</td></tr>
    </table>
</body>
</html>
