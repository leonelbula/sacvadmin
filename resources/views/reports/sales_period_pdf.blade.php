<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Ventas por Período</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        h2 {
            text-align: center;
        }
    </style>
</head>

<body>
    <h2>Ventas por Período</h2>
    <p><strong>Desde:</strong> {{ $start_date }} <strong>Hasta:</strong> {{ $end_date }}</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Número Venta</th>
                <th>Fecha</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ventas as $venta)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $venta->sale_number }}</td>
                    <td>{{ $venta->date_sale }}</td>
                    <td>${{ number_format($venta->total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Total Ventas: ${{ number_format($total, 2) }}</h3>
</body>

</html>
