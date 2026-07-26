@extends('layouts.app')
@section('subtitle')
    Kaedex
@endsection
@section('content')
    <div class="container-fluid  py-4 mt-4">

        <!-- Header -->

        <div class="card shadow border-0 rounded-4 mb-4">

            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">

                <div>

                    <h3 class="mb-0">

                        <i class="bi bi-clock-history"></i>

                        Kardex del Producto

                    </h3>

                    <small>Historial completo de movimientos de inventario</small>

                </div>

                <div>

                    <button class="btn btn-light">

                        <i class="bi bi-printer"></i>

                        Imprimir

                    </button>

                    <button class="btn btn-success">

                        <i class="bi bi-file-earmark-pdf"></i>

                        PDF

                    </button>

                    <button class="btn btn-secondary">

                        <i class="bi bi-arrow-left"></i>

                        Volver

                    </button>

                </div>

            </div>

        </div>

        <!-- Información del producto -->

        <div class="row mb-4">

            <div class="col-lg-3">

                <div class="card border-primary shadow-sm">

                    <div class="card-body">

                        <small class="text-muted">Producto</small>

                        <h5>Coca Cola 350ml</h5>

                        <span class="badge bg-success">Activo</span>

                    </div>

                </div>

            </div>

            <div class="col-lg-2">

                <div class="card shadow-sm">

                    <div class="card-body text-center">

                        <i class="bi bi-upc fs-2 text-primary"></i>

                        <h6 class="mt-2">Código</h6>

                        <strong>PRD-001</strong>

                    </div>

                </div>

            </div>

            <div class="col-lg-2">

                <div class="card shadow-sm">

                    <div class="card-body text-center">

                        <i class="bi bi-tags fs-2 text-info"></i>

                        <h6 class="mt-2">Categoría</h6>

                        <strong>Bebidas</strong>

                    </div>

                </div>

            </div>

            <div class="col-lg-2">

                <div class="card shadow-sm border-success">

                    <div class="card-body text-center">

                        <i class="bi bi-box-seam fs-2 text-success"></i>

                        <h6 class="mt-2">Stock</h6>

                        <h3>143</h3>

                    </div>

                </div>

            </div>

            <div class="col-lg-3">

                <div class="card shadow-sm border-warning">

                    <div class="card-body text-center">

                        <i class="bi bi-exclamation-triangle fs-2 text-warning"></i>

                        <h6 class="mt-2">Stock Mínimo</h6>

                        <h3>20</h3>

                    </div>

                </div>

            </div>

        </div>

        <!-- Filtros -->

        <div class="card shadow-sm border-0 mb-4">

            <div class="card-body">

                <form class="row g-3 align-items-end">

                    <div class="col-lg-3">

                        <label class="form-label">Buscar</label>

                        <input type="text" class="form-control" placeholder="Referencia...">

                    </div>

                    <div class="col-lg-2">

                        <label class="form-label">Desde</label>

                        <input type="date" class="form-control">

                    </div>

                    <div class="col-lg-2">

                        <label class="form-label">Hasta</label>

                        <input type="date" class="form-control">

                    </div>

                    <div class="col-lg-2">

                        <label class="form-label">Movimiento</label>

                        <select class="form-select">

                            <option>Todos</option>

                            <option>Entrada</option>

                            <option>Salida</option>

                            <option>Ajuste</option>

                        </select>

                    </div>

                    <div class="col-lg-3">

                        <button class="btn btn-primary">

                            <i class="bi bi-search"></i>

                            Buscar

                        </button>

                        <button class="btn btn-outline-secondary">

                            <i class="bi bi-arrow-clockwise"></i>

                            Limpiar

                        </button>

                    </div>

                </form>

            </div>

        </div>

        <!-- Tabla -->

        <div class="card shadow border-0">

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-dark">

                            <tr>

                                <th>Fecha</th>

                                <th>Movimiento</th>

                                <th>Origen</th>

                                <th>Referencia</th>

                                <th class="text-success">Entrada</th>

                                <th class="text-danger">Salida</th>

                                <th>Stock</th>

                                <th>Costo</th>

                                <th>Usuario</th>

                                <th width="80">Acción</th>

                            </tr>

                        </thead>

                        <tbody>

                            <tr>

                                <td>26/07/2026 09:30</td>

                                <td>

                                    <span class="badge bg-success">

                                        Compra

                                    </span>

                                </td>

                                <td>Compras</td>

                                <td>CP-00012</td>

                                <td class="text-success fw-bold">50</td>

                                <td>-</td>

                                <td>150</td>

                                <td>$2.500</td>

                                <td>Administrador</td>

                                <td>

                                    <button class="btn btn-sm btn-primary">

                                        <i class="bi bi-eye"></i>

                                    </button>

                                </td>

                            </tr>

                            <tr>

                                <td>26/07/2026 11:15</td>

                                <td>

                                    <span class="badge bg-danger">

                                        Venta

                                    </span>

                                </td>

                                <td>Ventas</td>

                                <td>FV-00152</td>

                                <td>-</td>

                                <td class="text-danger fw-bold">10</td>

                                <td>140</td>

                                <td>$2.500</td>

                                <td>Administrador</td>

                                <td>

                                    <button class="btn btn-sm btn-primary">

                                        <i class="bi bi-eye"></i>

                                    </button>

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

            <div class="card-footer bg-white d-flex justify-content-between align-items-center">

                <small class="text-muted">

                    Mostrando 1 a 10 de 150 movimientos

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
@endsection
