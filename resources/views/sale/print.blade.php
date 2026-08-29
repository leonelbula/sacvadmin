<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>
        Factura #{{ $sale->sale_number }}
    </title>

    <style>
        @page {
            margin: 25px 30px 30px 30px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;

            font-family: DejaVu Sans, Arial, sans-serif;

            font-size: 10px;

            color: #1f2937;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        /* =========================================
           ENCABEZADO
        ========================================= */

        .header-table {
            width: 100%;
            margin-bottom: 18px;
        }

        .company {
            width: 60%;
            vertical-align: top;
        }

        .invoice-info {
            width: 40%;
            vertical-align: top;
            text-align: right;
        }

        .company-name {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .company-data {
            color: #64748b;
            line-height: 1.6;
            font-size: 9px;
        }

        .invoice-label {
            font-size: 9px;
            text-transform: uppercase;
            color: #64748b;
            font-weight: bold;
        }

        .invoice-number {
            font-size: 20px;
            font-weight: bold;
            margin: 3px 0 8px 0;
        }

        .invoice-data {
            font-size: 9px;
            color: #475569;
            line-height: 1.6;
        }

        /* =========================================
           LINEA
        ========================================= */

        .separator {
            border-top: 2px solid #1f2937;
            margin-bottom: 15px;
        }

        /* =========================================
           CLIENTE
        ========================================= */

        .info-table {
            margin-bottom: 18px;
        }

        .info-box {
            border: 1px solid #d1d5db;
            padding: 10px;
            vertical-align: top;
        }

        .info-title {
            font-size: 8px;
            text-transform: uppercase;
            color: #64748b;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .customer-name {
            font-size: 11px;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .info-text {
            font-size: 9px;
            color: #475569;
            line-height: 1.6;
        }

        /* =========================================
           PRODUCTOS
        ========================================= */

        .products {
            margin-top: 10px;
        }

        .products th {
            background: #f1f5f9;
            border-top: 1px solid #cbd5e1;
            border-bottom: 1px solid #cbd5e1;

            padding: 8px 6px;

            font-size: 8px;

            text-transform: uppercase;

            text-align: left;
        }

        .products td {
            padding: 8px 6px;

            border-bottom: 1px solid #e5e7eb;

            font-size: 9px;

            vertical-align: top;
        }

        .center {
            text-align: center !important;
        }

        .right {
            text-align: right !important;
        }

        .product-name {
            font-weight: bold;
        }

        .product-code {
            color: #94a3b8;
            font-size: 7px;
            margin-top: 2px;
        }

        /* =========================================
           TOTALES
        ========================================= */

        .bottom-table {
            margin-top: 20px;
        }

        .observation {
            width: 55%;
            vertical-align: top;
        }

        .totals {
            width: 45%;
            vertical-align: top;
        }

        .totals-table {
            width: 100%;
        }

        .totals-table td {
            padding: 5px;
            font-size: 9px;
        }

        .total-final td {
            border-top: 2px solid #1f2937;

            padding-top: 10px;

            font-size: 13px;

            font-weight: bold;
        }

        .balance {
            color: #dc2626;
        }

        /* =========================================
           OBSERVACIONES
        ========================================= */

        .observation-title {
            font-size: 8px;

            text-transform: uppercase;

            color: #64748b;

            font-weight: bold;

            margin-bottom: 5px;
        }

        .observation-text {
            font-size: 9px;

            color: #475569;

            line-height: 1.6;
        }

        /* =========================================
           PIE
        ========================================= */

        .footer {
            margin-top: 35px;

            padding-top: 12px;

            border-top: 1px solid #d1d5db;

            text-align: center;

            font-size: 8px;

            color: #64748b;

            line-height: 1.6;
        }

        .footer strong {
            color: #334155;
        }
    </style>

</head>


<body>


    {{-- =====================================================
    ENCABEZADO
===================================================== --}}

    <table class="header-table">

        <tr>

            <td class="company">

                <div class="company-name">
                    SACVAdmin
                </div>

                <div class="company-data">

                    Sistema de gestión empresarial<br>

                    Dirección de la empresa<br>

                    Teléfono: 000 000 0000<br>

                    Email: correo@empresa.com<br>

                    NIT: 000.000.000-0

                </div>

            </td>


            <td class="invoice-info">

                <div class="invoice-label">
                    Factura de venta
                </div>

                <div class="invoice-number">

                    #{{ $sale->sale_number }}

                </div>

                <div class="invoice-data">

                    Fecha:
                    <strong>
                        {{ \Carbon\Carbon::parse($sale->date_sale)->format('d/m/Y') }}
                    </strong>

                    <br>

                    Hora:
                    <strong>
                        {{ $sale->hour }}
                    </strong>

                    <br>

                    Estado:

                    <strong>
                        {{ $sale->state === 'active' ? 'ACTIVA' : strtoupper($sale->state) }}
                    </strong>

                </div>

            </td>

        </tr>

    </table>


    <div class="separator"></div>


    {{-- =====================================================
    CLIENTE
===================================================== --}}

    <table class="info-table">

        <tr>

            <td class="info-box" width="60%">

                <div class="info-title">
                    Información del cliente
                </div>

                <div class="customer-name">

                    {{ $sale->customer->full_name ?? 'Consumidor final' }}

                </div>


                @if ($sale->customer)

                    <div class="info-text">

                        <strong>
                            Identificación:
                        </strong>

                        {{ $sale->customer->identification }}

                        <br>

                        <strong>
                            Teléfono:
                        </strong>

                        {{ $sale->customer->phone ?? 'No registrado' }}

                        <br>

                        <strong>
                            Dirección:
                        </strong>

                        {{ $sale->customer->address ?? 'No registrada' }}

                        @if ($sale->customer->city)
                            <br>

                            <strong>
                                Ciudad:
                            </strong>

                            {{ $sale->customer->city->name }}
                        @endif

                    </div>

                @endif

            </td>


            <td width="2%"></td>


            <td class="info-box" width="38%">

                <div class="info-title">
                    Información del pago
                </div>

                <div class="info-text">

                    <strong>
                        Forma de pago:
                    </strong>

                    {{ $sale->payment_form === 'counted' ? 'Contado' : 'Crédito' }}

                    <br>

                    <strong>
                        Método:
                    </strong>

                    {{ $sale->paymentMethod?->name ?? 'No especificado' }}

                    <br>

                    <strong>
                        Plazo:
                    </strong>

                    {{ $sale->term ?? 0 }} días

                    <br>

                    <strong>
                        Vencimiento:
                    </strong>

                    @if ($sale->expiration_date)
                        {{ \Carbon\Carbon::parse($sale->expiration_date)->format('d/m/Y') }}
                    @else
                        —
                    @endif

                </div>

            </td>

        </tr>

    </table>


    {{-- =====================================================
    PRODUCTOS
===================================================== --}}

    <table class="products">

        <thead>

            <tr>

                <th width="5%" class="center">
                    #
                </th>

                <th width="40%">
                    Producto
                </th>

                <th width="10%" class="center">
                    Cant.
                </th>

                <th width="15%" class="right">
                    Precio
                </th>

                <th width="15%" class="right">
                    IVA
                </th>

                <th width="15%" class="right">
                    Total
                </th>

            </tr>

        </thead>


        <tbody>

            @foreach ($sale->details as $index => $detail)
                <tr>

                    <td class="center">
                        {{ $index + 1 }}
                    </td>


                    <td>

                        <div class="product-name">

                            {{ $detail->product->name ?? 'Producto eliminado' }}

                        </div>


                        @if ($detail->product)
                            <div class="product-code">

                                Código:
                                {{ $detail->product->code }}

                            </div>
                        @endif

                    </td>


                    <td class="center">

                        {{ $detail->quantity }}

                    </td>


                    <td class="right">

                        ${{ number_format($detail->price, 0, ',', '.') }}

                    </td>


                    <td class="right">

                        ${{ number_format($detail->tax ?? 0, 0, ',', '.') }}

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


    {{-- =====================================================
    TOTALES
===================================================== --}}

    <table class="bottom-table">

        <tr>

            <td class="observation">

                @if ($sale->observation)
                    <div class="observation-title">
                        Observaciones
                    </div>

                    <div class="observation-text">

                        {{ $sale->observation }}

                    </div>
                @endif

            </td>


            <td class="totals">

                <table class="totals-table">

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
                            Impuestos
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
                        <tr>

                            <td class="balance">
                                Saldo pendiente
                            </td>

                            <td class="right balance">

                                ${{ number_format($sale->balance, 0, ',', '.') }}

                            </td>

                        </tr>
                    @endif

                </table>

            </td>

        </tr>

    </table>


    {{-- =====================================================
    PIE
===================================================== --}}

    <div class="footer">

        <strong>
            Gracias por su compra
        </strong>

        <br>

        Esta factura fue generada mediante SACVAdmin.

        <br>

        Factura #{{ $sale->sale_number }}

    </div>


</body>

</html>
