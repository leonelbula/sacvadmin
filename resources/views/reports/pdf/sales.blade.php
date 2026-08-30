@extends('reports.pdf.layout')

@section('title', 'Reporte de Ventas')


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
                        {{ $quantity ?? 0 }}
                    </div>

                </div>

            </td>


            <td width="33%">

                <div class="summary-box">

                    <div class="summary-label">
                        Promedio por venta
                    </div>

                    <div class="summary-value">

                        $

                        {{ number_format(($quantity ?? 0) > 0 ? ($total ?? 0) / $quantity : 0, 0, ',', '.') }}

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

                <th width="7%">
                    #
                </th>

                <th width="13%">
                    Fecha
                </th>

                <th width="15%">
                    Factura
                </th>

                <th width="25%">
                    Cliente
                </th>

                <th width="20%">
                    Usuario
                </th>

                <th width="20%" class="text-right">

                    Total

                </th>

            </tr>

        </thead>


        <tbody>

            @forelse($sales as $sale)
                <tr>

                    <td>
                        {{ $loop->iteration }}
                    </td>


                    <td>

                        @if ($sale->date_sale)
                            {{ \Carbon\Carbon::parse($sale->date)->format('d/m/Y') }}
                        @else
                            -
                        @endif

                    </td>


                    <td>

                        {{ $sale->invoice_number ?? ($sale->number ?? $sale->id) }}

                    </td>


                    <td>

                        @if ($sale->customer)
                            {{ $sale->customer->full_name ?? 'Cliente' }}
                        @else
                            Consumidor final
                        @endif

                    </td>


                    <td>

                        {{ $sale->user->name ?? 'Sin usuario' }}

                    </td>


                    <td class="text-right money">

                        $

                        {{ number_format($sale->total ?? 0, 0, ',', '.') }}

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="6" class="empty">

                        No existen ventas registradas.

                    </td>

                </tr>
            @endforelse


            @if ($sales->count())
                <tr class="total-row">

                    <td colspan="5" class="text-right">

                        TOTAL VENTAS

                    </td>

                    <td class="text-right">

                        $

                        {{ number_format($total, 0, ',', '.') }}

                    </td>

                </tr>
            @endif

        </tbody>

    </table>

@endsection
