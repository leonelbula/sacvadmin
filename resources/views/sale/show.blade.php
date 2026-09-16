@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4 mt-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h3 class="fw-bold mb-1">
                    <i class="bi bi-receipt me-2"></i>
                    Detalle de Venta
                </h3>

                <span class="text-muted">
                    Consulta de factura
                </span>
            </div>

            <div class="d-flex gap-2">

                <a href="{{route('sale.index')}}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Volver
                </a>

                <a href="{{ route('sale.edit', $sale->id) }}" class="btn btn-warning">
                    <i class="bi bi-pencil me-1"></i>
                    Editar
                </a>

                <button type="button" class="btn btn-primary" onclick="window.print()">
                    <i class="bi bi-printer me-1"></i>
                    Imprimir
                </button>

            </div>

        </div>


        {{-- =========================================================
    INFORMACIÓN DE LA VENTA
========================================================== --}}

        <div class="card border-0 shadow-sm rounded-4 mb-4">

            <div class="card-header bg-primary text-white border-0 rounded-top-4 py-3">

                <div class="row align-items-center">

                    <div class="col-md-6">

                        <h5 class="mb-0 fw-bold">
                            Factura #{{ $sale->sale_number }}
                        </h5>

                    </div>

                    <div class="col-md-6 text-md-end">

                        @if ($sale->state === 'active')
                            <span class="badge bg-success">
                                <i class="bi bi-check-circle me-1"></i>
                                Activa
                            </span>
                        @else
                            <span class="badge bg-danger">
                                {{ ucfirst($sale->state) }}
                            </span>
                        @endif

                    </div>

                </div>

            </div>


            <div class="card-body">

                <div class="row g-4">

                    {{-- Número --}}
                    <div class="col-md-3">

                        <label class="text-muted small">
                            Número de factura
                        </label>

                        <div class="fw-bold">
                            {{ $sale->sale_number }}
                        </div>

                    </div>


                    {{-- Fecha --}}
                    <div class="col-md-3">

                        <label class="text-muted small">
                            Fecha
                        </label>

                        <div class="fw-bold">
                            {{ \Carbon\Carbon::parse($sale->date_sale)->format('d/m/Y') }}
                        </div>

                    </div>


                    {{-- Hora --}}
                    <div class="col-md-3">

                        <label class="text-muted small">
                            Hora
                        </label>

                        <div class="fw-bold">
                            {{ $sale->hour }}
                        </div>

                    </div>


                    {{-- Usuario --}}
                    <div class="col-md-3">

                        <label class="text-muted small">
                            Usuario
                        </label>

                        <div class="fw-bold">
                            {{ $sale->user?->name ?? 'N/A' }}
                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- =========================================================
    CLIENTE + PAGO
        ========================================================== --}}

        <div class="row g-4 mb-4">

            {{-- CLIENTE --}}
            <div class="col-lg-7">

                <div class="card border-0 shadow-sm rounded-4 h-100">

                    <div class="card-header bg-light border-0 rounded-top-4">

                        <h5 class="mb-0 fw-bold">

                            <i class="bi bi-person-circle me-2 text-primary"></i>

                            Información del cliente

                        </h5>

                    </div>


                    <div class="card-body">

                        <div class="row g-3">

                            <div class="col-md-6">

                                <label class="text-muted small">
                                    Cliente
                                </label>

                                <div class="fw-semibold">
                                    {{ $sale->customer?->full_name ?? 'Consumidor final' }}
                                </div>

                            </div>


                            <div class="col-md-6">

                                <label class="text-muted small">
                                    Identificación
                                </label>

                                <div class="fw-semibold">
                                    {{ $sale->customer?->identification ?? 'N/A' }}
                                </div>

                            </div>


                            <div class="col-md-6">

                                <label class="text-muted small">
                                    Teléfono
                                </label>

                                <div>
                                    {{ $sale->customer?->phone ?? 'N/A' }}
                                </div>

                            </div>


                            <div class="col-md-6">

                                <label class="text-muted small">
                                    Email
                                </label>

                                <div>
                                    {{ $sale->customer?->email ?? 'N/A' }}
                                </div>

                            </div>


                            <div class="col-12">

                                <label class="text-muted small">
                                    Dirección
                                </label>

                                <div>
                                    {{ $sale->customer?->address ?? 'N/A' }}
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- PAGO --}}
            <div class="col-lg-5">

                <div class="card border-0 shadow-sm rounded-4 h-100">

                    <div class="card-header bg-light border-0 rounded-top-4">

                        <h5 class="mb-0 fw-bold">

                            <i class="bi bi-credit-card me-2 text-success"></i>

                            Información de pago

                        </h5>

                    </div>


                    <div class="card-body">

                        <div class="mb-3">

                            <label class="text-muted small">
                                Método de pago
                            </label>

                            <div class="fw-bold">

                                {{ $sale->paymentMethod?->name ?? 'N/A' }}

                            </div>

                        </div>


                        <div class="mb-3">

                            <label class="text-muted small">
                                Forma de pago
                            </label>

                            <div>

                                @if ($sale->payment_form === 'counted')
                                    <span class="badge bg-success">
                                        Contado
                                    </span>
                                @else
                                    <span class="badge bg-warning text-dark">
                                        Crédito
                                    </span>
                                @endif

                            </div>

                        </div>


                        @if ($sale->payment_form === 'credit')
                            <div class="row">

                                <div class="col-6">

                                    <label class="text-muted small">
                                        Plazo
                                    </label>

                                    <div class="fw-bold">
                                        {{ $sale->term }} días
                                    </div>

                                </div>

                                <div class="col-6">

                                    <label class="text-muted small">
                                        Saldo
                                    </label>

                                    <div class="fw-bold text-danger">

                                        $ {{ number_format($sale->balance, 0, ',', '.') }}

                                    </div>

                                </div>

                            </div>
                        @endif

                    </div>

                </div>

            </div>

        </div>


        {{-- =========================================================
    PRODUCTOS
        ========================================================== --}}

        <div class="card border-0 shadow-sm rounded-4 mb-4">

            <div class="card-header bg-light border-0 rounded-top-4 py-3">

                <div class="d-flex justify-content-between align-items-center">

                    <h5 class="mb-0 fw-bold">

                        <i class="bi bi-box-seam me-2 text-primary"></i>

                        Productos vendidos

                    </h5>

                    <span class="badge bg-primary">

                        {{ $sale->details->count() }} productos

                    </span>

                </div>

            </div>


            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">

                            <tr>

                                <th class="text-center">
                                    #
                                </th>

                                <th>
                                    Código
                                </th>

                                <th>
                                    Producto
                                </th>

                                <th class="text-center">
                                    Cantidad
                                </th>

                                <th class="text-end">
                                    Precio
                                </th>

                                <th class="text-center">
                                    IVA
                                </th>

                                <th class="text-end">
                                    Subtotal
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($sale->details as $index => $detail)
                                <tr>

                                    <td class="text-center">
                                        {{ $index + 1 }}
                                    </td>


                                    <td>

                                        <span class="badge bg-light text-dark border">

                                            {{ $detail->product?->code }}

                                        </span>

                                    </td>


                                    <td>

                                        <div class="fw-semibold">

                                            {{ $detail->product?->name }}

                                        </div>

                                    </td>


                                    <td class="text-center">

                                        {{ $detail->quantity }}

                                    </td>


                                    <td class="text-end">

                                        $ {{ number_format($detail->price, 0, ',', '.') }}

                                    </td>


                                    <td class="text-center">

                                        {{ $detail->tax?->value ?? 0 }}%

                                    </td>


                                    <td class="text-end fw-bold">

                                        $ {{ number_format($detail->subtotal, 0, ',', '.') }}

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="7" class="text-center py-5 text-muted">

                                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>

                                        No hay productos registrados.

                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>


        {{-- =========================================================
    OBSERVACIONES + TOTALES
        ========================================================== --}}

        <div class="row g-4">

            {{-- OBSERVACIÓN --}}
            <div class="col-lg-7">

                <div class="card border-0 shadow-sm rounded-4 h-100">

                    <div class="card-header bg-light border-0 rounded-top-4">

                        <h5 class="mb-0 fw-bold">

                            <i class="bi bi-chat-left-text me-2 text-primary"></i>

                            Observaciones

                        </h5>

                    </div>


                    <div class="card-body">

                        <p class="mb-0 text-muted">

                            {{ $sale->observation ?: 'Sin observaciones.' }}

                        </p>

                    </div>

                </div>

            </div>


            {{-- TOTALES --}}
            <div class="col-lg-5">

                <div class="card border-0 shadow rounded-4">

                    <div class="card-header bg-primary text-white border-0 rounded-top-4">

                        <h5 class="mb-0 fw-bold">

                            <i class="bi bi-calculator me-2"></i>

                            Resumen de la venta

                        </h5>

                    </div>


                    <div class="card-body">




                        <div class="d-flex justify-content-between mb-3">

                            <span>
                                Subtotal
                            </span>

                            <strong>
                                $ {{ number_format($sale->subtotal, 0, ',', '.') }}
                            </strong>

                        </div>


                        <div class="d-flex justify-content-between mb-3">

                            <span>
                                Impuestos
                            </span>

                            <strong>
                                $ {{ number_format($sale->taxes, 0, ',', '.') }}
                            </strong>

                        </div>


                        <hr>


                        <div class="d-flex justify-content-between mb-3">

                            <span class="fw-bold fs-5">
                                Total
                            </span>

                            <strong class="text-primary fs-4">

                                $ {{ number_format($sale->total, 0, ',', '.') }}

                            </strong>

                        </div>


                        @if ($sale->payment_form === 'credit')
                            <div class="d-flex justify-content-between">

                                <span class="text-muted">
                                    Saldo pendiente
                                </span>

                                <strong class="text-danger">

                                    $ {{ number_format($sale->balance, 0, ',', '.') }}

                                </strong>

                            </div>
                        @endif

                    </div>

                </div>

            </div>

        </div>


        {{-- =========================================================
    PIE
        ========================================================== --}}

        <div class="text-center text-muted small mt-4">

            Venta registrada el
            {{ $sale->created_at?->format('d/m/Y H:i') }}

        </div>
        ```

    </div>

    <style>
        @media print {

            body {
                background: #fff !important;
            }

            .btn,
            nav,
            .sidebar {
                display: none !important;
            }

            .card {
                box-shadow: none !important;
                border: 1px solid #ddd !important;
            }

            .container-fluid {
                width: 100% !important;
                padding: 0 !important;
            }

        }
    </style>
@endsection
