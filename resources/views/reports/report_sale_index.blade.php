@extends('layouts.master')
@section('title')
    {{ $title }}
@endsection
@section('subtitle')
    Reportes de Inventario
@endsection
@section('content')
    <div class="row">

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('dashboard') }}">
                        <button type="button" class="btn btn-primary">Volver</button>
                    </a>

                </div>
                <div class="card-body">
                    <div class="card" style="width: 50rem;">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Detalles Venta :: {{ date('Y-m-d') }}</li>
                            <li class="list-group-item">
                                <h3>Venta Total: {{ number_format($totalVentas, 0, ',', '.') }} </h3>
                            </li>
                            <li class="list-group-item">
                                <h3>Gastos Total: {{ number_format($totalUtilidad, 0, ',', '.') }} </h3>
                            </li>
                            <li class="list-group-item">
                                <h3>Devoluciones Total: {{ number_format($totalDevoluciones, 0, ',', '.') }} </h3>
                            </li>
                            <li class="list-group-item">
                                <h3>Utilidad Total: {{ number_format($totalGastos, 0, ',', '.') }} </h3>
                            </li>


                            <li class="list-group-item">
                                <br>
                                <div class="row">
                                    <h3>Reportes </h3>
                                    <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                        <!-- Botón -->
                                        <div class="btn-group me-2" role="group" aria-label="First group">
                                            <button class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#salesPeriodModal">
                                                Ventas x perriodo
                                            </button>
                                        </div>
                                        <div class="btn-group me-2" role="group" aria-label="First group">
                                            <a href="{{ route('reports.profit_loss_daily') }}" target="_blank"
                                                rel="noopener noreferrer">
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#modalsale">
                                                    Venta Totales
                                                </button>
                                            </a>
                                        </div>

                                        <div class="btn-group me-2" role="group" aria-label="First group">
                                            <button class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#monthlySalesModal">
                                                Ventas por mes
                                            </button>
                                        </div>
                                    </div>

                                </div>
                                <br>
                                <div class="row">
                                    <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                        <div class="btn-group me-2" role="group" aria-label="First group">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#profitModal">
                                                Ganacias
                                            </button>
                                        </div>
                                        <div class="btn-group me-2" role="group" aria-label="First group">
                                            <button class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#profit_loss">
                                                Ganancias detallado
                                            </button>
                                        </div>
                                        <div class="btn-group me-2" role="group" aria-label="First group">
                                            <button class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#profit_loss_daily">
                                                Ganacias diarias
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <br>
                            </li>
                        </ul>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="salesPeriodModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('report.sales.period.pdf') }}" target="_blank">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Seleccionar Rango de Fechas</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Fecha Inicio</label>
                            <input type="date" name="start_date" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Fecha Final</label>
                            <input type="date" name="end_date" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Generar PDF</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="modalsale" tabindex="-1" aria-labelledby="modalFechasLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- 🔹 Agregar target="_blank" para abrir en otra pestaña -->
                <form action="{{ route('reporte.ganancias_perdidas') }}" method="GET" target="_blank">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalFechasLabel">Seleccionar Rango de Fechas</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
                            <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control"
                                value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="fecha_fin" class="form-label">Fecha Fin</label>
                            <input type="date" id="fecha_fin" name="fecha_fin" class="form-control"
                                value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Ver Vista Previa</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalFechasDia" tabindex="-1" aria-labelledby="modalFechasLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- 🔹 Agregar target="_blank" para abrir en otra pestaña -->
                <form action="{{ route('reporte.ganancias_perdidas') }}" method="GET" target="_blank">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalFechasLabel">Seleccionar Rango de Fechas</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
                            <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control"
                                value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="fecha_fin" class="form-label">Fecha Fin</label>
                            <input type="date" id="fecha_fin" name="fecha_fin" class="form-control"
                                value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Ver Vista Previa</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="profitModal" tabindex="-1" aria-labelledby="profitModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('report.profit.pdf') }}" target="_blank">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Seleccionar Rango de Fechas</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Fecha Inicio</label>
                            <input type="date" name="start_date" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Fecha Final</label>
                            <input type="date" name="end_date" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Generar PDF</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="monthlySalesModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('report.sales.month.pdf') }}" target="_blank">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Seleccionar Rango de Meses</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Mes de Inicio</label>
                            <input type="month" name="start_month" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Mes de Fin</label>
                            <input type="month" name="end_month" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Generar PDF</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- profitLoss -->
    <div class="modal fade" id="profit_loss" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form method="GET" action="{{ route('reports.profit_loss') }}" target="_blank">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Seleccionar Rango de fecha</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Fecha Inicio</label>
                            <input type="date" name="start_date" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Fecha final</label>
                            <input type="date" name="end_date" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Generar PDF</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- profit_loss_daily -->
    <div class="modal fade" id="profit_loss_daily" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form method="GET" action="{{ route('reports.profit_loss_daily') }}" target="_blank">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Seleccionar Rango de fecha</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Fecha Inicio</label>
                            <input type="date" name="start_date" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Fecha final</label>
                            <input type="date" name="end_date" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Generar PDF</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
