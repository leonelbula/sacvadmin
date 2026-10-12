
@extends('layouts.app')

@section('title', 'Mejores Clientes')

@section('content')

<div class="container-fluid py-4 mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">
                <i class="bi bi-trophy me-2"></i>
                Mejores Clientes
            </h1>

            <p class="text-muted mb-0">
                Clientes con mayor volumen de compras
            </p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ url()->previous() }}"
               class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i>
                Volver
            </a>

            <a href="{{ route('reports.customers.customers-top.pdf', request()->query()) }}"
               target="_blank"
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
            <form method="GET"
                  action="{{ route('reports.customers.top') }}">

                <div class="row g-3 align-items-end">

                    <div class="col-md-4">
                        <label for="fecha_desde" class="form-label">
                            Fecha desde
                        </label>

                        <input type="date"
                               name="fecha_desde"
                               id="fecha_desde"
                               class="form-control"
                               value="{{ request('fecha_desde') }}">
                    </div>

                    <div class="col-md-4">
                        <label for="fecha_hasta" class="form-label">
                            Fecha hasta
                        </label>

                        <input type="date"
                               name="fecha_hasta"
                               id="fecha_hasta"
                               class="form-control"
                               value="{{ request('fecha_hasta') }}">
                    </div>

                    <div class="col-md-4 d-flex gap-2">

                        <button type="submit"
                                class="btn btn-primary">
                            <i class="bi bi-search me-1"></i>
                            Consultar
                        </button>

                        <a href="{{ route('reports.customers.top') }}"
                           class="btn btn-outline-secondary">
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
                                Clientes
                            </h6>

                            <h3 class="mb-0">
                                {{ number_format($quantity) }}
                            </h3>
                        </div>

                        <div class="fs-1 text-primary">
                            <i class="bi bi-people"></i>
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
                                Ventas realizadas
                            </h6>

                            <h3 class="mb-0">
                                {{ number_format($clients->sum('quantity')) }}
                            </h3>
                        </div>

                        <div class="fs-1 text-success">
                            <i class="bi bi-cart-check"></i>
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
                <i class="bi bi-trophy me-2"></i>
                Ranking de clientes
            </h5>

            @if($fechaDesde || $fechaHasta)
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
                                Posición
                            </th>

                            <th>
                                Cliente
                            </th>

                            <th>
                                Identificación
                            </th>

                            <th class="text-center">
                                Ventas
                            </th>

                            <th class="text-end">
                                Total comprado
                            </th>

                            <th class="text-end">
                                Participación
                            </th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($clients as $index => $client)

                            @php
                                $percentage = $total > 0
                                    ? ($client->total / $total) * 100
                                    : 0;
                            @endphp

                            <tr>

                                <td class="text-center">

                                    @if($index === 0)

                                        <span class="badge bg-warning text-dark fs-6">
                                            <i class="bi bi-trophy-fill"></i>
                                            1
                                        </span>

                                    @elseif($index === 1)

                                        <span class="badge bg-secondary fs-6">
                                            2
                                        </span>

                                    @elseif($index === 2)

                                        <span class="badge bg-danger fs-6">
                                            3
                                        </span>

                                    @else

                                        <span class="badge bg-light text-dark fs-6">
                                            {{ $index + 1 }}
                                        </span>

                                    @endif

                                </td>

                                <td>
                                    <strong>
                                        {{ $client->name }}
                                    </strong>
                                </td>

                                <td>
                                    {{ $client->identification }}
                                </td>

                                <td class="text-center">

                                    <span class="badge bg-primary">
                                        {{ $client->quantity }}
                                    </span>

                                </td>

                                <td class="text-end">

                                    <strong>
                                        $ {{ number_format($client->total, 0, ',', '.') }}
                                    </strong>

                                </td>

                                <td class="text-end">

                                    <span class="badge bg-success">
                                        {{ number_format($percentage, 2, ',', '.') }}%
                                    </span>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="6"
                                    class="text-center py-5">

                                    <i class="bi bi-people fs-1 text-muted"></i>

                                    <p class="text-muted mt-3 mb-0">
                                        No hay clientes con ventas en el período seleccionado.
                                    </p>

                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                    @if($clients->count() > 0)

                        <tfoot class="table-light">

                            <tr>

                                <th colspan="3">
                                    TOTAL
                                </th>

                                <th class="text-center">
                                    {{ number_format($clients->sum('quantity')) }}
                                </th>

                                <th class="text-end">
                                    $ {{ number_format($total, 0, ',', '.') }}
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

