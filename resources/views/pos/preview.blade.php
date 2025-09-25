@extends('layouts.master')
@section('subtitle')
    Detalles
@endsection
@section('content')
    <div class="row">

        <div class="col-12">
            <div class="card">

                <div class="card-header">


                    <a href="{{ route('pos.index') }}" type="button" class="btn btn-block btn-success">Volver</a>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="card" style="width: 50rem;">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Detalles Venta :: {{ $date }}</li>
                            <li class="list-group-item">
                                <h3>Venta Total: {{ $totalVentas }} </h3>
                            </li>
                            <li class="list-group-item">
                                <h4>Efectivo: {{ $totalVentasEfectivo }}</h4>
                            </li>
                            <li class="list-group-item">
                                <h4>Consignacion: {{ $totalVentasConsignacion }} </h4>
                            </li>
                            <li class="list-group-item">
                                <h4>Gastos: {{ $spents }} </h4>
                            </li>
                            <li class="list-group-item">
                                <h4>Devoluciones: {{ $returnsale }}</h4>
                            </li>
                            <li class="list-group-item">
                                <h4>Efectivo Entregado: {{ $amount }}</h4>
                            </li>

                            <li class="list-group-item">
                                <h4>Diferencia: {{ $diferencia }} </h4>
                            </li>


                            <li class="list-group-item">

                                <form action="{{ route('pos.update', $pos) }}" method="post" style="display: inline">
                                    @method('put')
                                    @csrf
                                    <input type="hidden" name="total_sale" value="{{ $totalVentas }}">
                                    <input type="hidden" name="diferencia" value="{{ $diferencia }}">
                                    <input type="hidden" name="start_date" value="{{ $date }}">
                                    <input type="hidden" name="consignment" value="{{ $totalVentasConsignacion }}">
                                    <input type="hidden" name="cash" value="{{ $totalVentasEfectivo }}">
                                    <input type="hidden" name="returns_sale" value="{{ $returnsale }}">
                                    <input type="hidden" name="bills" value="{{ $spents }}">
                                    <input type="hidden" name="amount" value="{{ $amount }}">

                                    <button type="submit" class="btn btn-success "> Confirmar Cierre</button>
                                </form>
                                <br>
                            </li>
                        </ul>
                    </div>

                </div>
                <!-- /.card-body -->
            </div>
        </div>
    @endsection
