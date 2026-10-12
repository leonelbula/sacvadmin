<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Clientes Inactivos</title>

    <style>
        @page {
            size: letter landscape;
            margin: 12mm;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 9px;
            color: #222;
        }

        .header {
            text-align: center;
            margin-bottom: 18px;
        }

        .header h1 {
            margin: 0 0 5px;
            font-size: 18px;
        }

        .header p {
            margin: 3px 0;
            color: #666;
        }

        .summary {
            width: 100%;
            margin-bottom: 18px;
        }

        .summary td {
            width: 33.33%;
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        .summary-title {
            font-size: 8px;
            color: #666;
            margin-bottom: 4px;
        }

        .summary-value {
            font-size: 14px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #343a40;
            color: #fff;
            padding: 6px;
            border: 1px solid #343a40;
            text-align: left;
        }

        td {
            padding: 6px;
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

        .inactive {
            font-weight: bold;
        }

        .footer {
            margin-top: 15px;
            text-align: right;
            font-size: 8px;
            color: #777;
        }
    </style>

</head>

<body>

    <div class="header">

        <h1>
            REPORTE DE CLIENTES INACTIVOS
        </h1>

        <p>
            Clientes que no han realizado compras en el período seleccionado
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
                    CLIENTES INACTIVOS
                </div>

                <div class="summary-value">
                    {{ number_format($quantity) }}
                </div>

            </td>

            <td>

                <div class="summary-title">
                    COMPRAS REGISTRADAS
                </div>

                <div class="summary-value">
                    {{ number_format($clients->sum('quantity')) }}
                </div>

            </td>

            <td>

                <div class="summary-title">
                    TOTAL COMPRADO
                </div>

                <div class="summary-value">
                    $
                    {{ number_format($total, 0, ',', '.') }}
                </div>

            </td>

        </tr>

    </table>

    <table>

        <thead>

            <tr>

                <th>
                    Cliente
                </th>

                <th>
                    Identificación
                </th>

                <th>
                    Teléfono
                </th>

                <th class="center">
                    Última compra
                </th>

                <th class="center">
                    Días inactivo
                </th>

                <th class="center">
                    Compras
                </th>

                <th class="right">
                    Total comprado
                </th>

            </tr>

        </thead>

        <tbody>

            @forelse($clients as $client)
                <tr>

                    <td class="inactive">
                        {{ $client->name }}
                    </td>

                    <td>
                        {{ $client->identification }}
                    </td>

                    <td>
                        {{ $client->phone ?? 'Sin teléfono' }}
                    </td>

                    <td class="center">

                        @if ($client->last_purchase)
                            {{ \Carbon\Carbon::parse($client->last_purchase)->format('d/m/Y') }}
                        @else
                            Nunca ha comprado
                        @endif

                    </td>

                    <td class="center">

                        @if ($client->days_inactive !== null)
                            {{ $client->days_inactive }} días
                        @else
                            Sin compras
                        @endif

                    </td>

                    <td class="center">
                        {{ $client->quantity }}
                    </td>

                    <td class="right">

                        $
                        {{ number_format($client->total_purchases, 0, ',', '.') }}

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="7" class="center">
                        No hay clientes inactivos para el período seleccionado.
                    </td>

                </tr>
            @endforelse

        </tbody>

        @if ($clients->count() > 0)
            <tfoot>

                <tr class="total">

                    <td colspan="5">
                        TOTAL
                    </td>

                    <td class="center">
                        {{ number_format($clients->sum('quantity')) }}
                    </td>

                    <td class="right">
                        $
                        {{ number_format($clients->sum('total_purchases'), 0, ',', '.') }}
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
