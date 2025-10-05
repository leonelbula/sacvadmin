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
                                <h3>Inventario Total: {{ number_format($totalInventario, 0, ',', '.') }} </h3>
                            </li>


                            <li class="list-group-item">

                                <div class="row">
                                    <h3>Reportes Productos</h3>
                                    <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                        <!-- Botón -->
                                        <div class="btn-group me-2" role="group" aria-label="First group">
                                            <a href="{{route('reporte.productos')}}" target="_blank" rel="noopener noreferrer">
                                            <button type="button" class="btn btn-primary">
                                                Producto Vendidos
                                            </button>
                                        </a>
                                        </div>
                                        <div class="btn-group me-2" role="group" aria-label="First group">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#modalFechas">
                                                Generar Reporte por Fechas
                                            </button>
                                        </div>
                                        <div class="btn-group me-2" role="group" aria-label="First group">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#modalFechasDia">
                                                Mas Vendidos
                                            </button>
                                        </div>
                                        <div class="btn-group me-2" role="group" aria-label="First group">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#modalProductoMenos">
                                                Menos Vendidos x dia
                                            </button>
                                        </div>
                                        <div class="btn-group me-2" role="group" aria-label="First group">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#modalProductoCode">
                                                Vendidos x Producto
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
    <div class="modal fade" id="modalFechas" tabindex="-1" aria-labelledby="modalFechasLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- 🔹 Agregar target="_blank" para abrir en otra pestaña -->
                <form action="{{ route('reporte.productos.fechas') }}" method="GET" target="_blank">
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
                        <div class="md-3">
                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                data-bs-target="#modalProducto">
                                Venta x Producto
                            </button>
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
                <form action="{{ route('reporte.productos.fechas') }}" method="GET" target="_blank">
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


    <div class="modal fade" id="modalProducto" tabindex="-1" aria-labelledby="modalProductoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- abrir en nueva pestaña -->
                <form action="{{ route('reporte.productos.menos') }}" method="GET" target="_blank">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalProductoLabel">Reporte de Producto por Código</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="codigo" class="form-label">Código del Producto</label>
                            <input type="text" id="codigo" name="codigo" class="form-control" required>
                        </div>
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
                        <button type="submit" class="btn btn-success">Ver Reporte</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- producto especifico -->
    <div class="modal fade" id="modalProductoCode" tabindex="-1" aria-labelledby="modalProductoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- abrir en nueva pestaña -->
                <form action="{{ route('reporte.producto-code') }}" method="GET" target="_blank">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalProductoLabel">Reporte de Producto por Código</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="codigo" class="form-label">Código del Producto</label>
                            <input type="text" id="codigo" name="codigo" class="form-control" required>
                        </div>
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
                        <button type="submit" class="btn btn-success">Ver Reporte</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
