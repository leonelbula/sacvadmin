<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <title>Reporte de Kardex</title>

    <style>
        @page {
            margin: 25px 25px 30px 25px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 9px;
            color: #222;
        }

        .header {
            width: 100%;
            border-bottom: 2px solid #222;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-table td {
            vertical-align: top;
        }

        .company {
            font-size: 16px;
            font-weight: bold;
        }

        .title {
            font-size: 14px;
            font-weight: bold;
            margin-top: 5px;
        }

        .date {
            text-align: right;
            font-size: 8px;
            color: #555;
        }

        .filters {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .filters td {
            border: 1px solid #ddd;
            padding: 6px;
        }

        .filter-label {
            font-weight: bold;
            background: #f3f3f3;
            width: 20%;
        }

        .summary {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .summary td {
            width: 25%;
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        .summary-label {
            font-size: 8px;
            color: #666;
            display: block;
        }

        .summary-value {
            font-size: 13px;
            font-weight: bold;
            display: block;
            margin-top: 3px;
        }

        .income {
            color: #198754;
        }

        .output {
            color: #dc3545;
        }

        .stock {
            color: #0d6efd;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .table th {
            background: #343a40;
            color: #fff;
            font-size: 7px;
            padding: 6px 3px;
            text-align: center;
            border: 1px solid #343a40;
        }

        .table td {
            padding: 5px 3px;
            border: 1px solid #ddd;
            font-size: 7px;
            vertical-align: middle;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-success {
            color: #198754;
        }

        .text-danger {
            color: #dc3545;
        }

        .movement-entry {
            color: #198754;
            font-weight: bold;
        }

        .movement-output {
            color: #dc3545;
            font-weight: bold;
        }

        .empty {
            text-align: center;
            padding: 30px;
            color: #777;
        }

        .footer {
            position: fixed;
            bottom: -15px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 7px;
            color: #777;
        }

        .page-number:after {
            content: counter(page);
        }
    </style>
</head>

<body>

    <div class="header">

        <table class="header-table">

            <tr>

                <td>
                    <div class="company">
                        Reporte de Inventario
                    </div>

                    <div class="title">
                        Kardex de Movimientos
                    </div>
                </td>

                <td class="date">
                    Generado:
                    {{ now()->format('d/m/Y H:i') }}
                </td>

            </tr>

        </table>

    </div>

    <table class="filters">

        <tr>
            <td class="filter-label">
                Producto
            </td>

            <td>
                @if (isset($product) && $product)
                    {{ $product->code }} - {{ $product->name }}
                @else
                    Todos los productos
                @endif
            </td>
        </tr>

        <tr>
            <td class="filter-label">
                Fecha desde
            </td>

            <td>
                {{ $fechaDesde ? \Carbon\Carbon::parse($fechaDesde)->format('d/m/Y') : 'Sin límite' }}
            </td>
        </tr>

        <tr>
            <td class="filter-label">
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
                <span class="summary-label">
                    Movimientos
                </span>

                <span class="summary-value">
                    {{ number_format($quantity ?? 0, 0, ',', '.') }}
                </span>
            </td>

            <td>
                <span class="summary-label">
                    Total entradas
                </span>

                <span class="summary-value income">
                    {{ number_format($income ?? 0, 0, ',', '.') }}
                </span>
            </td>

            <td>
                <span class="summary-label">
                    Total salidas
                </span>

                <span class="summary-value output">
                    {{ number_format($output ?? 0, 0, ',', '.') }}
                </span>
            </td>

            <td>
                <span class="summary-label">
                    Existencia actual
                </span>

                <span class="summary-value stock">
                    {{ number_format($currentStock ?? 0, 0, ',', '.') }}
                </span>
            </td>

        </tr>

    </table>

    <table class="table">

        <thead>

            <tr>
                <th style="width: 4%;">#</th>
                <th style="width: 9%;">Fecha</th>
                <th style="width: 15%;">Producto</th>
                <th style="width: 10%;">Movimiento</th>
                <th style="width: 10%;">Origen</th>
                <th style="width: 8%;">Ref.</th>
                <th style="width: 9%;">Entrada</th>
                <th style="width: 9%;">Salida</th>
                <th style="width: 9%;">Saldo ant.</th>
                <th style="width: 9%;">Saldo act.</th>
                <th style="width: 8%;">Costo</th>
            </tr>

        </thead>

        <tbody>

            @forelse($kardex as $index => $movement)
                @php
                    $incomeMovement = (int) ($movement->income ?? 0);
                    $outputMovement = (int) ($movement->output ?? 0);
                @endphp

                <tr>

                    <td class="text-center">
                        {{ $index + 1 }}
                    </td>

                    <td class="text-center">
                        {{ \Carbon\Carbon::parse($movement->date)->format('d/m/Y') }}

                        <br>

                        <span style="color:#777;">
                            {{ \Carbon\Carbon::parse($movement->date)->format('H:i') }}
                        </span>
                    </td>

                    <td>
                        @if ($movement->product)
                            <strong>
                                {{ $movement->product->name }}
                            </strong>

                            <br>

                            <span style="color:#777;">
                                {{ $movement->product->code }}
                            </span>
                        @else
                            Producto eliminado
                        @endif
                    </td>

                    <td class="text-center">

                        @if ($incomeMovement > 0)
                            <span class="movement-entry">
                                ENTRADA
                            </span>
                        @elseif($outputMovement > 0)
                            <span class="movement-output">
                                SALIDA
                            </span>
                        @else
                            MOVIMIENTO
                        @endif

                    </td>

                    <td class="text-center">
                        {{ $movement->origin ?? '-' }}
                    </td>

                    <td class="text-center">
                        {{ $movement->reference_id ?? '-' }}
                    </td>

                    <td class="text-center text-success">
                        @if ($incomeMovement > 0)
                            +{{ number_format($incomeMovement, 0, ',', '.') }}
                        @else
                            -
                        @endif
                    </td>

                    <td class="text-center text-danger">
                        @if ($outputMovement > 0)
                            -{{ number_format($outputMovement, 0, ',', '.') }}
                        @else
                            -
                        @endif
                    </td>

                    <td class="text-center">
                        {{ number_format($movement->stock_before ?? 0, 0, ',', '.') }}
                    </td>

                    <td class="text-center">
                        <strong>
                            {{ number_format($movement->stock_after ?? 0, 0, ',', '.') }}
                        </strong>
                    </td>

                    <td class="text-right">
                        ${{ number_format($movement->unit_cost ?? 0, 0, ',', '.') }}
                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="11" class="empty">
                        No se encontraron movimientos de inventario.
                    </td>
                </tr>
            @endforelse

        </tbody>

    </table>

    <div class="footer">
        Reporte de Kardex |
        Página <span class="page-number"></span>
    </div>

</body>

</html>
