```blade
@extends('layouts.app')

@section('title', 'Detalle del Cierre de Caja')

@section('content')

    <div class="container-fluid py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">
                    <i class="bi bi-cash-stack me-2"></i>
                    Detalle del Cierre de Caja
                </h4>
                <p class="text-muted mb-0">
                    Información detallada del cierre seleccionado
                </p>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('pos.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Volver
                </a>

                <button type="button" class="btn btn-primary" onclick="window.print()">
                    <i class="bi bi-printer me-1"></i>
                    Imprimir
                </button>
            </div>
        </div>

        {{-- Información general --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">
                    <i class="bi bi-info-circle me-2"></i>
                    Información del cierre
                </h5>
            </div>

            <div class="card-body">

                <div class="row g-4">

                    <div class="col-md-3">
                        <small class="text-muted d-block">
                            Usuario
                        </small>

                        <strong>
                            {{ $box->user->name ?? 'N/A' }}
                        </strong>
                    </div>

                    <div class="col-md-3">
                        <small class="text-muted d-block">
                            Fecha de apertura
                        </small>

                        <strong>
                            {{ \Carbon\Carbon::parse($box->start_date)->format('d/m/Y') }}
                        </strong>
                    </div>

                    <div class="col-md-3">
                        <small class="text-muted d-block">
                            Hora de apertura
                        </small>

                        <strong>
                            {{ \Carbon\Carbon::parse($box->start_time)->format('h:i A') }}
                        </strong>
                    </div>

                    <div class="col-md-3">
                        <small class="text-muted d-block">
                            Estado
                        </small>

                        @if ($box->state == false)
                            <span class="badge bg-success">
                                <i class="bi bi-check-circle me-1"></i>
                                Cerrada
                            </span>
                        @else
                            <span class="badge bg-warning text-dark">
                                <i class="bi bi-clock me-1"></i>
                                Abierta
                            </span>
                        @endif
                    </div>

                    <div class="col-md-3">
                        <small class="text-muted d-block">
                            Fecha de cierre
                        </small>

                        <strong>
                            {{ $box->closing_date ? \Carbon\Carbon::parse($box->closing_date)->format('d/m/Y') : 'N/A' }}
                        </strong>
                    </div>

                    <div class="col-md-3">
                        <small class="text-muted d-block">
                            Hora de cierre
                        </small>

                        <strong>
                            {{ $box->closing_time ? \Carbon\Carbon::parse($box->closing_time)->format('h:i A') : 'N/A' }}
                        </strong>
                    </div>

                    <div class="col-md-3">
                        <small class="text-muted d-block">
                            ID del cierre
                        </small>

                        <strong>
                            #{{ $box->id }}
                        </strong>
                    </div>

                </div>

            </div>
        </div>


        {{-- Resumen --}}
        <div class="row g-4 mb-4">

            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <small class="text-muted">
                                    Base de caja
                                </small>

                                <h4 class="mt-2 mb-0">
                                    ${{ number_format($box->box_base, 0, ',', '.') }}
                                </h4>
                            </div>

                            <div class="fs-2 text-primary">
                                <i class="bi bi-wallet2"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <small class="text-muted">
                                    Total ventas
                                </small>

                                <h4 class="mt-2 mb-0">
                                    ${{ number_format($box->total_sale, 0, ',', '.') }}
                                </h4>
                            </div>

                            <div class="fs-2 text-success">
                                <i class="bi bi-cart-check"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <small class="text-muted">
                                    Devoluciones
                                </small>

                                <h4 class="mt-2 mb-0">
                                    ${{ number_format($box->returns_sale, 0, ',', '.') }}
                                </h4>
                            </div>

                            <div class="fs-2 text-danger">
                                <i class="bi bi-arrow-return-left"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <small class="text-muted">
                                    Diferencia
                                </small>

                                <h4
                                    class="mt-2 mb-0
                                @if ($box->difference > 0) text-success
                                @elseif($box->difference < 0)
                                    text-danger
                                @else
                                    text-dark @endif">

                                    ${{ number_format($box->difference, 0, ',', '.') }}

                                </h4>
                            </div>

                            <div class="fs-2">
                                @if ($box->difference > 0)
                                    <i class="bi bi-arrow-up-circle text-success"></i>
                                @elseif($box->difference < 0)
                                    <i class="bi bi-arrow-down-circle text-danger"></i>
                                @else
                                    <i class="bi bi-check-circle text-success"></i>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        {{-- Formas de pago --}}
        <div class="card border-0 shadow-sm mb-4">

            <div class="card-header bg-white py-3">
                <h5 class="mb-0">
                    <i class="bi bi-credit-card me-2"></i>
                    Resumen por forma de pago
                </h5>
            </div>

            <div class="card-body">

                <div class="row g-4">

                    <div class="col-md-4">
                        <div class="border rounded p-3">

                            <div class="d-flex justify-content-between align-items-center">

                                <div>
                                    <small class="text-muted">
                                        Efectivo
                                    </small>

                                    <h5 class="mb-0 mt-1">
                                        ${{ number_format($box->cash, 0, ',', '.') }}
                                    </h5>
                                </div>

                                <i class="bi bi-cash-coin fs-2 text-success"></i>

                            </div>

                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="border rounded p-3">

                            <div class="d-flex justify-content-between align-items-center">

                                <div>
                                    <small class="text-muted">
                                        Consignaciones
                                    </small>

                                    <h5 class="mb-0 mt-1">
                                        ${{ number_format($box->consignment, 0, ',', '.') }}
                                    </h5>
                                </div>

                                <i class="bi bi-bank fs-2 text-primary"></i>

                            </div>

                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="border rounded p-3">

                            <div class="d-flex justify-content-between align-items-center">

                                <div>
                                    <small class="text-muted">
                                        Valor entregado
                                    </small>

                                    <h5 class="mb-0 mt-1">
                                        ${{ number_format($box->delivered_value, 0, ',', '.') }}
                                    </h5>
                                </div>

                                <i class="bi bi-box-arrow-right fs-2 text-warning"></i>

                            </div>

                        </div>
                    </div>

                </div>

            </div>

        </div>


        {{-- Detalle financiero --}}
        <div class="card border-0 shadow-sm mb-4">

            <div class="card-header bg-white py-3">
                <h5 class="mb-0">
                    <i class="bi bi-calculator me-2"></i>
                    Detalle financiero
                </h5>
            </div>

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover mb-0">

                        <tbody>

                            <tr>
                                <td class="ps-4">
                                    Base inicial
                                </td>

                                <td class="text-end pe-4">
                                    ${{ number_format($box->box_base, 0, ',', '.') }}
                                </td>
                            </tr>

                            <tr>
                                <td class="ps-4">
                                    Total de ventas
                                </td>

                                <td class="text-end pe-4 text-success">
                                    + ${{ number_format($box->total_sale, 0, ',', '.') }}
                                </td>
                            </tr>

                            <tr>
                                <td class="ps-4">
                                    Gastos
                                </td>

                                <td class="text-end pe-4 text-danger">
                                    - ${{ number_format($box->bills, 0, ',', '.') }}
                                </td>
                            </tr>

                            <tr>
                                <td class="ps-4">
                                    Devoluciones
                                </td>

                                <td class="text-end pe-4 text-danger">
                                    - ${{ number_format($box->returns_sale, 0, ',', '.') }}
                                </td>
                            </tr>

                            <tr class="table-light">

                                <td class="ps-4">
                                    <strong>
                                        Total esperado
                                    </strong>
                                </td>

                                <td class="text-end pe-4">



                                    <strong>
                                        ${{ number_format($box->total_sale - $box->returns_sale, 0, ',', '.') }}
                                    </strong>

                                </td>

                            </tr>

                            <tr>

                                <td class="ps-4">
                                    Valor entregado efectivo
                                </td>

                                <td class="text-end pe-4">
                                    ${{ number_format($box->delivered_value, 0, ',', '.') }}
                                </td>

                            </tr>

                            <tr class="table-light">

                                <td class="ps-4">
                                    <strong>
                                        Diferencia
                                    </strong>
                                </td>

                                <td class="text-end pe-4">

                                    <strong
                                        class="
                                    @if ($box->difference > 0) text-success
                                    @elseif($box->difference < 0)
                                        text-danger
                                    @else
                                        text-dark @endif
                                ">

                                        ${{ number_format($box->difference, 0, ',', '.') }}

                                    </strong>

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>




        {{-- Observación --}}
        @if (isset($box->observation) && $box->observation)
            <div class="card border-0 shadow-sm mb-4">

                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">
                        <i class="bi bi-chat-left-text me-2"></i>
                        Observación
                    </h5>
                </div>

                <div class="card-body">
                    {{ $box->observation }}
                </div>

            </div>
        @endif


        {{-- Footer --}}
        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <div class="row align-items-center">

                    <div class="col-md-6">

                        <small class="text-muted">
                            Registro creado
                        </small>

                        <div>
                            {{ $box->created_at ? $box->created_at->format('d/m/Y h:i A') : 'N/A' }}
                        </div>

                    </div>

                    <div class="col-md-6 text-md-end mt-3 mt-md-0">

                        <a href="{{ route('pos.index') }}" class="btn btn-outline-secondary">

                            <i class="bi bi-arrow-left me-1"></i>
                            Volver a cierres

                        </a>

                        <button type="button" class="btn btn-primary" onclick="window.print()">

                            <i class="bi bi-printer me-1"></i>
                            Imprimir cierre

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection

@push('styles')
    <style>
        @media print {

            body {
                background: #fff !important;
            }

            .navbar,
            .sidebar,
            footer,
            .btn,
            .no-print {
                display: none !important;
            }

            .container-fluid {
                width: 100% !important;
                padding: 0 !important;
            }

            .card {
                box-shadow: none !important;
                border: 1px solid #ddd !important;
            }

        }
    </style>
@endpush
```
