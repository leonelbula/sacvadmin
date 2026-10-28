@extends('layouts.app')

@section('title', 'Reporte de Kardex')

@section('content')
    <div class="container-fluid py-4 mt-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1">
                    <i class="bi bi-arrow-left-right me-2"></i>
                    Reporte de Kardex
                </h4>

                <p class="text-muted mb-0">
                    Consulta los movimientos y existencias de los productos.
                </p>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('reports.inventory.kardex.pdf', request()->query()) }}" class="btn btn-danger"
                    target="_blank">
                    <i class="bi bi-file-earmark-pdf me-1"></i>
                    PDF
                </a>

                <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary">
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

                <form method="GET" action="{{ route('reports.inventory.kardex') }}">

                    <div class="row g-3">

                        <div class="col-md-4">
                            <label for="product_id" class="form-label fw-semibold">
                                Producto
                            </label>

                            <select name="product_id" id="product_id" class="form-select">

                                <option value="">
                                    Todos los productos
                                </option>

                                @foreach ($productList ?? [] as $product)
                                    <option value="{{ $product->id }}" @selected(request('product_id') == $product->id)>
                                        {{ $product->code }} - {{ $product->name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="fecha_desde" class="form-label fw-semibold">
                                Fecha desde
                            </label>

                            <input type="date" name="fecha_desde" id="fecha_desde" class="form-control"
                                value="{{ request('fecha_desde') }}">
                        </div>

                        <div class="col-md-3">
                            <label for="fecha_hasta" class="form-label fw-semibold">
                                Fecha hasta
                            </label>

                            <input type="date" name="fecha_hasta" id="fecha_hasta" class="form-control"
                                value="{{ request('fecha_hasta') }}">
                        </div>

                        <div class="col-md-2 d-flex align-items-end">

                            <div class="d-flex gap-2 w-100">

                                <button type="submit" class="btn btn-primary flex-grow-1">
                                    <i class="bi bi-search me-1"></i>
                                    Buscar
                                </button>

                                <a href="{{ route('reports.inventory.kardex') }}" class="btn btn-outline-secondary"
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
                                <i class="bi bi-list-check text-primary fs-4"></i>
                            </div>

                            <div>
                                <small class="text-muted d-block">
                                    Movimientos
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
                                <i class="bi bi-box-arrow-in-down text-success fs-4"></i>
                            </div>

                            <div>
                                <small class="text-muted d-block">
                                    Entradas
                                </small>

                                <h4 class="fw-bold mb-0 text-success">
                                    {{ number_format($income ?? 0, 0, ',', '.') }}
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

                            <div class="rounded-circle bg-danger bg-opacity-10 p-3 me-3">
                                <i class="bi bi-box-arrow-up text-danger fs-4"></i>
                            </div>

                            <div>
                                <small class="text-muted d-block">
                                    Salidas
                                </small>

                                <h4 class="fw-bold mb-0 text-danger">
                                    {{ number_format($output ?? 0, 0, ',', '.') }}
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
                                <i class="bi bi-boxes text-info fs-4"></i>
                            </div>

                            <div>
                                <small class="text-muted d-block">
                                    Existencia actual
                                </small>

                                <h4 class="fw-bold mb-0">
                                    {{ number_format($currentStock ?? 0, 0, ',', '.') }}
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
                            Movimientos de inventario
                        </h5>

                        @if (request('fecha_desde') || request('fecha_hasta'))
                            <small class="text-muted">
                                Periodo:
                                {{ request('fecha_desde') ?: 'Inicio' }}
                                -
                                {{ request('fecha_hasta') ?: 'Actualidad' }}
                            </small>
                        @endif
                    </div>

                    @if (request('product_id'))
                        <span class="badge bg-primary">
                            Producto filtrado
                        </span>
                    @endif

                </div>

            </div>

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">

                            <tr>
                                <th class="text-center">#</th>
                                <th>Fecha</th>
                                <th>Producto</th>
                                <th>Movimiento</th>
                                <th>Origen</th>
                                <th class="text-center">Referencia</th>
                                <th class="text-center">Entrada</th>
                                <th class="text-center">Salida</th>
                                <th class="text-center">Saldo anterior</th>
                                <th class="text-center">Saldo actual</th>
                                <th class="text-end">Costo unitario</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($kardex as $index => $movement)
                                @php
                                    $income = (int) ($movement->income ?? 0);
                                    $output = (int) ($movement->output ?? 0);

                                    $movementType = strtolower($movement->movement_type ?? '');

                                    if ($income > 0) {
                                        $movementBadge = 'success';
                                        $movementIcon = 'arrow-down-circle';
                                        $movementLabel = 'Entrada';
                                    } elseif ($output > 0) {
                                        $movementBadge = 'danger';
                                        $movementIcon = 'arrow-up-circle';
                                        $movementLabel = 'Salida';
                                    } else {
                                        $movementBadge = 'secondary';
                                        $movementIcon = 'dash-circle';
                                        $movementLabel = ucfirst($movementType ?: 'Movimiento');
                                    }
                                @endphp

                                <tr>

                                    <td class="text-center">
                                        {{ $kardex->firstItem() + $index }}
                                    </td>

                                    <td>
                                        <div class="fw-semibold">
                                            {{ \Carbon\Carbon::parse($movement->date)->format('d/m/Y') }}
                                        </div>

                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($movement->date)->format('H:i') }}
                                        </small>
                                    </td>

                                    <td>
                                        <div class="fw-semibold">
                                            {{ $movement->product->name ?? 'Producto eliminado' }}
                                        </div>

                                        @if (isset($movement->product->code))
                                            <small class="text-muted">
                                                {{ $movement->product->code }}
                                            </small>
                                        @endif
                                    </td>

                                    <td>
                                        <span class="badge bg-{{ $movementBadge }}">
                                            <i class="bi bi-{{ $movementIcon }} me-1"></i>
                                            {{ $movementLabel }}
                                        </span>
                                    </td>

                                    <td>
                                        {{ $movement->origin ?? 'N/A' }}
                                    </td>

                                    <td class="text-center">
                                        {{ $movement->reference_id ?? '-' }}
                                    </td>

                                    <td class="text-center">
                                        @if ($income > 0)
                                            <span class="fw-bold text-success">
                                                +{{ number_format($income, 0, ',', '.') }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        @if ($output > 0)
                                            <span class="fw-bold text-danger">
                                                -{{ number_format($output, 0, ',', '.') }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        {{ number_format($movement->stock_before ?? 0, 0, ',', '.') }}
                                    </td>

                                    <td class="text-center">
                                        <span class="fw-bold">
                                            {{ number_format($movement->stock_after ?? 0, 0, ',', '.') }}
                                        </span>
                                    </td>

                                    <td class="text-end">
                                        ${{ number_format($movement->unit_cost ?? 0, 0, ',', '.') }}
                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="11" class="text-center py-5">

                                        <i class="bi bi-inbox text-muted fs-1"></i>

                                        <h5 class="mt-3 mb-1">
                                            No hay movimientos
                                        </h5>

                                        <p class="text-muted mb-0">
                                            No se encontraron movimientos de inventario
                                            con los filtros seleccionados.
                                        </p>

                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                        @if ($kardex->count() > 0)
                            <tfoot class="table-light">

                                <tr>

                                    <th colspan="6" class="text-end">
                                        Totales:
                                    </th>

                                    <th class="text-center text-success">
                                        {{ number_format($income ?? 0, 0, ',', '.') }}
                                    </th>

                                    <th class="text-center text-danger">
                                        {{ number_format($output ?? 0, 0, ',', '.') }}
                                    </th>

                                    <th colspan="3"></th>

                                </tr>

                            </tfoot>
                        @endif

                    </table>

                </div>

            </div>

            @if ($kardex->hasPages())
                <div class="card-footer bg-white">

                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                        <div class="text-muted small">
                            Mostrando
                            <strong>{{ $kardex->firstItem() }}</strong>
                            -
                            <strong>{{ $kardex->lastItem() }}</strong>
                            de
                            <strong>{{ $kardex->total() }}</strong>
                            movimientos
                        </div>

                        <div>
                            {{ $kardex->withQueryString()->links() }}
                        </div>

                    </div>

                </div>
            @endif

        </div>

    </div>
@endsection
