<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <title>Reporte de Gastos por Tipo</title>

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

        .header {
            border-bottom: 2px solid #222;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .title {
            font-size: 18px;
            font-weight: bold;
        }

        .subtitle {
            color: #666;
            font-size: 9px;
            margin-top: 4px;
        }

        .date-info {
            text-align: right;
            font-size: 9px;
        }

        .filters {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .filters td {
            border: 1px solid #ddd;
            padding: 7px;
        }

        .label {
            font-weight: bold;
            color: #555;
        }

        .summary {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
        }

        .summary td {
            width: 33.33%;
            border: 1px solid #ddd;
            padding: 9px;
        }

        .summary-label {
            font-size: 8px;
            color: #666;
            text-transform: uppercase;
        }

        .summary-value {
            font-size: 14px;
            font-weight: bold;
            margin-top: 3px;
        }

        .report {
            width: 100%;
            border-collapse: collapse;
        }

        .report th {
            background: #343a40;
            color: #fff;
            padding: 7px 5px;
            border: 1px solid #343a40;
            font-size: 8px;
            text-align: left;
        }

        .report td {
            padding: 7px 5px;
            border: 1px solid #ddd;
            vertical-align: middle;
        }

        .report tbody tr:nth-child(even) {
            background: #f8f9fa;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .total-row td {
            background: #e9ecef;
            font-weight: bold;
        }

        .empty {
            text-align: center;
            padding: 25px;
            color: #777;
        }

        .footer {
            position: fixed;
            bottom: -10px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 8px;
            color: #777;
        }

        .percentage {
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="header">

        <table class="header-table">

            <tr>

                <td>

                    <div class="title">
                        REPORTE DE GASTOS POR TIPO
                    </div>

                    <div class="subtitle">
                        Resumen de gastos agrupados por tipo
                    </div>

                </td>

                <td class="date-info">

                    <strong>Generado:</strong><br>

                    {{ now()->format('d/m/Y H:i') }}

                </td>

            </tr>

        </table>

    </div>

    <table class="filters">

        <tr>

            <td>

                <span class="label">
                    Fecha desde:
                </span>

                {{ $fechaDesde ? \Carbon\Carbon::parse($fechaDesde)->format('d/m/Y') : 'Inicio' }}

            </td>

            <td>

                <span class="label">
                    Fecha hasta:
                </span>

                {{ $fechaHasta ? \Carbon\Carbon::parse($fechaHasta)->format('d/m/Y') : 'Actual' }}

            </td>

        </tr>

    </table>

    <table class="summary">

        <tr>

            <td>

                <div class="summary-label">
                    Tipos de gasto
                </div>

                <div class="summary-value">
                    {{ number_format($types->count(), 0, ',', '.') }}
                </div>

            </td>

            <td>

                <div class="summary-label">
                    Gastos registrados
                </div>

                <div class="summary-value">
                    {{ number_format($quantity ?? 0, 0, ',', '.') }}
                </div>

            </td>

            <td>

                <div class="summary-label">
                    Total de gastos
                </div>

                <div class="summary-value">
                    ${{ number_format($total ?? 0, 0, ',', '.') }}
                </div>

            </td>

        </tr>

    </table>

    <table class="report">

        <thead>

            <tr>

                <th width="7%">
                    #
                </th>

                <th width="43%">
                    Tipo de gasto
                </th>

                <th width="18%" class="text-center">
                    Cantidad
                </th>

                <th width="20%" class="text-right">
                    Total
                </th>

                <th width="12%" class="text-right">
                    %
                </th>

            </tr>

        </thead>

        <tbody>

            @forelse($types as $type)
                @php
                    $percentage = ($total ?? 0) > 0 ? (($type->total ?? 0) / $total) * 100 : 0;
                @endphp

                <tr>

                    <td class="text-center">
                        {{ $loop->iteration }}
                    </td>

                    <td>
                        {{ $type->description ?? 'Sin tipo' }}
                    </td>

                    <td class="text-center">
                        {{ number_format($type->quantity ?? 0, 0, ',', '.') }}
                    </td>

                    <td class="text-right">
                        ${{ number_format($type->total ?? 0, 0, ',', '.') }}
                    </td>

                    <td class="text-right percentage">
                        {{ number_format($percentage, 2, ',', '.') }}%
                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="5" class="empty">
                        No se encontraron gastos para el periodo seleccionado.
                    </td>

                </tr>
            @endforelse

            @if ($types->count())
                <tr class="total-row">

                    <td colspan="2" class="text-right">
                        TOTAL GENERAL
                    </td>

                    <td class="text-center">
                        {{ number_format($quantity ?? 0, 0, ',', '.') }}
                    </td>

                    <td class="text-right">
                        ${{ number_format($total ?? 0, 0, ',', '.') }}
                    </td>

                    <td class="text-right">
                        100%
                    </td>

                </tr>
            @endif

        </tbody>

    </table>

    <div class="footer">
        Reporte de gastos por tipo generado el
        {{ now()->format('d/m/Y H:i') }}
    </div>

</body>

</html>
