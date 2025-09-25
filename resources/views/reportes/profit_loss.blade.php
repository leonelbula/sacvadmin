<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Ganancias y Pérdidas</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: right; }
        th { background: #f2f2f2; }
        td.text-left { text-align: left; }
    </style>
</head>
<body>
    <h2>Reporte de Ganancias y Pérdidas</h2>
    <p><strong>Desde:</strong> {{ $start }} <strong>Hasta:</strong> {{ $end }}</p>

    <table>
        <tr><th class="text-left">Concepto</th><th>Valor</th></tr>
        <tr><td class="text-left">Ventas Totales</td><td>{{ number_format($totalSales, 2) }}</td></tr>
        <tr><td class="text-left">Costos de Ventas</td><td>{{ number_format($totalSalesCost, 2) }}</td></tr>
        <tr><td class="text-left">Utilidad Ventas</td><td>{{ number_format($totalSalesUtil, 2) }}</td></tr>

        <tr><td class="text-left">Devoluciones Totales</td><td>{{ number_format($totalReturns, 2) }}</td></tr>
        <tr><td class="text-left">Costos Devueltos</td><td>{{ number_format($totalReturnsCost, 2) }}</td></tr>
        <tr><td class="text-left">Utilidad Devuelta</td><td>{{ number_format($totalReturnsUtil, 2) }}</td></tr>

        <tr><td class="text-left">Gastos</td><td>{{ number_format($totalSpents, 2) }}</td></tr>

        <tr><th class="text-left">Ingresos Netos</th><th>{{ number_format($ingresosNetos, 2) }}</th></tr>
        <tr><th class="text-left">Costo Neto</th><th>{{ number_format($costoNeto, 2) }}</th></tr>
        <tr><th class="text-left">Utilidad Bruta</th><th>{{ number_format($utilidadBruta, 2) }}</th></tr>
        <tr><th class="text-left">Utilidad Operativa</th><th>{{ number_format($utilidadOperativa, 2) }}</th></tr>
    </table>
</body>
</html>
