@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    <div class="container-fluid">

        <!-- Encabezado -->
        <div class="page-header mb-4">
            <div>
                <h2 class="fw-bold mb-1">Bienvenido, Administrador 👋</h2>
                <p class="text-muted mb-0">
                    Resumen general del sistema
                </p>
            </div>

            <div class="text-end">
                <small class="text-muted">
                    {{ now()->format('d/m/Y') }}
                </small>
            </div>
        </div>

        <!-- KPIs -->
        <div class="row g-4">

            <div class="col-xl-2 col-md-4">
                <div class="kpi-card primary">
                    <div class="icon">
                        <i class="bi bi-cash-stack"></i>
                    </div>

                    <h3>$12.850.000</h3>

                    <span>Ventas del día</span>
                </div>
            </div>

            <div class="col-xl-2 col-md-4">
                <div class="kpi-card success">
                    <div class="icon">
                        <i class="bi bi-cart-check"></i>
                    </div>

                    <h3>128</h3>

                    <span>Ventas</span>
                </div>
            </div>

            <div class="col-xl-2 col-md-4">
                <div class="kpi-card warning">
                    <div class="icon">
                        <i class="bi bi-box-seam"></i>
                    </div>

                    <h3>945</h3>

                    <span>Productos</span>
                </div>
            </div>

            <div class="col-xl-2 col-md-4">
                <div class="kpi-card info">
                    <div class="icon">
                        <i class="bi bi-people"></i>
                    </div>

                    <h3>2.435</h3>

                    <span>Clientes</span>
                </div>
            </div>

            <div class="col-xl-2 col-md-4">
                <div class="kpi-card danger">
                    <div class="icon">
                        <i class="bi bi-truck"></i>
                    </div>

                    <h3>36</h3>

                    <span>Proveedores</span>
                </div>
            </div>

            <div class="col-xl-2 col-md-4">
                <div class="kpi-card dark">
                    <div class="icon">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>

                    <h3>18%</h3>

                    <span>Crecimiento</span>
                </div>
            </div>

        </div>

    </div>

@endsection
