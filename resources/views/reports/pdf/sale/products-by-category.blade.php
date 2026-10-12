<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Ventas por Categoría</title>

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
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0 0 5px;
            font-size: 19px;
        }

        .header p {
            margin: 3px 0;
            color: #666;
        }

        .summary {
            width: 100%;
            margin-bottom: 20px;
        }

        .summary td {
            width: 33.33%;
            border: 1px solid #ddd;
            padding: 9px;
            text-align: center;
        }

        .summary-title {
            font-size: 8px;
            color: #666;
            margin-bottom: 5px;
        }

        .summary-value {
            font-size: 14px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #343a40;
            color: #fff;
            padding: 7px;
            border: 1px solid #343a40;
            text-align: left;
        }

        td {
            padding: 7px;
            border: 1px solid #ddd;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .total {
            font-weight: bold;
            background: #f1f1f1;
        }

        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 8px;
            color: #777;
        }
    </style>

</head>

<body>

    <div class="header">

        <h1>
            REPORTE DE VENTAS POR CATEGORÍA
        </h1>

        <p>
            Valor total de productos vendidos por categoría
        </p>

        @if ($fechaDesde || $fechaHasta)
            <p>
                Período:

                {{ $fechaDesde ?? 'Inicio' }}

                -

                {{ $fechaHasta ?? 'Actualidad' }}
            </p>
        @endif

    </div>

    <table class="summary">

        <tr>

            <td>

                <div class="summary-title">
                    CATEGORÍAS
                </div>

                <div class="summary-value">
                    {{ number_format($categories->count()) }}
                </div>

            </td>

            <td>

                <div class="summary-title">
                    UNIDADES VENDIDAS
                </div>

                <div class="summary-value">
                    {{ number_format($quantity) }}
                </div>

            </td>

            <td>

                <div class="summary-title">
                    TOTAL VENDIDO
                </div>

                <div class="summary-value">
                    $
                    {{ number_format($total, 0, ',', '.') }}
                </div>

            </td>

        </tr>

    </table>

    <table>

        <thead>

            <tr>

                <th class="center">
                    #
                </th>

                <th>
                    Categoría
                </th>

                <th class="center">
                    Unidades vendidas
                </th>

                <th class="right">
                    Total vendido
                </th>

                <th class="right">
                    Participación
                </th>

            </tr>

        </thead>

        <tbody>

            @forelse($categories as $index => $category)
                <tr>

                    <td class="center">
                        {{ $index + 1 }}
                    </td>

                    <td>
                        {{ $category->name }}
                    </td>

                    <td class="center">
                        {{ number_format($category->quantity) }}
                    </td>

                    <td class="right">
                        $
                        {{ number_format($category->total, 0, ',', '.') }}
                    </td>

                    <td class="right">
                        {{ number_format($category->percentage, 2, ',', '.') }}%
                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="5" class="center">
                        No hay ventas por categoría
                        para el período seleccionado.
                    </td>

                </tr>
            @endforelse

        </tbody>

        @if ($categories->count() > 0)
            <tfoot>

                <tr class="total">

                    <td colspan="2">
                        TOTAL
                    </td>

                    <td class="center">
                        {{ number_format($quantity) }}
                    </td>

                    <td class="right">
                        $
                        {{ number_format($total, 0, ',', '.') }}
                    </td>

                    <td class="right">
                        100%
                    </td>

                </tr>

            </tfoot>
        @endif

    </table>

    <div class="footer">

        Generado el {{ now()->format('d/m/Y H:i') }}

    </div>

</body>

</html>
