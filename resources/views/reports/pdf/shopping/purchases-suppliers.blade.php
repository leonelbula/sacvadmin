<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <title>Reporte de Compras por Proveedor</title>

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
            margin: 5px 0 0;
            font-size: 10px;
            color: #555;
        }

        .filters {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .filters td {
            border: 1px solid #ccc;
            padding: 6px;
        }

        .filters .label {
            width: 18%;
            font-weight: bold;
            background: #f2f2f2;
        }

        .summary {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .summary td {
            width: 25%;
            border: 1px solid #ccc;
            padding: 8px;
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

        .report {
            width: 100%;
            border-collapse: collapse;
        }

        .report th {
            background: #e9ecef;
            border: 1px solid #999;
            padding: 6px 4px;
            font-size: 8px;
            text-align: center;
        }

        .report td {
            border: 1px solid #ccc;
            padding: 6px 4px;
            font-size: 8px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .total-row {
            background: #f2f2f2;
            font-weight: bold;
        }

        .empty {
            text-align: center;
            padding: 20px;
            color: #666;
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

        <h1>REPORTE DE COMPRAS POR PROVEEDOR</h1>

        @if ($fechaDesde || $fechaHasta)
            <p>
                Periodo:

                {{ $fechaDesde ? \Carbon\Carbon::parse($fechaDesde)->format('d/m/Y') : 'Inicio' }}

                -

                {{ $fechaHasta ? \Carbon\Carbon::parse($fechaHasta)->format('d/m/Y') : 'Actual' }}
            </p>
        @else
            <p>
                Todos los registros
            </p>
        @endif

    </div>

    <table class="filters">

        <tr>

            <td class="label">
                Fecha desde
            </td>

            <td>
                {{ $fechaDesde ? \Carbon\Carbon::parse($fechaDesde)->format('d/m/Y') : 'Sin límite' }}
            </td>

            <td class="label">
                Fecha hasta
            </td>

            <td>
                {{ $fechaHasta ? \Carbon\Carbon::parse($fechaHasta)->format('d/m/Y') : 'Sin límite' }}
            </td>

        </tr>

    </table>

    <table class="summary">

        <tr>

            <td>

                <span class="label">
                    PROVEEDORES
                </span>

                <span class="value">
                    {{ number_format($quantity, 0, ',', '.') }}
                </span>

            </td>

            <td>

                <span class="label">
                    COMPRAS REALIZADAS
                </span>

                <span class="value">
                    {{ number_format($purchasesQuantity, 0, ',', '.') }}
                </span>

            </td>

            <td>

                <span class="label">
                    TOTAL COMPRADO
                </span>

                <span class="value">
                    ${{ number_format($total, 0, ',', '.') }}
                </span>

            </td>

            <td>

                <span class="label">
                    SALDO PENDIENTE
                </span>

                <span class="value">
                    ${{ number_format($balance, 0, ',', '.') }}
                </span>

            </td>

        </tr>

    </table>

    <table class="report">

        <thead>

            <tr>

                <th width="5%">
                    #
                </th>

                <th width="25%">
                    Proveedor
                </th>

                <th width="15%">
                    Identificación
                </th>

                <th width="10%">
                    Compras
                </th>

                <th width="11%">
                    Subtotal
                </th>

                <th width="9%">
                    IVA
                </th>

                <th width="13%">
                    Total
                </th>

                <th width="12%">
                    Saldo
                </th>

            </tr>

        </thead>

        <tbody>

            @forelse($suppliers as $supplier)
                <tr>

                    <td class="text-center">
                        {{ $loop->iteration }}
                    </td>

                    <td>
                        {{ $supplier->full_name }}
                    </td>

                    <td class="text-center">
                        {{ $supplier->identification ?? 'N/A' }}
                    </td>

                    <td class="text-center">
                        {{ number_format($supplier->quantity, 0, ',', '.') }}
                    </td>

                    <td class="text-right">
                        ${{ number_format($supplier->subtotal, 0, ',', '.') }}
                    </td>

                    <td class="text-right">
                        ${{ number_format($supplier->iva, 0, ',', '.') }}
                    </td>

                    <td class="text-right">
                        ${{ number_format($supplier->total, 0, ',', '.') }}
                    </td>

                    <td class="text-right">
                        ${{ number_format($supplier->balance, 0, ',', '.') }}
                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="8" class="empty">
                        No existen compras para los proveedores
                        durante el periodo seleccionado.
                    </td>

                </tr>
            @endforelse

            @if ($suppliers->count() > 0)
                <tr class="total-row">

                    <td colspan="3" class="text-right">
                        TOTALES
                    </td>

                    <td class="text-center">
                        {{ number_format($purchasesQuantity, 0, ',', '.') }}
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

        Reporte generado el
        {{ now()->format('d/m/Y H:i') }}

    </div>

</body>

</html>
