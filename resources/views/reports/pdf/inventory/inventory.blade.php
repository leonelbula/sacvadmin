<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Reporte de Inventario</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #222;
            margin: 30px;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
        }

        .header h1 {
            margin: 0 0 6px 0;
            font-size: 20px;
        }

        .header p {
            margin: 3px 0;
            color: #666;
        }

        .summary {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        .summary td {
            width: 25%;
            border: 1px solid #ddd;
            padding: 12px 8px;
            text-align: center;
        }

        .summary-title {
            display: block;
            font-size: 9px;
            color: #666;
            margin-bottom: 6px;
        }

        .summary-value {
            display: block;
            font-size: 14px;
            font-weight: bold;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th {
            background-color: #343a40;
            color: white;
            padding: 7px 5px;
            border: 1px solid #343a40;
            text-align: center;
            font-size: 9px;
        }

        .table td {
            padding: 6px 5px;
            border: 1px solid #ddd;
            font-size: 9px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .total-row {
            font-weight: bold;
            background-color: #f1f1f1;
        }

        .empty {
            text-align: center;
            padding: 20px;
            color: #777;
        }

        .footer {
            margin-top: 30px;
            padding-top: 8px;
            border-top: 1px solid #ddd;
            text-align: center;
            color: #777;
            font-size: 8px;
        }
    </style>

</head>

<body>

    <div class="header">

        <h1>Reporte de Inventario</h1>

        <p>
            Generado el {{ now()->format('d/m/Y H:i') }}
        </p>

    </div>


    <table class="summary">

        <tr>

            <td>

                <span class="summary-title">
                    Productos registrados
                </span>

                <span class="summary-value">
                    {{ number_format($quantity ?? 0, 0, ',', '.') }}
                </span>

            </td>


            <td>

                <span class="summary-title">
                    Stock total
                </span>

                <span class="summary-value">
                    {{ number_format($stock ?? 0, 0, ',', '.') }}
                </span>

            </td>


            <td>

                <span class="summary-title">
                    Valor al costo
                </span>

                <span class="summary-value">
                    $ {{ number_format($inventory_cost ?? 0, 0, ',', '.') }}
                </span>

            </td>


            <td>

                <span class="summary-title">
                    Valor a precio de venta
                </span>

                <span class="summary-value">
                    $ {{ number_format($inventory_price ?? 0, 0, ',', '.') }}
                </span>

            </td>

        </tr>

    </table>


    <table class="table">

        <thead>

            <tr>

                <th style="width: 5%;">
                    #
                </th>

                <th style="width: 10%;">
                    Código
                </th>

                <th style="width: 25%;">
                    Producto
                </th>

                <th style="width: 10%;">
                    Stock
                </th>

                <th style="width: 12%;">
                    Costo
                </th>

                <th style="width: 13%;">
                    Valor costo
                </th>

                <th style="width: 12%;">
                    Precio venta
                </th>

                <th style="width: 13%;">
                    Valor venta
                </th>

            </tr>

        </thead>


        <tbody>

            @forelse($products as $index => $product)
                @php

                    $stockProduct = (float) ($product->stock ?? 0);

                    $costProduct = (float) ($product->cost ?? 0);

                    $priceProduct = (float) ($product->price ?? 0);

                    $valueCost = $stockProduct * $costProduct;

                    $valuePrice = $stockProduct * $priceProduct;

                @endphp


                <tr>

                    <td class="text-center">
                        {{ $index + 1 }}
                    </td>

                    <td class="text-center">
                        {{ $product->code }}
                    </td>

                    <td>
                        {{ $product->name }}
                    </td>

                    <td class="text-center">
                        {{ number_format($stockProduct, 0, ',', '.') }}
                    </td>

                    <td class="text-right">
                        $ {{ number_format($costProduct, 0, ',', '.') }}
                    </td>

                    <td class="text-right">
                        $ {{ number_format($valueCost, 0, ',', '.') }}
                    </td>

                    <td class="text-right">
                        $ {{ number_format($priceProduct, 0, ',', '.') }}
                    </td>

                    <td class="text-right">
                        $ {{ number_format($valuePrice, 0, ',', '.') }}
                    </td>

                </tr>


            @empty

                <tr>

                    <td colspan="8" class="empty">
                        No existen productos registrados.
                    </td>

                </tr>
            @endforelse

        </tbody>


        @if ($products->count() > 0)
            <tfoot>

                <tr class="total-row">

                    <td colspan="3" class="text-right">
                        TOTAL
                    </td>

                    <td class="text-center">
                        {{ number_format($stock ?? 0, 0, ',', '.') }}
                    </td>

                    <td>
                    </td>

                    <td class="text-right">
                        $ {{ number_format($inventory_cost ?? 0, 0, ',', '.') }}
                    </td>

                    <td>
                    </td>

                    <td class="text-right">
                        $ {{ number_format($inventory_price ?? 0, 0, ',', '.') }}
                    </td>

                </tr>

            </tfoot>
        @endif

    </table>


    <table class="summary" style="margin-top: 20px;">

        <tr>

            <td style="width: 50%;">

                <span class="summary-title">
                    Valor total del inventario
                </span>

                <span class="summary-value">
                    $ {{ number_format($inventory_cost ?? 0, 0, ',', '.') }}
                </span>

            </td>


            <td style="width: 50%;">

                <span class="summary-title">
                    Utilidad potencial
                </span>

                <span class="summary-value">
                    $ {{ number_format($utility ?? 0, 0, ',', '.') }}
                </span>

            </td>

        </tr>

    </table>


    <div class="footer">

        Reporte de inventario generado por el sistema

    </div>

</body>

</html>
