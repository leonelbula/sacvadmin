<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Comprobante de abono</title>

    <style>
        @page {
            margin: 35px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #333;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0 0 8px;
            font-size: 21px;
        }

        .header p {
            margin: 4px 0;
        }

        .section-title {
            background: #f0f0f0;
            padding: 8px;
            font-weight: bold;
            margin-top: 18px;
            margin-bottom: 10px;
        }

        .details {
            width: 100%;
            border-collapse: collapse;
        }

        .details td {
            padding: 7px;
            border-bottom: 1px solid #ddd;
        }

        .details td:first-child {
            width: 40%;
            font-weight: bold;
        }

        .amount-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .amount-table th,
        .amount-table td {
            border: 1px solid #ddd;
            padding: 9px;
        }

        .amount-table th {
            background: #f0f0f0;
            text-align: left;
        }

        .amount-table .number {
            text-align: right;
        }

        .paid {
            font-size: 15px;
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
        }

        .signatures {
            width: 100%;
            margin-top: 55px;
        }

        .signatures td {
            width: 50%;
            text-align: center;
            padding: 10px;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>COMPROBANTE DE ABONO</h1>
        <p>Comprobante N.º {{ str_pad($abono->id, 6, '0', STR_PAD_LEFT) }}</p>
        <p>Fecha de emisión: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <div class="section-title">Datos del cliente</div>

    <table class="details">
        <tr>
            <td>Nombre</td>
            <td>{{ $abono->sale->customer->full_name ?? 'No registrado' }}</td>
        </tr>
        <tr>
            <td>Identificación</td>
            <td>{{ $abono->sale->customer->identification ?? 'No registrada' }}</td>
        </tr>
        <tr>
            <td>Teléfono</td>
            <td>{{ $abono->sale->customer->phone ?? 'No registrado' }}</td>
        </tr>
    </table>

    <div class="section-title">Datos de la factura</div>

    <table class="details">
        <tr>
            <td>Número de factura</td>
            <td>{{ $abono->sale->sale_number ?? $abono->sale_id }}</td>
        </tr>
        <tr>
            <td>Fecha de venta</td>
            <td>
                {{ $abono->sale->date_sale ? \Carbon\Carbon::parse($abono->sale->date_sale)->format('d/m/Y') : 'No registrada' }}
            </td>
        </tr>
    </table>

    <div class="section-title">Detalle del abono</div>

    <table class="amount-table">
        <thead>
            <tr>
                <th>Concepto</th>
                <th class="number">Valor</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Valor original de la factura</td>
                <td class="number">
                    ${{ number_format((float) $abono->sale->total, 2, ',', '.') }}
                </td>
            </tr>
            <tr>
                <td class="paid">Abono recibido</td>
                <td class="number paid">
                    ${{ number_format((float) $abono->amount, 2, ',', '.') }}
                </td>
            </tr>
            <tr>
                <td>Saldo pendiente después del abono</td>
                <td class="number">
                    ${{ number_format((float) $abono->sale->balance, 2, ',', '.') }}
                </td>
            </tr>
        </tbody>
    </table>

    <div class="section-title">Información del pago</div>

    <table class="details">
        <tr>
            <td>Fecha del abono</td>
            <td>{{ \Carbon\Carbon::parse($abono->payment_date)->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td>Método de pago</td>
            <td>
                {{ [
                    'cash' => 'Efectivo',
                    'transfer' => 'Transferencia',
                    'debit_card' => 'Tarjeta débito',
                    'credit_card' => 'Tarjeta crédito',
                    'other' => 'Otro',
                ][$abono->payment_method] ?? $abono->payment_method }}
            </td>
        </tr>
        <tr>
            <td>Referencia</td>
            <td>{{ $abono->reference ?: 'No registrada' }}</td>
        </tr>
        <tr>
            <td>Registrado por</td>
            <td>{{ $abono->user->name ?? 'No registrado' }}</td>
        </tr>
        <tr>
            <td>Observaciones</td>
            <td>{{ $abono->observation ?: 'Sin observaciones' }}</td>
        </tr>
    </table>

    <p style="margin-top: 20px;">
        Se deja constancia de la recepción del abono indicado en este comprobante.
    </p>

    <table class="signatures">
        <tr>
            <td>
                ______________________________<br>
                Firma de quien recibe
            </td>
            <td>
                ______________________________<br>
                Firma del cliente
            </td>
        </tr>
    </table>

    <div class="footer">
        Documento generado por el sistema de ventas.
    </div>

</body>

</html>
