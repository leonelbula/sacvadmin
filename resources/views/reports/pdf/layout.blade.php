<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>
        @yield('title', 'Reporte')
    </title>

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
            color: #222;
            margin: 0;
        }

        .header {
            width: 100%;
            border-bottom: 2px solid #198754;
            padding-bottom: 12px;
            margin-bottom: 15px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .logo {
            font-size: 22px;
            font-weight: bold;
            color: #198754;
        }

        .company {
            font-size: 11px;
            font-weight: bold;
        }

        .report-title {
            text-align: right;
            font-size: 16px;
            font-weight: bold;
        }

        .date {
            text-align: right;
            color: #666;
            font-size: 9px;
            margin-top: 4px;
        }

        .summary {
            width: 100%;
            margin-bottom: 18px;
        }

        .summary-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 8px;
        }

        .summary-box {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        .summary-label {
            color: #666;
            font-size: 9px;
            text-transform: uppercase;
        }

        .summary-value {
            font-size: 15px;
            font-weight: bold;
            margin-top: 4px;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table.data thead {
            background: #198754;
            color: white;
        }

        table.data th {
            padding: 7px;
            font-size: 9px;
            text-align: left;
        }

        table.data td {
            padding: 6px;
            border-bottom: 1px solid #ddd;
            font-size: 9px;
        }

        table.data tbody tr:nth-child(even) {
            background: #f7f7f7;
        }

        .text-right {
            text-align: right !important;
        }

        .text-center {
            text-align: center !important;
        }

        .total-row {
            font-weight: bold;
            background: #eee !important;
        }

        .footer {
            position: fixed;
            bottom: -10px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 8px;
            color: #777;
            border-top: 1px solid #ddd;
            padding-top: 5px;
        }

        .page-number:after {
            content: counter(page);
        }

        .badge {
            display: inline-block;
            padding: 3px 6px;
            border-radius: 3px;
            font-size: 8px;
        }

        .badge-success {
            background: #d1e7dd;
            color: #0f5132;
        }

        .badge-danger {
            background: #f8d7da;
            color: #842029;
        }

        .money {
            white-space: nowrap;
        }

        .empty {
            text-align: center;
            padding: 20px;
            color: #777;
        }
    </style>

</head>

<body>

    {{-- HEADER --}}

    <div class="header">

        <table class="header-table">

            <tr>

                <td width="50%">

                    <div class="logo">
                        SACVAdmin
                    </div>

                    <div class="company">
                        Sistema Administrativo y de Ventas
                    </div>

                </td>

                <td width="50%">

                    <div class="report-title">
                        @yield('title', 'Reporte')
                    </div>

                    <div class="date">

                        Generado:
                        {{ now()->format('d/m/Y H:i') }}

                    </div>

                </td>

            </tr>

        </table>

    </div>


    {{-- RESUMEN --}}

    @hasSection('summary')
        <div class="summary">

            @yield('summary')

        </div>
    @endif


    {{-- CONTENIDO --}}

    @yield('content')


    {{-- FOOTER --}}

    <div class="footer">

        SACVAdmin &nbsp; | &nbsp;
        Reporte generado automáticamente

        &nbsp; | &nbsp;

        Página
        <span class="page-number"></span>

    </div>

</body>

</html>

