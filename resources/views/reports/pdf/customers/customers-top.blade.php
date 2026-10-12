<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Mejores Clientes</title>

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

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0 0 5px;
            font-size: 20px;
        }

        .header p {
            margin: 2px 0;
            color: #666;
        }

        .summary {
            width: 100%;
            margin-bottom: 20px;
        }

        .summary td {
            width: 33.33%;
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        .summary-title {
            font-size: 9px;
            color: #666;
            margin-bottom: 5px;
        }

        .summary-value {
            font-size: 15px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #343a40;
            color: white;
            padding: 7px;
            border: 1px solid #343a40;
            text-align: left;
        }

        td {
            padding: 7px;
            border: 1px solid #ddd;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .total {
            font-weight: bold;
            background: #f1f1f1;
        }

        .position {
            font-weight: bold;
            text-align: center;
        }

        .date-filter {
            text-align: center;
            margin-bottom: 15px;
        }

        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 8px;
            color: #777;
        }
    </style>

</head>

<body>

    <div class="header">

        <h1>REPORTE DE MEJORES CLIENTES</h1>

        <p>
            Ranking de clientes por volumen de compras
        </p>

        @if ($fechaDesde || $fechaHasta)
            <p>
                Período:
                {{ $fechaDesde ?? 'Inicio' }}
                -
                {{ $fechaHasta ?? 'Actualidad' }}
            </p>
        @endif

    </div>

    <table class="summary">

        <tr>

            <td>
                <div class="summary-title">
                    CLIENTES
                </div>

                <div class="summary-value">
                    {{ number_format($quantity) }}
                </div>
            </td>

            <td>
                <div class="summary-title">
                    VENTAS
                </div>

                <div class="summary-value">
                    {{ number_format($clients->sum('quantity')) }}
                </div>
            </td>

            <td>
                <div class="summary-title">
                    TOTAL VENDIDO
                </div>

                <div class="summary-value">
                    $ {{ number_format($total, 0, ',', '.') }}
                </div>
            </td>

        </tr>

    </table>

    <table>

        <thead>

            <tr>

                <th class="center">
                    #
                </th>

                <th>
                    Cliente
                </th>

                <th>
                    Identificación
                </th>

                <th class="center">
                    Ventas
                </th>

                <th class="right">
                    Total comprado
                </th>

                <th class="right">
                    Participación
                </th>

            </tr>

        </thead>

        <tbody>

            @forelse($clients as $index => $client)
                @php
                    $percentage = $total > 0 ? ($client->total / $total) * 100 : 0;
                @endphp

                <tr>

                    <td class="position">
                        {{ $index + 1 }}
                    </td>

                    <td>
                        {{ $client->name }}
                    </td>

                    <td>
                        {{ $client->identification }}
                    </td>

                    <td class="center">
                        {{ $client->quantity }}
                    </td>

                    <td class="right">
                        $ {{ number_format($client->total, 0, ',', '.') }}
                    </td>

                    <td class="right">
                        {{ number_format($percentage, 2, ',', '.') }}%
                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="6" class="center">
                        No hay clientes con ventas en el período seleccionado.
                    </td>

                </tr>
            @endforelse

        </tbody>

        @if ($clients->count() > 0)
            <tfoot>

                <tr class="total">

                    <td colspan="3">
                        TOTAL
                    </td>

                    <td class="center">
                        {{ number_format($clients->sum('quantity')) }}
                    </td>

                    <td class="right">
                        $ {{ number_format($total, 0, ',', '.') }}
                    </td>

                    <td class="right">
                        100%
                    </td>

                </tr>

            </tfoot>
        @endif

    </table>

    <div class="footer">

        Generado el {{ now()->format('d/m/Y H:i') }}

    </div>

</body>

</html>
