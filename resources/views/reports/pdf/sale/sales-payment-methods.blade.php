<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <title>Reporte de ventas por método de pago</title>

    <style>
        * {
            box-sizing: border-box;
        }

        @page {
            size: letter portrait;
            margin: 15mm;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #222;
            margin: 30px;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
        }

        .header h1 {
            margin: 0 0 5px 0;
            font-size: 20px;
        }

        .header p {
            margin: 3px 0;
            color: #555;
        }

        .periodo {
            width: 100%;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            padding: 10px;
        }

        .periodo table {
            width: 100%;
            border-collapse: collapse;
        }

        .periodo td {
            padding: 4px;
        }

        .label {
            font-weight: bold;
        }

        .summary {
            width: 100%;
            margin-bottom: 20px;
        }

        .summary td {
            width: 33.33%;
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }

        .summary-title {
            display: block;
            font-size: 10px;
            color: #198754;
            margin-bottom: 5px;
        }

        .summary-value {
            display: block;
            font-size: 16px;
            font-weight: bold;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table th {
            background-color: #198754;
            color: white;
            padding: 9px;
            border: 1px solid #198754;
            text-align: left;
        }

        .table td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .total-row {
            font-weight: bold;
            background-color: #f1f1f1;
        }

        .empty {
            text-align: center;
            padding: 20px;
            color: #777;
        }

        .footer {
            margin-top: 30px;
            border-top: 1px solid #ddd;
            padding-top: 8px;
            font-size: 9px;
            color: #777;
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="header">

        <h1>Reporte de Ventas por Método de Pago</h1>

        <p>
            Reporte generado el {{ now()->format('d/m/Y H:i') }}
        </p>

    </div>

    <div class="periodo">

        <table>

            <tr>

                <td class="label">
                    Fecha desde:
                </td>

                <td>
                    {{ $fechaDesde ?? 'Todas' }}
                </td>

                <td class="label">
                    Fecha hasta:
                </td>

                <td>
                    {{ $fechaHasta ?? 'Todas' }}
                </td>

            </tr>

        </table>

    </div>

    <table class="summary">

        <tr>

            <td>

                <span class="summary-title">
                    Cantidad de ventas
                </span>

                <span class="summary-value">
                    {{ number_format($quantity ?? 0, 0, ',', '.') }}
                </span>

            </td>

            <td>

                <span class="summary-title">
                    Total de ventas
                </span>

                <span class="summary-value">
                    $ {{ number_format($total ?? 0, 0, ',', '.') }}
                </span>

            </td>

            <td>

                <span class="summary-title">
                    Métodos de pago
                </span>

                <span class="summary-value">
                    {{ $payments->count() }}
                </span>

            </td>

        </tr>

    </table>

    <table class="table">

        <thead>

            <tr>

                <th style="width: 10%;" class="text-center">
                    #
                </th>

                <th style="width: 45%;">
                    Método de pago
                </th>

                <th style="width: 20%;" class="text-center">
                    Cantidad
                </th>

                <th style="width: 25%;" class="text-right">
                    Total
                </th>

            </tr>

        </thead>

        <tbody>

            @forelse($payments as $index => $payment)
                <tr>

                    <td class="text-center">
                        {{ $index + 1 }}
                    </td>

                    <td>
                        {{ $payment->name }}
                    </td>

                    <td class="text-center">
                        {{ number_format($payment->quantity, 0, ',', '.') }}
                    </td>

                    <td class="text-right">
                        $ {{ number_format($payment->total, 0, ',', '.') }}
                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="4" class="empty">
                        No existen ventas para el período seleccionado.
                    </td>

                </tr>
            @endforelse

        </tbody>

        @if ($payments->count() > 0)
            <tfoot>

                <tr class="total-row">

                    <td colspan="2" class="text-right">
                        TOTAL
                    </td>

                    <td class="text-center">
                        {{ number_format($quantity ?? 0, 0, ',', '.') }}
                    </td>

                    <td class="text-right">
                        $ {{ number_format($total ?? 0, 0, ',', '.') }}
                    </td>

                </tr>

            </tfoot>
        @endif

    </table>

    <div class="footer">

        Reporte de ventas por método de pago

    </div>

</body>

</html>
