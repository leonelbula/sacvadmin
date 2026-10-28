<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de ventas</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #1f2937;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 7px;
            text-align: left;
        }

        th {
            background-color: #e5e7eb;
        }

        .total {
            text-align: right;
            margin-top: 20px;
            font-size: 14px;
        }
    </style>
</head>

<body>

    <h1>Reporte de ventas</h1>

    <p>Desde: {{ $fechaDesde ?? 'Sin fecha inicial' }}</p>
    <p>Hasta: {{ $fechaHasta ?? 'Sin fecha final' }}</p>

    <table>
        <thead>
            <tr>
                <th>Factura</th>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>Vendedor</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($sales as $sale)
                <tr>
                    <td>{{ $sale->sale_number }}</td>
                    <td>{{ $sale->date_sale }}</td>
                    <td>{{ $sale->customer->full_name ?? 'Sin cliente' }}</td>
                    <td>{{ $sale->user->name ?? 'Sin vendedor' }}</td>
                    <td>${{ number_format($sale->total, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No hay ventas para el período seleccionado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="total">
        <p>Cantidad de ventas: {{ $quantity }}</p>
        <p><strong>Total general: ${{ number_format($total, 0, ',', '.') }}</strong></p>
    </div>

</body>

</html>
