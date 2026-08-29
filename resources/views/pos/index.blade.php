@extends('layouts.app')

@section('title', 'Cierres de Caja')

@section('content')

    <div class="container-fluid py-4 mt-4">

        {{-- HEADER --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">

            <div>
                <h3 class="fw-bold mb-1">
                    <i class="bi bi-safe2 me-2 text-primary"></i>
                    Cierres de Caja
                </h3>

                <p class="text-muted mb-0">
                    Consulta y administra todos los cierres de caja realizados.
                </p>
            </div>

            <div class="mt-3 mt-md-0">
                <a href="{{route('pos.create')}}" class="btn btn-primary rounded-3 px-4">
                    <i class="bi bi-plus-lg me-2"></i>
                    Nuevo cierre
                </a>
            </div>

        </div>


        {{-- RESUMEN --}}
        <div class="row g-3 mb-4">

            {{-- TOTAL CIERRES --}}
            <div class="col-xl-3 col-md-6">

                <div class="card border-0 shadow-sm rounded-4 h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>
                                <span class="text-muted small">
                                    Total cierres
                                </span>

                                <h3 class="fw-bold mb-0 mt-1">
                                    125
                                </h3>
                            </div>

                            <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-3">
                                <i class="bi bi-safe2 fs-4"></i>
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- TOTAL VENTAS --}}
            <div class="col-xl-3 col-md-6">

                <div class="card border-0 shadow-sm rounded-4 h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <span class="text-muted small">
                                    Ventas realizadas
                                </span>

                                <h3 class="fw-bold mb-0 mt-1">
                                    $48.250.000
                                </h3>

                            </div>

                            <div class="bg-success bg-opacity-10 text-success rounded-3 p-3">
                                <i class="bi bi-graph-up-arrow fs-4"></i>
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- EFECTIVO --}}
            <div class="col-xl-3 col-md-6">

                <div class="card border-0 shadow-sm rounded-4 h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <span class="text-muted small">
                                    Total efectivo
                                </span>

                                <h3 class="fw-bold mb-0 mt-1">
                                    $21.500.000
                                </h3>

                            </div>

                            <div class="bg-warning bg-opacity-10 text-warning rounded-3 p-3">
                                <i class="bi bi-cash-stack fs-4"></i>
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- DIFERENCIAS --}}
            <div class="col-xl-3 col-md-6">

                <div class="card border-0 shadow-sm rounded-4 h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <span class="text-muted small">
                                    Diferencias
                                </span>

                                <h3 class="fw-bold mb-0 mt-1 text-danger">
                                    $125.000
                                </h3>

                            </div>

                            <div class="bg-danger bg-opacity-10 text-danger rounded-3 p-3">
                                <i class="bi bi-exclamation-triangle fs-4"></i>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- FILTROS --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">

            <div class="card-body">

                <div class="row g-3 align-items-end">

                    {{-- BUSCAR --}}
                    <div class="col-lg-4">

                        <label class="form-label fw-semibold">
                            Buscar
                        </label>

                        <div class="input-group">

                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-search"></i>
                            </span>

                            <input type="text" class="form-control bg-light border-start-0"
                                placeholder="Buscar por caja, usuario...">

                        </div>

                    </div>


                    {{-- FECHA INICIAL --}}
                    <div class="col-lg-2">

                        <label class="form-label fw-semibold">
                            Desde
                        </label>

                        <input type="date" class="form-control">

                    </div>


                    {{-- FECHA FINAL --}}
                    <div class="col-lg-2">

                        <label class="form-label fw-semibold">
                            Hasta
                        </label>

                        <input type="date" class="form-control">

                    </div>


                    {{-- ESTADO --}}
                    <div class="col-lg-2">

                        <label class="form-label fw-semibold">
                            Estado
                        </label>

                        <select class="form-select">

                            <option value="">
                                Todos
                            </option>

                            <option value="closed">
                                Cerrados
                            </option>

                            <option value="difference">
                                Con diferencia
                            </option>

                        </select>

                    </div>


                    {{-- BOTONES --}}
                    <div class="col-lg-2 d-flex gap-2">

                        <button type="button" class="btn btn-primary flex-fill">
                            <i class="bi bi-search"></i>
                            Buscar
                        </button>

                        <button type="button" class="btn btn-light border" title="Limpiar filtros">
                            <i class="bi bi-arrow-clockwise"></i>
                        </button>

                    </div>

                </div>

            </div>

        </div>


        {{-- TABLA --}}
        <div class="card border-0 shadow-sm rounded-4">

            {{-- HEADER TABLA --}}
            <div class="card-header bg-white border-0 rounded-top-4 p-4">

                <div class="d-flex flex-wrap justify-content-between align-items-center">

                    <div>

                        <h5 class="fw-bold mb-1">
                            Historial de cierres
                        </h5>

                        <span class="text-muted small">
                            Registro de todas las cajas cerradas
                        </span>

                    </div>


                    <div class="dropdown">

                        <button class="btn btn-light border rounded-3 dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="bi bi-download me-1"></i>
                            Exportar
                        </button>

                        <ul class="dropdown-menu dropdown-menu-end shadow border-0">

                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="bi bi-file-earmark-excel me-2 text-success"></i>
                                    Excel
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="bi bi-file-earmark-pdf me-2 text-danger"></i>
                                    PDF
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="bi bi-printer me-2"></i>
                                    Imprimir
                                </a>
                            </li>

                        </ul>

                    </div>

                </div>

            </div>


            {{-- TABLA --}}
            <div class="table-responsive">

                <table class="table align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th class="ps-4">
                                #
                            </th>

                            <th>
                                Caja
                            </th>

                            <th>
                                Usuario
                            </th>

                            <th>
                                Apertura
                            </th>

                            <th>
                                Cierre
                            </th>

                            <th class="text-end">
                                Base
                            </th>

                            <th class="text-end">
                                Ventas
                            </th>

                            <th class="text-end">
                                Entregado
                            </th>

                            <th class="text-end">
                                Diferencia
                            </th>

                            <th class="text-center">
                                Estado
                            </th>

                            <th class="text-center pe-4">
                                Acción
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        {{-- FILA 1 --}}
                        <tr>

                            <td class="ps-4 fw-semibold">
                                #00125
                            </td>

                            <td>

                                <div class="d-flex align-items-center">

                                    <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-2 me-2">
                                        <i class="bi bi-shop"></i>
                                    </div>

                                    <div>
                                        <div class="fw-semibold">
                                            Caja Principal
                                        </div>

                                        <small class="text-muted">
                                            POS-01
                                        </small>
                                    </div>

                                </div>

                            </td>

                            <td>
                                Leonel Bula
                            </td>

                            <td>
                                <div>
                                    25/08/2026
                                </div>

                                <small class="text-muted">
                                    08:02 AM
                                </small>
                            </td>

                            <td>
                                <div>
                                    25/08/2026
                                </div>

                                <small class="text-muted">
                                    06:15 PM
                                </small>
                            </td>

                            <td class="text-end">
                                $500.000
                            </td>

                            <td class="text-end fw-semibold">
                                $3.850.000
                            </td>

                            <td class="text-end">
                                $4.350.000
                            </td>

                            <td class="text-end">

                                <span class="text-success fw-semibold">
                                    $0
                                </span>

                            </td>

                            <td class="text-center">

                                <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">
                                    <i class="bi bi-check-circle me-1"></i>
                                    Cuadrado
                                </span>

                            </td>

                            <td class="text-center pe-4">

                                <div class="dropdown">

                                    <button class="btn btn-light btn-sm border rounded-3" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>

                                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">

                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <i class="bi bi-eye me-2"></i>
                                                Ver cierre
                                            </a>
                                        </li>

                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <i class="bi bi-printer me-2"></i>
                                                Imprimir
                                            </a>
                                        </li>

                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <i class="bi bi-file-earmark-pdf me-2"></i>
                                                Descargar PDF
                                            </a>
                                        </li>

                                    </ul>

                                </div>

                            </td>

                        </tr>


                        {{-- FILA 2 --}}
                        <tr>

                            <td class="ps-4 fw-semibold">
                                #00124
                            </td>

                            <td>

                                <div class="d-flex align-items-center">

                                    <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-2 me-2">
                                        <i class="bi bi-shop"></i>
                                    </div>

                                    <div>

                                        <div class="fw-semibold">
                                            Caja Principal
                                        </div>

                                        <small class="text-muted">
                                            POS-01
                                        </small>

                                    </div>

                                </div>

                            </td>

                            <td>
                                Carlos Pérez
                            </td>

                            <td>
                                <div>
                                    24/08/2026
                                </div>

                                <small class="text-muted">
                                    08:05 AM
                                </small>
                            </td>

                            <td>
                                <div>
                                    24/08/2026
                                </div>

                                <small class="text-muted">
                                    06:10 PM
                                </small>
                            </td>

                            <td class="text-end">
                                $500.000
                            </td>

                            <td class="text-end fw-semibold">
                                $4.120.000
                            </td>

                            <td class="text-end">
                                $4.600.000
                            </td>

                            <td class="text-end">

                                <span class="text-danger fw-semibold">
                                    -$20.000
                                </span>

                            </td>

                            <td class="text-center">

                                <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill">
                                    <i class="bi bi-exclamation-circle me-1"></i>
                                    Diferencia
                                </span>

                            </td>

                            <td class="text-center pe-4">

                                <div class="dropdown">

                                    <button class="btn btn-light btn-sm border rounded-3" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>

                                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">

                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <i class="bi bi-eye me-2"></i>
                                                Ver cierre
                                            </a>
                                        </li>

                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <i class="bi bi-printer me-2"></i>
                                                Imprimir
                                            </a>
                                        </li>

                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <i class="bi bi-file-earmark-pdf me-2"></i>
                                                Descargar PDF
                                            </a>
                                        </li>

                                    </ul>

                                </div>

                            </td>

                        </tr>


                        {{-- FILA 3 --}}
                        <tr>

                            <td class="ps-4 fw-semibold">
                                #00123
                            </td>

                            <td>

                                <div class="d-flex align-items-center">

                                    <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-2 me-2">
                                        <i class="bi bi-shop"></i>
                                    </div>

                                    <div>

                                        <div class="fw-semibold">
                                            Caja Secundaria
                                        </div>

                                        <small class="text-muted">
                                            POS-02
                                        </small>

                                    </div>

                                </div>

                            </td>

                            <td>
                                María Gómez
                            </td>

                            <td>
                                <div>
                                    24/08/2026
                                </div>

                                <small class="text-muted">
                                    08:15 AM
                                </small>
                            </td>

                            <td>
                                <div>
                                    24/08/2026
                                </div>

                                <small class="text-muted">
                                    05:55 PM
                                </small>
                            </td>

                            <td class="text-end">
                                $300.000
                            </td>

                            <td class="text-end fw-semibold">
                                $2.850.000
                            </td>

                            <td class="text-end">
                                $3.150.000
                            </td>

                            <td class="text-end">

                                <span class="text-success fw-semibold">
                                    $0
                                </span>

                            </td>

                            <td class="text-center">

                                <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">
                                    <i class="bi bi-check-circle me-1"></i>
                                    Cuadrado
                                </span>

                            </td>

                            <td class="text-center pe-4">

                                <div class="dropdown">

                                    <button class="btn btn-light btn-sm border rounded-3" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>

                                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">

                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <i class="bi bi-eye me-2"></i>
                                                Ver cierre
                                            </a>
                                        </li>

                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <i class="bi bi-printer me-2"></i>
                                                Imprimir
                                            </a>
                                        </li>

                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <i class="bi bi-file-earmark-pdf me-2"></i>
                                                Descargar PDF
                                            </a>
                                        </li>

                                    </ul>

                                </div>

                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>


            {{-- FOOTER / PAGINACIÓN --}}
            <div class="card-footer bg-white border-0 rounded-bottom-4 p-4">

                <div class="d-flex flex-wrap justify-content-between align-items-center">

                    <span class="text-muted small">
                        Mostrando
                        <strong>1</strong>
                        a
                        <strong>10</strong>
                        de
                        <strong>125</strong>
                        cierres
                    </span>


                    <nav>

                        <ul class="pagination pagination-sm mb-0">

                            <li class="page-item disabled">
                                <a class="page-link" href="#">
                                    <i class="bi bi-chevron-left"></i>
                                </a>
                            </li>

                            <li class="page-item active">
                                <a class="page-link" href="#">
                                    1
                                </a>
                            </li>

                            <li class="page-item">
                                <a class="page-link" href="#">
                                    2
                                </a>
                            </li>

                            <li class="page-item">
                                <a class="page-link" href="#">
                                    3
                                </a>
                            </li>

                            <li class="page-item">
                                <a class="page-link" href="#">
                                    4
                                </a>
                            </li>

                            <li class="page-item">
                                <a class="page-link" href="#">
                                    5
                                </a>
                            </li>

                            <li class="page-item">
                                <a class="page-link" href="#">
                                    <i class="bi bi-chevron-right"></i>
                                </a>
                            </li>

                        </ul>

                    </nav>

                </div>

            </div>

        </div>

    </div>

@endsection
