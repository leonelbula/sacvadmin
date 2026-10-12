<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ajuste de Inventario</title>

    <style>
        @page {
            margin: 25px 30px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #334155;
            margin: 0;
        }

        .header {
            width: 100%;
            border-bottom: 3px solid #163b65;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .header-table,
        .info-table,
        .products-table,
        .summary-table,
        .signatures-table {
            width: 100%;
            border-collapse: collapse;
        }

        .company-name {
            font-size: 23px;
            font-weight: bold;
            color: #163b65;
            margin-bottom: 5px;
        }

        .company-info {
            font-size: 9px;
            line-height: 1.7;
            color: #64748b;
        }

        .document-title {
            text-align: right;
            color: #163b65;
            font-size: 16px;
            font-weight: bold;
        }

        .document-number {
            text-align: right;
            font-size: 10px;
            margin-top: 7px;
        }

        .status {
            display: inline-block;
            background: #dcfce7;
            color: #166534;
            padding: 5px 9px;
            border-radius: 3px;
            font-size: 9px;
            margin-top: 7px;
        }

        .section-title {
            background: #163b65;
            color: #ffffff;
            padding: 9px 10px;
            font-size: 11px;
            font-weight: bold;
            margin-top: 16px;
            margin-bottom: 0;
        }

        .info-table td {
            width: 50%;
            padding: 10px;
            border: 1px solid #e2e8f0;
            vertical-align: top;
        }

        .label {
            display: block;
            color: #64748b;
            font-size: 8px;
            margin-bottom: 5px;
        }

        .value {
            font-size: 10px;
            font-weight: bold;
            color: #1e293b;
        }

        .products-table {
            margin-top: 0;
        }

        .products-table thead th {
            background: #eaf0f7;
            color: #163b65;
            font-weight: bold;
            font-size: 8px;
            padding: 9px 5px;
            border: 1px solid #d7e0eb;
            text-align: center;
        }

        .products-table tbody td {
            padding: 9px 5px;
            border: 1px solid #e2e8f0;
            font-size: 8px;
            vertical-align: middle;
        }

        .products-table tbody tr:nth-child(even) {
            background: #f8fafc;
        }

        .text-left {
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .increase {
            color: #15803d;
            font-weight: bold;
        }

        .decrease {
            color: #b91c1c;
            font-weight: bold;
        }

        .summary-table {
            margin-top: 15px;
        }

        .summary-table td {
            width: 33.33%;
            padding: 12px;
            background: #f1f5f9;
            border: 3px solid #ffffff;
            text-align: center;
        }

        .summary-label {
            color: #64748b;
            font-size: 8px;
            margin-bottom: 7px;
        }

        .summary-value {
            color: #163b65;
            font-size: 16px;
            font-weight: bold;
        }

        .observations {
            border: 1px solid #e2e8f0;
            padding: 12px;
            min-height: 55px;
            line-height: 1.6;
        }

        .signatures-table {
            margin-top: 55px;
        }

        .signatures-table td {
            width: 50%;
            text-align: center;
            padding: 0 25px;
        }

        .signature-line {
            border-top: 1px solid #94a3b8;
            padding-top: 8px;
            font-size: 9px;
            font-weight: bold;
        }

        .signature-caption {
            color: #64748b;
            font-size: 8px;
            margin-top: 4px;
        }

        .footer {
            position: fixed;
            bottom: -8px;
            left: 0;
            right: 0;
            border-top: 1px solid #e2e8f0;
            padding-top: 7px;
            text-align: center;
            color: #64748b;
            font-size: 8px;
        }

        .empty {
            text-align: center;
            padding: 15px;
            color: #64748b;
        }

        .page-number:after {
            content: counter(page);
        }
    </style>
</head>

<body>

    @php
        $empresa = $company ?? null;


        $productos = $adjustments ?? collect();

        $fecha = $filters->date_from ?? date('Y-m-d');
    @endphp

    <div class="header">
        <table class="header-table">
            <tr>
                <td style="width: 55%; vertical-align: top;">
                    <div class="company-name">
                        {{ $empresa->full_name ?? 'SISTEMAVENTA' }}
                    </div>

                    <div class="company-info">
                        @if ($empresa)
                            NIT: {{ $empresa->identification_card ?? 'No registrado' }}<br>
                            Teléfono: {{ $empresa->phone ?? 'No registrado' }}<br>
                            Correo: {{ $empresa->email ?? 'No registrado' }}
                        @else
                            Sistema de gestión comercial
                        @endif
                    </div>
                </td>

                <td style="width: 45%; vertical-align: top;">
                    <div class="document-title">
                        AJUSTE DE INVENTARIO
                    </div>

                    <div style="text-align: right;">
                        <span class="status">
                        </span>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="section-title">
        INFORMACIÓN DEL AJUSTE
    </div>

    <table class="info-table">
        <tr>
            <td>
                <span class="label">Fecha del ajuste</span>
                <span class="value">
                    {{ $fecha ? \Carbon\Carbon::parse($fecha)->format('d/m/Y') : 'No registrada' }}
                </span>
            </td>

            <td>
                <span class="label">Responsable</span>
                <span class="value">
                    {{ $ajuste->user->name ?? '___________' }}
                </span>
            </td>
        </tr>
    </table>

    <div class="section-title">
        DETALLE DE PRODUCTOS
    </div>

    <table class="products-table">
        <thead>
            <tr>
                <th style="width: 8%;">N.º</th>
                <th style="width: 15%;">Código</th>
                <th style="width: 27%;">Producto</th>
                <th style="width: 12%;">Stock anterior</th>
                <th style="width: 12%;">Diferencia</th>
                <th style="width: 12%;">Stock nuevo</th>
                <th style="width: 14%;">Costo unitario</th>
            </tr>
        </thead>

        <tbody>
            @forelse($productos as $detalle)
                @php
                    $diferencia = (float) ($detalle->quantity ?? 0);
                    $stockAnterior = (float) ($detalle->stock_before ?? 0);
                    $stockNuevo = (float) ($detalle->stock_after ?? $stockAnterior + $diferencia);
                @endphp

                <tr>
                    <td class="text-center">
                        {{ $loop->iteration }}
                    </td>

                    <td class="text-center">
                        {{ $detalle->product->code ?? 'N/A' }}
                    </td>

                    <td class="text-left">
                        {{ $detalle->product->name ?? 'Producto no disponible' }}
                    </td>

                    <td class="text-center">
                        {{ number_format($stockAnterior, 0, ',', '.') }}
                    </td>

                    <td class="text-center {{ $diferencia > 0 ? 'increase' : ($diferencia < 0 ? 'decrease' : '') }}">
                        {{ $diferencia > 0 ? '+' : '' }}{{ number_format($diferencia, 0, ',', '.') }}
                    </td>

                    <td class="text-center">
                        {{ number_format($stockNuevo, 0, ',', '.') }}
                    </td>

                    <td class="text-right">
                        ${{ number_format((float) ($detalle->unit_cost ?? ($detalle->product->cost ?? 0)), 2, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="empty">
                        No hay productos registrados en este ajuste.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>



    <div class="section-title">
        OBSERVACIONES
    </div>

    <div class="observations">
        {{ $ajuste->observation ?? 'Sin observaciones registradas.' }}
    </div>

    <table class="signatures-table">
        <tr>
            <td>
                <div class="signature-line">
                    {{ $ajuste->user->name ?? ' ' }}
                </div>
                <div class="signature-caption">
                    Elaborado por
                </div>
            </td>

            <td>
                <div class="signature-line">
                    &nbsp;
                </div>
                <div class="signature-caption">
                    Autorizado por
                </div>
            </td>
        </tr>
    </table>

    <div class="footer">
        Documento generado por Sisventa |
        Fecha de impresión: {{ now()->format('d/m/Y H:i') }}
        | Página <span class="page-number"></span>
    </div>

</body>

</html>
