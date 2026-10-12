@extends('layouts.app')

@section('title', 'Reporte de Productos Comprados')

@section('content')

    <div class="container-fluid py-5 mt-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">
                    <i class="bi bi-box-seam me-2"></i>
                    Reporte de Productos Comprados
                </h4>

                <p class="text-muted mb-0">
                    Consulta de productos adquiridos durante un periodo.
                </p>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('reports.purchases.products.pdf', request()->query()) }}" target="_blank"
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
                    Filtros
                </h6>
            </div>

            <div class="card-body">

                <form method="GET" action="{{ route('reports.purchases.products') }}">

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

                            <a href="{{ route('reports.purchases.products') }}" class="btn btn-outline-secondary">
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
                                    Productos
                                </small>

                                <h4 class="mb-0 mt-1">
                                    {{ number_format($quantity, 0, ',', '.') }}
                                </h4>
                            </div>

                            <div class="text-primary fs-3">
                                <i class="bi bi-box-seam"></i>
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
                                    Unidades compradas
                                </small>

                                <h4 class="mb-0 mt-1">
                                    {{ number_format($units, 0, ',', '.') }}
                                </h4>
                            </div>

                            <div class="text-success fs-3">
                                <i class="bi bi-cart-plus"></i>
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
                                    Inversión
                                </small>

                                <h4 class="mb-0 mt-1">
                                    ${{ number_format($totalCost, 0, ',', '.') }}
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
                                    Costo promedio
                                </small>

                                <h4 class="mb-0 mt-1">
                                    ${{ number_format($averageCost, 0, ',', '.') }}
                                </h4>
                            </div>

                            <div class="text-warning fs-3">
                                <i class="bi bi-calculator"></i>
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
                        Productos comprados
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
                                <th class="text-center">#</th>
                                <th>Código</th>
                                <th>Producto</th>
                                <th class="text-center">Unidades</th>
                                <th class="text-end">Costo Promedio</th>
                                <th class="text-end">Total comprado</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($products as $product)
                                <tr>

                                    <td class="text-center">
                                        {{ $products->firstItem() + $loop->index }}
                                    </td>

                                    <td>
                                        <span class="badge bg-secondary">
                                            {{ $product->product->code }}
                                        </span>
                                    </td>

                                    <td>
                                        <strong>
                                            {{ $product->product->name }}
                                        </strong>
                                    </td>

                                    <td class="text-center">
                                        {{ number_format($product->units, 0, ',', '.') }}
                                    </td>

                                    <td class="text-end">
                                        ${{ number_format($product->unit_cost, 0, ',', '.') }}
                                    </td>

                                    <td class="text-end fw-semibold">
                                        ${{ number_format($product->total_cost, 0, ',', '.') }}
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="6" class="text-center py-5">

                                        <div class="text-muted">

                                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>

                                            <h6>
                                                No hay productos comprados
                                            </h6>

                                            <p class="mb-0">
                                                No existen productos para el periodo seleccionado.
                                            </p>

                                        </div>

                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                        @if ($products->count() > 0)
                            <tfoot class="table-light">

                                <tr>

                                    <th colspan="3" class="text-end">
                                        TOTALES
                                    </th>

                                    <th class="text-center">
                                        {{ number_format($units, 0, ',', '.') }}
                                    </th>

                                    <th></th>

                                    <th class="text-end">
                                        ${{ number_format($totalCost, 0, ',', '.') }}
                                    </th>

                                </tr>

                            </tfoot>
                        @endif

                    </table>

                </div>

            </div>

            @if ($products->hasPages())
                <div class="card-footer bg-white">

                    <div class="d-flex justify-content-between align-items-center">

                        <small class="text-muted">
                            Mostrando
                            {{ $products->firstItem() }}
                            -
                            {{ $products->lastItem() }}
                            de
                            {{ $products->total() }}
                            productos
                        </small>

                        {{ $products->withQueryString()->links() }}

                    </div>

                </div>
            @endif

        </div>

    </div>

@endsection
