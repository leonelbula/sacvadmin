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
                <a href="{{ route('pos.create') }}" class="btn btn-primary rounded-3 px-4">
                    <i class="bi bi-plus-lg me-2"></i>
                    Nuevo cierre
                </a>
            </div>

        </div>


        {{-- RESUMEN --}}
        <div class="row g-3 mb-4">


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
                                    ${{ number_format($closures['totalSale'], 0, ',', '.') }}
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
                                    ${{ number_format($closures['totalCash'], 0, ',', '.') }}
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
                                    Diferencias Faltantes
                                </span>

                                <h3 class="fw-bold mb-0 mt-1 text-danger">
                                    ${{ number_format($closures['totalDifferenceNegative'], 0, ',', '.') }}
                                </h3>

                            </div>

                            <div class="bg-danger bg-opacity-10 text-danger rounded-3 p-3">
                                <i class="bi bi-exclamation-triangle fs-4"></i>
                            </div>

                        </div>

                    </div>

                </div>

            </div>
            <div class="col-xl-3 col-md-6">

                <div class="card border-0 shadow-sm rounded-4 h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>
                                <span class="text-muted small">
                                    Diferencia Sobrantes
                                </span>

                                <h3 class="fw-bold mb-0 mt-1">
                                    ${{ number_format($closures['totalDifferencePositive'], 0, ',', '.') }}
                                </h3>
                            </div>

                            <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-3">
                                <i class="bi bi-safe2 fs-4"></i>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <form action="{{ route('pos.index') }}" method="get">
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

                                <select class="form-select" name="userId">

                                    @foreach ($userAll as $user)
                                        <option value="{{ $user->id }}">
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>


                            </div>

                        </div>


                        {{-- FECHA INICIAL --}}
                        <div class="col-lg-2">

                            <label class="form-label fw-semibold">
                                Desde
                            </label>

                            <input type="date" class="form-control" name="startDate">

                        </div>


                        {{-- FECHA FINAL --}}
                        <div class="col-lg-2">

                            <label class="form-label fw-semibold">
                                Hasta
                            </label>

                            <input type="date" class="form-control" name="endDate">

                        </div>


                        {{-- ESTADO --}}
                        <div class="col-lg-2">

                            <label class="form-label fw-semibold">
                                Estado
                            </label>

                            <select class="form-select" name="difference">

                                <option value="">
                                    Todos
                                </option>

                                <option value="negative">
                                    faltante
                                </option>

                                <option value="positive">
                                    sobrante
                                </option>
                                <option value="zero">
                                    cierre exacto
                                </option>

                            </select>

                        </div>


                        {{-- BOTONES --}}
                        <div class="col-lg-2 d-flex gap-2">

                            <button type="submit" class="btn btn-primary flex-fill">
                                <i class="bi bi-search"></i>
                                Buscar
                            </button>

                            <a href="{{ route('pos.index') }}">
                                <button type="button" class="btn btn-light border" title="Limpiar filtros">
                                    <i class="bi bi-arrow-clockwise"></i>
                                </button>
                            </a>
                        </div>

                    </div>

                </div>

            </div>

        </form>
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

                        @foreach ($closures['pos'] as $box)
                            <tr>

                                <td class="ps-4 fw-semibold">
                                    {{ $box->id }}
                                </td>


                                <td>
                                    {{ $box->user->name }}
                                </td>

                                <td>
                                    <div>
                                        {{ $box->start_date }}
                                    </div>

                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($box->start_time)->format('h:i A') }}
                                    </small>
                                </td>

                                <td>
                                    <div>
                                        {{ $box->closing_date }}
                                    </div>

                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($box->closing_time)->format('h:i A') }}
                                    </small>
                                </td>

                                <td class="text-end">
                                    {{ $box->box_base }}
                                </td>

                                <td class="text-end fw-semibold">
                                    ${{ number_format($box->total_sale, 0, ',', '.') }}
                                </td>

                                <td class="text-end">
                                    ${{ number_format($box->delivered_value, 0, ',', '.') }}
                                </td>

                                <td class="text-end">

                                    @if ($box->difference > 0)
                                        <span class="text-success fw-semibold">
                                            $0
                                        </span>
                                    @else
                                        <span class="text-danger fw-semibold">
                                            $ {{ $box->difference }}
                                        </span>
                                    @endif


                                </td>


                                <td class="text-center">
                                    @if ($box->difference = 0)
                                        <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">
                                            <i class="bi bi-check-circle me-1"></i>
                                            Cuadrado
                                        </span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill">
                                            <i class="bi bi-exclamation-circle me-1"></i>
                                            Diferencia
                                        </span>
                                    @endif



                                </td>

                                <td class="text-center pe-4">

                                    <div class="dropdown">

                                        <button class="btn btn-light btn-sm border rounded-3" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>

                                        <ul class="dropdown-menu dropdown-menu-end shadow border-0">

                                            <li>
                                                <a class="dropdown-item" href="{{ route('pos.show', $box->id) }}">
                                                    <i class="bi bi-eye me-2"></i>
                                                    Ver cierre
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
                        @endforeach



                    </tbody>

                </table>

            </div>


            {{-- FOOTER / PAGINACIÓN --}}
            <div class="card-footer bg-white border-0 rounded-bottom-4 p-4">

                <div class="d-flex flex-wrap justify-content-between align-items-center">

                    <span class="text-muted small">
                        Mostrando
                        <strong>{{ $closures['pos']->firstItem() ?? 0 }}</strong>
                        a
                        <strong>{{ $closures['pos']->lastItem() ?? 0 }}</strong>
                        de
                        <strong>{{ $closures['pos']->total() }}</strong>
                        cierres
                    </span>

                    <div>
                        {{ $closures['pos']->links() }}
                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
