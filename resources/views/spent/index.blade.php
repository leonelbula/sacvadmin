@extends('layouts.app')

@section('title', 'Gastos')

@section('content')

<div class="container-fluid py-4">

    {{-- ============================================================
         ENCABEZADO
    ============================================================ --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-wallet2 me-2 text-primary"></i>
                Gastos
            </h2>

            <p class="text-muted mb-0">
                Administra y controla los gastos de tu empresa.
            </p>
        </div>

        <div class="mt-3 mt-md-0">

            <a href="{{route('spent.create')}}"
               class="btn btn-primary rounded-3 px-4">

                <i class="bi bi-plus-lg me-2"></i>
                Nuevo gasto

            </a>

        </div>

    </div>


    {{-- ============================================================
         TARJETAS RESUMEN
    ============================================================ --}}
    <div class="row g-4 mb-4">

        {{-- Total gastos --}}
        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <p class="text-muted mb-2">
                                Total gastos
                            </p>

                            <h3 class="fw-bold mb-0">
                                $ 0
                            </h3>

                            <small class="text-muted">
                                Periodo seleccionado
                            </small>

                        </div>

                        <div class="bg-danger bg-opacity-10
                                    text-danger rounded-3 p-3">

                            <i class="bi bi-wallet2 fs-4"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Gastos del mes --}}
        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <p class="text-muted mb-2">
                                Gastos del mes
                            </p>

                            <h3 class="fw-bold mb-0">
                                $ 0
                            </h3>

                            <small class="text-muted">
                                Mes actual
                            </small>

                        </div>

                        <div class="bg-warning bg-opacity-10
                                    text-warning rounded-3 p-3">

                            <i class="bi bi-calendar-month fs-4"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Cantidad --}}
        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <p class="text-muted mb-2">
                                Cantidad de gastos
                            </p>

                            <h3 class="fw-bold mb-0">
                                0
                            </h3>

                            <small class="text-muted">
                                Registros
                            </small>

                        </div>

                        <div class="bg-primary bg-opacity-10
                                    text-primary rounded-3 p-3">

                            <i class="bi bi-receipt fs-4"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Promedio --}}
        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <p class="text-muted mb-2">
                                Promedio por gasto
                            </p>

                            <h3 class="fw-bold mb-0">
                                $ 0
                            </h3>

                            <small class="text-muted">
                                Valor promedio
                            </small>

                        </div>

                        <div class="bg-success bg-opacity-10
                                    text-success rounded-3 p-3">

                            <i class="bi bi-graph-up-arrow fs-4"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ============================================================
         FILTROS
    ============================================================ --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-body p-4">

            <div class="row g-3 align-items-end">

                {{-- Buscar --}}
                <div class="col-lg-4">

                    <label class="form-label fw-semibold">
                        Buscar
                    </label>

                    <div class="input-group">

                        <span class="input-group-text bg-white">
                            <i class="bi bi-search text-muted"></i>
                        </span>

                        <input type="text"
                               class="form-control"
                               placeholder="Buscar gasto...">

                    </div>

                </div>


                {{-- Categoría --}}
                <div class="col-lg-2">

                    <label class="form-label fw-semibold">
                        Categoría
                    </label>

                    <select class="form-select">

                        <option value="">
                            Todas
                        </option>

                        <option>
                            Servicios
                        </option>

                        <option>
                            Arriendo
                        </option>

                        <option>
                            Transporte
                        </option>

                        <option>
                            Papelería
                        </option>

                        <option>
                            Otros
                        </option>

                    </select>

                </div>


                {{-- Fecha inicial --}}
                <div class="col-lg-2">

                    <label class="form-label fw-semibold">
                        Desde
                    </label>

                    <input type="date"
                           class="form-control">

                </div>


                {{-- Fecha final --}}
                <div class="col-lg-2">

                    <label class="form-label fw-semibold">
                        Hasta
                    </label>

                    <input type="date"
                           class="form-control">

                </div>


                {{-- Botón buscar --}}
                <div class="col-lg-2">

                    <button type="button"
                            class="btn btn-primary w-100">

                        <i class="bi bi-search me-2"></i>
                        Filtrar

                    </button>

                </div>

            </div>

        </div>

    </div>


    {{-- ============================================================
         TABLA DE GASTOS
    ============================================================ --}}
    <div class="card border-0 shadow-sm rounded-4">

        {{-- Header --}}
        <div class="card-header bg-white border-0 p-4">

            <div class="d-flex flex-wrap
                        justify-content-between
                        align-items-center">

                <div>

                    <h5 class="fw-bold mb-1">
                        Lista de gastos
                    </h5>

                    <p class="text-muted mb-0 small">
                        Historial de gastos registrados
                    </p>

                </div>


                <div class="dropdown">

                    <button class="btn btn-light border
                                   rounded-3 dropdown-toggle"
                            type="button"
                            data-bs-toggle="dropdown">

                        <i class="bi bi-download me-2"></i>
                        Exportar

                    </button>

                    <ul class="dropdown-menu dropdown-menu-end">

                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="bi bi-file-earmark-excel me-2"></i>
                                Excel
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="bi bi-file-earmark-pdf me-2"></i>
                                PDF
                            </a>
                        </li>

                    </ul>

                </div>

            </div>

        </div>


        {{-- Tabla --}}
        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th class="ps-4">
                            #
                        </th>

                        <th>
                            Fecha
                        </th>

                        <th>
                            Descripción
                        </th>

                        <th>
                            Categoría
                        </th>

                        <th>
                            Método de pago
                        </th>

                        <th>
                            Usuario
                        </th>

                        <th class="text-end">
                            Valor
                        </th>

                        <th class="text-center pe-4">
                            Acciones
                        </th>

                    </tr>

                </thead>


                <tbody>

                    {{-- Ejemplo --}}
                    <tr>

                        <td class="ps-4">
                            1
                        </td>

                        <td>
                            <div class="fw-semibold">
                                27/08/2026
                            </div>

                            <small class="text-muted">
                                08:30 PM
                            </small>
                        </td>

                        <td>

                            <div class="fw-semibold">
                                Pago servicio de energía
                            </div>

                            <small class="text-muted">
                                Factura del mes
                            </small>

                        </td>

                        <td>

                            <span class="badge bg-primary bg-opacity-10
                                         text-primary rounded-pill px-3">

                                Servicios

                            </span>

                        </td>

                        <td>

                            <span class="text-muted">
                                Efectivo
                            </span>

                        </td>

                        <td>
                            Administrador
                        </td>

                        <td class="text-end">

                            <span class="fw-bold text-danger">
                                $ 250.000
                            </span>

                        </td>

                        <td class="text-center pe-4">

                            <div class="dropdown">

                                <button class="btn btn-sm btn-light
                                               border rounded-3"
                                        type="button"
                                        data-bs-toggle="dropdown">

                                    <i class="bi bi-three-dots-vertical"></i>

                                </button>

                                <ul class="dropdown-menu dropdown-menu-end">

                                    <li>

                                        <a class="dropdown-item"
                                           href="#">

                                            <i class="bi bi-eye me-2"></i>
                                            Ver detalle

                                        </a>

                                    </li>

                                    <li>

                                        <a class="dropdown-item"
                                           href="#">

                                            <i class="bi bi-pencil me-2"></i>
                                            Editar

                                        </a>

                                    </li>

                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>

                                    <li>

                                        <button class="dropdown-item text-danger">

                                            <i class="bi bi-trash me-2"></i>
                                            Eliminar

                                        </button>

                                    </li>

                                </ul>

                            </div>

                        </td>

                    </tr>


                    {{-- Estado vacío --}}
                    <tr>

                        <td colspan="8" class="text-center py-5">

                            <div class="mb-3">

                                <i class="bi bi-wallet2 text-muted"
                                   style="font-size: 3rem;">
                                </i>

                            </div>

                            <h6 class="fw-bold">
                                No hay gastos registrados
                            </h6>

                            <p class="text-muted mb-3">
                                Cuando registres un gasto aparecerá aquí.
                            </p>

                            <a href="{{ route('spent.create') }}"
                               class="btn btn-primary rounded-3">

                                <i class="bi bi-plus-lg me-2"></i>
                                Registrar gasto

                            </a>

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>


        {{-- Footer --}}
        <div class="card-footer bg-white border-0 p-4">

            <div class="d-flex flex-wrap
                        justify-content-between
                        align-items-center">

                <span class="text-muted small">
                    Mostrando 0 de 0 gastos
                </span>

                {{-- Pagination --}}
                <nav>

                    <ul class="pagination pagination-sm mb-0">

                        <li class="page-item disabled">
                            <a class="page-link" href="#">
                                Anterior
                            </a>
                        </li>

                        <li class="page-item active">
                            <a class="page-link" href="#">
                                1
                            </a>
                        </li>

                        <li class="page-item disabled">
                            <a class="page-link" href="#">
                                Siguiente
                            </a>
                        </li>

                    </ul>

                </nav>

            </div>

        </div>

    </div>

</div>

@endsection
```
