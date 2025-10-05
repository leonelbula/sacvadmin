<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: monospace;
            /* compatible con DomPDF y térmica */
            font-size: 12px;
            margin: 0;
            padding: 0;
            width: 100%;
            text-align: center;
        }

        .line {
            border-top: 1px dashed #000;
            margin: 4px 0;
        }

        .right {
            text-align: right;
        }

        .left {
            text-align: left;
        }
    </style>
</head>

<body>
    <!-- Encabezado -->
    <p>{{ $company->full_name }}</p>
    <p>{{ $company->address }}</p>
    <p>NIT: {{ $company->nit }}</p>
    <p>Tel: {{ $company->phone }}</p>

    <p class="line">---------------------------------</p>

    <!-- Datos venta -->
    <p>Factura: {{ $sale->sale_number }}</p>
    <p>Fecha: {{ \Carbon\Carbon::parse($sale->date_sale)->format('d/m/Y H:i') }}</p>
    <p>Cliente: {{ $sale->customer->name ?? 'Consumidor Final' }}</p>

    <p class="line"></p>

    <!-- Detalle -->
    <p><strong>DETALLE</strong></p>
     <p class="line">---------------------------------</p>
    @foreach ($sale->details as $item)
        <p>
            {{ $item->quantity }} x {{ \Illuminate\Support\Str::limit($item->product->name, 25) }}
            ${{ number_format($item->price, 0) }}
            = ${{ number_format($item->quantity * $item->price, 0) }}
        </p>
    @endforeach

    <p class="line">--------------------------------------</p>

    <!-- Totales -->
    <p>Subtotal: ${{ number_format($sale->subtotal, 0) }}</p>
    <p>IVA: ${{ number_format($sale->iva, 0) }}</p>
    <p><strong>TOTAL: ${{ number_format($sale->total, 0) }}</strong></p>

    <p class="line">--------------------------------------</p>

    <!-- Mensaje -->
    <p>*** GRACIAS POR SU COMPRA ***</p>
</body>

</html>
