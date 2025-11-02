<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Ventas por Usuario</title>
    <style>
        body {
            font-family: DejaVu Sans;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        h2,
        h3 {
            text-align: center;
            margin: 0;
        }
    </style>
</head>

<body>
    <h2>Reporte de Ventas por Usuario</h2>
    <p><strong>Período:</strong> {{ $fechaInicio }} - {{ $fechaFin }}</p>
    <p><strong>Método de Pago:</strong> {{ $nombreMetodo }}</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>N° Fact.</th>
                <th>Cliente</th>
                <th>Fecha</th>
                <th>Total Venta</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($ventas as $index => $venta)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $venta->sale_number}}</td>
                    <td>{{ $venta->customer->full_name ?? 'Sin cliente' }}</td>
                    <td>{{ $venta->date_sale }}</td>
                    <td>${{ number_format($venta->total, 2, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align:center;">No hay ventas registradas en este rango</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <h3>Total general: ${{ number_format($total, 2, ',', '.') }}</h3>
</body>

</html>
