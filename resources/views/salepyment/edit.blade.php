@extends('layouts.master')
@section('subtitle')
    {{ $title }}
@endsection
@section('content')
    <div class="row">

        <div class="col-12">
            <div class="card">

                <div class="card-header">

                    <ul class="nav nav-pills">
                        <li class="nav-item"><a href="{{ route('accountstatecustomer.show', $cusntomer_id) }}" type="button"
                                class="btn btn-block btn-primary">Volver</a></li>
                    </ul>
                </div>

                <div class="card-body">
                    <form action="{{ route('salepyment.update', $payment->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="sale_id" value="{{ $sale->id }}">

                        <div class="form-group">
                            <label for="amount">Saldo</label>
                            <input id="amount" class="form-control" value="{{ $sale->balance }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="amount">Monto del abono</label>
                            <input type="number" name="amount" id="amount" class="form-control" value="{{ $payment->amount }}" step="0"
                                required>
                        </div>

                        <div class="form-group mt-2">
                            <label for="date">Fecha del abono</label>
                            <input type="date" name="date" id="date" class="form-control"
                                value="{{ $payment->date }}" required>
                        </div>

                        <div class="form-group mt-2">
                            <label for="note">Observación (opcional)</label>
                            <textarea name="note" id="note" class="form-control" rows="2">{{ $payment->note }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
