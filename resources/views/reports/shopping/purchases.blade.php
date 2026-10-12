@extends('layouts.app')

@section('title', 'Reporte de Compras por Fechas')

@section('content')
    <div class="container-fluid py-4 mt-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h4 class="fw-bold mb-1">
                    <i class="bi bi-cart-check me-2"></i>
                    Reporte de Compras
                </h4>

                <p class="text-muted mb-0">
                    Consulta las compras realizadas en un periodo determinado.
                </p>
            </div>

            <div class="d-flex gap-2">

                <a href="{{ route('reports.purchases.pdf', request()->query()) }}" class="btn btn-danger" target="_blank">
                    <i class="bi bi-file-earmark-pdf me-1"></i>
                    PDF
                </a>

                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Volver
                </a>

            </div>

        </div>

        <div class="card border-0 shadow-sm mb-4">

            <div class="card-header bg-white py-3">

                <h6 class="fw-bold mb-0">
                    <i class="bi bi-funnel me-2"></i>
                    Filtros del reporte
                </h6>

            </div>

            <div class="card-body">

                <form method="GET" action="{{ route('reports.purchases') }}">

                    <div class="row g-3">

                        <div class="col-md-4">

                            <label for="fecha_desde" class="form-label fw-semibold">
                                Fecha desde
                            </label>

                            <input type="date" name="fecha_desde" id="fecha_desde" class="form-control"
                                value="{{ request('fecha_desde') }}">

                        </div>

                        <div class="col-md-4">

                            <label for="fecha_hasta" class="form-label fw-semibold">
                                Fecha hasta
                            </label>

                            <input type="date" name="fecha_hasta" id="fecha_hasta" class="form-control"
                                value="{{ request('fecha_hasta') }}">

                        </div>

                        <div class="col-md-4 d-flex align-items-end">

                            <div class="d-flex gap-2 w-100">

                                <button type="submit" class="btn btn-primary flex-grow-1">
                                    <i class="bi bi-search me-1"></i>
                                    Consultar
                                </button>

                                <a href="{{ route('reports.purchases') }}" class="btn btn-outline-secondary"
                                    title="Limpiar filtros">
                                    <i class="bi bi-x-lg"></i>
                                </a>

                            </div>

                        </div>

                    </div>

                </form>

            </div>

        </div>

        <div class="row g-3 mb-4">

            <div class="col-md-3">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body">

                        <div class="d-flex align-items-center">

                            <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
                                <i class="bi bi-cart-check text-primary fs-4"></i>
                            </div>

                            <div>

                                <small class="text-muted d-block">
                                    Total compras
                                </small>

                                <h4 class="fw-bold mb-0">
                                    {{ number_format($quantity ?? 0, 0, ',', '.') }}
                                </h4>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-md-3">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body">

                        <div class="d-flex align-items-center">

                            <div class="rounded-circle bg-success bg-opacity-10 p-3 me-3">
                                <i class="bi bi-cash-stack text-success fs-4"></i>
                            </div>

                            <div>

                                <small class="text-muted d-block">
                                    Total comprado
                                </small>

                                <h4 class="fw-bold mb-0">
                                    ${{ number_format($total ?? 0, 0, ',', '.') }}
                                </h4>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-md-3">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body">

                        <div class="d-flex align-items-center">

                            <div class="rounded-circle bg-warning bg-opacity-10 p-3 me-3">
                                <i class="bi bi-hourglass-split text-warning fs-4"></i>
                            </div>

                            <div>

                                <small class="text-muted d-block">
                                    Saldo pendiente
                                </small>

                                <h4 class="fw-bold mb-0">
                                    ${{ number_format($balance ?? 0, 0, ',', '.') }}
                                </h4>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-md-3">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body">

                        <div class="d-flex align-items-center">

                            <div class="rounded-circle bg-info bg-opacity-10 p-3 me-3">
                                <i class="bi bi-receipt text-info fs-4"></i>
                            </div>

                            <div>

                                <small class="text-muted d-block">
                                    Promedio por compra
                                </small>

                                <h4 class="fw-bold mb-0">
                                    ${{ number_format($quantity > 0 ? $total / $quantity : 0, 0, ',', '.') }}
                                </h4>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white py-3">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <h5 class="fw-bold mb-1">
                            Compras realizadas
                        </h5>

                        @if (request('fecha_desde') || request('fecha_hasta'))
                            <small class="text-muted">

                                Periodo:

                                {{ request('fecha_desde') ? \Carbon\Carbon::parse(request('fecha_desde'))->format('d/m/Y') : 'Inicio' }}

                                -

                                {{ request('fecha_hasta') ? \Carbon\Carbon::parse(request('fecha_hasta'))->format('d/m/Y') : 'Actualidad' }}

                            </small>
                        @endif

                    </div>

                    <span class="badge bg-primary">
                        {{ number_format($quantity ?? 0, 0, ',', '.') }} compras
                    </span>

                </div>

            </div>

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">

                            <tr>

                                <th class="text-center">#</th>
                                <th>Fecha</th>
                                <th>Factura</th>
                                <th>Proveedor</th>
                                <th>Tipo</th>
                                <th class="text-end">Subtotal</th>
                                <th class="text-end">IVA</th>
                                <th class="text-end">Total</th>
                                <th class="text-end">Saldo</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($purchases as $index => $purchase)

                                <tr>

                                    <td class="text-center">
                                        {{ $purchases->firstItem() + $index }}
                                    </td>

                                    <td>
                                        <span class="fw-semibold">
                                            {{ \Carbon\Carbon::parse($purchase->shopping_date)->format('d/m/Y') }}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="fw-semibold">
                                            {{ $purchase->invoice_number }}
                                        </span>
                                    </td>

                                    <td>

                                        @if ($purchase->supplier)
                                            <div class="fw-semibold">
                                                {{ $purchase->supplier->full_name }}
                                            </div>

                                            @if ($purchase->supplier->identification_card)
                                                <small class="text-muted">
                                                    {{ $purchase->supplier->identification_card }}
                                                </small>
                                            @endif
                                        @else
                                            <span class="text-muted">
                                                Sin proveedor
                                            </span>
                                        @endif

                                    </td>

                                    <td>

                                        @php
                                            $purchaseType = strtolower($purchase->purchase_type ?? '');

                                            $typeClass = match ($purchaseType) {
                                                'contado' => 'success',
                                                'credito', 'crédito' => 'warning',
                                                default => 'secondary',
                                            };
                                        @endphp

                                        <span class="badge bg-{{ $typeClass }}">
                                            {{ $purchase->purchase_type ?? 'N/A' }}
                                        </span>

                                    </td>

                                    <td class="text-end">
                                        ${{ number_format($purchase->subtotal ?? 0, 0, ',', '.') }}
                                    </td>

                                    <td class="text-end">
                                        ${{ number_format($purchase->iva ?? 0, 0, ',', '.') }}
                                    </td>

                                    <td class="text-end fw-bold">
                                        ${{ number_format($purchase->total ?? 0, 0, ',', '.') }}
                                    </td>

                                    <td class="text-end">

                                        @if (($purchase->balance ?? 0) > 0)
                                            <span class="text-danger fw-semibold">
                                                ${{ number_format($purchase->balance, 0, ',', '.') }}
                                            </span>
                                        @else
                                            <span class="text-success">
                                                $0
                                            </span>
                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="9" class="text-center py-5">

                                        <i class="bi bi-cart-x text-muted fs-1"></i>

                                        <h5 class="mt-3 mb-1">
                                            No hay compras
                                        </h5>

                                        <p class="text-muted mb-0">
                                            No se encontraron compras para el periodo seleccionado.
                                        </p>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                        @if ($purchases->count() > 0)
                            <tfoot class="table-light">

                                <tr>

                                    <th colspan="5" class="text-end">
                                        Totales:
                                    </th>

                                    <th class="text-end">
                                        ${{ number_format($subtotal ?? 0, 0, ',', '.') }}
                                    </th>

                                    <th class="text-end">
                                        ${{ number_format($iva ?? 0, 0, ',', '.') }}
                                    </th>

                                    <th class="text-end">
                                        ${{ number_format($total ?? 0, 0, ',', '.') }}
                                    </th>

                                    <th class="text-end">
                                        ${{ number_format($balance ?? 0, 0, ',', '.') }}
                                    </th>

                                </tr>

                            </tfoot>
                        @endif

                    </table>

                </div>

            </div>

            @if ($purchases->hasPages())
                <div class="card-footer bg-white">

                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                        <div class="text-muted small">

                            Mostrando
                            <strong>{{ $purchases->firstItem() }}</strong>
                            -
                            <strong>{{ $purchases->lastItem() }}</strong>
                            de
                            <strong>{{ $purchases->total() }}</strong>
                            compras

                        </div>

                        <div>
                            {{ $purchases->withQueryString()->links() }}
                        </div>

                    </div>

                </div>
            @endif

        </div>

    </div>
@endsection
