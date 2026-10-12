@extends('reports.pdf.layout')

@section('title', 'Reporte de Ventas por Cliente')


@section('summary')

    <table class="summary-table">

        <tr>

            <td width="33%">
                <div class="summary-box">

                    <div class="summary-label">
                        Total ventas
                    </div>

                    <div class="summary-value">
                        $ {{ number_format($total ?? 0, 0, ',', '.') }}
                    </div>
                </div>

            </td>

            <td width="33%">

                <div class="summary-box">
                    <div class="summary-label">
                        Facturas
                    </div>
                    <div class="summary-value">
                        {{ number_format($quantity ?? 0, 0, ',', '.') }}
                    </div>
                </div>

            </td>

            <td width="33%">
                <div class="summary-box">
                    <div class="summary-label">
                        Clientes
                    </div>
                    <div class="summary-value">
                        {{ $customers->count() }}
                    </div>

                </div>
            </td>

        </tr>

    </table>
@endsection



@section('content')


    <table class="data">

        <thead>

            <tr>

                <th style="width: 8%;" class="text-center">
                    #
                </th>

                <th style="width: 42%;">
                    Cliente
                </th>

                <th style="width: 20%;" class="text-center">
                    Ventas
                </th>

                <th style="width: 30%;" class="text-right">
                    Total vendido
                </th>

            </tr>

        </thead>

        <tbody>

            @forelse($customers as $index => $customer)
                <tr>

                    <td class="text-center">
                        {{ $index + 1 }}
                    </td>

                    <td>
                        {{ $customer->customer->full_name }}
                    </td>

                    <td class="text-center">
                        {{ number_format($customer->sales, 0, ',', '.') }}
                    </td>

                    <td class="text-right">
                        $ {{ number_format($customer->total, 0, ',', '.') }}
                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="4" class="empty">
                        No existen ventas para el período seleccionado.
                    </td>

                </tr>
            @endforelse

        </tbody>

        @if ($customers->count() > 0)
            <tfoot>

                <tr class="total-row">

                    <td colspan="2" class="text-right">
                        TOTAL
                    </td>

                    <td class="text-center">
                        {{ number_format($quantity ?? 0, 0, ',', '.') }}
                    </td>

                    <td class="text-right">
                        $ {{ number_format($total ?? 0, 0, ',', '.') }}
                    </td>

                </tr>

            </tfoot>
        @endif

    </table>

@endsection
