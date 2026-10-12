@extends('layouts.app')

@section('title', 'Reporte de Gastos')

@section('content')
    <div class="container-fluid py-4 mt-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">
                    <i class="bi bi-cash-stack me-2"></i>
                    Reporte de Gastos
                </h4>
                <small class="text-muted">
                    Consulta de gastos registrados por rango de fechas
                </small>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Volver
                </a>

                <a href="{{ route('reports.expenses.pdf', request()->query()) }}" target="_blank" class="btn btn-danger">
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
                <form method="GET" action="{{ route('reports.expenses') }}">
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

                            <a href="{{ route('reports.expenses') }}" class="btn btn-outline-secondary">
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
                                    Gastos registrados
                                </small>

                                <h4 class="mb-0 mt-1">
                                    {{ number_format($quantity ?? 0, 0, ',', '.') }}
                                </h4>
                            </div>

                            <div class="text-primary fs-2">
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
                                <i class="bi bi-cash-coin"></i>
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
                                    Periodo consultado
                                </small>

                                <div class="fw-semibold mt-2">
                                    @if (request('fecha_desde') || request('fecha_hasta'))
                                        {{ request('fecha_desde') ?? 'Inicio' }}
                                        <span class="text-muted mx-1">→</span>
                                        {{ request('fecha_hasta') ?? 'Actual' }}
                                    @else
                                        Todas las fechas
                                    @endif
                                </div>
                            </div>

                            <div class="text-success fs-2">
                                <i class="bi bi-calendar3"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="card shadow-sm">

            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0">
                    <i class="bi bi-list-ul me-2"></i>
                    Detalle de gastos
                </h6>

                <span class="badge bg-primary">
                    {{ number_format($quantity ?? 0, 0, ',', '.') }} registros
                </span>
            </div>

            <div class="card-body p-0">

                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle mb-0">

                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Fecha</th>
                                <th>Descripción</th>
                                <th>Entregado a</th>
                                <th>Tipo</th>
                                <th>Método de pago</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($expenses as $expense)
                                <tr>

                                    <td>
                                        {{ $expenses->firstItem() + $loop->index }}
                                    </td>

                                    <td>
                                        {{ \Carbon\Carbon::parse($expense->date)->format('d/m/Y') }}
                                    </td>

                                    <td>
                                        <div class="fw-semibold">
                                            {{ $expense->description }}
                                        </div>

                                        @if ($expense->observation)
                                            <small class="text-muted">
                                                {{ $expense->observation }}
                                            </small>
                                        @endif
                                    </td>

                                    <td>
                                        {{ $expense->delivered_to ?? 'N/A' }}
                                    </td>

                                    <td>
                                        @if ($expense->typeExpense)
                                            <span class="badge bg-secondary">
                                                {{ $expense->typeExpense->description }}
                                            </span>
                                        @else
                                            <span class="text-muted">
                                                N/A
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($expense->paymentMethod)
                                            <span class="badge bg-info text-dark">
                                                {{ $expense->paymentMethod->name }}
                                            </span>
                                        @else
                                            <span class="text-muted">
                                                N/A
                                            </span>
                                        @endif
                                    </td>

                                    <td class="text-end fw-semibold">
                                        ${{ number_format($expense->total ?? 0, 0, ',', '.') }}
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="bi bi-inbox fs-1 d-block mb-3"></i>

                                            <h6>No se encontraron gastos</h6>

                                            <p class="mb-0">
                                                No existen gastos para el periodo seleccionado.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                        @if ($expenses->count())
                            <tfoot class="table-light">

                                <tr>

                                    <th colspan="6" class="text-end">
                                        Total:
                                    </th>

                                    <th class="text-end">
                                        ${{ number_format($total ?? 0, 0, ',', '.') }}
                                    </th>

                                </tr>

                            </tfoot>
                        @endif

                    </table>
                </div>

            </div>

            @if ($expenses->hasPages())
                <div class="card-footer bg-white">

                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

                        <small class="text-muted">
                            Mostrando
                            <strong>{{ $expenses->firstItem() }}</strong>
                            -
                            <strong>{{ $expenses->lastItem() }}</strong>
                            de
                            <strong>{{ $expenses->total() }}</strong>
                            registros
                        </small>

                        <div>
                            {{ $expenses->withQueryString()->links() }}
                        </div>

                    </div>

                </div>
            @endif

        </div>

    </div>
@endsection
