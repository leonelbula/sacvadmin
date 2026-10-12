@extends('layouts.app')

@section('title', 'Stock Bajo')

@section('content')
    <div class="container-fluid py-4 mt-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Productos con Stock Bajo
                </h4>
                <p class="text-muted mb-0">
                    Productos que requieren reposición de inventario.
                </p>
            </div>

            <div>
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Volver
                </a>
            </div>
        </div>

        <div class="row g-3 mb-4">

            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-warning bg-opacity-10 p-3 me-3">
                                <i class="bi bi-exclamation-triangle text-warning fs-4"></i>
                            </div>

                            <div>
                                <small class="text-muted d-block">
                                    Productos con stock bajo
                                </small>

                                <h4 class="fw-bold mb-0">
                                    {{ $quantity ?? 0 }}
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-danger bg-opacity-10 p-3 me-3">
                                <i class="bi bi-box-seam text-danger fs-4"></i>
                            </div>

                            <div>
                                <small class="text-muted d-block">
                                    Unidades disponibles
                                </small>

                                <h4 class="fw-bold mb-0">
                                    {{ number_format($stock ?? 0, 0, ',', '.') }}
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-info bg-opacity-10 p-3 me-3">
                                <i class="bi bi-arrow-repeat text-info fs-4"></i>
                            </div>

                            <div>
                                <small class="text-muted d-block">
                                    Unidades necesarias
                                </small>

                                <h4 class="fw-bold mb-0">
                                    {{ number_format($needed ?? 0, 0, ',', '.') }}
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
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-boxes me-2"></i>
                        Listado de productos
                    </h5>

                    <span class="badge bg-warning text-dark">
                        {{ $quantity ?? 0 }} productos
                    </span>
                </div>
            </div>

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">
                            <tr>
                                <th class="text-center">#</th>
                                <th>Código</th>
                                <th>Producto</th>
                                <th class="text-center">Stock actual</th>
                                <th class="text-center">Stock mínimo</th>
                                <th class="text-center">Faltante</th>
                                <th class="text-center">Estado</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($products as $index => $product)
                                @php
                                    $stock = (int) ($product->stock ?? 0);
                                    $stockMin = (int) ($product->stock_min ?? 0);
                                    $needed = max($stockMin - $stock, 0);

                                    if ($stock <= 0) {
                                        $badge = 'danger';
                                        $icon = 'x-circle';
                                        $status = 'Agotado';
                                    } else {
                                        $badge = 'warning';
                                        $icon = 'exclamation-triangle';
                                        $status = 'Stock bajo';
                                    }
                                @endphp

                                <tr>

                                    <td class="text-center">
                                        {{ $products->firstItem() + $index }}
                                    </td>

                                    <td>
                                        <span class="fw-semibold">
                                            {{ $product->code }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="fw-semibold">
                                            {{ $product->name }}
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <span class="fw-bold text-{{ $badge }}">
                                            {{ number_format($stock, 0, ',', '.') }}
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        {{ number_format($stockMin, 0, ',', '.') }}
                                    </td>

                                    <td class="text-center">
                                        @if ($needed > 0)
                                            <span class="fw-bold text-danger">
                                                {{ number_format($needed, 0, ',', '.') }}
                                            </span>
                                        @else
                                            <span class="text-muted">0</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <span class="badge bg-{{ $badge }}">
                                            <i class="bi bi-{{ $icon }} me-1"></i>
                                            {{ $status }}
                                        </span>
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="7" class="text-center py-5">

                                        <i class="bi bi-check-circle text-success fs-1"></i>

                                        <h5 class="mt-3 mb-1">
                                            Inventario en buen estado
                                        </h5>

                                        <p class="text-muted mb-0">
                                            No existen productos con stock bajo.
                                        </p>

                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

            @if ($products->hasPages())
                <div class="card-footer bg-white">

                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                        <div class="text-muted small">
                            Mostrando
                            <strong>{{ $products->firstItem() }}</strong>
                            -
                            <strong>{{ $products->lastItem() }}</strong>
                            de
                            <strong>{{ $products->total() }}</strong>
                            productos
                        </div>

                        <div>
                            {{ $products->links() }}
                        </div>

                    </div>

                </div>
            @endif

        </div>

    </div>
@endsection
