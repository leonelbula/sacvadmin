<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: monospace, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
            width: 100%;
            text-align: center; /* centra texto por defecto */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto; /* centra tablas */
        }
        .right { text-align: right; }
        .left { text-align: left; }
        .bold { font-weight: bold; }
        hr {
            border: none;
            border-top: 1px dashed #000;
            margin: 4px 0;
        }
    </style>
</head>
<body>
    <!-- Encabezado -->
    <h3>{{ $company->full_name }}</h3>
    <p>{{ $company->address }}</p>
    <p>NIT: {{ $company->nit }}</p>
    <p>Tel: {{ $company->phone }}</p>

    <hr>

    <!-- Datos de venta -->
    <table>
        <tr>
            <td class="left">Factura: {{ $sale->sale_number }}</td>
            <td class="right">{{ \Carbon\Carbon::parse($sale->date_sale)->format('d/m/Y H:i') }}</td>
        </tr>
        <tr>
            <td colspan="2" class="left">Cliente: {{ $sale->customer->name ?? 'Consumidor final' }}</td>
        </tr>
    </table>

    <hr>

    <!-- Detalle -->
    <table>
        <thead>
            <tr>
                <td class="left">Cant</td>
                <td class="left">Producto</td>
                <td class="right">P.Unit</td>
                <td class="right">Total</td>
            </tr>
        </thead>
        <tbody>
            @foreach($sale->details as $item)
            <tr>
                <td>{{ $item->quantity }}</td>
                <td>{{ \Illuminate\Support\Str::limit($item->product->name, 12) }}</td>
                <td class="right">{{ number_format($item->price, 0) }}</td>
                <td class="right">{{ number_format($item->quantity * $item->price, 0) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <hr>

    <!-- Totales -->
    <table>
        <tr>
            <td class="right bold">Subtotal:</td>
            <td class="right">{{ number_format($sale->subtotal, 0) }}</td>
        </tr>
        <tr>
            <td class="right bold">IVA:</td>
            <td class="right">{{ number_format($sale->iva, 0) }}</td>
        </tr>
        <tr>
            <td class="right bold">TOTAL:</td>
            <td class="right bold">{{ number_format($sale->total, 0) }}</td>
        </tr>
    </table>

    <hr>

    <!-- Mensaje -->
    <p>*** GRACIAS POR SU COMPRA ***</p>
</body>
</html>
