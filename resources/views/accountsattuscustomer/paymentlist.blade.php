@extends('layouts.master')
@section('title')
    {{ $title }}
@endsection
@section('content')
    <div class="row">

        <div class="col-12">
            <div class="card">

                <div class="card-header">

                    <a href="{{ route('accountstatecustomer.index') }}">
                        <button type="button" class="btn btn-primary">Volver</button>
                    </a>
                    <a href="{{ route('accountsale.abonar', $sale->id) }}">
                        <button type="button" class="btn btn-success">Registrar Abono</button>
                    </a>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <h3>Cliente: {{ $sale->customer->full_name }} </h3>
                        </li>
                         <li class="list-group-item">
                            <h3>N° Factura: {{ $sale->sale_number }} </h3>
                        </li>
                        <li class="list-group-item">
                            <h4>Saldo Pendiente: {{ number_format($sale->total, 0, ',', '.') }}</h4>
                        </li>
                        <li class="list-group-item">
                            <h4>Saldo : {{ number_format($sale->balance, 0, ',', '.') }} </h4>
                        </li>
                    </ul>
                    <hr>
                    <div class="container mt-4">
                        <h4 class="mb-3">📋 Reporte de abonos realizados</h4>

                        <table class="table table-bordered table-striped">
                            <thead class="table-dark text-center">
                                <tr>
                                    <th>Id</th>
                                    <th>Fecha</th>
                                    <th>Pagos Realizados</th>
                                    <th>Accion</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payment_sale as $pay )
                                    <tr>
                                        <td>{{$pay->id}}</td>
                                        <td>{{$pay->date}}</td>
                                        <td>{{$pay->amount}}</td>
                                        <td>
                                            <div class="btn-group">

                                            <a href="{{ route('salepyment.show', $pay) }}" class="btn btn-primary ">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('salepyment.edit', $pay) }}" class="btn btn-warning ">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('salepyment.destroy', $pay->id) }}" method="post"
                                                style="display: inline">
                                                @method('delete')
                                                @csrf
                                                <button type="submit" class="btn btn-danger "> <i
                                                        class="bi bi-trash3"></i></button>
                                            </form>
                                        </div>
                                        </td>
                                    </tr>

                                @endforeach
                            </tbody>
                        </table>

                        {{-- Total general --}}

                    </div>
                </div>
            </div>
        @endsection
