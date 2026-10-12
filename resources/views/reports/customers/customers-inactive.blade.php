@extends('layouts.app')

@section('title', 'Clientes Inactivos')

@section('content')

    <div class="container-fluid py-4 mt-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h1 class="h3 mb-1">
                    <i class="bi bi-person-x me-2"></i>
                    Clientes Inactivos
                </h1>

                <p class="text-muted mb-0">
                    Clientes que no han realizado compras en el período seleccionado
                </p>
            </div>

            <div class="d-flex gap-2">

                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Volver
                </a>

                <a href="{{ route('reports.customers.customers-inactive.pdf', request()->query()) }}" target="_blank"
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

                <form method="GET" action="{{ route('reports.customers.inactive') }}">

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

                            <a href="{{ route('reports.customers.inactive') }}" class="btn btn-outline-secondary">
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
                                    Clientes inactivos
                                </h6>

                                <h3 class="mb-0">
                                    {{ number_format($quantity) }}
                                </h3>

                            </div>

                            <div class="fs-1 text-danger">
                                <i class="bi bi-person-x"></i>
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
                                    Compras registradas
                                </h6>

                                <h3 class="mb-0">
                                    {{ number_format($clients->sum('quantity')) }}
                                </h3>

                            </div>

                            <div class="fs-1 text-warning">
                                <i class="bi bi-cart-x"></i>
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
                                    Total histórico
                                </h6>

                                <h3 class="mb-0">
                                    $
                                    {{ number_format($total, 0, ',', '.') }}
                                </h3>

                            </div>

                            <div class="fs-1 text-secondary">
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

                    <i class="bi bi-person-x me-2"></i>

                    Listado de clientes inactivos

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

                                <th>
                                    Cliente
                                </th>

                                <th>
                                    Identificación
                                </th>

                                <th>
                                    Teléfono
                                </th>

                                <th class="text-center">
                                    Última compra
                                </th>

                                <th class="text-center">
                                    Días inactivo
                                </th>

                                <th class="text-center">
                                    Compras
                                </th>

                                <th class="text-end">
                                    Total comprado
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($clients as $client)

                                <tr>

                                    <td>

                                        <strong>
                                            {{ $client->name }}
                                        </strong>

                                    </td>

                                    <td>
                                        {{ $client->identification }}
                                    </td>

                                    <td>
                                        {{ $client->phone ?? 'Sin teléfono' }}
                                    </td>

                                    <td class="text-center">

                                        @if ($client->last_purchase)
                                            {{ \Carbon\Carbon::parse($client->last_purchase)->format('d/m/Y') }}
                                        @else
                                            <span class="badge bg-danger">
                                                Nunca ha comprado
                                            </span>
                                        @endif

                                    </td>

                                    <td class="text-center">

                                        @if ($client->days_inactive !== null)
                                            @if ($client->days_inactive >= 60)
                                                <span class="badge bg-danger">
                                                    {{ $client->days_inactive }} días
                                                </span>
                                            @elseif($client->days_inactive >= 30)
                                                <span class="badge bg-warning text-dark">
                                                    {{ $client->days_inactive }} días
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">
                                                    {{ $client->days_inactive }} días
                                                </span>
                                            @endif
                                        @else
                                            <span class="badge bg-danger">
                                                Sin compras
                                            </span>
                                        @endif

                                    </td>

                                    <td class="text-center">

                                        <span class="badge bg-primary">
                                            {{ $client->quantity }}
                                        </span>

                                    </td>

                                    <td class="text-end">

                                        <strong>
                                            $
                                            {{ number_format($client->total_purchases, 0, ',', '.') }}
                                        </strong>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="7" class="text-center py-5">

                                        <i class="bi bi-person-check fs-1 text-success"></i>

                                        <p class="text-muted mt-3 mb-0">
                                            No hay clientes inactivos para el período seleccionado.
                                        </p>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                        @if ($clients->count() > 0)
                            <tfoot class="table-light">

                                <tr>

                                    <th colspan="5">
                                        TOTAL
                                    </th>

                                    <th class="text-center">
                                        {{ number_format($clients->sum('quantity')) }}
                                    </th>

                                    <th class="text-end">
                                        $
                                        {{ number_format($clients->sum('total_purchases'), 0, ',', '.') }}
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
