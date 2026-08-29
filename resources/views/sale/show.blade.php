@extends('layouts.app')

@section('title', 'Factura #' . $sale->sale_number)

@section('content')

    <div class="container-fluid py-4 mt-4">

        {{-- =====================================================
        BARRA SUPERIOR
    ====================================================== --}}

        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

            <div>
                <a href="{{ route('sale.index') }}" class="btn btn-light border">

                    <i class="bi bi-arrow-left me-1"></i>

                    Volver
                </a>
            </div>

            <div class="d-flex gap-2">

                <a href="{{ route('sale.print', $sale->id) }}" target="_blank" class="btn btn-outline-secondary">

                    <i class="bi bi-printer me-1"></i>
                    Imprimir
                </a>

                <a href="{{ route('sale.ticket', $sale->id) }}" target="_blank" class="btn btn-dark">

                    <i class="bi bi-receipt me-1"></i>
                    Ticket
                </a>

            </div>

        </div>


        {{-- =====================================================
        FACTURA
    ====================================================== --}}

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden invoice-card">

            {{-- =================================================
            ENCABEZADO
        ================================================== --}}

            <div class="card-body p-4 p-lg-5">

                <div class="row align-items-start">

                    {{-- EMPRESA --}}

                    <div class="col-md-7">

                        <div class="d-flex align-items-center gap-3">

                            <div class="bg-primary text-white rounded-3 d-flex align-items-center justify-content-center"
                                style="width:55px;height:55px;">

                                <i class="bi bi-shop fs-3"></i>

                            </div>

                            <div>

                                <h3 class="fw-bold mb-1">
                                    SACVAdmin
                                </h3>

                                <div class="text-muted">
                                    Sistema de gestión empresarial
                                </div>

                            </div>

                        </div>

                        <div class="mt-4 text-muted small">

                            <div>
                                <i class="bi bi-geo-alt me-2"></i>
                                Dirección de la empresa
                            </div>

                            <div>
                                <i class="bi bi-telephone me-2"></i>
                                Teléfono
                            </div>

                            <div>
                                <i class="bi bi-envelope me-2"></i>
                                correo@empresa.com
                            </div>

                            <div>
                                <strong>NIT:</strong>
                                000.000.000-0
                            </div>

                        </div>

                    </div>


                    {{-- INFORMACIÓN FACTURA --}}

                    <div class="col-md-5 mt-4 mt-md-0">

                        <div class="border rounded-4 p-4">

                            <div class="text-uppercase text-muted small fw-semibold mb-1">
                                Factura de venta
                            </div>

                            <h2 class="fw-bold text-primary mb-3">
                                #{{ $sale->sale_number }}
                            </h2>

                            <div class="d-flex justify-content-between mb-2">

                                <span class="text-muted">
                                    Fecha
                                </span>

                                <strong>
                                    {{ \Carbon\Carbon::parse($sale->date_sale)->format('d/m/Y') }}
                                </strong>

                            </div>

                            <div class="d-flex justify-content-between mb-2">

                                <span class="text-muted">
                                    Hora
                                </span>

                                <strong>
                                    {{ $sale->hour }}
                                </strong>

                            </div>

                            <div class="d-flex justify-content-between align-items-center">

                                <span class="text-muted">
                                    Estado
                                </span>

                                @if ($sale->state === 'active')
                                    <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">
                                        <i class="bi bi-check-circle me-1"></i>
                                        Activa
                                    </span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill">
                                        {{ ucfirst($sale->state) }}
                                    </span>
                                @endif

                            </div>

                        </div>

                    </div>

                </div>


                <hr class="my-4">


                {{-- =================================================
                CLIENTE / PAGO
            ================================================== --}}

                <div class="row g-4 mb-4">

                    {{-- CLIENTE --}}

                    <div class="col-lg-6">

                        <div class="invoice-section h-100">

                            <div class="section-title">

                                <i class="bi bi-person"></i>

                                Información del cliente

                            </div>

                            <div class="mt-3">

                                <h6 class="fw-bold mb-1">

                                    {{ $sale->customer->full_name ?? 'Consumidor final' }}

                                </h6>

                                @if ($sale->customer)
                                    <div class="text-muted small mb-1">

                                        <strong>Identificación:</strong>

                                        {{ $sale->customer->identification }}

                                    </div>

                                    <div class="text-muted small mb-1">

                                        <strong>Teléfono:</strong>

                                        {{ $sale->customer->phone ?? 'No registrado' }}

                                    </div>

                                    <div class="text-muted small">

                                        <strong>Dirección:</strong>

                                        {{ $sale->customer->address ?? 'No registrada' }}

                                    </div>
                                @endif

                            </div>

                        </div>

                    </div>


                    {{-- PAGO --}}

                    <div class="col-lg-6">

                        <div class="invoice-section h-100">

                            <div class="section-title">

                                <i class="bi bi-credit-card"></i>

                                Información del pago

                            </div>

                            <div class="row g-3 mt-2">

                                <div class="col-6">

                                    <small class="text-muted d-block">
                                        Forma de pago
                                    </small>

                                    <strong>
                                        {{ $sale->paymentMethod === 'counted' ? 'Contado' : 'credito' }}
                                    </strong>

                                </div>

                                <div class="col-6">

                                    <small class="text-muted d-block">
                                        Método
                                    </small>

                                    <strong>

                                        {{ $sale->payment_method->name ?? 'No especificado' }}

                                    </strong>

                                </div>

                                <div class="col-6">

                                    <small class="text-muted d-block">
                                        Plazo
                                    </small>

                                    <strong>
                                        {{ $sale->term ?? 0 }} días
                                    </strong>

                                </div>

                                <div class="col-6">

                                    <small class="text-muted d-block">
                                        Vencimiento
                                    </small>

                                    <strong>

                                        @if ($sale->expiration_date)
                                            {{ \Carbon\Carbon::parse($sale->expiration_date)->format('d/m/Y') }}
                                        @else
                                            —
                                        @endif

                                    </strong>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                PRODUCTOS
            ================================================== --}}

                <div class="invoice-section mb-4">

                    <div class="section-title mb-3">

                        <i class="bi bi-box-seam"></i>

                        Detalle de productos

                    </div>


                    <div class="table-responsive">

                        <table class="table align-middle invoice-table">

                            <thead>

                                <tr>

                                    <th width="50">
                                        #
                                    </th>

                                    <th>
                                        Producto
                                    </th>

                                    <th class="text-center">
                                        Cant.
                                    </th>

                                    <th class="text-end">
                                        Precio
                                    </th>

                                    <th class="text-end">
                                        IVA
                                    </th>

                                    <th class="text-end">
                                        Total
                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                @foreach ($sale->details as $index => $detail)
                                    <tr>

                                        <td class="text-muted">

                                            {{ $index + 1 }}

                                        </td>

                                        <td>

                                            <div class="fw-semibold">

                                                {{ $detail->product->name ?? 'Producto eliminado' }}

                                            </div>

                                            @if (isset($detail->product->code))
                                                <small class="text-muted">

                                                    Código:
                                                    {{ $detail->product->code }}

                                                </small>
                                            @endif

                                        </td>

                                        <td class="text-center">

                                            {{ $detail->quantity }}

                                        </td>

                                        <td class="text-end">

                                            ${{ number_format($detail->price, 0, ',', '.') }}

                                        </td>

                                        <td class="text-end">

                                            ${{ number_format($detail->tax ?? 0, 0, ',', '.') }}

                                        </td>

                                        <td class="text-end fw-semibold">

                                            ${{ number_format($detail->subtotal, 0, ',', '.') }}

                                        </td>

                                    </tr>
                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>


                {{-- =================================================
                OBSERVACIONES + TOTALES
            ================================================== --}}

                <div class="row justify-content-between g-4">

                    <div class="col-lg-6">

                        @if ($sale->observation)
                            <div class="invoice-section">

                                <div class="section-title">

                                    <i class="bi bi-chat-left-text"></i>

                                    Observaciones

                                </div>

                                <p class="text-muted mt-3 mb-0">

                                    {{ $sale->observation }}

                                </p>

                            </div>
                        @endif


                        {{-- INFORMACIÓN ELECTRÓNICA --}}

                        <div class="invoice-electronic mt-3">

                            <div class="d-flex align-items-center gap-2 mb-2">

                                <i class="bi bi-shield-check text-success"></i>

                                <strong>
                                    Factura electrónica
                                </strong>

                            </div>

                            <small class="text-muted">

                                Documento generado mediante SACVAdmin.

                            </small>

                        </div>

                    </div>


                    {{-- TOTALES --}}

                    <div class="col-lg-5">

                        <div class="totals-box">

                            <div class="d-flex justify-content-between mb-3">

                                <span>
                                    Subtotal
                                </span>

                                <strong>

                                    ${{ number_format($sale->subtotal, 0, ',', '.') }}

                                </strong>

                            </div>


                            <div class="d-flex justify-content-between mb-3">

                                <span>
                                    Impuestos
                                </span>

                                <strong>

                                    ${{ number_format($sale->taxes ?? 0, 0, ',', '.') }}

                                </strong>

                            </div>


                            <div class="d-flex justify-content-between mb-3">

                                <span>
                                    Descuento
                                </span>

                                <strong>

                                    $0

                                </strong>

                            </div>


                            <hr>


                            <div class="d-flex justify-content-between align-items-center">

                                <span class="fs-5 fw-semibold">
                                    Total
                                </span>

                                <span class="fs-3 fw-bold text-primary">

                                    ${{ number_format($sale->total, 0, ',', '.') }}

                                </span>

                            </div>


                            @if ($sale->balance > 0)
                                <div class="d-flex justify-content-between mt-3 text-danger">

                                    <span>
                                        Saldo pendiente
                                    </span>

                                    <strong>

                                        ${{ number_format($sale->balance, 0, ',', '.') }}

                                    </strong>

                                </div>
                            @endif

                        </div>

                    </div>

                </div>


                {{-- =================================================
                PIE
            ================================================== --}}

                <div class="text-center mt-5 pt-4 border-top">

                    <p class="mb-1 fw-semibold">

                        Gracias por su compra

                    </p>

                    <small class="text-muted">

                        Esta factura fue generada por SACVAdmin

                    </small>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
    ESTILOS
========================================================= --}}

    <style>
        .invoice-section {

            background: #f8fafc;

            border: 1px solid #e5e7eb;

            border-radius: 14px;

            padding: 20px;

        }

        .section-title {

            font-size: 14px;

            font-weight: 700;

            color: #334155;

            display: flex;

            align-items: center;

            gap: 8px;

        }

        .section-title i {

            color: #2563eb;

            font-size: 18px;

        }

        .invoice-table {

            margin-bottom: 0;

        }

        .invoice-table thead th {

            background: #f8fafc;

            color: #64748b;

            font-size: 12px;

            text-transform: uppercase;

            letter-spacing: .04em;

            border-bottom: 1px solid #e2e8f0;

            padding: 14px 12px;

        }

        .invoice-table tbody td {

            padding: 15px 12px;

            border-bottom: 1px solid #f1f5f9;

        }

        .totals-box {

            background: #f8fafc;

            border: 1px solid #e2e8f0;

            border-radius: 16px;

            padding: 24px;

        }

        .invoice-electronic {

            border: 1px solid #d1fae5;

            background: #ecfdf5;

            border-radius: 12px;

            padding: 16px;

        }


        /* =========================================
                   IMPRESIÓN
                ========================================= */

        @media print {

            body {

                background: white !important;

            }

            .top-navbar,
            .sidebar,
            #sidebarOverlay,
            .btn,
            nav {

                display: none !important;

            }

            .main {

                margin: 0 !important;

                padding: 0 !important;

            }

            .container-fluid {

                padding: 0 !important;

            }

            .invoice-card {

                box-shadow: none !important;

                border: none !important;

            }

            .card-body {

                padding: 0 !important;

            }

            .invoice-section {

                background: white !important;

            }

            .totals-box {

                background: white !important;

            }

        }
    </style>

@endsection
