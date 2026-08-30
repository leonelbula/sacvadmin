@extends('layouts.app')

@section('title', 'Reportes')

@section('content')

    <div class="container-fluid py-4 mt-4">

        {{-- ==========================================================
        ENCABEZADO
    =========================================================== --}}
        <div class="d-flex flex-wrap justify-content-between
                align-items-center mb-4">

            <div>

                <h2 class="fw-bold mb-1">

                    <i class="bi bi-bar-chart-line-fill
                          text-primary me-2"></i>

                    Reportes

                </h2>

                <p class="text-muted mb-0">

                    Consulta y analiza la información de tu negocio.

                </p>

            </div>

        </div>


        {{-- ==========================================================
        RESUMEN
    =========================================================== --}}
        <div class="row g-4 mb-4">

            {{-- VENTAS --}}
            <div class="col-xl-3 col-md-6">

                <div class="card border-0 shadow-sm rounded-4 h-100">

                    <div class="card-body p-4">

                        <div class="d-flex justify-content-between
                                align-items-start">

                            <div>

                                <span class="text-muted small">
                                    Ventas
                                </span>

                                <h4 class="fw-bold mt-2 mb-1">

                                    ${{ number_format($totalSales ?? 0, 0, ',', '.') }}

                                </h4>

                                <small class="text-success">

                                    <i class="bi bi-graph-up-arrow me-1"></i>

                                    Ventas registradas

                                </small>

                            </div>


                            <div
                                class="bg-primary bg-opacity-10
                                    text-primary rounded-4 p-3">

                                <i class="bi bi-cart-check fs-3"></i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- COMPRAS --}}
            <div class="col-xl-3 col-md-6">

                <div class="card border-0 shadow-sm rounded-4 h-100">

                    <div class="card-body p-4">

                        <div class="d-flex justify-content-between
                                align-items-start">

                            <div>

                                <span class="text-muted small">
                                    Compras
                                </span>

                                <h4 class="fw-bold mt-2 mb-1">

                                    ${{ number_format($totalPurchases ?? 0, 0, ',', '.') }}

                                </h4>

                                <small class="text-muted">

                                    Total de compras

                                </small>

                            </div>


                            <div class="bg-info bg-opacity-10
                                    text-info rounded-4 p-3">

                                <i class="bi bi-bag-check fs-3"></i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- GASTOS --}}
            <div class="col-xl-3 col-md-6">

                <div class="card border-0 shadow-sm rounded-4 h-100">

                    <div class="card-body p-4">

                        <div class="d-flex justify-content-between
                                align-items-start">

                            <div>

                                <span class="text-muted small">
                                    Gastos
                                </span>

                                <h4 class="fw-bold mt-2 mb-1 text-danger">

                                    ${{ number_format($totalExpenses ?? 0, 0, ',', '.') }}

                                </h4>

                                <small class="text-muted">

                                    Gastos registrados

                                </small>

                            </div>


                            <div
                                class="bg-danger bg-opacity-10
                                    text-danger rounded-4 p-3">

                                <i class="bi bi-wallet2 fs-3"></i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- UTILIDAD --}}
            <div class="col-xl-3 col-md-6">

                <div class="card border-0 shadow-sm rounded-4 h-100">

                    <div class="card-body p-4">

                        <div class="d-flex justify-content-between
                                align-items-start">

                            <div>

                                <span class="text-muted small">
                                    Utilidad
                                </span>

                                <h4 class="fw-bold mt-2 mb-1 text-success">

                                    ${{ number_format($utility ?? 0, 0, ',', '.') }}

                                </h4>

                                <small class="text-success">

                                    Resultado estimado

                                </small>

                            </div>


                            <div
                                class="bg-success bg-opacity-10
                                    text-success rounded-4 p-3">

                                <i class="bi bi-graph-up-arrow fs-3"></i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- ==========================================================
        REPORTES
    =========================================================== --}}
        <div class="row g-4">


            {{-- ======================================================
            VENTAS
        ======================================================= --}}
            <div class="col-xl-4 col-md-6">

                <div class="card border-0 shadow-sm rounded-4 h-100">

                    <div class="card-header bg-white border-0 p-4">

                        <div class="d-flex align-items-center">

                            <div
                                class="bg-primary bg-opacity-10
                                    text-primary rounded-3 p-2 me-3">

                                <i class="bi bi-cart-check fs-4"></i>

                            </div>

                            <div>

                                <h5 class="fw-bold mb-0">
                                    Ventas
                                </h5>

                                <small class="text-muted">
                                    Analiza tus ventas
                                </small>

                            </div>

                        </div>

                    </div>


                    <div class="card-body px-4 pt-0">

                        <a href="{{ route('reports.sales') }}" class="report-item">

                            <div>

                                <strong>
                                    Ventas por fecha
                                </strong>

                                <small class="text-muted d-block">
                                    Consulta ventas por período.
                                </small>

                            </div>

                            <i class="bi bi-chevron-right"></i>

                        </a>


                        <a href="{{ route('reports.sales.products') }}" class="report-item">

                            <div>

                                <strong>
                                    Productos vendidos
                                </strong>

                                <small class="text-muted d-block">
                                    Productos y cantidades vendidas.
                                </small>

                            </div>

                            <i class="bi bi-chevron-right"></i>

                        </a>


                        <a href="{{ route('reports.sales.payment-methods') }}" class="report-item">

                            <div>

                                <strong>
                                    Métodos de pago
                                </strong>

                                <small class="text-muted d-block">
                                    Ventas agrupadas por método.
                                </small>

                            </div>

                            <i class="bi bi-chevron-right"></i>

                        </a>


                        <a href="{{ route('reports.sales.customers') }}" class="report-item">

                            <div>

                                <strong>
                                    Ventas por cliente
                                </strong>

                                <small class="text-muted d-block">
                                    Historial de compras por cliente.
                                </small>

                            </div>

                            <i class="bi bi-chevron-right"></i>

                        </a>

                    </div>

                </div>

            </div>


            {{-- ======================================================
            INVENTARIO
        ======================================================= --}}
            <div class="col-xl-4 col-md-6">

                <div class="card border-0 shadow-sm rounded-4 h-100">

                    <div class="card-header bg-white border-0 p-4">

                        <div class="d-flex align-items-center">

                            <div
                                class="bg-warning bg-opacity-10
                                    text-warning rounded-3 p-2 me-3">

                                <i class="bi bi-box-seam fs-4"></i>

                            </div>

                            <div>

                                <h5 class="fw-bold mb-0">
                                    Inventario
                                </h5>

                                <small class="text-muted">
                                    Control de existencias
                                </small>

                            </div>

                        </div>

                    </div>


                    <div class="card-body px-4 pt-0">

                        <a href="{{ route('reports.inventory') }}" class="report-item">

                            <div>

                                <strong>
                                    Estado del inventario
                                </strong>

                                <small class="text-muted d-block">
                                    Existencias actuales.
                                </small>

                            </div>

                            <i class="bi bi-chevron-right"></i>

                        </a>


                        <a href="{{ route('reports.inventory.valuation') }}" class="report-item">

                            <div>

                                <strong>
                                    Valorización
                                </strong>

                                <small class="text-muted d-block">
                                    Valor del inventario.
                                </small>

                            </div>

                            <i class="bi bi-chevron-right"></i>

                        </a>


                        <a href="{{ route('reports.inventory.low-stock') }}" class="report-item">

                            <div>

                                <strong>
                                    Stock bajo
                                </strong>

                                <small class="text-muted d-block">
                                    Productos por debajo del mínimo.
                                </small>

                            </div>

                            <i class="bi bi-chevron-right"></i>

                        </a>


                        <a href="{{ route('reports.inventory.kardex') }}" class="report-item">

                            <div>

                                <strong>
                                    Kardex
                                </strong>

                                <small class="text-muted d-block">
                                    Movimientos de inventario.
                                </small>

                            </div>

                            <i class="bi bi-chevron-right"></i>

                        </a>

                    </div>

                </div>

            </div>


            {{-- ======================================================
            COMPRAS
        ======================================================= --}}
            <div class="col-xl-4 col-md-6">

                <div class="card border-0 shadow-sm rounded-4 h-100">

                    <div class="card-header bg-white border-0 p-4">

                        <div class="d-flex align-items-center">

                            <div
                                class="bg-info bg-opacity-10
                                    text-info rounded-3 p-2 me-3">

                                <i class="bi bi-bag-check fs-4"></i>

                            </div>

                            <div>

                                <h5 class="fw-bold mb-0">
                                    Compras
                                </h5>

                                <small class="text-muted">
                                    Control de compras
                                </small>

                            </div>

                        </div>

                    </div>


                    <div class="card-body px-4 pt-0">

                        <a href="{{ route('reports.purchases') }}" class="report-item">

                            <div>

                                <strong>
                                    Compras por fecha
                                </strong>

                                <small class="text-muted d-block">
                                    Consulta compras por período.
                                </small>

                            </div>

                            <i class="bi bi-chevron-right"></i>

                        </a>


                        <a href="{{ route('reports.purchases.products') }}" class="report-item">

                            <div>

                                <strong>
                                    Productos comprados
                                </strong>

                                <small class="text-muted d-block">
                                    Productos y cantidades.
                                </small>

                            </div>

                            <i class="bi bi-chevron-right"></i>

                        </a>


                        <a href="{{ route('reports.purchases.suppliers') }}" class="report-item">

                            <div>

                                <strong>
                                    Compras por proveedor
                                </strong>

                                <small class="text-muted d-block">
                                    Compras agrupadas por proveedor.
                                </small>

                            </div>

                            <i class="bi bi-chevron-right"></i>

                        </a>

                    </div>

                </div>

            </div>


            {{-- ======================================================
            GASTOS
        ======================================================= --}}
            <div class="col-xl-4 col-md-6">

                <div class="card border-0 shadow-sm rounded-4 h-100">

                    <div class="card-header bg-white border-0 p-4">

                        <div class="d-flex align-items-center">

                            <div
                                class="bg-danger bg-opacity-10
                                    text-danger rounded-3 p-2 me-3">

                                <i class="bi bi-wallet2 fs-4"></i>

                            </div>

                            <div>

                                <h5 class="fw-bold mb-0">
                                    Gastos
                                </h5>

                                <small class="text-muted">
                                    Control de gastos
                                </small>

                            </div>

                        </div>

                    </div>


                    <div class="card-body px-4 pt-0">

                        <a href="{{ route('reports.expenses') }}" class="report-item">

                            <div>

                                <strong>
                                    Gastos por fecha
                                </strong>

                                <small class="text-muted d-block">
                                    Consulta gastos por período.
                                </small>

                            </div>

                            <i class="bi bi-chevron-right"></i>

                        </a>


                        <a href="{{ route('reports.expenses.types') }}" class="report-item">

                            <div>

                                <strong>
                                    Gastos por tipo
                                </strong>

                                <small class="text-muted d-block">
                                    Agrupados por categoría.
                                </small>

                            </div>

                            <i class="bi bi-chevron-right"></i>

                        </a>


                        <a href="{{ route('reports.expenses.payment-methods') }}" class="report-item">

                            <div>

                                <strong>
                                    Gastos por método de pago
                                </strong>

                                <small class="text-muted d-block">
                                    Distribución de los gastos.
                                </small>

                            </div>

                            <i class="bi bi-chevron-right"></i>

                        </a>

                    </div>

                </div>

            </div>


            {{-- ======================================================
            FINANCIERO
        ======================================================= --}}
            <div class="col-xl-4 col-md-6">

                <div class="card border-0 shadow-sm rounded-4 h-100">

                    <div class="card-header bg-white border-0 p-4">

                        <div class="d-flex align-items-center">

                            <div
                                class="bg-success bg-opacity-10
                                    text-success rounded-3 p-2 me-3">

                                <i class="bi bi-cash-stack fs-4"></i>

                            </div>

                            <div>

                                <h5 class="fw-bold mb-0">
                                    Financiero
                                </h5>

                                <small class="text-muted">
                                    Análisis financiero
                                </small>

                            </div>

                        </div>

                    </div>


                    <div class="card-body px-4 pt-0">

                        <a href="{{ route('reports.profit') }}" class="report-item">

                            <div>

                                <strong>
                                    Utilidad
                                </strong>

                                <small class="text-muted d-block">
                                    Ingresos, costos y utilidad.
                                </small>

                            </div>

                            <i class="bi bi-chevron-right"></i>

                        </a>


                        <a href="{{ route('reports.cash-flow') }}" class="report-item">

                            <div>

                                <strong>
                                    Flujo de caja
                                </strong>

                                <small class="text-muted d-block">
                                    Entradas y salidas de dinero.
                                </small>

                            </div>

                            <i class="bi bi-chevron-right"></i>

                        </a>


                        <a href="{{ route('reports.payment-methods') }}" class="report-item">

                            <div>

                                <strong>
                                    Métodos de pago
                                </strong>

                                <small class="text-muted d-block">
                                    Resumen financiero por método.
                                </small>

                            </div>

                            <i class="bi bi-chevron-right"></i>

                        </a>

                    </div>

                </div>

            </div>


            {{-- ======================================================
            CLIENTES
        ======================================================= --}}
            <div class="col-xl-4 col-md-6">

                <div class="card border-0 shadow-sm rounded-4 h-100">

                    <div class="card-header bg-white border-0 p-4">

                        <div class="d-flex align-items-center">

                            <div
                                class="bg-secondary bg-opacity-10
                                    text-secondary rounded-3 p-2 me-3">

                                <i class="bi bi-people fs-4"></i>

                            </div>

                            <div>

                                <h5 class="fw-bold mb-0">
                                    Clientes
                                </h5>

                                <small class="text-muted">
                                    Información de clientes
                                </small>

                            </div>

                        </div>

                    </div>


                    <div class="card-body px-4 pt-0">

                        <a href="{{ route('reports.customers') }}" class="report-item">

                            <div>

                                <strong>
                                    Clientes
                                </strong>

                                <small class="text-muted d-block">
                                    Resumen de clientes.
                                </small>

                            </div>

                            <i class="bi bi-chevron-right"></i>

                        </a>


                        <a href="{{ route('reports.customers.top') }}" class="report-item">

                            <div>

                                <strong>
                                    Mejores clientes
                                </strong>

                                <small class="text-muted d-block">
                                    Clientes con mayores compras.
                                </small>

                            </div>

                            <i class="bi bi-chevron-right"></i>

                        </a>


                        <a href="{{ route('reports.customers.inactive') }}" class="report-item">

                            <div>

                                <strong>
                                    Clientes inactivos
                                </strong>

                                <small class="text-muted d-block">
                                    Clientes sin compras recientes.
                                </small>

                            </div>

                            <i class="bi bi-chevron-right"></i>

                        </a>

                    </div>

                </div>

            </div>

        </div>


        {{-- ==========================================================
        EXPORTACIONES
    =========================================================== --}}
        <div class="card border-0 shadow-sm rounded-4 mt-4">

            <div class="card-body p-4">

                <div class="d-flex flex-wrap justify-content-between
                        align-items-center">

                    <div>

                        <h5 class="fw-bold mb-1">

                            <i class="bi bi-download text-primary me-2"></i>

                            Exportar información

                        </h5>

                        <small class="text-muted">

                            Genera reportes para análisis externo.

                        </small>

                    </div>


                    <div class="d-flex gap-2 mt-3 mt-md-0">

                        <a href="" class="btn btn-success rounded-3">

                            <i class="bi bi-file-earmark-excel me-2"></i>

                            Excel

                        </a>


                        <a href="" class="btn btn-danger rounded-3">

                            <i class="bi bi-file-earmark-pdf me-2"></i>

                            PDF

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ==============================================================
    ESTILOS
================================================================ --}}


    <style>
        .report-item {

            display: flex;
            align-items: center;
            justify-content: space-between;

            text-decoration: none;

            color: inherit;

            padding: 14px 10px;

            border-bottom: 1px solid #f0f0f0;

            transition: all .2s ease;

        }


        .report-item:last-child {

            border-bottom: 0;

        }


        .report-item:hover {

            background-color: #f8f9fa;

            padding-left: 16px;

        }


        .report-item strong {

            font-size: .95rem;

        }


        .report-item small {

            font-size: .8rem;

        }


        .report-item>i {

            color: #adb5bd;

        }
    </style>



@endsection
