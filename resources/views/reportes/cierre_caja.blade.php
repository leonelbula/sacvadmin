<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Cierre de Caja</title>
    <style>
        body {
            font-family: monospace;
            font-size: 12px;
            margin: 0;
            padding: 5px;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .line {
            border-top: 1px dashed #000;
            margin: 5px 0;
        }

        table {
            width: 100%;
            font-size: 12px;
        }

        td {
            padding: 2px 0;
        }
    </style>
</head>

<body>

    <div class="center">
        <h3>Cierre de Caja</h3>
        <p>Ticket #{{ $box->id }}</p>
        <div class="line"></div>
    </div>

    <p><strong>Cajero:</strong> {{ $user->name ?? 'N/A' }}</p>
    <p><strong>Estado:</strong> Cerrado</p>

    <div class="line"></div>

    <table>
        <tr>
            <td>Base:</td>
            <td class="right">{{ number_format($box->box_base, 2, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Total Ventas:</td>
            <td class="right">{{ number_format($box->total_sale, 2, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Devoluciones:</td>
            <td class="right">{{ number_format($box->returns_sale, 2, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Consignación:</td>
            <td class="right">{{ number_format($box->consignment, 2, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Efectivo:</td>
            <td class="right">{{ number_format($box->cash, 2, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Gastos:</td>
            <td class="right">{{ number_format($box->bills, 2, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Entregado:</td>
            <td class="right">{{ number_format($box->delivered_value, 2, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Diferencia:</td>
            <td class="right">{{ number_format($box->difference, 2, ',', '.') }}</td>
        </tr>
    </table>

    <div class="line"></div>

    <p><strong>Apertura:</strong><br>
        {{ $box->start_date }} {{ $box->start_time }}</p>
    <p><strong>Cierre:</strong><br>
        {{ $box->closing_date }} {{ $box->closing_time }}</p>

    <div class="line"></div>

    <p class="center">*** Fin del Reporte ***</p>

</body>

</html>
