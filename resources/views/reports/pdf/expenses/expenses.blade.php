<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <title>Reporte de Gastos</title>

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

        .header-title {
            font-size: 18px;
            font-weight: bold;
        }

        .header-subtitle {
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

        .filters-label {
            font-weight: bold;
            color: #555;
        }

        .summary {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
        }

        .summary td {
            width: 50%;
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

        table.report {
            width: 100%;
            border-collapse: collapse;
        }

        table.report th {
            background: #343a40;
            color: #fff;
            padding: 7px 5px;
            border: 1px solid #343a40;
            font-size: 8px;
            text-align: left;
        }

        table.report td {
            padding: 6px 5px;
            border: 1px solid #ddd;
            vertical-align: top;
        }

        table.report tbody tr:nth-child(even) {
            background: #f8f9fa;
        }

        .text-right {
            text-align: right !important;
        }

        .text-center {
            text-align: center !important;
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

        .small {
            font-size: 8px;
            color: #666;
        }
    </style>
</head>

<body>

    <div class="header">
        <table class="header-table">
            <tr>
                <td>
                    <div class="header-title">
                        REPORTE DE GASTOS
                    </div>

                    <div class="header-subtitle">
                        Detalle de gastos registrados por fecha
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
                <span class="filters-label">Fecha desde:</span>
                {{ $fechaDesde ? \Carbon\Carbon::parse($fechaDesde)->format('d/m/Y') : 'Inicio' }}
            </td>

            <td>
                <span class="filters-label">Fecha hasta:</span>
                {{ $fechaHasta ? \Carbon\Carbon::parse($fechaHasta)->format('d/m/Y') : 'Actual' }}
            </td>
        </tr>
    </table>

    <table class="summary">
        <tr>
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
                <th width="4%">#</th>
                <th width="9%">Fecha</th>
                <th width="22%">Descripción</th>
                <th width="14%">Entregado a</th>
                <th width="14%">Tipo</th>
                <th width="14%">Método de pago</th>
                <th width="23%" class="text-right">Total</th>
            </tr>
        </thead>

        <tbody>

            @forelse($expenses as $expense)
                <tr>
                    <td class="text-center">
                        {{ $loop->iteration }}
                    </td>

                    <td>
                        {{ \Carbon\Carbon::parse($expense->date)->format('d/m/Y') }}
                    </td>

                    <td>
                        <strong>
                            {{ $expense->description }}
                        </strong>

                        @if ($expense->observation)
                            <br>
                            <span class="small">
                                {{ $expense->observation }}
                            </span>
                        @endif
                    </td>

                    <td>
                        {{ $expense->delivered_to ?? 'N/A' }}
                    </td>

                    <td>
                        {{ $expense->typeExpense?->description ?? 'N/A' }}
                    </td>

                    <td>
                        {{ $expense->paymentMethod?->name ?? 'N/A' }}
                    </td>

                    <td class="text-right">
                        ${{ number_format($expense->total ?? 0, 0, ',', '.') }}
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="7" class="empty">
                        No se encontraron gastos para el periodo seleccionado.
                    </td>
                </tr>
            @endforelse

            @if ($expenses->count())
                <tr class="total-row">
                    <td colspan="6" class="text-right">
                        TOTAL GASTOS
                    </td>

                    <td class="text-right">
                        ${{ number_format($total ?? 0, 0, ',', '.') }}
                    </td>
                </tr>
            @endif

        </tbody>

    </table>

    <div class="footer">
        Reporte de gastos generado el
        {{ now()->format('d/m/Y H:i') }}
    </div>

</body>

</html>
