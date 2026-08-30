
@extends('reports.pdf.layout')

@section('title', 'Reporte de Gastos')


@section('summary')

    <table class="summary-table">

        <tr>

            <td width="33%">

                <div class="summary-box">

                    <div class="summary-label">
                        Total gastos
                    </div>

                    <div class="summary-value">
                        $ {{ number_format($total ?? 0, 0, ',', '.') }}
                    </div>

                </div>

            </td>


            <td width="33%">

                <div class="summary-box">

                    <div class="summary-label">
                        Cantidad de gastos
                    </div>

                    <div class="summary-value">
                        {{ $quantity ?? 0 }}
                    </div>

                </div>

            </td>


            <td width="33%">

                <div class="summary-box">

                    <div class="summary-label">
                        Promedio
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

                <th width="5%">
                    #
                </th>

                <th width="12%">
                    Fecha
                </th>

                <th width="25%">
                    Descripción
                </th>

                <th width="15%">
                    Tipo
                </th>

                <th width="15%">
                    Método de pago
                </th>

                <th width="15%">
                    Entregado a
                </th>

                <th width="13%" class="text-right">

                    Total

                </th>

            </tr>

        </thead>


        <tbody>

            @forelse($expenses as $expense)
                <tr>

                    <td>
                        {{ $loop->iteration }}
                    </td>


                    <td>

                        {{ \Carbon\Carbon::parse($expense->date)->format('d/m/Y') }}

                        @if ($expense->hour)
                            <br>

                            <small>
                                {{ $expense->hour }}
                            </small>
                        @endif

                    </td>


                    <td>

                        {{ $expense->description }}

                        @if ($expense->observation)
                            <br>

                            <small>
                                {{ $expense->observation }}
                            </small>
                        @endif

                    </td>


                    <td>

                        {{ $expense->typeExpense->name ?? 'Sin tipo' }}

                    </td>


                    <td>

                        {{ $expense->paymentMethod->name ?? 'Sin método' }}

                    </td>


                    <td>

                        {{ $expense->delivered_to }}

                    </td>


                    <td class="text-right money">

                        $
                        {{ number_format($expense->total, 0, ',', '.') }}

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="7" class="empty">

                        No existen gastos registrados.

                    </td>

                </tr>
            @endforelse


            @if ($expenses->count())
                <tr class="total-row">

                    <td colspan="6" class="text-right">

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

