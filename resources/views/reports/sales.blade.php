@extends('layouts.app')

@section('title', 'Reporte de Ventas')

@section('content')

    <div class="container-fluid py-4 mt-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h3 class="fw-bold mb-1">
                    <i class="bi bi-cart-check me-2"></i>
                    Reporte de Ventas
                </h3>

                <p class="text-muted mb-0">
                    Consulta detallada de las ventas realizadas.
                </p>
            </div>

            <a href="{{ route('reports.sales.pdf')}}" target="_blank" class="btn btn-danger rounded-3">

                <i class="bi bi-file-earmark-pdf me-2"></i>
                PDF

            </a>

        </div>

        <div class="card border-0 shadow-sm rounded-4 mb-4">

            <div class="card-body">

                <form method="GET" action="{{ route('reports.sales') }}">

                    <div class="row g-3 align-items-end">

                        <div class="col-md-4">

                            <label class="form-label fw-semibold">
                                Fecha desde
                            </label>

                            <input type="date" name="fecha_desde" class="form-control" value="{{ $fechaDesde ?? '' }}">

                        </div>


                        <div class="col-md-4">

                            <label class="form-label fw-semibold">
                                Fecha hasta
                            </label>

                            <input type="date" name="fecha_hasta" class="form-control" value="{{ $fechaHasta ?? '' }}">

                        </div>


                        <div class="col-md-4">

                            <div class="d-flex gap-2">

                                <button type="submit" class="btn btn-success">

                                    <i class="bi bi-search me-1"></i>

                                    Consultar

                                </button>


                                <a href="{{ route('reports.sales') }}" class="btn btn-outline-secondary">

                                    <i class="bi bi-x-circle me-1"></i>

                                    Limpiar

                                </a>

                            </div>

                        </div>

                    </div>

                </form>

            </div>

        </div>



        <div class="row g-3 mb-4">

            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body">
                        <small class="text-muted">Total ventas</small>
                        <h4 class="fw-bold mt-2">
                            $ {{ number_format($total ?? 0, 0, ',', '.') }}
                        </h4>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body">
                        <small class="text-muted">Cantidad de ventas</small>
                        <h4 class="fw-bold mt-2">
                            {{ $quantity ?? 0 }}
                        </h4>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body">
                        <small class="text-muted">Promedio</small>
                        <h4 class="fw-bold mt-2">
                            $
                            {{ number_format($quantity > 0 ? $total / $quantity : 0, 0, ',', '.') }}
                        </h4>
                    </div>
                </div>
            </div>

        </div>


        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead class="table-light">

                            <tr>
                                <th>#</th>
                                <th>Fecha</th>
                                <th>Factura</th>
                                <th>Cliente</th>
                                <th>Usuario</th>
                                <th class="text-end">Total</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($sales as $sale)
                                <tr>

                                    <td>{{ $loop->iteration }}</td>

                                    <td>
                                        {{ $sale->date_sale}}
                                    </td>

                                    <td>
                                        {{ $sale->invoice_number ?? ($sale->number ?? $sale->id) }}
                                    </td>

                                    <td>
                                        {{ $sale->customer->full_name ?? 'Consumidor final' }}
                                    </td>

                                    <td>
                                        {{ $sale->user->name ?? '-' }}
                                    </td>

                                    <td class="text-end fw-semibold">

                                        $
                                        {{ number_format($sale->total ?? 0, 0, ',', '.') }}

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">

                                        No hay ventas registradas.

                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                        <tfoot>

                            <tr class="fw-bold">

                                <td colspan="5" class="text-end">

                                    TOTAL

                                </td>

                                <td class="text-end">

                                    $
                                    {{ number_format($total ?? 0, 0, ',', '.') }}

                                </td>

                            </tr>

                        </tfoot>

                    </table>

                </div>

            </div>

        </div>

    </div>

@endsection
