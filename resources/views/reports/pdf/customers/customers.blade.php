
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>
        Reporte de Compras por Clientes
    </title>

    <style>

        @page {
            size: letter portrait;
            margin: 15mm;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 9px;
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

        .info {
            color: #0dcaf0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
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
        REPORTE DE COMPRAS POR CLIENTES
    </h1>

    <div class="subtitle">
        Resumen de compras por cliente
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
                CLIENTES
            </div>

            <div class="summary-value primary">
                {{ $quantity }}
            </div>

        </div>

        <div class="summary-box">

            <div class="summary-title">
                TOTAL VENDIDO
            </div>

            <div class="summary-value success">

                $
                {{ number_format(
                    $total,
                    0,
                    ',',
                    '.'
                ) }}

            </div>

        </div>

        <div class="summary-box">

            <div class="summary-title">
                PROMEDIO POR CLIENTE
            </div>

            <div class="summary-value info">

                $
                {{ number_format(
                    $quantity > 0
                        ? $total / $quantity
                        : 0,
                    0,
                    ',',
                    '.'
                ) }}

            </div>

        </div>

    </div>

    <table>

        <thead>

            <tr>

                <th>
                    Cliente
                </th>

                <th>
                    Identificación
                </th>

                <th class="text-center">
                    Ventas
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

            @forelse($clients as $client)

                @php

                    $clientTotal =
                        $client->total ?? 0;

                    $percentage =
                        $total > 0
                            ? ($clientTotal / $total) * 100
                            : 0;

                @endphp

                <tr>

                    <td>
                        {{ $client->name }}
                    </td>

                    <td>
                        {{ $client->identification ?? 'N/A' }}
                    </td>

                    <td class="text-center">
                        {{ $client->quantity ?? 0 }}
                    </td>

                    <td class="text-right success">

                        $
                        {{ number_format(
                            $clientTotal,
                            0,
                            ',',
                            '.'
                        ) }}

                    </td>

                    <td class="text-right">

                        {{ number_format(
                            $percentage,
                            2,
                            ',',
                            '.'
                        ) }}%

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="5"
                        class="text-center">

                        No hay clientes para el período seleccionado.

                    </td>

                </tr>

            @endforelse

        </tbody>

        <tfoot>

            <tr>

                <th colspan="2">
                    Total
                </th>

                <th class="text-center">
                    {{ $quantity }}
                </th>

                <th class="text-right success">

                    $
                    {{ number_format(
                        $total,
                        0,
                        ',',
                        '.'
                    ) }}

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

