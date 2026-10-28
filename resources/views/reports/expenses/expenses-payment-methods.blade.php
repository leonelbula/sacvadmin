@extends('layouts.app')

@section('title', 'Gastos por Método de Pago')

@section('content')
    <div class="container-fluid py-4 mt-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">
                    <i class="bi bi-credit-card me-2"></i>
                    Gastos por Método de Pago
                </h4>

                <small class="text-muted">
                    Resumen de gastos agrupados por método de pago
                </small>
            </div>

            <div class="d-flex gap-2">

                <a href="{{ route('reports.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Volver
                </a>

                <a href="{{ route('reports.expenses.payment-method.pdf', request()->query()) }}" target="_blank"
                    class="btn btn-danger">
                    <i class="bi bi-file-earmark-pdf me-1"></i>
                    PDF
                </a>

            </div>
        </div>

        <div class="card shadow-sm mb-4">

            <div class="card-header bg-white">
                <h6 class="mb-0">
                    <i class="bi bi-funnel me-2"></i>
                    Filtros
                </h6>
            </div>

            <div class="card-body">

                <form method="GET" action="{{ route('reports.expenses.payment-methods') }}">

                    <div class="row g-3 align-items-end">

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
                                <i class="bi bi-search me-1"></i>
                                Consultar
                            </button>

                            <a href="{{ route('reports.expenses.payment-methods') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle me-1"></i>
                                Limpiar
                            </a>

                        </div>

                    </div>

                </form>

            </div>
        </div>

        <div class="row g-3 mb-4">

            <div class="col-md-4">

                <div class="card shadow-sm border-0 h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <small class="text-muted">
                                    Métodos de pago
                                </small>

                                <h4 class="mb-0 mt-1">
                                    {{ number_format($paymentMethods->total(), 0, ',', '.') }}
                                </h4>

                            </div>

                            <div class="text-primary fs-2">
                                <i class="bi bi-credit-card"></i>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="card shadow-sm border-0 h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <small class="text-muted">
                                    Gastos registrados
                                </small>

                                <h4 class="mb-0 mt-1">
                                    {{ number_format($quantity ?? 0, 0, ',', '.') }}
                                </h4>

                            </div>

                            <div class="text-info fs-2">
                                <i class="bi bi-receipt"></i>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="card shadow-sm border-0 h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <small class="text-muted">
                                    Total de gastos
                                </small>

                                <h4 class="mb-0 mt-1">
                                    ${{ number_format($total ?? 0, 0, ',', '.') }}
                                </h4>

                            </div>

                            <div class="text-danger fs-2">
                                <i class="bi bi-cash-stack"></i>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="card shadow-sm">

            <div class="card-header bg-white d-flex justify-content-between align-items-center">

                <h6 class="mb-0">
                    <i class="bi bi-bar-chart me-2"></i>
                    Resumen por método de pago
                </h6>

                <span class="badge bg-primary">
                    {{ number_format($quantity ?? 0, 0, ',', '.') }} gastos
                </span>

            </div>

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover table-striped align-middle mb-0">

                        <thead class="table-dark">

                            <tr>

                                <th>#</th>

                                <th>Método de pago</th>

                                <th class="text-center">
                                    Cantidad
                                </th>

                                <th class="text-end">
                                    Total
                                </th>

                                <th class="text-end">
                                    % del total
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($paymentMethods as $paymentMethod)
                                @php
                                    $percentage = ($total ?? 0) > 0 ? (($paymentMethod->total ?? 0) / $total) * 100 : 0;
                                @endphp

                                <tr>

                                    <td>
                                        {{ $paymentMethods->firstItem() + $loop->index }}
                                    </td>

                                    <td>

                                        <span class="fw-semibold">
                                            {{ $paymentMethod->name ?? 'Sin método de pago' }}
                                        </span>

                                    </td>

                                    <td class="text-center">

                                        <span class="badge bg-secondary">
                                            {{ number_format($paymentMethod->quantity ?? 0, 0, ',', '.') }}
                                        </span>

                                    </td>

                                    <td class="text-end fw-semibold">
                                        ${{ number_format($paymentMethod->total ?? 0, 0, ',', '.') }}
                                    </td>

                                    <td class="text-end">

                                        <div class="d-flex align-items-center justify-content-end gap-2">

                                            <div class="progress" style="width: 80px; height: 8px;">

                                                <div class="progress-bar" role="progressbar"
                                                    style="width: {{ min($percentage, 100) }}%">
                                                </div>

                                            </div>

                                            <span>
                                                {{ number_format($percentage, 2, ',', '.') }}%
                                            </span>

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="5" class="text-center py-5">

                                        <div class="text-muted">

                                            <i class="bi bi-inbox fs-1 d-block mb-3"></i>

                                            <h6>
                                                No se encontraron gastos
                                            </h6>

                                            <p class="mb-0">
                                                No existen gastos para el periodo seleccionado.
                                            </p>

                                        </div>

                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                        @if ($paymentMethods->count())
                            <tfoot class="table-light">

                                <tr>

                                    <th colspan="2" class="text-end">
                                        Total general
                                    </th>

                                    <th class="text-center">
                                        {{ number_format($quantity ?? 0, 0, ',', '.') }}
                                    </th>

                                    <th class="text-end">
                                        ${{ number_format($total ?? 0, 0, ',', '.') }}
                                    </th>

                                    <th class="text-end">
                                        100%
                                    </th>

                                </tr>

                            </tfoot>
                        @endif

                    </table>

                </div>

            </div>

            @if ($paymentMethods->hasPages())
                <div class="card-footer bg-white">

                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

                        <small class="text-muted">

                            Mostrando
                            <strong>{{ $paymentMethods->firstItem() }}</strong>
                            -
                            <strong>{{ $paymentMethods->lastItem() }}</strong>
                            de
                            <strong>{{ $paymentMethods->total() }}</strong>
                            métodos

                        </small>

                        <div>
                            {{ $paymentMethods->withQueryString()->links() }}
                        </div>

                    </div>

                </div>
            @endif

        </div>

    </div>
@endsection
