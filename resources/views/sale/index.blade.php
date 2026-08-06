@extends('layouts.app')
@section('title')
    {{ $title }}
@endsection
@section('subtitle')
    Lista Venta
@endsection
@section('content')
    <div class="container-fluid py-4 mt-4">

        <div class="card shadow border-0 rounded-4">

            <!-- Header -->

            <div class="card-header bg-primary text-white">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <h3 class="mb-0">

                            <i class="bi bi-receipt-cutoff me-2"></i>

                            Gestión de Ventas

                        </h3>

                        <small>Administración de facturas de venta</small>

                    </div>

                    <a href="{{route('sale.create')}}" class="btn btn-light">

                        <i class="bi bi-plus-circle"></i>

                        Nueva Venta

                    </a>

                </div>

            </div>

            <div class="card-body">

                <!-- Encabezado -->

                <div class="d-flex justify-content-between align-items-center mb-4">

                    <h5 class="mb-0">

                        <i class="bi bi-search me-2"></i>

                        Buscar Venta

                    </h5>

                    <a href="#" class="btn btn-outline-secondary">

                        <i class="bi bi-arrow-clockwise"></i>

                        Mostrar Todas

                    </a>

                </div>

                <!-- Formulario -->

                <form class="row g-3 mb-4">

                    <div class="col-lg-3">

                        <label class="form-label">
                            Cliente
                        </label>

                        <input type="text" class="form-control" placeholder="Nombre del cliente">

                    </div>

                    <div class="col-lg-2">

                        <label class="form-label">
                            Factura
                        </label>

                        <input type="text" class="form-control" placeholder="FV-0001">

                    </div>

                    <div class="col-lg-2">

                        <label class="form-label">
                            Estado
                        </label>

                        <select class="form-select">

                            <option>Todos</option>
                            <option>Pagada</option>
                            <option>Pendiente</option>
                            <option>Anulada</option>

                        </select>

                    </div>

                    <div class="col-lg-2">

                        <label class="form-label">
                            Desde
                        </label>

                        <input type="date" class="form-control">

                    </div>

                    <div class="col-lg-2">

                        <label class="form-label">
                            Hasta
                        </label>

                        <input type="date" class="form-control">

                    </div>

                    <div class="col-lg-1 d-grid">

                        <label class="form-label">&nbsp;</label>

                        <button class="btn btn-primary">

                            <i class="bi bi-search"></i>

                        </button>

                    </div>

                </form>

                <!-- Tabla -->

                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead class="table-light">

                            <tr>

                                <th>Factura</th>

                                <th>Fecha</th>

                                <th>Cliente</th>

                                <th class="text-end">Total</th>

                                <th>Pago</th>

                                <th>Estado</th>

                                <th>Usuario</th>

                                <th class="text-center">Acciones</th>

                            </tr>

                        </thead>

                        <tbody>

                            <tr>

                                <td><strong>FV-000125</strong></td>

                                <td>29/07/2026</td>

                                <td>Juan Pérez</td>

                                <td class="text-end">$520.000</td>

                                <td>Efectivo</td>

                                <td>

                                    <span class="btn btn-sm bg-success text-white">

                                        Pagada

                                    </span>

                                </td>

                                <td>Administrador</td>

                                <td class="text-center">

                                    <div class="btn-group">

                                        <button class="btn btn-sm btn-outline-primary">

                                            <i class="bi bi-eye"></i>

                                        </button>

                                        <button class="btn btn-sm btn-outline-success">

                                            <i class="bi bi-printer"></i>

                                        </button>

                                        <button class="btn btn-sm btn-outline-warning">

                                            <i class="bi bi-pencil"></i>

                                        </button>

                                        <button class="btn btn-sm btn-outline-danger">

                                            <i class="bi bi-x-circle"></i>

                                        </button>

                                    </div>

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

            <div class="card-footer bg-white">

                <div class="d-flex justify-content-between align-items-center">

                    <small class="text-muted">

                        Mostrando 1 a 20 de 2.350 ventas

                    </small>

                    <nav>

                        <ul class="pagination pagination-sm mb-0">

                            <li class="page-item disabled">
                                <a class="page-link">Anterior</a>
                            </li>

                            <li class="page-item active">
                                <a class="page-link">1</a>
                            </li>

                            <li class="page-item">
                                <a class="page-link">2</a>
                            </li>

                            <li class="page-item">
                                <a class="page-link">3</a>
                            </li>

                            <li class="page-item">
                                <a class="page-link">Siguiente</a>
                            </li>

                        </ul>

                    </nav>

                </div>

            </div>

        </div>

    </div>
@endsection
