@extends('layouts.app')

@section('title', 'Detalle del abono')

@section('content')
    <div class="container-fluid py-4 mt-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1">
                    <i class="bi bi-cash-coin text-primary"></i>
                    Detalle del abono
                </h4>
                <p class="text-muted mb-0">
                    Información del pago registrado por el cliente.
                </p>
            </div>

            <a href="{{ route('accounts-receivable.payments.index', $abono->sale_id) }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
        </div>

        <div class="row g-4">

            {{-- Información del abono --}}
            <div class="col-lg-8">

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-semibold">
                            Información del pago
                        </h5>
                    </div>

                    <div class="card-body">

                        <div class="text-center py-4">
                            <span class="text-muted d-block mb-2">
                                Valor del abono
                            </span>

                            <h2 class="fw-bold text-success">
                                ${{ number_format($abono->amount, 0, ',', '.') }}
                            </h2>

                            <span class="badge bg-success-subtle text-success">
                                <i class="bi bi-check-circle"></i>
                                Pago registrado
                            </span>
                        </div>

                        <hr>

                        <div class="row g-4">

                            <div class="col-md-6">
                                <small class="text-muted d-block">
                                    Número de registro
                                </small>
                                <strong>#{{ $abono->id }}</strong>
                            </div>

                            <div class="col-md-6">
                                <small class="text-muted d-block">
                                    Fecha del abono
                                </small>
                                <strong>
                                    {{ \Carbon\Carbon::parse($abono->payment_date)->format('d/m/Y') }}
                                </strong>
                            </div>

                            <div class="col-md-6">
                                <small class="text-muted d-block">
                                    Método de pago
                                </small>
                                <strong>
                                    
                                    {{ ucfirst(str_replace('_', ' ', $abono->payment_method)) }}
                                </strong>
                            </div>

                            <div class="col-md-6">
                                <small class="text-muted d-block">
                                    Referencia
                                </small>
                                <strong>
                                    {{ $abono->reference ?: 'No registrada' }}
                                </strong>
                            </div>

                            <div class="col-12">
                                <small class="text-muted d-block">
                                    Observaciones
                                </small>
                                <p class="mb-0">
                                    {{ $abono->observation ?: 'Sin observaciones' }}
                                </p>
                            </div>

                        </div>

                    </div>
                </div>

                {{-- Información de la factura --}}
                <div class="card border-0 shadow-sm mt-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-semibold">
                            <i class="bi bi-receipt text-primary"></i>
                            Factura asociada
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="row g-3">

                            <div class="col-md-6">
                                <small class="text-muted d-block">
                                    Número de factura
                                </small>
                                <strong>
                                    {{ $abono->sale->sale_number ?? 'No disponible' }}
                                </strong>
                            </div>

                            <div class="col-md-6">
                                <small class="text-muted d-block">
                                    Total de la factura
                                </small>
                                <strong>
                                    ${{ number_format($abono->sale->total ?? 0, 0, ',', '.') }}
                                </strong>
                            </div>

                            <div class="col-md-6">
                                <small class="text-muted d-block">
                                    Saldo pendiente actual
                                </small>
                                <strong class="text-danger">
                                    ${{ number_format($abono->sale->balance ?? 0, 0, ',', '.') }}
                                </strong>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

            {{-- Información del cliente --}}
            <div class="col-lg-4">

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-semibold">
                            <i class="bi bi-person-circle text-primary"></i>
                            Información del cliente
                        </h5>
                    </div>

                    <div class="card-body">

                        <h5 class="fw-bold mb-3">
                            {{ $abono->sale->customer->full_name ?? 'Cliente no disponible' }}
                        </h5>

                        <div class="mb-3">
                            <small class="text-muted d-block">
                                Identificación
                            </small>
                            <strong>
                                {{ $abono->sale->customer->identification ?? 'No disponible' }}
                            </strong>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block">
                                Teléfono
                            </small>
                            <strong>
                                {{ $abono->sale->customer->phone ?? 'No disponible' }}
                            </strong>
                        </div>

                        <hr>

                        <div>
                            <small class="text-muted d-block">
                                Registrado por
                            </small>
                            <strong>
                                {{ $abono->user->name ?? 'Usuario no disponible' }}
                            </strong>
                        </div>

                        <div class="mt-3">
                            <small class="text-muted d-block">
                                Fecha de registro
                            </small>
                            <strong>
                                {{ $abono->created_at?->format('d/m/Y h:i A') }}
                            </strong>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection
