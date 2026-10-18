@extends('layouts.app')

@section('title', 'Detalle de cuenta por cobrar')

@section('content')
    <div class="container-fluid py-4 mt-4">

        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <h3 class="mb-1">Detalle de cuenta por cobrar</h3>
                <p class="text-muted mb-0">Factura {{ $cuenta->sale_number }}</p>
            </div>

            <a href="{{ route('accounts-payable.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
        </div>

        @php
            $saldo = (float) $cuenta->balance;
            $total = (float) $cuenta->total;
            $abonado = max(0, $total - $saldo);

            $vencida =
                $saldo > 0 &&
                $cuenta->expiration_date &&
                \Illuminate\Support\Carbon::parse($cuenta->expiration_date)
                    ->startOfDay()
                    ->lt(now()->startOfDay());
        @endphp

        <div class="row g-3 mb-4">

            <div class="col-12 col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <p class="text-muted mb-1">Total de la factura</p>
                        <h4 class="fw-bold">
                            ${{ number_format($total, 0, ',', '.') }}
                        </h4>
                        <i class="bi bi-receipt text-primary fs-3"></i>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <p class="text-muted mb-1">Total abonado estimado</p>
                        <h4 class="fw-bold text-success">
                            ${{ number_format($abonado, 0, ',', '.') }}
                        </h4>
                        <i class="bi bi-cash-coin text-success fs-3"></i>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <p class="text-muted mb-1">Saldo pendiente</p>
                        <h4 class="fw-bold text-danger">
                            ${{ number_format($saldo, 0, ',', '.') }}
                        </h4>

                        @if ($saldo <= 0)
                            <span class="badge bg-success">Pagada</span>
                        @elseif ($vencida)
                            <span class="badge bg-danger">Vencida</span>
                        @else
                            <span class="badge bg-warning text-dark">Pendiente</span>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        <div class="row g-4">

            <div class="col-12 col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">Información del cliente</h5>
                    </div>

                    <div class="card-body">
                        <div class="mb-3">
                            <label class="text-muted small">Nombre</label>
                            <div class="fw-semibold">
                                {{ $cuenta->supplier?->full_name ?? 'No disponible' }}
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="text-muted small">Identificación</label>
                            <div>
                                {{ $cuenta->supplier?->identification ?? 'No registrada' }}
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="text-muted small">Teléfono</label>
                            <div>
                                {{ $cuenta->supplier?->phone ?? 'No registrado' }}
                            </div>
                        </div>

                        <div>
                            <label class="text-muted small">Dirección</label>
                            <div>
                                {{ $cuenta->supplier?->address ?? 'No registrada' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">Información de la factura</h5>
                    </div>

                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Número de factura</span>
                            <strong>{{ $cuenta->invoice_number }}</strong>
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Fecha de venta</span>
                            <span>
                                {{ $cuenta->shopping_date ? \Illuminate\Support\Carbon::parse($cuenta->date_sale)->format('d/m/Y') : '—' }}
                            </span>
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Vencimiento</span>
                            <span>
                                {{ $cuenta->due_date ? \Illuminate\Support\Carbon::parse($cuenta->expiration_date)->format('d/m/Y') : 'Sin fecha' }}
                            </span>
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Observaciones</span>
                            <span>{{ $cuenta->observation ?: '—' }}</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Gestión de pagos</h5>
            </div>

            <div class="card-body d-flex flex-wrap gap-2">

                @if ($saldo > 0)
                    <a href="{{ route('accounts-payable.payments.create', $cuenta->id) }}" class="btn btn-success">
                        <i class="bi bi-plus-circle me-1"></i>
                        Registrar abono
                    </a>
                @endif

                <a href="{{ route('accounts-payable.payments.index', $cuenta->id) }}" class="btn btn-outline-primary">
                    <i class="bi bi-clock-history me-1"></i>
                    Consultar historial de abonos
                </a>

                <a href="{{ route('sale.show', $cuenta->id) }}" class="btn btn-outline-secondary">
                    <i class="bi bi-receipt me-1"></i>
                    Ver factura
                </a>

            </div>
        </div>

    </div>
@endsection
