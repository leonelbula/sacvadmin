@extends('reports.pdf.layout')

@section('title', 'Reporte de Ventas de productos')


@section('summary')


    <table class="summary-table">

        <tr>

            <td width="33%">

                <div class="summary-box">

                    <div class="summary-label">
                        Total productos vendidos
                    </div>

                    <div class="summary-value">
                        $ {{ number_format($total ?? 0, 0, ',', '.') }}
                    </div>
                </div>

            </td>


            <td width="33%">

                <div class="summary-box">

                    <div class="summary-label">
                        ventas
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
                    codigo
                </th>

                <th width="40%">
                    producto
                </th>


                <th width="20%">
                    cantidad
                </th>

                <th width="20%" class="text-right">

                    Total

                </th>

            </tr>

        </thead>


        <tbody>

            @forelse($products as $item)
                <tr>

                    <td>
                        {{ $loop->iteration }}
                    </td>


                    <td>

                        {{ $item->product->code ?? '-' }}

                    </td>


                    <td>

                         {{ $item->product->name ?? 'Producto eliminado' }}
                    </td>


                    <td class="text-center">

                        {{ $item->quantity }}

                    </td>


                    <td class="text-right money">

                        $

                        {{ number_format($item->total ?? 0, 0, ',', '.') }}

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="6" class="empty">

                        No existen ventas registradas.

                    </td>

                </tr>
            @endforelse


            @if ($total ?? 0 > 0))
                <tr class="total-row">

                    <td colspan="4" class="text-right">

                        TOTAL

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
