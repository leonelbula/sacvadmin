@extends('layouts.app')

@section('title', 'Reporte Financiero - Métodos de Pago')

@section('content')

    <div class="container-fluid py-4 mt-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h4 class="mb-1">
                    <i class="bi bi-credit-card"></i>
                    Reporte Financiero por Métodos de Pago
                </h4>

                <p class="text-muted mb-0">
                    Resumen de ventas agrupadas por método de pago
                </p>
            </div>

            <div class="d-flex gap-2">

                <a href="{{ route('reports.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i>
                    Volver
                </a>

                <a href="{{ route('reports.financial.payment-methods.pdf', request()->query()) }}" target="_blank"
                    class="btn btn-danger">
                    <i class="bi bi-file-earmark-pdf"></i>
                    Generar PDF
                </a>

            </div>

        </div>

        <div class="card shadow-sm mb-4">

            <div class="card-header">

                <h5 class="mb-0">
                    <i class="bi bi-calendar-range"></i>
                    Filtrar período
                </h5>

            </div>

            <div class="card-body">

                <form action="{{ route('reports.financial.payment-methods') }}" method="GET">

                    <div class="row align-items-end">

                        <div class="col-md-4">

                            <label for="fecha_desde" class="form-label">
                                Fecha desde
                            </label>

                            <input type="date" name="fecha_desde" id="fecha_desde" class="form-control"
                                value="{{ request('fecha_desde') }}">

                        </div>

                        <div class="col-md-4">

                            <label for="fecha_hasta" class="form-label">
                                Fecha hasta
                            </label>

                            <input type="date" name="fecha_hasta" id="fecha_hasta" class="form-control"
                                value="{{ request('fecha_hasta') }}">

                        </div>

                        <div class="col-md-4 d-flex gap-2">

                            <button type="submit" class="btn btn-primary">

                                <i class="bi bi-search"></i>
                                Consultar

                            </button>

                            <a href="{{ route('reports.financial.payment-methods') }}" class="btn btn-outline-secondary">

                                <i class="bi bi-x-circle"></i>
                                Limpiar

                            </a>

                        </div>

                    </div>

                </form>

            </div>

        </div>

        @if ($fechaDesde || $fechaHasta)
            <div class="alert alert-info">

                <i class="bi bi-info-circle"></i>

                Período consultado:

                <strong>
                    {{ $fechaDesde ?? 'Inicio' }}
                </strong>

                hasta

                <strong>
                    {{ $fechaHasta ?? 'Actualidad' }}
                </strong>

            </div>
        @endif

        <div class="row g-3 mb-4">

            <div class="col-md-4">

                <div class="card shadow-sm border-0 h-100">

                    <div class="card-body">

                        <small class="text-muted">
                            Total recaudado
                        </small>

                        <h4 class="text-success mt-2 mb-0">

                            $
                            {{ number_format($total, 0, ',', '.') }}

                        </h4>

                        <small class="text-muted">
                            Según métodos de pago
                        </small>

                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="card shadow-sm border-0 h-100">

                    <div class="card-body">

                        <small class="text-muted">
                            Métodos de pago
                        </small>

                        <h4 class="text-primary mt-2 mb-0">
                            {{ $quantity }}
                        </h4>

                        <small class="text-muted">
                            Métodos registrados
                        </small>

                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="card shadow-sm border-0 h-100">

                    <div class="card-body">

                        <small class="text-muted">
                            Período
                        </small>

                        <h6 class="mt-2 mb-0">

                            {{ $fechaDesde ?? 'Inicio' }}

                            <span class="text-muted">
                                -
                            </span>

                            {{ $fechaHasta ?? 'Actualidad' }}

                        </h6>

                        <small class="text-muted">
                            Fecha de consulta
                        </small>

                    </div>

                </div>

            </div>

        </div>

        <div class="card shadow-sm">

            <div class="card-header">

                <h5 class="mb-0">
                    <i class="bi bi-wallet2"></i>
                    Distribución por método de pago
                </h5>

            </div>

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-dark">

                            <tr>

                                <th>
                                    Método de pago
                                </th>

                                <th class="text-center">
                                    Cantidad
                                </th>

                                <th class="text-end">
                                    Total
                                </th>

                                <th class="text-end">
                                    Participación
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($paymentMethods as $paymentMethod)
                                @php
                                    $methodTotal = $paymentMethod->total ?? 0;

                                    $percentage = $total > 0 ? ($methodTotal / $total) * 100 : 0;
                                @endphp

                                <tr>

                                    <td>

                                        <i class="bi bi-credit-card text-primary me-2"></i>

                                        <strong>
                                            {{ $paymentMethod->name }}
                                        </strong>

                                    </td>

                                    <td class="text-center">

                                        <span class="badge bg-secondary">
                                            {{ $paymentMethod->quantity }}
                                        </span>

                                    </td>

                                    <td class="text-end">

                                        <strong class="text-success">

                                            $
                                            {{ number_format($methodTotal, 0, ',', '.') }}

                                        </strong>

                                    </td>

                                    <td class="text-end">

                                        <strong>
                                            {{ number_format($percentage, 2, ',', '.') }}%
                                        </strong>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="4" class="text-center py-5">

                                        <i class="bi bi-inbox fs-1 text-muted"></i>

                                        <p class="text-muted mt-2 mb-0">
                                            No hay información de métodos de pago
                                            para el período seleccionado.
                                        </p>

                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                        <tfoot class="table-light">

                            <tr>

                                <th>
                                    Total
                                </th>

                                <th class="text-center">
                                    {{ $quantity }}
                                </th>

                                <th class="text-end text-success">

                                    $
                                    {{ number_format($total, 0, ',', '.') }}

                                </th>

                                <th class="text-end">
                                    100%
                                </th>

                            </tr>

                        </tfoot>

                    </table>

                </div>

            </div>

        </div>

    </div>

@endsection
