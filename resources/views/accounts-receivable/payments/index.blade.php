@extends('layouts.app')

@section('title', 'Historial de abonos')

@section('content')
    <div class="container-fluid py-4 mt-4">

        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <h3 class="mb-1">Historial de abonos</h3>
                <p class="text-muted mb-0">
                    Factura {{ $cuenta->sale_number }}
                </p>
            </div>

            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('accounts-receivable.show', $cuenta->id) }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Volver
                </a>

                @if ((float) $cuenta->balance > 0)
                    <a href="{{ route('accounts-receivable.payments.create', $cuenta->id) }}" class="btn btn-success">
                        <i class="bi bi-plus-circle"></i> Registrar abono
                    </a>
                @endif
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row g-3 mb-4">

            <div class="col-12 col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <p class="text-muted mb-1">Cliente</p>
                        <h5 class="fw-semibold">
                            {{ $cuenta->customer?->full_name ?? 'No disponible' }}
                        </h5>
                        <p class="text-muted mb-0">
                            Factura {{ $cuenta->sale_number }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <p class="text-muted mb-1">Total de la venta</p>
                        <h4 class="fw-bold">
                            ${{ number_format($cuenta->total, 0, ',', '.') }}
                        </h4>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <p class="text-muted mb-1">Saldo pendiente</p>
                        <h4 class="fw-bold text-danger">
                            ${{ number_format($cuenta->balance, 0, ',', '.') }}
                        </h4>
                    </div>
                </div>
            </div>

        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Pagos registrados</h5>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Fecha de pago</th>
                                <th>Método</th>
                                <th>Referencia</th>
                                <th class="text-end">Valor</th>
                                <th>Usuario</th>
                                <th>Observaciones</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($abonos as $abono)
                                <tr>
                                    <td>{{ $abono->id }}</td>

                                    <td>
                                        {{ \Illuminate\Support\Carbon::parse($abono->payment_date)->format('d/m/Y') }}
                                    </td>

                                    <td>
                                        @switch($abono->payment_method)
                                            @case('cash')
                                                Efectivo
                                            @break

                                            @case('transfer')
                                                Transferencia / NEQUI
                                            @break

                                            @case('debit_card')
                                                Tarjeta débito
                                            @break

                                            @case('credit_card')
                                                Tarjeta crédito
                                            @break

                                            @case('other')
                                                Otro
                                            @break

                                            @default
                                                {{ $abono->payment_method }}
                                        @endswitch
                                    </td>

                                    <td>{{ $abono->reference ?: '—' }}</td>

                                    <td class="text-end fw-bold text-success">
                                        ${{ number_format($abono->amount, 0, ',', '.') }}
                                    </td>

                                    <td>{{ $abono->user?->name ?? 'No disponible' }}</td>

                                    <td>{{ $abono->observation ?: '—' }}</td>
                                    <td>
                                        <a href="{{ route('accounts-receivable.payments.pdf', [
                                            'id' => $cuenta->id,
                                            'paymentId' => $abono->id,
                                        ]) }}"
                                            class="btn btn-sm btn-danger" target="_blank">
                                            <i class="bi bi-file-earmark-pdf"></i>
                                            Descargar PDF
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <i class="bi bi-inbox fs-1 text-muted"></i>
                                            <p class="text-muted mt-2 mb-0">
                                                Esta factura todavía no tiene abonos registrados.
                                            </p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                            @if ($abonos->count() > 0)
                                <tfoot class="table-light">
                                    <tr>
                                        <th colspan="4" class="text-end">
                                            Total abonado en esta página
                                        </th>
                                        <th class="text-end text-success">
                                            ${{ number_format($abonos->sum('amount'), 0, ',', '.') }}
                                        </th>
                                        <th colspan="2"></th>
                                    </tr>
                                </tfoot>
                            @endif
                        </table>

                    </div>
                </div>

                <div class="card-footer bg-white">
                    {{ $abonos->withQueryString()->links() }}
                </div>
            </div>

        </div>
    @endsection
