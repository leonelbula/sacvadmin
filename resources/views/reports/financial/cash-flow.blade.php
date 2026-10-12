@extends('layouts.app')

@section('title', 'Reporte de Flujo de Caja')

@section('content')

    <div class="container-fluid py-4 mt-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">
                    <i class="bi bi-cash-stack"></i>
                    Reporte de Flujo de Caja
                </h4>
                <p class="text-muted mb-0">
                    Resumen de ingresos y egresos del período seleccionado
                </p>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i>
                    Volver
                </a>

                <a href="{{ route('reports.financial.cash-flow.pdf', request()->query()) }}" target="_blank" class="btn btn-danger">
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
                <form action="{{ route('reports.financial.cash-flow') }}" method="GET">

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

                            <a href="{{ route('reports.financial.cash-flow') }}" class="btn btn-outline-secondary">
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

            <div class="col-md-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <small class="text-muted">
                            Ingresos
                        </small>

                        <h4 class="text-success mt-2 mb-0">
                            $ {{ number_format($income, 0, ',', '.') }}
                        </h4>

                        <small class="text-muted">
                            Ventas
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <small class="text-muted">
                            Egresos
                        </small>

                        <h4 class="text-danger mt-2 mb-0">
                            $ {{ number_format($outcome, 0, ',', '.') }}
                        </h4>

                        <small class="text-muted">
                            Compras + gastos + devoluciones
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <small class="text-muted">
                            Flujo neto
                        </small>

                        <h4 class="{{ $netCashFlow >= 0 ? 'text-success' : 'text-danger' }} mt-2 mb-0">
                            $ {{ number_format($netCashFlow, 0, ',', '.') }}
                        </h4>

                        <small class="text-muted">
                            Ingresos - Egresos
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <small class="text-muted">
                            Dinero entregado
                        </small>

                        <h4 class="text-primary mt-2 mb-0">
                            $ {{ number_format($totalDelivered, 0, ',', '.') }}
                        </h4>

                        <small class="text-muted">
                            Según cierres de caja
                        </small>
                    </div>
                </div>
            </div>

        </div>

        <div class="card shadow-sm mb-4">

            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-arrow-left-right"></i>
                    Movimiento de caja
                </h5>
            </div>

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-dark">
                            <tr>
                                <th>Concepto</th>
                                <th class="text-end">Tipo</th>
                                <th class="text-end">Valor</th>
                            </tr>
                        </thead>

                        <tbody>

                            <tr>
                                <td>
                                    <i class="bi bi-cart-check text-success"></i>
                                    Ventas
                                </td>

                                <td class="text-end">
                                    <span class="badge bg-success">
                                        Ingreso
                                    </span>
                                </td>

                                <td class="text-end fw-bold text-success">
                                    $ {{ number_format($salesTotal, 0, ',', '.') }}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <i class="bi bi-box-seam text-danger"></i>
                                    Compras
                                </td>

                                <td class="text-end">
                                    <span class="badge bg-danger">
                                        Egreso
                                    </span>
                                </td>

                                <td class="text-end fw-bold text-danger">
                                    $ {{ number_format($purchases, 0, ',', '.') }}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <i class="bi bi-receipt text-danger"></i>
                                    Gastos
                                </td>

                                <td class="text-end">
                                    <span class="badge bg-danger">
                                        Egreso
                                    </span>
                                </td>

                                <td class="text-end fw-bold text-danger">
                                    $ {{ number_format($expenses, 0, ',', '.') }}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <i class="bi bi-arrow-return-left text-danger"></i>
                                    Devoluciones de ventas
                                </td>

                                <td class="text-end">
                                    <span class="badge bg-danger">
                                        Egreso
                                    </span>
                                </td>

                                <td class="text-end fw-bold text-danger">
                                    $ {{ number_format($totalReturnsSale, 0, ',', '.') }}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <i class="bi bi-box-arrow-up-right text-primary"></i>
                                    Dinero entregado
                                </td>

                                <td class="text-end">
                                    <span class="badge bg-primary">
                                        Movimiento
                                    </span>
                                </td>

                                <td class="text-end fw-bold text-primary">
                                    $ {{ number_format($totalDelivered, 0, ',', '.') }}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <i class="bi bi-plus-circle text-success"></i>
                                    Sobrantes de caja
                                </td>

                                <td class="text-end">
                                    <span class="badge bg-success">
                                        Ajuste
                                    </span>
                                </td>

                                <td class="text-end fw-bold text-success">
                                    $ {{ number_format($surplus, 0, ',', '.') }}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <i class="bi bi-dash-circle text-danger"></i>
                                    Faltantes de caja
                                </td>

                                <td class="text-end">
                                    <span class="badge bg-danger">
                                        Ajuste
                                    </span>
                                </td>

                                <td class="text-end fw-bold text-danger">
                                    $ {{ number_format($shortage, 0, ',', '.') }}
                                </td>
                            </tr>

                        </tbody>

                        <tfoot class="table-light">

                            <tr>
                                <th colspan="2">
                                    Flujo neto de caja
                                </th>

                                <th
                                    class="text-end fs-5
                                {{ $netCashFlow >= 0 ? 'text-success' : 'text-danger' }}">

                                    $ {{ number_format($netCashFlow, 0, ',', '.') }}

                                </th>
                            </tr>

                        </tfoot>

                    </table>

                </div>

            </div>

        </div>

        <div class="row g-4">

            <div class="col-md-6">

                <div class="card shadow-sm h-100">

                    <div class="card-header">
                        <h5 class="mb-0 text-success">
                            <i class="bi bi-arrow-down-circle"></i>
                            Ingresos
                        </h5>
                    </div>

                    <div class="card-body">

                        <div class="d-flex justify-content-between border-bottom py-2">
                            <span>Ventas</span>

                            <strong class="text-success">
                                $ {{ number_format($salesTotal, 0, ',', '.') }}
                            </strong>
                        </div>

                        <div class="d-flex justify-content-between py-2">
                            <span>Total ingresos</span>

                            <strong class="text-success fs-5">
                                $ {{ number_format($income, 0, ',', '.') }}
                            </strong>
                        </div>

                    </div>

                </div>

            </div>

            <div class="col-md-6">

                <div class="card shadow-sm h-100">

                    <div class="card-header">
                        <h5 class="mb-0 text-danger">
                            <i class="bi bi-arrow-up-circle"></i>
                            Egresos
                        </h5>
                    </div>

                    <div class="card-body">

                        <div class="d-flex justify-content-between border-bottom py-2">
                            <span>Compras</span>

                            <strong class="text-danger">
                                $ {{ number_format($purchases, 0, ',', '.') }}
                            </strong>
                        </div>

                        <div class="d-flex justify-content-between border-bottom py-2">
                            <span>Gastos</span>

                            <strong class="text-danger">
                                $ {{ number_format($expenses, 0, ',', '.') }}
                            </strong>
                        </div>

                        <div class="d-flex justify-content-between border-bottom py-2">
                            <span>Devoluciones</span>

                            <strong class="text-danger">
                                $ {{ number_format($totalReturnsSale, 0, ',', '.') }}
                            </strong>
                        </div>

                        <div class="d-flex justify-content-between py-2">
                            <span>Total egresos</span>

                            <strong class="text-danger fs-5">
                                $ {{ number_format($outcome, 0, ',', '.') }}
                            </strong>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="card shadow-sm mt-4">

            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-wallet2"></i>
                    Información de cierres de caja
                </h5>
            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-3">
                        <strong>Efectivo</strong>

                        <div class="fs-5 text-success">
                            $ {{ number_format($totalCash, 0, ',', '.') }}
                        </div>
                    </div>

                    <div class="col-md-3">
                        <strong>Consignaciones</strong>

                        <div class="fs-5 text-primary">
                            $ {{ number_format($totalConsignment, 0, ',', '.') }}
                        </div>
                    </div>

                    <div class="col-md-3">
                        <strong>Sobrantes</strong>

                        <div class="fs-5 text-success">
                            $ {{ number_format($surplus, 0, ',', '.') }}
                        </div>
                    </div>

                    <div class="col-md-3">
                        <strong>Faltantes</strong>

                        <div class="fs-5 text-danger">
                            $ {{ number_format($shortage, 0, ',', '.') }}
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
