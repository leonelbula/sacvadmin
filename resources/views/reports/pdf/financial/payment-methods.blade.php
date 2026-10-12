<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>
        Reporte Financiero - Métodos de Pago
    </title>

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
            text-align: center;
            font-size: 18px;
            margin-bottom: 5px;
        }

        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 15px;
        }

        .period {
            text-align: center;
            margin-bottom: 20px;
        }

        .summary {
            width: 100%;
            margin-bottom: 20px;
        }

        .summary-box {
            width: 31%;
            display: inline-block;
            vertical-align: top;
            border: 1px solid #ddd;
            padding: 10px;
            box-sizing: border-box;
            margin-right: 1%;
        }

        .summary-box:last-child {
            margin-right: 0;
        }

        .summary-title {
            font-size: 9px;
            color: #666;
        }

        .summary-value {
            font-size: 15px;
            font-weight: bold;
            margin-top: 5px;
        }

        .success {
            color: #198754;
        }

        .primary {
            color: #0d6efd;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th {
            background: #343a40;
            color: white;
            padding: 8px;
            text-align: left;
        }

        td {
            border-bottom: 1px solid #ddd;
            padding: 8px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .total {
            font-weight: bold;
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

    <h1>
        REPORTE FINANCIERO
    </h1>

    <div class="subtitle">
        Distribución de ventas por métodos de pago
    </div>

    <div class="period">

        <strong>Período:</strong>

        {{ $fechaDesde ?? 'Inicio' }}

        &nbsp; - &nbsp;

        {{ $fechaHasta ?? 'Actualidad' }}

    </div>

    <div class="summary">

        <div class="summary-box">

            <div class="summary-title">
                TOTAL RECAUDADO
            </div>

            <div class="summary-value success">

                $
                {{ number_format($total, 0, ',', '.') }}

            </div>

        </div>

        <div class="summary-box">

            <div class="summary-title">
                MÉTODOS DE PAGO
            </div>

            <div class="summary-value primary">
                {{ $quantity }}
            </div>

        </div>

        <div class="summary-box">

            <div class="summary-title">
                PARTICIPACIÓN
            </div>

            <div class="summary-value">
                100%
            </div>

        </div>

    </div>

    <table>

        <thead>

            <tr>

                <th>
                    Método de pago
                </th>

                <th class="text-center">
                    Cantidad
                </th>

                <th class="text-right">
                    Total
                </th>

                <th class="text-right">
                    Participación
                </th>

            </tr>

        </thead>

        <tbody>

            @forelse($paymentMethods as $paymentMethod)
                @php

                    $methodTotal = $paymentMethod->total ?? 0;

                    $percentage = $total > 0 ? ($methodTotal / $total) * 100 : 0;

                @endphp

                <tr>

                    <td>
                        {{ $paymentMethod->name }}
                    </td>

                    <td class="text-center">
                       {{ $paymentMethod->quantity }}
                    </td>

                    <td class="text-right success">

                        $
                        {{ number_format($methodTotal, 0, ',', '.') }}

                    </td>

                    <td class="text-right">

                        {{ number_format($percentage, 2, ',', '.') }}%

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="4" class="text-center">

                        No hay información para el período seleccionado.

                    </td>

                </tr>
            @endforelse

        </tbody>

        <tfoot>

            <tr>

                <th>
                    Total
                </th>

                <th class="text-center">
                    {{ $quantity }}
                </th>

                <th class="text-right success">

                    $
                    {{ number_format($total, 0, ',', '.') }}

                </th>

                <th class="text-right">
                    100%
                </th>

            </tr>

        </tfoot>

    </table>

    <div class="footer">
        Reporte generado por el sistema
    </div>

</body>

</html>
