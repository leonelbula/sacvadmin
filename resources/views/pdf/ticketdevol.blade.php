<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>Ticket #{{ $returnsale->id }}</title>
    <style>
        /* ===== Reset y base ===== */
        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, "Helvetica Neue", sans-serif;
            color: #222;
            background: #fff;
            font-size: 12px;
            /* compacto */
            padding: 0;
            width: 80mm;
            /* fuerza el ancho en el PDF */
        }


        /* ===== Ancho de ticket =====
       - Spatie (Chromium) respeta @page size con mm.
       - DomPDF usa puntos; si no usas @page, controla el ancho con contenedor.
    */
        @page {
            size: 80mm auto;
            margin: 6mm 4mm;
        }

        /* Spatie: 80mm ancho, alto auto */
        .ticket {
            width: 80mm;
            /* ~ 80mm en pantallas (no crítico para PDF) */
            max-width: 100%;
            margin: 0 auto;
        }

        /* ===== Tarjeta ===== */
        .card {
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 12px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .05);
        }

        /* ===== Header ===== */
        .center {
            text-align: center;
        }

        .muted {
            color: #666;
        }

        .logo {
            max-width: 120px;
            max-height: 60px;
            margin: 0 auto 6px;
            display: block;
        }

        h1 {
            font-size: 14px;
            margin: 4px 0 2px;
            letter-spacing: .5px;
        }

        h2 {
            font-size: 12px;
            margin: 0;
            font-weight: 600;
        }

        /* ===== Separadores ===== */
        .rule {
            border: 0;
            border-top: 1px dashed #ccc;
            margin: 8px 0;
        }

        .rule-bold {
            border-top: 1px solid #000;
            margin: 10px 0;
        }

        /* ===== Meta grid (sin flex para compatibilidad DomPDF) ===== */
        .meta {
            width: 100%;
            border-collapse: collapse;
        }

        .meta td {
            padding: 2px 0;
            vertical-align: top;
        }

        .meta .k {
            width: 34%;
            color: #666;
        }

        .meta .v {
            width: 66%;
            text-align: right;
            font-weight: 600;
        }

        /* ===== Tabla de items ===== */
        table.items {
            width: 100%;
            border-collapse: collapse;
        }

        .items thead th {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .3px;
            text-align: left;
            padding: 4px 0;
            border-bottom: 1px solid #ddd;
            color: #444;
        }

        .items tbody td {
            padding: 6px 0;
            border-bottom: 1px dashed #eee;
            vertical-align: top;
        }

        .td-right {
            text-align: right;
        }

        .desc {
            font-weight: 600;
        }

        .subline {
            font-size: 11px;
            color: #666;
        }

        /* ===== Totales ===== */
        table.totals {
            width: 100%;
            border-collapse: collapse;
            margin-top: 4px;
        }

        .totals td {
            padding: 4px 0;
            font-size: 12px;
        }

        .totals .k {
            color: #444;
        }

        .totals .v {
            text-align: right;
            font-weight: 600;
        }

        .grand {
            font-size: 13px;
            font-weight: 700;
        }

        /* ===== Footer ===== */
        .foot {
            text-align: center;
            margin-top: 10px;
            font-size: 11px;
            color: #555;
        }

        .policy {
            font-size: 10px;
            color: #777;
            margin-top: 6px;
        }

        .cut {
            display: block;
            text-align: center;
            font-size: 10px;
            color: #999;
            margin-top: 8px;
        }

        .cut:before,
        .cut:after {
            content: "— — — — — — — — — — — — — — — — — —";
            display: block;
            overflow: hidden;
        }

        /* ===== Código de barras / QR ===== */
        .barcode,
        .qrcode {
            display: block;
            margin: 8px auto 0;
            max-width: 180px;
            max-height: 180px;
        }

        /* ===== Modo impresión (por si lo envías a impresora POS) ===== */
        @media print {
            .card {
                border: 0;
                box-shadow: none;
                padding: 0;
            }

            .rule {
                margin: 6px 0;
            }
        }
    </style>
</head>

<body>
    <div class="ticket">
        <div class="card">
            <!-- Header -->
            <img src="{{ $company->logo == null ? '' : public_path($company->logo) }}" class="logo">
            <div class="center">
                <h1>{{ $company->full_name }}</h1>
                <div class="muted">
                    NIT: {{ $company->identification_card }}<br>
                    {{ $company->address }}<br>
                    {{ $company->phone ?? '' }} • {{ $company->email ?? '' }}
                </div>
            </div>

            <hr class="rule">

            <!-- Datos del ticket -->
            <table class="meta">
                <tr>
                    <td class="k">Ticket #</td>
                    <td class="v">#{{ $returnsale->sale_number }}</td>
                </tr>
                <tr>
                    <td class="k">Fecha</td>
                    <td class="v">
                        {{ \Carbon\Carbon::parse($returnsale->date ?? $returnsale->created_at)->format('d/m/Y H:i') }}</td>
                </tr>
                <tr>
                    <td class="k">Cajero</td>
                    <td class="v"></td>
                </tr>
                <tr>
                    <td class="k">Cliente</td>
                    <td class="v">{{ $returnsale->customer->full_name ?? 'Consumidor final' }}</td>
                </tr>
            </table>

            <hr class="rule">

            <!-- Items -->
            <table class="items">
                <thead>
                    <tr>
                        <th>Prod.</th>
                        <th class="td-right">Cant &nbsp;</th>
                        <th class="td-right">Precio</th>
                        <th class="td-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($returnsale->details as $row)
                        @php
                            $qty = $row->quantity;
                            $price = $row->price;
                            $subtotal = $qty * $price;
                            $iva = $row->tax_value;
                        @endphp
                        <tr>
                            <td>
                                <div class="desc">{{ $row->product->name }}</div>
                                <div class="subline">Cod: {{ $row->product->code ?? $row->product_id }} • IVA
                                    {{ number_format($iva, 0) }}%</div>
                            </td>
                            <td class="td-right">{{ rtrim(rtrim(number_format($qty, 0, '.', ''), '0'), '.') }}&nbsp;
                                &nbsp;</td>
                            <td class="td-right">${{ number_format($price, 0) }}</td>
                            <td class="td-right">${{ number_format($subtotal, 0) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <hr class="rule-bold">

            <!-- Totales -->
            @php
                $subtotal = $returnsale->subtotal;
                $ivaTotal = $returnsale->total_iva;
                $total = $returnsale->total;
            @endphp

            <table class="totals">
                <tr>
                    <td class="k">Subtotal</td>
                    <td class="v">${{ number_format($subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td class="k">IVA</td>
                    <td class="v">${{ number_format($ivaTotal, 2) }}</td>
                </tr>
                <tr class="grand">
                    <td class="k">Total</td>
                    <td class="v">${{ number_format($total, 2) }}</td>
                </tr>
            </table>


            <div class="foot">¡Gracias por su compra! 💙</div>
            <div class="policy">Cambios dentro de 8 días con factura. Garantía según fabricante.</div>
            <div class="cut">✂ cortar aquí</div>
        </div>
    </div>
</body>

</html>
