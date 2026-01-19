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
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <h3>Cliente: {{ $customer->full_name }} </h3>
                        </li>
                        <li class="list-group-item">
                            <h4>Saldo Pendiente: {{ number_format($balance, 0, ',', '.') }}</h4>
                        </li>
                        <li class="list-group-item">
                            <h4>Saldo Vencidos: {{ number_format($totalVencido, 0, ',', '.') }} </h4>
                        </li>
                    </ul>
                    <hr>
                    <div class="container mt-4">
                        <h4 class="mb-3">📋 Reporte de Cuentas por Cobrar</h4>

                        <table class="table table-bordered table-striped">
                            <thead class="table-dark text-center">
                                <tr>
                                    <th>#</th>
                                    <th>Cliente</th>
                                    <th>N° Factura</th>
                                    <th>Fecha</th>
                                    <th>Vencimiento</th>
                                    <th>Plazo</th>
                                    <th>Estado</th>
                                    <th>Total</th>
                                    <th>Pagos Realizados</th>
                                    <th>Saldo Pendiente</th>
                                    <th>Accion</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ventasConSaldo as $venta)
                                    <tr class="{{ $venta->saldo_pendiente > 0 ? 'table-warning' : 'table-success' }}">
                                        <td>{{ $venta->id }}</td>
                                        <td>{{ $venta->customer->full_name }}</td>
                                        <td>{{ $venta->sale_number }}</td>
                                        <td>{{ \Carbon\Carbon::parse($venta->date)->format('d/m/Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($venta->expiration_date)->format('d/m/Y') }}</td>
                                        <td>{{ $venta->term }}</td>
                                        <td>
                                            @if ($venta->vencida)
                                                <span class="badge bg-danger">Vencida ({{ $venta->dias_atraso }}
                                                    días)</span>
                                            @else
                                                <span class="badge bg-success">Al día</span>
                                            @endif
                                        </td>
                                        <td class="text-end">{{ number_format($venta->total, 0, ',', '.') }}</td>
                                        <td class="text-end">{{  number_format($venta->payments->sum('amount'), 0, ',', '.') }}
                                        </td>
                                        <td class="text-end fw-bold text-danger">
                                            {{ number_format($venta->balance, 0, ',', '.') }}
                                        </td>
                                        <td>
                                            <a href="{{ route('sale.show', $venta) }}"
                                                class="btn btn-info" target="_blank">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                             <a href="{{ route('accountsattuscustomer.list_show', $venta) }}">
                                                <button class="btn btn-primary " idsale="">
                                                    <i class="bi bi-file-earmark-check"></i>
                                                </button>
                                            </a>
                                            <a href="{{ route('accountsale.abonar', $venta) }}" class="btn btn-warning">
                                                <i class="bi bi-pencil"></i>Abonar
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">No hay ventas con saldo pendiente.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{-- Total general --}}
                        @if ($ventasConSaldo->count() > 0)
                            <div class="text-end mt-3">
                                <strong>Total Saldo Pendiente: </strong>
                                <span class="fs-5 text-danger fw-bold">
                                    {{ number_format($ventasConSaldo->sum('balance'), 0, ',', '.') }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endsection
