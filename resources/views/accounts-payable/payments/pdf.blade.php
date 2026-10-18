<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Comprobante de abono</title>

    <style>
        @page {
            margin: 20px 30px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #16345b;
            margin: 0;
        }

        .header {
            width: 100%;
            border-bottom: 2px solid #1685e8;
            padding-bottom: 15px;
            margin-bottom: 18px;
        }

        .header-table,
        .two-columns,
        .payment-table,
        .summary-table,
        .signatures {
            width: 100%;
            border-collapse: collapse;
        }

        .brand {
            font-size: 29px;
            font-weight: bold;
            color: #07549b;
            letter-spacing: -1px;
        }

        .brand span {
            color: #1685e8;
        }

        .tagline {
            color: #526e91;
            font-size: 11px;
            margin-top: 4px;
        }

        .company-info {
            font-size: 9px;
            line-height: 1.9;
            margin-top: 10px;
        }

        .receipt-title {
            text-align: right;
            font-size: 16px;
            font-weight: bold;
            color: #074782;
        }

        .receipt-subtitle {
            text-align: right;
            font-size: 10px;
            margin-top: 5px;
        }

        .receipt-number {
            margin-top: 14px;
            background: #eaf4ff;
            border-radius: 7px;
            padding: 10px;
            text-align: center;
        }

        .receipt-number strong {
            font-size: 15px;
            color: #074782;
        }

        .receipt-date {
            margin-top: 8px;
            line-height: 1.7;
        }

        .two-columns {
            margin-bottom: 8px;
        }

        .two-columns td {
            width: 50%;
            vertical-align: top;
        }

        .column-left {
            padding-right: 7px;
        }

        .column-right {
            padding-left: 7px;
        }

        .panel {
            border: 1px solid #d6e8fa;
            border-radius: 7px;
            overflow: hidden;
        }

        .panel-title {
            background: #eaf4ff;
            color: #074782;
            font-weight: bold;
            font-size: 11px;
            padding: 10px;
        }

        .panel-content {
            padding: 10px;
        }

        .detail-table {
            width: 100%;
            border-collapse: collapse;
        }

        .detail-table td {
            padding: 5px 2px;
            vertical-align: top;
            line-height: 1.4;
        }

        .detail-label {
            width: 43%;
            font-weight: bold;
        }

        .amount-banner {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }

        .amount-main {
            background: #084b88;
            color: #ffffff;
            padding: 18px 15px;
            width: 62%;
        }

        .amount-label {
            font-size: 11px;
            font-weight: bold;
            margin-bottom: 9px;
        }

        .amount-value {
            font-size: 25px;
            font-weight: bold;
            white-space: nowrap;
        }

        .amount-words {
            font-size: 9px;
            margin-top: 9px;
        }

        .payment-status {
            background: #eaf4ff;
            padding: 15px 8px;
            text-align: center;
            color: #074782;
        }

        .status-badge {
            display: inline-block;
            background: #159957;
            color: #ffffff;
            font-weight: bold;
            padding: 8px 10px;
            border-radius: 20px;
            font-size: 9px;
        }

        .status-message {
            margin-top: 14px;
            line-height: 1.7;
            font-size: 10px;
        }

        .summary-table {
            margin-bottom: 12px;
        }

        .summary-table th {
            background: #eaf4ff;
            color: #074782;
            padding: 10px;
            text-align: left;
            font-size: 11px;
        }

        .summary-table td {
            padding: 9px 10px;
            border-bottom: 1px solid #dce8f4;
        }

        .summary-table .value {
            text-align: right;
            white-space: nowrap;
        }

        .summary-table .highlight td {
            background: #eaf4ff;
            font-weight: bold;
            color: #074782;
        }

        .payment-info {
            margin-bottom: 5px;
        }

        .payment-info .panel-content {
            padding: 12px;
        }

        .payment-details {
            width: 100%;
            border-collapse: collapse;
        }

        .payment-details td {
            padding: 7px 3px;
            vertical-align: top;
            line-height: 1.4;
        }

        .payment-details .label {
            font-weight: bold;
            width: 42%;
        }

        .payment-notes {
            margin-top: 7px;
            line-height: 1.5;
        }

        .thanks {
            color: #07549b;
            font-size: 17px;
            font-weight: bold;
            font-style: italic;
            text-align: center;
            padding: 10px 0;
        }

        .signatures {
            margin-top: 10px;
        }

        .signatures td {
            width: 50%;
            text-align: center;
            padding: 8px 12px;
            vertical-align: bottom;
        }

        .signature-line {
            border-top: 1px solid #315779;
            padding-top: 7px;
            margin-top: 24px;
        }

        .legal-note {
            background: #f0f6fc;
            border-radius: 5px;
            color: #49617d;
            font-size: 8px;
            padding: 9px;
            margin-top: 10px;
            line-height: 1.6;
        }

        .footer {
            background: #084b88;
            color: #ffffff;
            text-align: center;
            padding: 10px;
            margin-top: 16px;
            font-size: 9px;
        }

        .muted {
            color: #657b95;
        }

        .no-wrap {
            white-space: nowrap;
        }
    </style>
</head>

<body>

    @php
        $shopping = $abono->shopping;
        $cliente = $shopping->supplier;

        $formatoDinero = function ($valor) {
            return '$ ' . number_format((float) $valor, 2, ',', '.');
        };

        $metodosPago = [
            'cash' => 'Efectivo',
            'transfer' => 'Transferencia',
            'debit_card' => 'Tarjeta débito',
            'credit_card' => 'Tarjeta crédito',
            'other' => 'Otro',
        ];

        $metodoPago = $metodosPago[$abono->payment_method] ?? $abono->payment_method;

        $fechaAbono = \Carbon\Carbon::parse($abono->payment_date);
        $fechashopping = $shopping->shopping_date ? \Carbon\Carbon::parse($shopping->shopping_date) : null;

        $saldoActual = max(0, (float) $shopping->balance);
        $totalFactura = (float) $shopping->total;
        $valorAbono = (float) $abono->amount;

        $saldoAntesDelAbono = $saldoActual + $valorAbono;

        $numeroRecibo = 'AB-' . str_pad((string) $abono->id, 6, '0', STR_PAD_LEFT);

        $valorEntero = (int) floor($valorAbono);
        $centavos = (int) round(($valorAbono - $valorEntero) * 100);

        $unidades = [
            '',
            'uno',
            'dos',
            'tres',
            'cuatro',
            'cinco',
            'seis',
            'siete',
            'ocho',
            'nueve',
            'diez',
            'once',
            'doce',
            'trece',
            'catorce',
            'quince',
            'dieciséis',
            'diecisiete',
            'dieciocho',
            'diecinueve',
            'veinte',
            'veintiuno',
            'veintidós',
            'veintitrés',
            'veinticuatro',
            'veinticinco',
            'veintiséis',
            'veintisiete',
            'veintiocho',
            'veintinueve',
        ];

        $decenas = [
            30 => 'treinta',
            40 => 'cuarenta',
            50 => 'cincuenta',
            60 => 'sesenta',
            70 => 'setenta',
            80 => 'ochenta',
            90 => 'noshopping',
        ];

        $centenas = [
            100 => 'ciento',
            200 => 'doscientos',
            300 => 'trescientos',
            400 => 'cuatrocientos',
            500 => 'quinientos',
            600 => 'seiscientos',
            700 => 'setecientos',
            800 => 'ochocientos',
            900 => 'novecientos',
        ];

        $numeroALetras = function ($numero) use (&$numeroALetras, $unidades, $decenas, $centenas) {
            $numero = (int) $numero;

            if ($numero < 0) {
                return 'menos ' . $numeroALetras(abs($numero));
            }

            if ($numero < 30) {
                return $numero === 0 ? 'cero' : $unidades[$numero];
            }

            if ($numero < 100) {
                $decena = intdiv($numero, 10) * 10;
                $resto = $numero % 10;

                return $resto ? $decenas[$decena] . ' y ' . $unidades[$resto] : $decenas[$decena];
            }

            if ($numero === 100) {
                return 'cien';
            }

            if ($numero < 1000) {
                $centena = intdiv($numero, 100) * 100;
                $resto = $numero % 100;

                return $centenas[$centena] . ($resto ? ' ' . $numeroALetras($resto) : '');
            }

            if ($numero < 1000000) {
                $miles = intdiv($numero, 1000);
                $resto = $numero % 1000;

                $textoMiles = $miles === 1 ? 'mil' : $numeroALetras($miles) . ' mil';

                return $textoMiles . ($resto ? ' ' . $numeroALetras($resto) : '');
            }

            if ($numero < 1000000000) {
                $millones = intdiv($numero, 1000000);
                $resto = $numero % 1000000;

                $textoMillones = $millones === 1 ? 'un millón' : $numeroALetras($millones) . ' millones';

                return $textoMillones . ($resto ? ' ' . $numeroALetras($resto) : '');
            }

            return (string) $numero;
        };

        $valorEnLetras =
            ucfirst($numeroALetras($valorEntero)) .
            ' pesos' .
            ($centavos > 0 ? ' con ' . str_pad((string) $centavos, 2, '0', STR_PAD_LEFT) . '/100' : ' m/cte');
    @endphp

    <table class="header-table">
        <tr>
            <td style="width: 52%; vertical-align: top;">
                <div class="brand">Sis<span>venta</span></div>
                <div class="tagline">Tu tienda, más fácil</div>

                <div class="company-info">
                    <strong>Empresa:</strong> {{ config('app.name', 'SACVADMIN') }}<br>
                    <strong>Dirección:</strong> {{ $empresa->address ?? 'Dirección de la empresa' }}<br>
                    <strong>Teléfono:</strong> {{ $empresa->phone ?? 'Teléfono de contacto' }}<br>
                    <strong>NIT:</strong> {{ $empresa->nit ?? 'NIT de la empresa' }}
                </div>
            </td>

            <td style="width: 48%; vertical-align: top;">
                <div class="receipt-title">COMPROBANTE DE ABONO</div>
                <div class="receipt-subtitle">CUENTA POR COBRAR</div>

                <div class="receipt-number">
                    <strong>N.º {{ $numeroRecibo }}</strong>

                    <div class="receipt-date">
                        Fecha del abono<br>
                        <strong>{{ $fechaAbono->format('d/m/Y') }}</strong><br>
                        <span class="muted">
                            Emitido: {{ now()->format('d/m/Y H:i') }}
                        </span>
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <table class="two-columns">
        <tr>
            <td class="column-left">
                <div class="panel">
                    <div class="panel-title">DATOS DEL Proveedor</div>
                    <div class="panel-content">
                        <table class="detail-table">
                            <tr>
                                <td class="detail-label">Nombre:</td>
                                <td>{{ $cliente->full_name ?? 'No registrado' }}</td>
                            </tr>
                            <tr>
                                <td class="detail-label">Identificación:</td>
                                <td>{{ $cliente->identification ?? ($cliente->identification_card ?? 'No registrada') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="detail-label">Teléfono:</td>
                                <td>{{ $cliente->phone ?? 'No registrado' }}</td>
                            </tr>
                            <tr>
                                <td class="detail-label">Dirección:</td>
                                <td>{{ $cliente->address ?? 'No registrada' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </td>

            <td class="column-right">
                <div class="panel">
                    <div class="panel-title">DATOS DE LA FACTURA</div>
                    <div class="panel-content">
                        <table class="detail-table">
                            <tr>
                                <td class="detail-label">Factura:</td>
                                <td>{{ $shopping->sale_number ?? $shopping->id }}</td>
                            </tr>
                            <tr>
                                <td class="detail-label">Fecha de compra:</td>
                                <td>{{ $fechashopping?->format('d/m/Y') ?? 'No registrada' }}</td>
                            </tr>
                            <tr>
                                <td class="detail-label">Vencimiento:</td>
                                <td>
                                    {{ $shopping->due_date ? \Carbon\Carbon::parse($shopping->due_date)->format('d/m/Y') : 'No definido' }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <table class="amount-banner">
        <tr>
            <td class="amount-main">
                <div class="amount-label">VALOR DEL ABONO</div>
                <div class="amount-value">{{ $formatoDinero($valorAbono) }}</div>
                <div class="amount-words">{{ $valorEnLetras }}</div>
            </td>

            <td class="payment-status">
                <span class="status-badge">✓ PAGO REGISTRADO</span>
                <div class="status-message">
                    El abono ha sido registrado correctamente en el sistema.
                </div>
            </td>
        </tr>
    </table>

    <div class="panel" style="margin-bottom: 8px;">
        <div class="panel-title">RESUMEN DE LA CUENTA</div>

        <table class="summary-table">
            <tr>
                <td>Total de la factura</td>
                <td class="value">{{ $formatoDinero($totalFactura) }}</td>
            </tr>
            <tr>
                <td>Saldo antes de este abono</td>
                <td class="value">{{ $formatoDinero($saldoAntesDelAbono) }}</td>
            </tr>
            <tr>
                <td>Abono recibido</td>
                <td class="value">{{ $formatoDinero($valorAbono) }}</td>
            </tr>
            <tr class="highlight">
                <td>Saldo pendiente después del abono</td>
                <td class="value">{{ $formatoDinero($saldoActual) }}</td>
            </tr>
        </table>
    </div>

    <div class="panel payment-info">
        <div class="panel-title">INFORMACIÓN DEL PAGO</div>

        <div class="panel-content">
            <table class="two-columns">
                <tr>
                    <td class="column-left">
                        <table class="payment-details">
                            <tr>
                                <td class="label">Fecha del abono:</td>
                                <td>{{ $fechaAbono->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td class="label">Método de pago:</td>
                                <td>{{ $metodoPago }}</td>
                            </tr>
                            <tr>
                                <td class="label">Referencia:</td>
                                <td>{{ $abono->reference ?: 'No registrada' }}</td>
                            </tr>
                        </table>
                    </td>

                    <td class="column-right">
                        <table class="payment-details">
                            <tr>
                                <td class="label">Registrado por:</td>
                                <td>{{ $abono->user->name ?? 'No registrado' }}</td>
                            </tr>
                            <tr>
                                <td class="label">Observaciones:</td>
                                <td>{{ $abono->observation ?: 'Sin observaciones' }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <table class="signatures">
        <tr>
            <td>
                <div class="signature-line">Firma de quien recibe</div>
            </td>
            <td>
                <div class="signature-line">Firma del cliente</div>
            </td>
        </tr>
    </table>

    <div class="legal-note">
        Este comprobante deja constancia del abono registrado en el sistema.
        No reemplaza una factura electrónica ni constituye por sí mismo un documento fiscal.
        Conserva este comprobante para futuras consultas.
    </div>

    <div class="footer">
        Sisshopping · Comprobante de abono · {{ now()->format('d/m/Y H:i') }}
    </div>

</body>

</html>
