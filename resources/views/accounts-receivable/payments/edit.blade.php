@extends('layouts.app')

@section('title', 'Registrar abono')

@section('content')
    <div class="container-fluid py-4 mt-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="mb-1">Registrar abono</h3>
                <p class="text-muted mb-0">Ingresa los datos del pago recibido.</p>
            </div>

            <a href="{{ route('accounts-receivable.show', $cuenta->id) }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Volver a la cuenta
            </a>
        </div>

        @php
            $saldo = (float) $cuenta->balance;
        @endphp

        <div class="row g-4">

            <div class="col-12 col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">Resumen de la deuda</h5>
                    </div>

                    <div class="card-body">
                        <p class="text-muted mb-1">Factura</p>
                        <h5 class="fw-bold">{{ $cuenta->sale_number }}</h5>

                        <p class="text-muted mb-1 mt-3">Cliente</p>
                        <p class="fw-semibold">
                            {{ $cuenta->customer?->full_name ?? 'No disponible' }}
                        </p>

                        <hr>

                        <p class="text-muted mb-1">Total de la venta</p>
                        <h5>${{ number_format($cuenta->total, 0, ',', '.') }}</h5>

                        <p class="text-muted mb-1 mt-3">Saldo pendiente</p>
                        <h3 class="fw-bold text-danger">
                            ${{ number_format($saldo, 0, ',', '.') }}
                        </h3>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">Datos del pago</h5>
                    </div>

                    <div class="card-body">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('accounts-receivable.payments.update', [$abono->id, $cuenta->id]) }}" method="POST">
                            @csrf
                            @method('PUT')

                            @include('accounts-receivable.payments._form', ['saldo' => $saldo])

                            <hr class="my-4">

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('accounts-receivable.show', $cuenta->id) }}"
                                    class="btn btn-outline-secondary">
                                    Cancelar
                                </a>

                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-check-circle me-1"></i>
                                    Guardar abono
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const amountInput = document.getElementById('amount');
        const payFullBalance = document.getElementById('payFullBalance');
        const balance = {{ (int) $cuenta->balance }};

        payFullBalance.addEventListener('click', function() {
            amountInput.value = balance;
        });
    });
</script>
