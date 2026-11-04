<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de ventas por medio de pago</title>

    <style>
        @page {
            margin: 3mm 2mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            width: 100%;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            font-size: 10px;
            color: #000;
        }

        .header {
            text-align: center;
            padding-bottom: 8px;
            border-bottom: 1px dashed #000;
        }

        .header h2 {
            font-size: 13px;
            margin: 0 0 5px;
        }

        .header p {
            margin: 2px 0;
        }

        .report-title {
            text-align: center;
            margin: 8px 0;
        }

        .report-title h3 {
            font-size: 11px;
            margin: 0 0 4px;
        }

        .filters {
            width: 100%;
            margin-bottom: 8px;
            font-size: 10px;
        }

        .filters td {
            padding: 3px 0;
        }

        table.sales {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        table.sales th {
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
            padding: 5px 2px;
            font-size: 10px;
            text-align: left;
        }

        table.sales td {
            padding: 5px 2px;
            border-bottom: 1px dotted #aaa;
            font-size: 10px;
            word-wrap: break-word;
        }

        .text-right {
            text-align: right;
        }

        .total {
            width: 100%;
            margin-top: 10px;
            border-collapse: collapse;
        }

        .total td {
            padding: 5px 0;
            font-weight: bold;
            font-size: 10px;
            border-top: 1px dashed #000;
        }

        .footer {
            text-align: center;
            margin-top: 10px;
            font-size: 8px;
        }
    </style>
</head>

<body>

    <div class="header">
        <h2>{{ $company->name ?? 'SISTEMA DE VENTAS' }}</h2>

        <p>
            NIT: {{ $company->nit ?? '' }}
        </p>

        <p>
            {{ $company->address ?? '' }}
        </p>

        <p>
            Teléfono: {{ $company->phone ?? '' }}
        </p>
    </div>

    <div class="report-title">
        <h3>REPORTE DE VENTAS POR MEDIO DE PAGO</h3>
        <p>Detalle de ventas registradas</p>
    </div>

    <table class="filters">
        <tr>
            <td>
                <strong>Medio de pago:</strong>
                {{ $paymentMethod }}
            </td>

            <td>
                <strong>Desde:</strong>
                {{ $fechaDesde }}
            </td>

            <td>
                <strong>Hasta:</strong>
                {{ $fechaHasta }}
            </td>
        </tr>
    </table>

    <table class="sales">
        <thead>
            <tr>
                <th width="12%">Factura</th>
                <th width="15%">Fecha</th>
                <th width="25%">Cliente</th>

                <th width="15%" class="text-right">Total</th>
            </tr>
        </thead>

        <tbody>
            @forelse($sales as $sale)
                <tr>
                    <td>{{ $sale->sale_number }}</td>

                    <td>
                        {{ \Carbon\Carbon::parse($sale->date_sale)->format('d/m/Y') }}
                    </td>

                    <td>
                        {{ $sale->customer->full_name ?? 'Consumidor final' }}
                    </td>

                    <td class="text-right">
                        ${{ number_format($sale->total, 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="empty">
                        No se encontraron ventas para este medio de pago.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <table class="total">
        <tr>
            <td>
                CANTIDAD DE VENTAS: {{ $sales->count() }}
            </td>

            <td class="text-right">
                TOTAL GENERAL:
                ${{ number_format($total, 0, ',', '.') }}
            </td>
        </tr>
    </table>

    <div class="footer">
        Reporte generado el {{ now()->format('d/m/Y H:i:s') }}
    </div>

</body>

</html>
