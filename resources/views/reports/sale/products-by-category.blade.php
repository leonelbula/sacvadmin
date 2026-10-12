@extends('layouts.app')

@section('title', 'Ventas por Categoría')

@section('content')

    <div class="container-fluid py-4 mt-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h1 class="h3 mb-1">
                    <i class="bi bi-tags me-2"></i>
                    Ventas por Categoría
                </h1>

                <p class="text-muted mb-0">
                    Valor total de productos vendidos por categoría
                </p>
            </div>

            <div class="d-flex gap-2">

                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Volver
                </a>

                <a href="{{ route('reports.sales.products-by-category.pdf', request()->query()) }}" target="_blank"
                    class="btn btn-danger">
                    <i class="bi bi-file-earmark-pdf me-1"></i>
                    PDF
                </a>

            </div>

        </div>

        <div class="card shadow-sm mb-4">

            <div class="card-header">

                <h5 class="mb-0">
                    <i class="bi bi-funnel me-2"></i>
                    Filtrar por fecha
                </h5>

            </div>

            <div class="card-body">

                <form method="GET" action="{{ route('reports.sales.products-by-category') }}">

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

                            <a href="{{ route('reports.sales.products-by-category') }}" class="btn btn-outline-secondary">
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

                                <h6 class="text-muted mb-2">
                                    Categorías
                                </h6>

                                <h3 class="mb-0">
                                    {{ number_format($categories->count()) }}
                                </h3>

                            </div>

                            <div class="fs-1 text-primary">
                                <i class="bi bi-tags"></i>
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

                                <h6 class="text-muted mb-2">
                                    Unidades vendidas
                                </h6>

                                <h3 class="mb-0">
                                    {{ number_format($quantity) }}
                                </h3>

                            </div>

                            <div class="fs-1 text-success">
                                <i class="bi bi-box-seam"></i>
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

                                <h6 class="text-muted mb-2">
                                    Total vendido
                                </h6>

                                <h3 class="mb-0">
                                    $ {{ number_format($total, 0, ',', '.') }}
                                </h3>

                            </div>

                            <div class="fs-1 text-warning">
                                <i class="bi bi-cash-stack"></i>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="card shadow-sm">

            <div class="card-header d-flex justify-content-between align-items-center">

                <h5 class="mb-0">
                    <i class="bi bi-bar-chart me-2"></i>
                    Ventas por categoría
                </h5>

                @if ($fechaDesde || $fechaHasta)
                    <span class="badge bg-info">

                        {{ $fechaDesde ?? 'Inicio' }}

                        -

                        {{ $fechaHasta ?? 'Actualidad' }}

                    </span>
                @endif

            </div>

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover table-striped align-middle mb-0">

                        <thead class="table-dark">

                            <tr>

                                <th class="text-center">
                                    #
                                </th>

                                <th>
                                    Categoría
                                </th>

                                <th class="text-center">
                                    Unidades vendidas
                                </th>

                                <th class="text-end">
                                    Total vendido
                                </th>

                                <th class="text-end">
                                    Participación
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($categories as $index => $category)
                                <tr>

                                    <td class="text-center">

                                        <span class="badge bg-secondary">
                                            {{ $index + 1 }}
                                        </span>

                                    </td>

                                    <td>

                                        <strong>
                                            {{ $category->name }}
                                        </strong>

                                    </td>

                                    <td class="text-center">

                                        <span class="badge bg-primary">
                                            {{ number_format($category->quantity) }}
                                        </span>

                                    </td>

                                    <td class="text-end">

                                        <strong>
                                            $
                                            {{ number_format($category->total, 0, ',', '.') }}
                                        </strong>

                                    </td>

                                    <td class="text-end">

                                        <span class="badge bg-success">

                                            {{ number_format($category->percentage, 2, ',', '.') }}%

                                        </span>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="5" class="text-center py-5">

                                        <i class="bi bi-tags fs-1 text-muted"></i>

                                        <p class="text-muted mt-3 mb-0">
                                            No hay ventas por categoría
                                            para el período seleccionado.
                                        </p>

                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                        @if ($categories->count() > 0)
                            <tfoot class="table-light">

                                <tr>

                                    <th colspan="2">
                                        TOTAL
                                    </th>

                                    <th class="text-center">
                                        {{ number_format($quantity) }}
                                    </th>

                                    <th class="text-end">
                                        $
                                        {{ number_format($total, 0, ',', '.') }}
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

        </div>

    </div>

@endsection
