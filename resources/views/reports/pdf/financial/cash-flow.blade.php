<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Reporte de Flujo de Caja</title>

    <style>
        @page {
            size: letter portrait;
            margin: 15mm;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #222;
        }

        h1 {
            font-size: 18px;
            text-align: center;
            margin-bottom: 5px;
        }

        h2 {
            font-size: 13px;
            margin-top: 20px;
            margin-bottom: 8px;
        }

        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 20px;
        }

        .period {
            text-align: center;
            margin-bottom: 20px;
        }

        .cards {
            width: 100%;
            margin-bottom: 15px;
        }

        .card {
            width: 24%;
            display: inline-block;
            vertical-align: top;
            border: 1px solid #ddd;
            padding: 8px;
            box-sizing: border-box;
            margin-right: 1%;
        }

        .card:last-child {
            margin-right: 0;
        }

        .card-title {
            font-size: 9px;
            color: #666;
        }

        .card-value {
            font-size: 14px;
            font-weight: bold;
            margin-top: 5px;
        }

        .success {
            color: #198754;
        }

        .danger {
            color: #dc3545;
        }

        .primary {
            color: #0d6efd;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th {
            background: #343a40;
            color: white;
            padding: 7px;
            text-align: left;
        }

        td {
            border-bottom: 1px solid #ddd;
            padding: 7px;
        }

        .text-right {
            text-align: right;
        }

        .total {
            font-weight: bold;
            font-size: 12px;
        }

        .summary-box {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 15px;
        }

        .summary-row {
            width: 100%;
            padding: 5px 0;
            border-bottom: 1px solid #eee;
        }

        .summary-label {
            display: inline-block;
            width: 70%;
        }

        .summary-value {
            display: inline-block;
            width: 28%;
            text-align: right;
        }

        .final-balance {
            border: 2px solid #333;
            padding: 12px;
            margin-top: 20px;
            text-align: center;
        }

        .final-value {
            font-size: 18px;
            font-weight: bold;
            margin-top: 5px;
        }

        .footer {
            margin-top: 25px;
            text-align: center;
            color: #777;
            font-size: 8px;
        }
    </style>

</head>

<body>

    <h1>REPORTE DE FLUJO DE CAJA</h1>

    <div class="subtitle">
        Resumen financiero del período
    </div>

    <div class="period">

        <strong>Período:</strong>

        {{ $fechaDesde ?? 'Inicio' }}

        &nbsp; - &nbsp;

        {{ $fechaHasta ?? 'Actualidad' }}

    </div>

    <div class="cards">

        <div class="card">
            <div class="card-title">
                INGRESOS
            </div>

            <div class="card-value success">
                $ {{ number_format($income, 0, ',', '.') }}
            </div>
        </div>

        <div class="card">
            <div class="card-title">
                EGRESOS
            </div>

            <div class="card-value danger">
                $ {{ number_format($outcome, 0, ',', '.') }}
            </div>
        </div>

        <div class="card">
            <div class="card-title">
                FLUJO NETO
            </div>

            <div class="card-value {{ $netCashFlow >= 0 ? 'success' : 'danger' }}">
                $ {{ number_format($netCashFlow, 0, ',', '.') }}
            </div>
        </div>

        <div class="card">
            <div class="card-title">
                DINERO ENTREGADO
            </div>

            <div class="card-value primary">
                $ {{ number_format($totalDelivered, 0, ',', '.') }}
            </div>
        </div>

    </div>

    <h2>Detalle del movimiento</h2>

    <table>

        <thead>
            <tr>
                <th>Concepto</th>
                <th>Tipo</th>
                <th class="text-right">Valor</th>
            </tr>
        </thead>

        <tbody>

            <tr>
                <td>Ventas</td>
                <td>Ingreso</td>
                <td class="text-right success">
                    $ {{ number_format($salesTotal, 0, ',', '.') }}
                </td>
            </tr>

            <tr>
                <td>Compras</td>
                <td>Egreso</td>
                <td class="text-right danger">
                    $ {{ number_format($purchases, 0, ',', '.') }}
                </td>
            </tr>

            <tr>
                <td>Gastos</td>
                <td>Egreso</td>
                <td class="text-right danger">
                    $ {{ number_format($expenses, 0, ',', '.') }}
                </td>
            </tr>

            <tr>
                <td>Devoluciones de ventas</td>
                <td>Egreso</td>
                <td class="text-right danger">
                    $ {{ number_format($totalReturnsSale, 0, ',', '.') }}
                </td>
            </tr>

            <tr>
                <td>Dinero entregado</td>
                <td>Movimiento</td>
                <td class="text-right primary">
                    $ {{ number_format($totalDelivered, 0, ',', '.') }}
                </td>
            </tr>

            <tr>
                <td>Sobrantes de caja</td>
                <td>Ajuste</td>
                <td class="text-right success">
                    $ {{ number_format($surplus, 0, ',', '.') }}
                </td>
            </tr>

            <tr>
                <td>Faltantes de caja</td>
                <td>Ajuste</td>
                <td class="text-right danger">
                    $ {{ number_format($shortage, 0, ',', '.') }}
                </td>
            </tr>

        </tbody>

    </table>

    <h2>Resumen de ingresos</h2>

    <div class="summary-box">

        <div class="summary-row">
            <span class="summary-label">
                Ventas
            </span>

            <span class="summary-value success">
                $ {{ number_format($salesTotal, 0, ',', '.') }}
            </span>
        </div>

        <div class="summary-row total">
            <span class="summary-label">
                Total ingresos
            </span>

            <span class="summary-value">
                $ {{ number_format($income, 0, ',', '.') }}
            </span>
        </div>

    </div>

    <h2>Resumen de egresos</h2>

    <div class="summary-box">

        <div class="summary-row">
            <span class="summary-label">
                Compras
            </span>

            <span class="summary-value danger">
                $ {{ number_format($purchases, 0, ',', '.') }}
            </span>
        </div>

        <div class="summary-row">
            <span class="summary-label">
                Gastos
            </span>

            <span class="summary-value danger">
                $ {{ number_format($expenses, 0, ',', '.') }}
            </span>
        </div>

        <div class="summary-row">
            <span class="summary-label">
                Devoluciones
            </span>

            <span class="summary-value danger">
                $ {{ number_format($totalReturnsSale, 0, ',', '.') }}
            </span>
        </div>

        <div class="summary-row total">
            <span class="summary-label">
                Total egresos
            </span>

            <span class="summary-value">
                $ {{ number_format($outcome, 0, ',', '.') }}
            </span>
        </div>

    </div>

    <h2>Información de cierres de caja</h2>

    <table>

        <thead>
            <tr>
                <th>Concepto</th>
                <th class="text-right">Valor</th>
            </tr>
        </thead>

        <tbody>

            <tr>
                <td>Efectivo</td>
                <td class="text-right">
                    $ {{ number_format($totalCash, 0, ',', '.') }}
                </td>
            </tr>

            <tr>
                <td>Consignaciones</td>
                <td class="text-right">
                    $ {{ number_format($totalConsignment, 0, ',', '.') }}
                </td>
            </tr>

            <tr>
                <td>Devoluciones de ventas</td>
                <td class="text-right">
                    $ {{ number_format($totalReturnsSale, 0, ',', '.') }}
                </td>
            </tr>

            <tr>
                <td>Dinero entregado</td>
                <td class="text-right">
                    $ {{ number_format($totalDelivered, 0, ',', '.') }}
                </td>
            </tr>

            <tr>
                <td>Sobrantes</td>
                <td class="text-right success">
                    $ {{ number_format($surplus, 0, ',', '.') }}
                </td>
            </tr>

            <tr>
                <td>Faltantes</td>
                <td class="text-right danger">
                    $ {{ number_format($shortage, 0, ',', '.') }}
                </td>
            </tr>

        </tbody>

    </table>

    <div class="final-balance">

        FLUJO NETO DE CAJA

        <div class="final-value {{ $netCashFlow >= 0 ? 'success' : 'danger' }}">
            $ {{ number_format($balance, 0, ',', '.') }}
        </div>

    </div>

    <div class="footer">
        Reporte generado por el sistema
    </div>

</body>

</html>
