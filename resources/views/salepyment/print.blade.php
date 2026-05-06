<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Recibo de Abono</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            margin: 30px;
            color: #333;
        }

        .header {
            text-align: center;
        }

        .header h2 {
            margin: 0;
        }

        .info {
            display: flex;
            gap: 20px;
            /* espacio entre columnas */
        }

        .box {
            width: 50%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        table th {
            background-color: #f5f5f5;
            text-align: left;
        }

        .totales {
            margin-top: 20px;
            width: 40%;
            float: right;
        }

        .totales td {
            padding: 6px;
        }

        .firma {
            margin-top: 80px;
            display: flex;
            justify-content: space-between;
        }

        .firma div {
            text-align: center;
            width: 40%;
        }

        .line {
            border-top: 1px solid #000;
            margin-top: 40px;
        }
    </style>
</head>

<body>

    <div class="header">
        <h2>RECIBO DE ABONO</h2>
        <p><strong>{{$company->full_name}}</strong></p>
        <p>NIT: {{$company->identification_card}} </p>
        <p>Dirección: {{$company->address}}  <span>Telefono: {{$company->phone}}</span></p>
    </div>

    <div class="info">
        <table width="100%">
            <tr>
                <td width="50%">
                    <p><strong>Cliente:</strong> {{$sale->customer->full_name}}</p>
                    <p><strong>Documento:</strong> {{$sale->customer->identification_card}}</p>
                    <p><strong>Teléfono:</strong> {{$sale->customer->phone}}</p>
                </td>
                <td width="50%">
                    <p><strong>No. Recibo:</strong> {{$payment->id}}</p>
                    <p><strong>Fecha:</strong> {{$payment->date}}</p>
                    <p><strong>Factura:</strong> {{$sale->sale_number}}</p>
                </td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th>Descripción</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Abono a factura {{$sale->sale_number}}</td>
                <td>${{ number_format($payment->amount, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <table class="totales">
        <tr>
            <td><strong>Total Factura:</strong></td>
            <td>${{ number_format($sale->total, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Total Abonado:</strong></td>
            <td>${{ number_format($payment->amount, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Saldo Pendiente:</strong></td>
            <td>${{ number_format($sale->total - $payment->amount, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div style="clear: both;"></div>

    <div class="firma">
        <table width="100%">
            <tr>
                <td width="50%">
                    <div class="line"></div>
                    <p>Firma Cliente</p>
                </td>
                <td width="50%">
                    <div class="line"></div>
                    <p>Firma Responsable</p>
                </td>
            </tr>
        </table>

    </div>

</body>

</html>
