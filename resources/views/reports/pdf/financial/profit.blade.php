<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <title>Reporte Financiero</title>

    <style>
        @page {
            size: letter portrait;
            margin: 15mm;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #222;
        }

        h1 {
            text-align: center;
            margin-bottom: 5px;
        }

        .periodo {
            text-align: center;
            margin-bottom: 20px;
            color: #555;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 8px;
        }

        .summary {
            width: 100%;
            margin-bottom: 15px;
        }

        .summary td {
            width: 25%;
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        .label {
            font-size: 9px;
            color: #666;
        }

        .value {
            font-size: 13px;
            font-weight: bold;
            margin-top: 5px;
        }

        table.report {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table.report th {
            background: #eeeeee;
            border: 1px solid #ccc;
            padding: 7px;
            text-align: left;
        }

        table.report td {
            border: 1px solid #ccc;
            padding: 7px;
        }

        .text-right {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }

        .positive {
            color: #198754;
        }

        .negative {
            color: #dc3545;
        }

        .highlight {
            background: #eeeeee;
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 9px;
            color: #777;
        }
    </style>

</head>

<body>

    <h1>REPORTE FINANCIERO</h1>

    <div class="periodo">
        Periodo:
        {{ $fechaDesde ?: 'Inicio' }}
        -
        {{ $fechaHasta ?: 'Actualidad' }}
    </div>

    <table class="summary">

        <tr>

            <td>
                <div class="label">Ventas totales</div>
                <div class="value">
                    ${{ number_format($salesTotal, 0, ',', '.') }}
                </div>
            </td>

            <td>
                <div class="label">Costo de ventas</div>
                <div class="value">
                    ${{ number_format($costTotal, 0, ',', '.') }}
                </div>
            </td>

            <td>
                <div class="label">Utilidad bruta</div>
                <div class="value">
                    ${{ number_format($grossProfit, 0, ',', '.') }}
                </div>
            </td>

            <td>
                <div class="label">Gastos</div>
                <div class="value">
                    ${{ number_format($expensesTotal, 0, ',', '.') }}
                </div>
            </td>

        </tr>

    </table>

    <div class="section-title">
        Resumen de caja
    </div>

    <table class="report">

        <thead>
            <tr>
                <th>Concepto</th>
                <th class="text-right">Valor</th>
            </tr>
        </thead>

        <tbody>

            <tr>
                <td>Total efectivo</td>
                <td class="text-right">
                    ${{ number_format($totalCash, 0, ',', '.') }}
                </td>
            </tr>

            <tr>
                <td>Total consignaciones</td>
                <td class="text-right">
                    ${{ number_format($totalConsignment, 0, ',', '.') }}
                </td>
            </tr>

            <tr>
                <td>Devoluciones en ventas</td>
                <td class="text-right">
                    ${{ number_format($totalReturnsSale, 0, ',', '.') }}
                </td>
            </tr>

            <tr>
                <td>Total entregado</td>
                <td class="text-right">
                    ${{ number_format($totalDelivered, 0, ',', '.') }}
                </td>
            </tr>

            <tr>
                <td>Sobrantes</td>
                <td class="text-right positive">
                    ${{ number_format($surplus, 0, ',', '.') }}
                </td>
            </tr>

            <tr>
                <td>Faltantes</td>
                <td class="text-right negative">
                    ${{ number_format($shortage, 0, ',', '.') }}
                </td>
            </tr>

            <tr class="highlight">
                <td>Diferencia neta de caja</td>
                <td class="text-right">
                    ${{ number_format($netCashDifference, 0, ',', '.') }}
                </td>
            </tr>

        </tbody>

    </table>

    <div class="section-title">
        Resultado financiero
    </div>

    <table class="report">

        <thead>
            <tr>
                <th>Concepto</th>
                <th class="text-right">Valor</th>
            </tr>
        </thead>

        <tbody>

            <tr>
                <td>Ventas totales</td>
                <td class="text-right">
                    ${{ number_format($salesTotal, 0, ',', '.') }}
                </td>
            </tr>

            <tr>
                <td>Costo de ventas</td>
                <td class="text-right">
                    ${{ number_format($costTotal, 0, ',', '.') }}
                </td>
            </tr>

            <tr>
                <td>Utilidad bruta</td>
                <td class="text-right">
                    ${{ number_format($grossProfit, 0, ',', '.') }}
                </td>
            </tr>

            <tr>
                <td>Gastos</td>
                <td class="text-right">
                    ${{ number_format($expensesTotal, 0, ',', '.') }}
                </td>
            </tr>

            <tr class="bold">
                <td>Utilidad neta</td>
                <td class="text-right">
                    ${{ number_format($netProfit, 0, ',', '.') }}
                </td>
            </tr>

            <tr>
                <td>Diferencia neta de caja</td>
                <td class="text-right">
                    ${{ number_format($netCashDifference, 0, ',', '.') }}
                </td>
            </tr>

            <tr class="highlight">
                <td>UTILIDAD AJUSTADA</td>
                <td class="text-right">
                    ${{ number_format($adjustedProfit, 0, ',', '.') }}
                </td>
            </tr>

            <tr>
                <td>Margen de utilidad</td>
                <td class="text-right bold">
                    {{ number_format($profitMargin, 2, ',', '.') }}%
                </td>
            </tr>

        </tbody>

    </table>

    <div class="footer">
        Reporte generado el {{ now()->format('d/m/Y H:i') }}
    </div>

</body>

</html>
