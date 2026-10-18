<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <title>Cierre de Caja</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 15px 10px;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #000;
        }

        .ticket {
            width: 80mm;
            margin: 0 auto;
            padding: 5px;
        }

        .center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .title {
            font-size: 17px;
            font-weight: bold;
        }

        .subtitle {
            font-size: 13px;
            font-weight: bold;
        }

        .line {
            border-top: 1px dashed #000;
            margin: 7px 0;
        }

        .row {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin: 4px 0;
        }

        .total {
            font-size: 14px;
            font-weight: bold;
            margin: 6px 0;
        }

        .section {
            font-weight: bold;
            text-align: center;
            margin: 7px 0;
        }

        .estado {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            margin: 10px 0;
        }

        .firma {
            text-align: center;
            margin-top: 30px;
        }

        .footer {
            text-align: center;
            font-size: 10px;
            margin-top: 15px;
        }

        @media print {

            @page {
                size: 80mm auto;
                margin: 0;
            }

            body {
                width: 80mm;
            }

            .ticket {
                width: 80mm;
            }
        }
    </style>
</head>

<body>

    <div class="ticket">

        {{-- ENCABEZADO --}}
        <div class="center">

            <div class="title">
                CIERRE DE CAJA
            </div>

            <div>
                Sistema de Ventas
            </div>

        </div>

        <div class="line"></div>

        {{-- INFORMACIÓN --}}
        <div class="section">
            INFORMACIÓN DE CAJA
        </div>

        <div class="row">
            <span>Caja:</span>
            <span>#{{ $pos->id }}</span>
        </div>

        <div class="row">
            <span>Cajero:</span>
            <span>{{ $pos->user->name }}</span>
        </div>

        <div class="row">
            <span>Apertura:</span>
            <span>
                {{ \Carbon\Carbon::parse($pos->start_date)->format('d/m/Y') }}
                {{ $pos->start_time }}
            </span>
        </div>

        <div class="row">
            <span>Cierre:</span>
            <span>
                {{ \Carbon\Carbon::parse($pos->closing_date)->format('d/m/Y') }}
                {{ $pos->closing_time }}
            </span>
        </div>

        <div class="line"></div>

        {{-- RESUMEN DE VENTAS --}}
        <div class="section">
            RESUMEN DE VENTAS
        </div>

        <div class="row">
            <span>Facturas:</span>
            <span>{{ $pos->bills }}</span>
        </div>

        <div class="row total">
            <span>TOTAL VENTAS:</span>
            <span>
                $ {{ number_format($pos->total_sale, 0, ',', '.') }}
            </span>
        </div>

        <div class="line"></div>

        {{-- MOVIMIENTOS DE CAJA --}}
        <div class="section">
            MOVIMIENTOS DE CAJA
        </div>

        <div class="row">
            <span>Base inicial:</span>
            <span>
                $ {{ number_format($pos->box_base, 0, ',', '.') }}
            </span>
        </div>

        <div class="row">
            <span>Efectivo:</span>
            <span>
                $ {{ number_format($pos->cash, 0, ',', '.') }}
            </span>
        </div>

        <div class="row">
            <span>Consignaciones:</span>
            <span>
                $ {{ number_format($pos->consignment, 0, ',', '.') }}
            </span>
        </div>

        <div class="row">
            <span>Devoluciones:</span>
            <span>
               - $ {{ number_format($pos->returns_sale, 0, ',', '.') }}
            </span>
        </div>

         <div class="row">
            <span>Gastos:</span>
            <span>
              -  $ {{ number_format($pos->bills, 0, ',', '.') }}
            </span>
        </div>
        <div class="line"></div>

        {{-- ENTREGA --}}
        <div class="section">
            CONTROL DE CAJA
        </div>

        <div class="row">
            <span>Valor entregado:</span>
            <span>
                $ {{ number_format($pos->delivered_value, 0, ',', '.') }}
            </span>
        </div>

        <div class="row total">
            <span>DIFERENCIA:</span>
            <span>
                $ {{ number_format($pos->difference, 0, ',', '.') }}
            </span>
        </div>

        <div class="line"></div>

        {{-- ESTADO --}}
        <div class="estado">

            @if ($pos->state == 1)
                CAJA CERRADA
            @else
                CAJA ABIERTA
            @endif

        </div>

        <div class="line"></div>

        {{-- FIRMA --}}
        <div class="firma">

            ______________________________

            <br>

            Firma del cajero

        </div>

        {{-- PIE --}}
        <div class="footer">

            <div>
                Gracias por utilizar nuestro sistema
            </div>

            <br>

            <div>
                {{ now()->format('d/m/Y H:i:s') }}
            </div>

        </div>

    </div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>

</body>

</html>
