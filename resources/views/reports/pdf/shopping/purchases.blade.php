<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Compras</title>

    <style>
        @page {
            margin: 25px 25px 35px 25px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 9px;
            color: #222;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #222;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .header h1 {
            margin: 0;
            font-size: 18px;
        }

        .header p {
            margin: 4px 0 0;
            font-size: 10px;
        }

        .filters {
            width: 100%;
            margin-bottom: 15px;
        }

        .filters td {
            padding: 4px;
            border: 1px solid #ddd;
        }

        .filters .label {
            font-weight: bold;
            background: #f2f2f2;
            width: 20%;
        }

        .summary {
            width: 100%;
            margin-bottom: 15px;
        }

        .summary td {
            width: 20%;
            border: 1px solid #ddd;
            padding: 7px;
            text-align: center;
        }

        .summary .label {
            display: block;
            font-size: 8px;
            color: #666;
            margin-bottom: 4px;
        }

        .summary .value {
            display: block;
            font-size: 11px;
            font-weight: bold;
        }

        table.report {
            width: 100%;
            border-collapse: collapse;
        }

        table.report th {
            background: #e9ecef;
            border: 1px solid #999;
            padding: 6px 4px;
            font-size: 8px;
            text-align: center;
        }

        table.report td {
            border: 1px solid #ccc;
            padding: 5px 4px;
            font-size: 8px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .total-row {
            font-weight: bold;
            background: #f2f2f2;
        }

        .negative {
            color: #b00020;
        }

        .footer {
            position: fixed;
            bottom: -20px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 8px;
            color: #666;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>REPORTE DE COMPRAS</h1>

        @if($fechaDesde || $fechaHasta)
            <p>
                Periodo:
                {{ $fechaDesde ? \Carbon\Carbon::parse($fechaDesde)->format('d/m/Y') : 'Inicio' }}
                -
                {{ $fechaHasta ? \Carbon\Carbon::parse($fechaHasta)->format('d/m/Y') : 'Actual' }}
            </p>
        @else
            <p>Todos los registros</p>
        @endif
    </div>

    <table class="filters">
        <tr>
            <td class="label">Fecha desde</td>
            <td>
                {{ $fechaDesde
                    ? \Carbon\Carbon::parse($fechaDesde)->format('d/m/Y')
                    : 'Sin límite'
                }}
            </td>

            <td class="label">Fecha hasta</td>
            <td>
                {{ $fechaHasta
                    ? \Carbon\Carbon::parse($fechaHasta)->format('d/m/Y')
                    : 'Sin límite'
                }}
            </td>
        </tr>
    </table>

    <table class="summary">
        <tr>
            <td>
                <span class="label">COMPRAS</span>
                <span class="value">{{ number_format($quantity, 0, ',', '.') }}</span>
            </td>

            <td>
                <span class="label">SUBTOTAL</span>
                <span class="value">
                    ${{ number_format($subtotal, 0, ',', '.') }}
                </span>
            </td>

            <td>
                <span class="label">IVA</span>
                <span class="value">
                    ${{ number_format($iva, 0, ',', '.') }}
                </span>
            </td>

            <td>
                <span class="label">TOTAL</span>
                <span class="value">
                    ${{ number_format($total, 0, ',', '.') }}
                </span>
            </td>

            <td>
                <span class="label">SALDO PENDIENTE</span>
                <span class="value">
                    ${{ number_format($balance, 0, ',', '.') }}
                </span>
            </td>
        </tr>
    </table>

    <table class="report">
        <thead>
            <tr>
                <th width="4%">#</th>
                <th width="10%">Fecha</th>
                <th width="12%">Factura</th>
                <th width="22%">Proveedor</th>
                <th width="10%">Tipo</th>
                <th width="10%">Subtotal</th>
                <th width="8%">IVA</th>
                <th width="12%">Total</th>
                <th width="12%">Saldo</th>
            </tr>
        </thead>

        <tbody>
            @forelse($purchases as $purchase)
                <tr>
                    <td class="text-center">
                        {{ $loop->iteration }}
                    </td>

                    <td class="text-center">
                        {{ \Carbon\Carbon::parse($purchase->shopping_date)->format('d/m/Y') }}
                    </td>

                    <td class="text-center">
                        {{ $purchase->invoice_number }}
                    </td>

                    <td>
                        {{ $purchase->supplier->full_name ?? 'Sin proveedor' }}

                        @if(!empty($purchase->supplier?->identification_card))
                            <br>
                            <small>
                                CC/NIT: {{ $purchase->supplier->identification_card }}
                            </small>
                        @endif
                    </td>

                    <td class="text-center">
                        {{ $purchase->purchase_type ?? 'N/A' }}
                    </td>

                    <td class="text-right">
                        ${{ number_format($purchase->subtotal, 0, ',', '.') }}
                    </td>

                    <td class="text-right">
                        ${{ number_format($purchase->iva, 0, ',', '.') }}
                    </td>

                    <td class="text-right">
                        ${{ number_format($purchase->total, 0, ',', '.') }}
                    </td>

                    <td class="text-right">
                        ${{ number_format($purchase->balance, 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">
                        No existen compras para el periodo seleccionado.
                    </td>
                </tr>
            @endforelse

            @if($purchases->count() > 0)
                <tr class="total-row">
                    <td colspan="5" class="text-right">
                        TOTALES
                    </td>

                    <td class="text-right">
                        ${{ number_format($subtotal, 0, ',', '.') }}
                    </td>

                    <td class="text-right">
                        ${{ number_format($iva, 0, ',', '.') }}
                    </td>

                    <td class="text-right">
                        ${{ number_format($total, 0, ',', '.') }}
                    </td>

                    <td class="text-right">
                        ${{ number_format($balance, 0, ',', '.') }}
                    </td>
                </tr>
            @endif
        </tbody>
    </table>

    <div class="footer">
        Reporte de compras generado el
        {{ now()->format('d/m/Y H:i') }}
    </div>

</body>
</html>

