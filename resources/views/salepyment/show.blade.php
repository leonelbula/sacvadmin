@extends('layouts.master')
@section('subtitle')
    {{ $title }}
@endsection
@section('content')
    <div class="row">

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a class="btn btn-primary" href="{{ route('accountsattuscustomer.list_show', $sale->id) }}">Volver</a>
                    <a class="btn btn-success" href="{{ route('accountsale.abonar', $sale->id) }}">Registrar Abono</a>
                    <a href="{{ route('salepayment.print', $payment->id) }}" target="_blank" class="btn btn-info"><i class="bi bi-printer"></i></a>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="customer">Cliente</label>
                                <input id="customer" class="form-control" value="{{ $sale->customer->full_name }}"
                                    readonly>
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="sale_number">N° Factura</label>
                                <input id="sale_number" class="form-control" value="{{ $sale->sale_number }}" readonly>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="date">Fecha del abono</label>
                                <input type="date" name="date" id="date" class="form-control"
                                    value="{{ $payment->date }}" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="amount">Monto del abono</label>
                                <input type="number" name="amount" id="amount" value="{{ $payment->amount }}"
                                    class="form-control" step="0" readonly>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="total">Saldo Pendiente</label>
                                <input id="total" class="form-control"
                                    value="{{ number_format($sale->total, 0, ',', '.') }}" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label for="note">Observación (opcional)</label>
                            <textarea name="note" id="note" class="form-control" rows="2" readonly>{{ $payment->note }}</textarea>
                        </div>

                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection
