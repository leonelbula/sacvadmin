<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura Electrónica</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .invoice-box {
            max-width: 900px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0,0,0,0.15);
        }

        .invoice-header, .invoice-footer {
            text-align: center;
            margin-bottom: 20px;
        }

        .company-logo {
            max-width: 150px;
            margin-bottom: 10px;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }

        .company-details, .customer-details , .data-details{
            width: 30%;
            display: inline-block;
            vertical-align: top;
        }

        .details-table {
            width: 100%;
            margin-bottom: 20px;
        }

        .details-table td {
            padding: 5px;
            vertical-align: top;
        }

        .products-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .products-table th, .products-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        .products-table th {
            background-color: #f4f4f4;
        }

        .totals-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .totals-table td {
            padding: 8px;
        }

        .totals-table .label {
            text-align: right;
            font-weight: bold;
        }

        .totals-table .value {
            text-align: right;
        }

        .footer-text {
            text-align: center;
            font-size: 12px;
            color: #777;
            margin-top: 30px;
        }

    </style>
</head>
<body>
    <div class="invoice-box">
        <!-- HEADER -->
        <div class="invoice-header">
            <img src="{{ $company->logo == null? '': public_path($company->logo) }}" class="company-logo">
            <h1>Factura Venta  N°: {{ $sale->sale_number}}</h1>
        </div>

        <!-- COMPANY & CUSTOMER DETAILS -->
        <div class="details">
            <div class="company-details">
                <strong>Empresa:</strong><br>
                {{ $company->full_name }}<br>
                {{ $company->address }}<br>
                {{ $company->email }}<br>
                NIT: {{ $company->identification_card }}
            </div>

            <div class="customer-details">
                <strong>Cliente:</strong><br>
                {{ $sale->customer->full_name }}<br>
                {{ $sale->customer->address }}<br>
                {{ $sale->customer->email }}<br>
                NIT/CC: {{ $sale->customer->identification_card }}
            </div>
            <div class="data-details">
                Fecha Factura <br>  <strong>{{ $sale->date_sale }}</strong><br>
                Tipo de venta<br> {{  $sale->payment_form == 'counted' ? 'Contado' : 'Credito'}}<br>
                Fecha Vencimiento<br> {{  $sale->expiration_date}}<br>
            </div>
        </div>

        <!-- PRODUCTS TABLE -->
        <table class="products-table">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>IVA (%)</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sale->details as $item)
                 <tr>
                    <td>{{ $item->product->code }}</td>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->price,  0, ',', '.') }}</td>
                    <td>{{ $item->tax_value }}%</td>
                    <td>{{ number_format($item->subtotal,  0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- TOTALS -->
        <table class="totals-table">
            <tr>
                <td class="label">Subtotal:</td>
                <td class="value">{{ number_format($sale->subtotal, 2) }}</td>
            </tr>
            <tr>
                <td class="label">IVA ({{ $sale->tax }}%):</td>
                <td class="value">{{ number_format($sale->tax, 2) }}</td>
            </tr>
            <tr>
                <td class="label"><strong>Total Venta:</strong></td>
                <td class="value"><strong>{{ number_format($sale->total, 2) }}</strong></td>
            </tr>
        </table>

        <div class="footer-text">
            Gracias por su compra. Para consultas, contáctenos a {{ $company->email }}
        </div>
    </div>
</body>
</html>
