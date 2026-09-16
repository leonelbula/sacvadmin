@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4 mt-5">

        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <h4 class="fw-bold mb-0">
                        Detalle del ajuste
                    </h4>

                    <span class="badge {{ $adjustment->movement_type === 'income' ? 'text-bg-success' : 'text-bg-danger' }}">
                        {{ $adjustment->movement_type === 'income' ? 'Entrada' : 'Salida' }}
                    </span>
                </div>

                <p class="text-muted mb-0">
                    Ajuste #{{ str_pad($adjustment->id, 6, '0', STR_PAD_LEFT) }}
                </p>
            </div>

            <div class="d-flex gap-2">

                <a href="{{ route('inventory.adjustments.index') }}" class="btn btn-outline-secondary">

                    <i class="bi bi-arrow-left me-1"></i>
                    Volver

                </a>

                <button type="button" class="btn btn-primary" onclick="window.print()">

                    <i class="bi bi-printer me-1"></i>
                    Imprimir

                </button>

            </div>

        </div>


        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">

                <i class="bi bi-check-circle me-2"></i>

                {{ session('success') }}

                <button type="button" class="btn-close" data-bs-dismiss="alert">
                </button>

            </div>
        @endif


        <div class="row g-4">

            <div class="col-lg-8">

                <div class="card border-0 shadow-sm rounded-4 mb-4">

                    <div class="card-header bg-white border-0 p-4">

                        <div class="d-flex justify-content-between align-items-center">

                            <h5 class="fw-bold mb-0">
                                <i class="bi bi-box-seam me-2"></i>
                                Producto
                            </h5>

                            <span class="badge bg-light text-dark">
                                ID: {{ $adjustment->product_id }}
                            </span>

                        </div>

                    </div>

                    <div class="card-body p-4">

                        <div class="row align-items-center">

                            <div class="col-md-8">

                                <div class="d-flex align-items-center gap-3">

                                    <div class="rounded-4 bg-light d-flex align-items-center justify-content-center"
                                        style="width: 65px; height: 65px;">

                                        <i class="bi bi-box-seam fs-2 text-primary"></i>

                                    </div>

                                    <div>

                                        <div class="text-muted small">
                                            Código
                                        </div>

                                        <div class="fw-bold fs-5">
                                            {{ $adjustment->product?->code ?? 'N/A' }}
                                        </div>

                                        <div class="text-muted">
                                            {{ $adjustment->product?->name ?? 'Producto no disponible' }}
                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="col-md-4 mt-3 mt-md-0">

                                <div class="bg-light rounded-4 p-3 text-center">

                                    <div class="text-muted small mb-1">
                                        Stock actual
                                    </div>

                                    <div class="fs-3 fw-bold">
                                        {{ $adjustment->product?->stock ?? 0 }}
                                    </div>

                                    <div class="text-muted small">
                                        unidades
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                <div class="card border-0 shadow-sm rounded-4 mb-4">

                    <div class="card-header bg-white border-0 p-4">

                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-arrow-left-right me-2"></i>
                            Movimiento de inventario
                        </h5>

                    </div>

                    <div class="card-body p-4">

                        <div class="row g-3">

                            <div class="col-md-4">

                                <div class="border rounded-4 p-3 h-100">

                                    <div class="text-muted small mb-2">
                                        Tipo de movimiento
                                    </div>

                                    @if ($adjustment->movement_type === 'income')
                                        <div class="d-flex align-items-center gap-2">

                                            <div class="rounded-circle bg-success-subtle text-success p-2">
                                                <i class="bi bi-arrow-down-circle"></i>
                                            </div>

                                            <span class="fw-bold text-success">
                                                Entrada
                                            </span>

                                        </div>
                                    @else
                                        <div class="d-flex align-items-center gap-2">

                                            <div class="rounded-circle bg-danger-subtle text-danger p-2">
                                                <i class="bi bi-arrow-up-circle"></i>
                                            </div>

                                            <span class="fw-bold text-danger">
                                                Salida
                                            </span>

                                        </div>
                                    @endif

                                </div>

                            </div>


                            <div class="col-md-4">

                                <div class="border rounded-4 p-3 h-100">

                                    <div class="text-muted small mb-2">
                                        Cantidad ajustada
                                    </div>

                                    <div class="fs-4 fw-bold">
                                        {{ number_format($adjustment->quantity, 0, ',', '.') }}
                                    </div>

                                    <div class="text-muted small">
                                        unidades
                                    </div>

                                </div>

                            </div>


                            <div class="col-md-4">

                                <div class="border rounded-4 p-3 h-100">

                                    <div class="text-muted small mb-2">
                                        Movimiento
                                    </div>

                                    @if ($adjustment->movement_type === 'income')
                                        <div class="fs-4 fw-bold text-success">
                                            +{{ number_format($adjustment->quantity, 0, ',', '.') }}
                                        </div>
                                    @else
                                        <div class="fs-4 fw-bold text-danger">
                                            -{{ number_format($adjustment->quantity, 0, ',', '.') }}
                                        </div>
                                    @endif

                                    <div class="text-muted small">
                                        unidades
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                <div class="card border-0 shadow-sm rounded-4">

                    <div class="card-header bg-white border-0 p-4">

                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-chat-left-text me-2"></i>
                            Observación
                        </h5>

                    </div>

                    <div class="card-body p-4">

                        @if ($adjustment->observation)
                            <div class="bg-light rounded-4 p-4">

                                <p class="mb-0">
                                    {{ $adjustment->observation }}
                                </p>

                            </div>
                        @else
                            <div class="text-center text-muted py-3">

                                <i class="bi bi-chat-square-text fs-2"></i>

                                <p class="mb-0 mt-2">
                                    No se registró ninguna observación.
                                </p>

                            </div>
                        @endif

                    </div>

                </div>

            </div>


            <div class="col-lg-4">

                <div class="card border-0 shadow-sm rounded-4 mb-4">

                    <div class="card-header bg-white border-0 p-4">

                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-bar-chart-line me-2"></i>
                            Resumen
                        </h5>

                    </div>

                    <div class="card-body p-4">

                        <div class="d-flex justify-content-between align-items-center mb-3">

                            <span class="text-muted">
                                Stock anterior
                            </span>

                            <strong>
                                {{ $adjustment->movement_type === 'income'
                                    ? $adjustment->product?->stock - $adjustment->quantity
                                    : $adjustment->product?->stock + $adjustment->quantity }}
                            </strong>

                        </div>


                        <div class="d-flex justify-content-between align-items-center mb-3">

                            <span class="text-muted">
                                Cantidad
                            </span>

                            <strong>
                                {{ number_format($adjustment->quantity, 0, ',', '.') }}
                            </strong>

                        </div>


                        <hr>


                        <div class="d-flex justify-content-between align-items-center">

                            <span class="fw-semibold">
                                Movimiento
                            </span>

                            @if ($adjustment->movement_type === 'income')
                                <strong class="text-success">
                                    +{{ number_format($adjustment->quantity, 0, ',', '.') }}
                                </strong>
                            @else
                                <strong class="text-danger">
                                    -{{ number_format($adjustment->quantity, 0, ',', '.') }}
                                </strong>
                            @endif

                        </div>

                    </div>

                </div>


                <div class="card border-0 shadow-sm rounded-4 mb-4">

                    <div class="card-header bg-white border-0 p-4">

                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-person me-2"></i>
                            Usuario
                        </h5>

                    </div>

                    <div class="card-body p-4">

                        <div class="d-flex align-items-center gap-3">

                            <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center"
                                style="width: 50px; height: 50px;">

                                <i class="bi bi-person fs-4"></i>

                            </div>

                            <div>

                                <div class="fw-semibold">
                                    {{ $adjustment->user?->name ?? 'Usuario no disponible' }}
                                </div>

                                <div class="text-muted small">
                                    Usuario que realizó el ajuste
                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                <div class="card border-0 shadow-sm rounded-4">

                    <div class="card-header bg-white border-0 p-4">

                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-calendar3 me-2"></i>
                            Información del registro
                        </h5>

                    </div>

                    <div class="card-body p-4">

                        <div class="mb-3">

                            <div class="text-muted small">
                                Fecha de creación
                            </div>

                            <div class="fw-semibold">
                                {{ $adjustment->created_at?->format('d/m/Y') }}
                            </div>

                        </div>


                        <div class="mb-3">

                            <div class="text-muted small">
                                Hora
                            </div>

                            <div class="fw-semibold">
                                {{ $adjustment->created_at?->format('h:i A') }}
                            </div>

                        </div>


                        <div>

                            <div class="text-muted small">
                                Última actualización
                            </div>

                            <div class="fw-semibold">
                                {{ $adjustment->updated_at?->format('d/m/Y h:i A') }}
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <style>
        @media print {

            .navbar,
            .sidebar,
            footer,
            .btn,
            .alert {
                display: none !important;
            }

            body {
                background: #fff !important;
            }

            .container-fluid {
                width: 100% !important;
                padding: 0 !important;
            }

            .card {
                box-shadow: none !important;
                border: 1px solid #dee2e6 !important;
            }

        }
    </style>
@endsection
