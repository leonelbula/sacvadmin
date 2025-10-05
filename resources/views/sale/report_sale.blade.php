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
                                                data-bs-target="#reporte">
                                                Ventas Cajero
                                            </button>
                                        </div>
                                        <div class="btn-group me-2" role="group" aria-label="First group">
                                            <button class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#salesPeriodModal">
                                                Ventas diaria
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

    <!-- reporte -->
    <div class="modal fade" id="reporte" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form method="GET" action="{{ route('sale.reporte') }}" target="_blank">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Seleccionar Rango de fecha</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Fecha Inicio</label>
                            <input type="date" name="start_month" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Fecha final</label>
                            <input type="date" name="end_month" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <select name="payment_form" class="form-control" onchange="toggleOpcionPay(this.value)"
                                required>
                                <option value="">Opciones de Pago</option>
                                <option value="counted">Contado</option>
                                <option value="credit">Crédito</option>
                            </select>
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
    <!-- reporte -->
    <div class="modal fade" id="reporte.dia" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form method="GET" action="{{ route('sale.reporte.dia') }}" target="_blank">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Seleccionar Rango de fecha</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Fecha Inicio</label>
                            <input type="date" name="start_month" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Fecha final</label>
                            <input type="date" name="end_month" class="form-control" required>
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
