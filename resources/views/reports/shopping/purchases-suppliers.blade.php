@extends('layouts.app')

@section('title', 'Reporte de Compras por Proveedor')

@section('content')

    <div class="container-fluid py-4 mt-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h4 class="mb-1">
                    <i class="bi bi-truck me-2"></i>
                    Reporte de Compras por Proveedor
                </h4>

                <p class="text-muted mb-0">
                    Resumen de compras realizadas por proveedor.
                </p>
            </div>

            <div class="d-flex gap-2">

                <a href="{{ route('reports.purchases.suppliers.pdf', request()->query()) }}" target="_blank"
                    class="btn btn-danger">
                    <i class="bi bi-file-earmark-pdf me-1"></i>
                    PDF
                </a>

                <a href="{{ route('reports.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Volver
                </a>

            </div>

        </div>

        <div class="card shadow-sm mb-4">

            <div class="card-header bg-white">

                <h6 class="mb-0">
                    <i class="bi bi-funnel me-2"></i>
                    Filtros de consulta
                </h6>

            </div>

            <div class="card-body">

                <form method="GET" action="{{ route('reports.purchases.suppliers') }}">

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

                            <a href="{{ route('reports.purchases.suppliers') }}" class="btn btn-outline-secondary">

                                <i class="bi bi-x-circle me-1"></i>
                                Limpiar

                            </a>

                        </div>

                    </div>

                </form>

            </div>

        </div>

        <div class="row g-3 mb-4">

            <div class="col-md-3">

                <div class="card shadow-sm border-0 h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <small class="text-muted">
                                    Proveedores
                                </small>

                                <h4 class="mb-0 mt-1">
                                    {{ number_format($quantity, 0, ',', '.') }}
                                </h4>

                            </div>

                            <div class="text-primary fs-3">
                                <i class="bi bi-people"></i>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-md-3">

                <div class="card shadow-sm border-0 h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <small class="text-muted">
                                    Compras realizadas
                                </small>

                                <h4 class="mb-0 mt-1">
                                    {{ number_format($purchasesQuantity, 0, ',', '.') }}
                                </h4>

                            </div>

                            <div class="text-success fs-3">
                                <i class="bi bi-cart-check"></i>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-md-3">

                <div class="card shadow-sm border-0 h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <small class="text-muted">
                                    Total comprado
                                </small>

                                <h4 class="mb-0 mt-1">
                                    ${{ number_format($total, 0, ',', '.') }}
                                </h4>

                            </div>

                            <div class="text-danger fs-3">
                                <i class="bi bi-cash-stack"></i>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-md-3">

                <div class="card shadow-sm border-0 h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <small class="text-muted">
                                    Saldo pendiente
                                </small>

                                <h4 class="mb-0 mt-1">
                                    ${{ number_format($balance, 0, ',', '.') }}
                                </h4>

                            </div>

                            <div class="text-warning fs-3">
                                <i class="bi bi-credit-card"></i>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="card shadow-sm">

            <div class="card-header bg-white d-flex justify-content-between align-items-center">

                <div>

                    <h6 class="mb-0">
                        <i class="bi bi-list-ul me-2"></i>
                        Compras agrupadas por proveedor
                    </h6>

                </div>

                @if (request('fecha_desde') || request('fecha_hasta'))
                    <span class="badge bg-primary">
                        Periodo filtrado
                    </span>
                @endif

            </div>

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover table-bordered align-middle mb-0">

                        <thead class="table-light">

                            <tr>

                                <th class="text-center">
                                    #
                                </th>

                                <th>
                                    Proveedor
                                </th>

                                <th>
                                    Identificación
                                </th>

                                <th class="text-center">
                                    Compras
                                </th>

                                <th class="text-end">
                                    Subtotal
                                </th>

                                <th class="text-end">
                                    IVA
                                </th>

                                <th class="text-end">
                                    Total
                                </th>

                                <th class="text-end">
                                    Saldo
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($suppliers as $supplier)
                                <tr>

                                    <td class="text-center">
                                        {{ $suppliers->firstItem() + $loop->index }}
                                    </td>

                                    <td>
                                        <strong>
                                            {{ $supplier->full_name }}
                                        </strong>
                                    </td>

                                    <td>
                                        {{ $supplier->identification ?? 'N/A' }}
                                    </td>

                                    <td class="text-center">

                                        <span class="badge bg-primary">
                                            {{ number_format($supplier->quantity, 0, ',', '.') }}
                                        </span>

                                    </td>

                                    <td class="text-end">
                                        ${{ number_format($supplier->subtotal, 0, ',', '.') }}
                                    </td>

                                    <td class="text-end">
                                        ${{ number_format($supplier->iva, 0, ',', '.') }}
                                    </td>

                                    <td class="text-end fw-semibold">
                                        ${{ number_format($supplier->total, 0, ',', '.') }}
                                    </td>

                                    <td class="text-end">

                                        @if ($supplier->balance > 0)
                                            <span class="text-danger fw-semibold">
                                                ${{ number_format($supplier->balance, 0, ',', '.') }}
                                            </span>
                                        @else
                                            <span class="text-success">
                                                $0
                                            </span>
                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="8" class="text-center py-5">

                                        <div class="text-muted">

                                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>

                                            <h6>
                                                No hay compras por proveedor
                                            </h6>

                                            <p class="mb-0">
                                                No existen compras para el periodo seleccionado.
                                            </p>

                                        </div>

                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                        @if ($suppliers->count() > 0)
                            <tfoot class="table-light">

                                <tr>

                                    <th colspan="3" class="text-end">
                                        TOTALES
                                    </th>

                                    <th class="text-center">
                                        {{ number_format($purchasesQuantity, 0, ',', '.') }}
                                    </th>

                                    <th class="text-end">
                                        ${{ number_format($subtotal, 0, ',', '.') }}
                                    </th>

                                    <th class="text-end">
                                        ${{ number_format($iva, 0, ',', '.') }}
                                    </th>

                                    <th class="text-end">
                                        ${{ number_format($total, 0, ',', '.') }}
                                    </th>

                                    <th class="text-end">
                                        ${{ number_format($balance, 0, ',', '.') }}
                                    </th>

                                </tr>

                            </tfoot>
                        @endif

                    </table>

                </div>

            </div>

            @if ($suppliers->hasPages())
                <div class="card-footer bg-white">

                    <div class="d-flex justify-content-between align-items-center">

                        <small class="text-muted">

                            Mostrando
                            {{ $suppliers->firstItem() }}
                            -
                            {{ $suppliers->lastItem() }}
                            de
                            {{ $suppliers->total() }}
                            proveedores

                        </small>

                        {{ $suppliers->withQueryString()->links() }}

                    </div>

                </div>
            @endif

        </div>

    </div>

@endsection
