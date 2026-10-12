@extends('layouts.app')

@section('title', 'Reporte Financiero')

@section('content')

    <div class="container-fluid py-4 mt-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">
                    <i class="bi bi-graph-up-arrow me-2"></i>
                    Reporte Financiero
                </h4>

                <small class="text-muted">
                    Resumen financiero y movimientos de caja
                </small>
            </div>

            <a href="{{ route('reports.financial.profit.pdf', request()->query()) }}" target="_blank" class="btn btn-danger">
                <i class="bi bi-file-earmark-pdf me-1"></i>
                Generar PDF
            </a>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-body">

                <form method="GET" action="{{ route('reports.financial.profit') }}">

                    <div class="row g-3 align-items-end">

                        <div class="col-md-4">
                            <label for="fecha_desde" class="form-label">
                                Fecha desde
                            </label>

                            <input type="date" id="fecha_desde" name="fecha_desde" value="{{ $fechaDesde }}"
                                class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label for="fecha_hasta" class="form-label">
                                Fecha hasta
                            </label>

                            <input type="date" id="fecha_hasta" name="fecha_hasta" value="{{ $fechaHasta }}"
                                class="form-control">
                        </div>

                        <div class="col-md-4 d-flex gap-2">

                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-search me-1"></i>
                                Consultar
                            </button>

                            <a href="{{ route('reports.financial.profit') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-counterclockwise me-1"></i>
                                Limpiar
                            </a>

                            <a href="{{ url()->previous() }}" class="btn btn-outline-dark">
                                <i class="bi bi-arrow-left me-1"></i>
                                Volver
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
                        <small class="text-muted">
                            Ventas totales
                        </small>

                        <h4 class="mt-2 mb-0">
                            ${{ number_format($salesTotal, 0, ',', '.') }}
                        </h4>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <small class="text-muted">
                            Costo de ventas
                        </small>

                        <h4 class="mt-2 mb-0">
                            ${{ number_format($costTotal, 0, ',', '.') }}
                        </h4>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <small class="text-muted">
                            Utilidad bruta
                        </small>

                        <h4 class="mt-2 mb-0">
                            ${{ number_format($grossProfit, 0, ',', '.') }}
                        </h4>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <small class="text-muted">
                            Gastos
                        </small>

                        <h4 class="mt-2 mb-0">
                            ${{ number_format($expensesTotal, 0, ',', '.') }}
                        </h4>
                    </div>
                </div>
            </div>

        </div>

        <div class="row g-3 mb-4">

            <div class="col-md-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <small class="text-muted">
                            Total efectivo
                        </small>

                        <h4 class="mt-2 mb-0">
                            ${{ number_format($totalCash, 0, ',', '.') }}
                        </h4>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <small class="text-muted">
                            Total consignaciones
                        </small>

                        <h4 class="mt-2 mb-0">
                            ${{ number_format($totalConsignment, 0, ',', '.') }}
                        </h4>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <small class="text-muted">
                            Devoluciones en ventas
                        </small>

                        <h4 class="mt-2 mb-0">
                            ${{ number_format($totalReturnsSale, 0, ',', '.') }}
                        </h4>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <small class="text-muted">
                            Total entregado
                        </small>

                        <h4 class="mt-2 mb-0">
                            ${{ number_format($totalDelivered, 0, ',', '.') }}
                        </h4>
                    </div>
                </div>
            </div>

        </div>

        <div class="card shadow-sm mb-4">

            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="bi bi-cash-stack me-2"></i>
                    Resumen de caja
                </h5>
            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-bordered align-middle mb-0">

                        <thead class="table-light">
                            <tr>
                                <th>Concepto</th>
                                <th class="text-end">Valor</th>
                            </tr>
                        </thead>

                        <tbody>

                            <tr>
                                <td>Total efectivo</td>
                                <td class="text-end">
                                    ${{ number_format($totalCash, 0, ',', '.') }}
                                </td>
                            </tr>

                            <tr>
                                <td>Total consignaciones</td>
                                <td class="text-end">
                                    ${{ number_format($totalConsignment, 0, ',', '.') }}
                                </td>
                            </tr>

                            <tr>
                                <td>Devoluciones en ventas</td>
                                <td class="text-end">
                                    ${{ number_format($totalReturnsSale, 0, ',', '.') }}
                                </td>
                            </tr>

                            <tr>
                                <td>Total entregado</td>
                                <td class="text-end">
                                    ${{ number_format($totalDelivered, 0, ',', '.') }}
                                </td>
                            </tr>

                            <tr>
                                <td>Sobrantes</td>
                                <td class="text-end text-success">
                                    ${{ number_format($surplus, 0, ',', '.') }}
                                </td>
                            </tr>

                            <tr>
                                <td>Faltantes</td>
                                <td class="text-end text-danger">
                                    ${{ number_format($shortage, 0, ',', '.') }}
                                </td>
                            </tr>

                            <tr class="fw-bold">
                                <td>Diferencia neta de caja</td>
                                <td class="text-end">
                                    ${{ number_format($netCashDifference, 0, ',', '.') }}
                                </td>
                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        <div class="card shadow-sm">

            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="bi bi-bar-chart-line me-2"></i>
                    Resultado financiero
                </h5>
            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-bordered align-middle">

                        <thead class="table-light">
                            <tr>
                                <th>Concepto</th>
                                <th class="text-end">Valor</th>
                            </tr>
                        </thead>

                        <tbody>

                            <tr>
                                <td>Ventas totales</td>
                                <td class="text-end">
                                    ${{ number_format($salesTotal, 0, ',', '.') }}
                                </td>
                            </tr>

                            <tr>
                                <td>Costo de ventas</td>
                                <td class="text-end">
                                    ${{ number_format($costTotal, 0, ',', '.') }}
                                </td>
                            </tr>

                            <tr>
                                <td>Utilidad bruta</td>
                                <td class="text-end">
                                    ${{ number_format($grossProfit, 0, ',', '.') }}
                                </td>
                            </tr>

                            <tr>
                                <td>Gastos</td>
                                <td class="text-end">
                                    ${{ number_format($expensesTotal, 0, ',', '.') }}
                                </td>
                            </tr>

                            <tr>
                                <td>Utilidad neta</td>
                                <td class="text-end fw-bold">
                                    ${{ number_format($netProfit, 0, ',', '.') }}
                                </td>
                            </tr>

                            <tr>
                                <td>Diferencia neta de caja</td>
                                <td class="text-end">
                                    ${{ number_format($netCashDifference, 0, ',', '.') }}
                                </td>
                            </tr>

                            <tr class="table-primary fw-bold">
                                <td>Utilidad ajustada</td>
                                <td class="text-end">
                                    ${{ number_format($adjustedProfit, 0, ',', '.') }}
                                </td>
                            </tr>

                            <tr>
                                <td>Margen de utilidad</td>
                                <td class="text-end fw-bold">
                                    {{ number_format($profitMargin, 2, ',', '.') }}%
                                </td>
                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

@endsection
