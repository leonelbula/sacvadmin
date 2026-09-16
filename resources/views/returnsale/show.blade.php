@extends('layouts.app')

@section('title', 'Detalle de devolución')

@section('content')

    <div class="container-fluid py-4 mt-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1">
                    <i class="bi bi-arrow-return-left me-2"></i>
                    Detalle de devolución
                </h4>
                <p class="text-muted mb-0">
                    Información completa de la devolución de venta
                </p>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('salereturn.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Volver
                </a>

                <button type="button" class="btn btn-danger" onclick="window.print()">
                    <i class="bi bi-printer me-1"></i>
                    Imprimir
                </button>
            </div>
        </div>


        {{-- INFORMACIÓN GENERAL --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-info-circle me-2"></i>
                    Información de la devolución
                </h5>
            </div>

            <div class="card-body">

                <div class="row g-4">

                    <div class="col-md-3">
                        <small class="text-muted d-block">
                            Número devolución
                        </small>

                        <span class="fw-bold fs-5">
                            {{ $returnSale->return_number ?? 'N/A' }}
                        </span>
                    </div>

                    <div class="col-md-3">
                        <small class="text-muted d-block">
                            Factura / Venta
                        </small>

                        <span class="fw-semibold">
                            {{ $returnSale->sale->sale_number ?? ($returnSale->sale_id ?? 'N/A') }}
                        </span>
                    </div>

                    <div class="col-md-3">
                        <small class="text-muted d-block">
                            Fecha
                        </small>

                        <span class="fw-semibold">
                            {{ optional($returnSale->created_at)->format('d/m/Y H:i') }}
                        </span>
                    </div>

                    <div class="col-md-3">
                        <small class="text-muted d-block">
                            Estado
                        </small>

                        @if ($returnSale->state = 'completed')
                            <span class="badge bg-success">
                                Procesado
                            </span>
                        @else
                            <span class="badge bg-danger">
                                Sin Confirmar
                            </span>
                        @endif
                    </div>

                </div>

            </div>
        </div>


        {{-- CLIENTE --}}
        <div class="card border-0 shadow-sm mb-4">

            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-person me-2"></i>
                    Información del cliente
                </h5>
            </div>

            <div class="card-body">

                <div class="row g-4">

                    <div class="col-md-4">
                        <small class="text-muted d-block">
                            Identificación
                        </small>

                        <span class="fw-semibold">
                            {{ $returnSale->customer->identification ?? 'Consumidor final' }}
                        </span>
                    </div>

                    <div class="col-md-4">
                        <small class="text-muted d-block">
                            Cliente
                        </small>

                        <span class="fw-semibold">
                            {{ $returnSale->customer->full_name ?? 'Consumidor final' }}
                        </span>
                    </div>

                    <div class="col-md-4">
                        <small class="text-muted d-block">
                            Teléfono
                        </small>

                        <span class="fw-semibold">
                            {{ $returnSale->customer->phone ?? 'N/A' }}
                        </span>
                    </div>

                </div>

            </div>
        </div>


        {{-- PRODUCTOS DEVUELTOS --}}
        <div class="card border-0 shadow-sm mb-4">

            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-box-seam me-2"></i>
                    Productos devueltos
                </h5>
            </div>

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">

                            <tr>
                                <th class="ps-4">#</th>
                                <th>Código</th>
                                <th>Producto</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-end">Precio unitario</th>
                                <th class="text-end pe-4">Total</th>
                            </tr>

                        </thead>

                        <tbody>

                            @php
                                $totalReturn = 0;
                            @endphp

                            @forelse($returnSale->details as $index => $detail)
                                @php
                                    $price = $detail->price ?? ($detail->unit_price ?? ($detail->product_price ?? 0));

                                    $quantity = $detail->quantity ?? 0;

                                    $subtotal = $price * $quantity;

                                    $totalReturn += $subtotal;
                                @endphp

                                <tr>

                                    <td class="ps-4">
                                        {{ $index + 1 }}
                                    </td>

                                    <td>
                                        <span class="badge text-bg-light border">
                                            {{ $detail->product->code ?? 'N/A' }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="fw-semibold">
                                            {{ $detail->product->name ?? 'Producto eliminado' }}
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <span class="badge bg-primary">
                                            {{ $quantity }}
                                        </span>
                                    </td>

                                    <td class="text-end">
                                        $ {{ number_format($price, 0, ',', '.') }}
                                    </td>

                                    <td class="text-end pe-4 fw-bold">
                                        $ {{ number_format($subtotal, 0, ',', '.') }}
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="6" class="text-center py-5">

                                        <i class="bi bi-box-seam fs-1 text-muted"></i>

                                        <p class="text-muted mt-2 mb-0">
                                            No existen productos registrados en esta devolución.
                                        </p>

                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>
        </div>


        {{-- RESUMEN --}}
        <div class="row justify-content-end mb-4">

            <div class="col-md-5">

                <div class="card border-0 shadow-sm">

                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">
                            Resumen
                        </h5>
                    </div>

                    <div class="card-body">

                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">
                                Productos devueltos
                            </span>

                            <span class="fw-semibold">
                                {{ $returnSale->details->sum('quantity') }}
                            </span>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between align-items-center">

                            <span class="fw-bold fs-5">
                                Total devolución
                            </span>

                            <span class="fw-bold fs-4 text-danger">
                                $ {{ number_format($returnSale->total ?? $totalReturn, 0, ',', '.') }}
                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- OBSERVACIÓN --}}
        <div class="card border-0 shadow-sm mb-4">

            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-chat-left-text me-2"></i>
                    Observación
                </h5>
            </div>

            <div class="card-body">

                @if (!empty($returnSale->observation))
                    <p class="mb-0">
                        {{ $returnSale->observation }}
                    </p>
                @else
                    <span class="text-muted">
                        No se registró ninguna observación.
                    </span>
                @endif

            </div>

        </div>


        {{-- USUARIO --}}
        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <div class="row">

                    <div class="col-md-6">

                        <small class="text-muted d-block">
                            Registrado por
                        </small>

                        <span class="fw-semibold">
                            {{ $returnSale->user->name ?? 'N/A' }}
                        </span>

                    </div>

                    <div class="col-md-6">

                        <small class="text-muted d-block">
                            Fecha de registro
                        </small>

                        <span class="fw-semibold">
                            {{ optional($returnSale->created_at)->format('d/m/Y H:i:s') }}
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <style>
        @media print {

            .sidebar,
            .navbar,
            footer,
            .btn,
            .no-print {
                display: none !important;
            }

            body {
                background: white !important;
            }

            .card {
                box-shadow: none !important;
                border: 1px solid #ddd !important;
            }

            .container-fluid {
                width: 100% !important;
            }

        }
    </style>

@endsection
