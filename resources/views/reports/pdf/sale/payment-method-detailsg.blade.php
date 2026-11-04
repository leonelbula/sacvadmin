<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de ventas por medio de pago</title>

    <style>
        @page {
            margin: 25px 30px;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            color: #333;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .header h2 {
            margin: 0 0 5px;
            font-size: 18px;
        }

        .header p {
            margin: 3px 0;
        }

        .report-title {
            text-align: center;
            margin: 15px 0;
        }

        .report-title h3 {
            margin: 0 0 5px;
            font-size: 15px;
        }

        .filters {
            width: 100%;
            margin-bottom: 15px;
            border-collapse: collapse;
        }

        .filters td {
            padding: 7px;
            background: #f2f2f2;
            border: 1px solid #ddd;
        }

        table.sales {
            width: 100%;
            border-collapse: collapse;
        }

        table.sales th {
            background: #343a40;
            color: white;
            padding: 8px 5px;
            text-align: left;
        }

        table.sales td {
            padding: 7px 5px;
            border-bottom: 1px solid #ddd;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .total {
            margin-top: 15px;
            width: 100%;
            border-collapse: collapse;
        }

        .total td {
            padding: 10px;
            font-size: 12px;
            font-weight: bold;
            background: #f2f2f2;
        }

        .footer {
            margin-top: 25px;
            text-align: center;
            font-size: 9px;
            color: #777;
        }

        .empty {
            text-align: center;
            padding: 20px;
        }
    </style>
</head>

<body>

    <div class="header">
        <h2>{{ $company->name ?? 'EMPRESA' }}</h2>

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
                <th width="20%">Vendedor</th>
                <th width="13%">Medio pago</th>
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

                    <td>
                        {{ $sale->user->name ?? '' }}
                    </td>

                    <td>
                        {{ $sale->payment_method_label ?? $paymentMethod }}
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
