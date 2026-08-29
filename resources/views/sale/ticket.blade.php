<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>
        Ticket #{{ $sale->sale_number }}
    </title>

    <style>
        @page {
            margin: 0;
            size: 80mm auto;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            width: 80mm;
        }

        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 8px;
            color: #000;
        }

        .ticket {
            width: 80mm;

            /*
     * Margen interno mínimo
     */
            padding: 2mm 3mm;

            margin: 0;
        }

        /* =========================================
   GENERAL
========================================= */

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }

        /* =========================================
   EMPRESA
========================================= */

        .company-name {
            font-size: 15px;
            font-weight: bold;
            margin-bottom: 2px;
        }

        .company-info {
            font-size: 7px;
            line-height: 1.3;
        }

        /* =========================================
   SEPARADORES
========================================= */

        .separator {
            border-top: 1px dashed #000;
            margin: 4px 0;
        }

        .separator-solid {
            border-top: 1px solid #000;
            margin: 4px 0;
        }

        /* =========================================
   FACTURA
========================================= */

        .invoice-title {
            font-size: 9px;
            font-weight: bold;
            margin-top: 3px;
        }

        .invoice-number {
            font-size: 13px;
            font-weight: bold;
            margin: 1px 0 3px;
        }

        .invoice-info {
            font-size: 7px;
            line-height: 1.3;
        }

        /* =========================================
   CLIENTE
========================================= */

        .customer {
            font-size: 7px;
            line-height: 1.3;
        }

        .customer-name {
            font-size: 8px;
            font-weight: bold;
        }

        /* =========================================
   PRODUCTOS
========================================= */

        .products {
            width: 95%;
            border-collapse: collapse;
        }

        .products th {
            font-size: 7px;

            padding: 3px 1px;

            border-bottom: 1px solid #000;

            text-align: left;
        }

        .products td {
            font-size: 7px;

            padding: 3px 1px;

            vertical-align: top;
        }

        .product-name {
            font-weight: bold;
            line-height: 1.2;
        }

        .product-code {
            font-size: 6px;
        }

        /* =========================================
   TOTALES
========================================= */

        .totals {
            width: 95%;
            border-collapse: collapse;
        }

        .totals td {
            padding: 2px 0;

            font-size: 7px;
        }

        .total-final td {
            border-top: 1px solid #000;

            padding-top: 4px;

            font-size: 11px;

            font-weight: bold;
        }

        .balance td {
            font-weight: bold;
        }

        /* =========================================
   PAGO
========================================= */

        .payment {
            font-size: 7px;
            line-height: 1.3;
        }

        /* =========================================
   OBSERVACIÓN
========================================= */

        .observation {
            font-size: 7px;
            line-height: 1.3;
        }

        /* =========================================
   PIE
========================================= */

        .footer {
            margin-top: 6px;

            padding-top: 5px;

            border-top: 1px dashed #000;

            text-align: center;

            font-size: 6.5px;

            line-height: 1.3;
        }
    </style>

</head>


<body>

    <div class="ticket">


        {{-- ==========================================
         EMPRESA
    =========================================== --}}

        <div class="center">

            <div class="company-name">
                SACVAdmin
            </div>

            <div class="company-info">

                Sistema de gestión empresarial

                <br>

                NIT: 000.000.000-0

                <br>

                Dirección de la empresa

                <br>

                Tel: 000 000 0000

                <br>

                correo@empresa.com

            </div>

        </div>


        <div class="separator"></div>


        {{-- ==========================================
         FACTURA
    =========================================== --}}

        <div class="center">

            <div class="invoice-title">
                FACTURA DE VENTA
            </div>

            <div class="invoice-number">
                #{{ $sale->sale_number }}
            </div>

            <div class="invoice-info">

                Fecha:

                {{ \Carbon\Carbon::parse($sale->date_sale)->format('d/m/Y') }}

                <br>

                Hora:

                {{ $sale->hour }}

            </div>

        </div>


        <div class="separator"></div>


        {{-- ==========================================
         CLIENTE
    =========================================== --}}

        <div class="customer">

            <strong>CLIENTE</strong>

            <br>

            <span class="customer-name">

                {{ $sale->customer->full_name ?? 'Consumidor final' }}

            </span>

            @if ($sale->customer)

                <br>

                CC/NIT:

                {{ $sale->customer->identification }}

                <br>

                Tel:

                {{ $sale->customer->phone ?? 'N/A' }}

                @if ($sale->customer->city)
                    <br>

                    Ciudad:

                    {{ $sale->customer->city->name }}
                @endif

            @endif

        </div>


        <div class="separator"></div>


        {{-- ==========================================
         PRODUCTOS
    =========================================== --}}

        <table class="products">

            <thead>

                <tr>

                    <th width="10%" class="center">
                        CANT
                    </th>

                    <th width="60%">
                        PRODUCTO
                    </th>

                    <th width="30%" class="right">
                        TOTAL
                    </th>

                </tr>

            </thead>

            <tbody>

                @foreach ($sale->details as $detail)
                    <tr>

                        <td class="center">
                            {{ $detail->quantity }}
                        </td>

                        <td>

                            <div class="product-name">
                                {{ $detail->product->name ?? 'Producto eliminado' }}
                            </div>

                            <div class="product-code">

                                ${{ number_format($detail->price, 0, ',', '.') }}

                                c/u

                            </div>

                        </td>

                        <td class="right">

                            <strong>
                                ${{ number_format($detail->subtotal, 0, ',', '.') }}
                            </strong>

                        </td>

                    </tr>
                @endforeach

            </tbody>

        </table>


        <div class="separator-solid"></div>


        {{-- ==========================================
         TOTALES
    =========================================== --}}

        <table class="totals">

            <tr>

                <td>
                    Subtotal
                </td>

                <td class="right">

                    ${{ number_format($sale->subtotal, 0, ',', '.') }}

                </td>

            </tr>


            <tr>

                <td>
                    IVA / Impuestos
                </td>

                <td class="right">

                    ${{ number_format($sale->taxes ?? 0, 0, ',', '.') }}

                </td>

            </tr>


            <tr>

                <td>
                    Descuento
                </td>

                <td class="right">
                    $0
                </td>

            </tr>


            <tr class="total-final">

                <td>
                    TOTAL
                </td>

                <td class="right">

                    ${{ number_format($sale->total, 0, ',', '.') }}

                </td>

            </tr>


            @if ($sale->balance > 0)
                <tr class="balance">

                    <td>
                        SALDO
                    </td>

                    <td class="right">

                        ${{ number_format($sale->balance, 0, ',', '.') }}

                    </td>

                </tr>
            @endif

        </table>


        <div class="separator"></div>


        {{-- ==========================================
         FORMA DE PAGO
    =========================================== --}}

        <div class="payment">

            <strong>
                FORMA DE PAGO
            </strong>

            <br>

            Forma:

            {{ $sale->payment_form === 'counted' ? 'Contado' : 'Crédito' }}

            <br>

            Método:

            {{ $sale->paymentMethod?->name ?? 'No especificado' }}

            @if (($sale->term ?? 0) > 0)
                <br>

                Plazo:

                {{ $sale->term }} días

                <br>

                Vencimiento:

                {{ \Carbon\Carbon::parse($sale->expiration_date)->format('d/m/Y') }}
            @endif

        </div>


        {{-- ==========================================
         OBSERVACIONES
    =========================================== --}}

        @if ($sale->observation)
            <div class="separator"></div>

            <div class="observation">

                <strong>
                    OBSERVACIONES
                </strong>

                <br>

                {{ $sale->observation }}

            </div>
        @endif


        {{-- ==========================================
         PIE
    =========================================== --}}

        <div class="footer">

            <strong>
                ¡Gracias por su compra!
            </strong>

            <br>

            Conserve este comprobante.

            <br>

            SACVAdmin

            <br>

            Factura #{{ $sale->sale_number }}

        </div>


    </div>

</body>

</html>
