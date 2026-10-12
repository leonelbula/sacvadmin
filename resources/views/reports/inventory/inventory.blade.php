@extends('layouts.app')

@section('title', 'Estado del Inventario')

@section('content')

    <div class="container-fluid py-4 mt-4">

        {{-- ENCABEZADO --}}

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h4 class="mb-1">
                    <i class="bi bi-clipboard-data"></i>
                    Estado del Inventario
                </h4>

                <p class="text-muted mb-0">
                    Consulta el estado actual de las existencias
                </p>
            </div>

            <div>

                <a href="{{ url()->previous() }}" class="btn btn-secondary">

                    <i class="bi bi-arrow-left"></i>
                    Volver

                </a>

            </div>

        </div>


        {{-- TARJETAS DE ESTADO --}}

        <div class="row g-3 mb-4">

            <div class="col-md-6 col-xl-3">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <span class="text-muted">
                                    Total productos
                                </span>

                                <h3 class="fw-bold mt-2 mb-0">
                                    {{ number_format($quantity ?? 0, 0, ',', '.') }}
                                </h3>

                            </div>

                            <div class="fs-1 text-primary">

                                <i class="bi bi-box-seam"></i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <div class="col-md-6 col-xl-3">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <span class="text-muted">
                                    Stock normal
                                </span>

                                <h3 class="fw-bold mt-2 mb-0 text-success">
                                    {{ number_format($normal ?? 0, 0, ',', '.') }}
                                </h3>

                            </div>

                            <div class="fs-1 text-success">

                                <i class="bi bi-check-circle"></i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <div class="col-md-6 col-xl-3">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <span class="text-muted">
                                    Stock bajo
                                </span>

                                <h3 class="fw-bold mt-2 mb-0 text-warning">
                                    {{ number_format($lowStock ?? 0, 0, ',', '.') }}
                                </h3>

                            </div>

                            <div class="fs-1 text-warning">

                                <i class="bi bi-exclamation-triangle"></i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <div class="col-md-6 col-xl-3">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <span class="text-muted">
                                    Agotados
                                </span>

                                <h3 class="fw-bold mt-2 mb-0 text-danger">
                                    {{ number_format($outOfStock ?? 0, 0, ',', '.') }}
                                </h3>

                            </div>

                            <div class="fs-1 text-danger">

                                <i class="bi bi-x-circle"></i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- TABLA --}}

        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white py-3">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <h5 class="mb-0">
                            Estado de productos
                        </h5>

                        <small class="text-muted">
                            Existencias actuales y niveles mínimos
                        </small>

                    </div>

                    <span class="badge bg-primary">

                        {{ number_format($quantity ?? 0, 0, ',', '.') }}
                        productos

                    </span>

                </div>

            </div>


            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">

                            <tr>

                                <th class="text-center">
                                    #
                                </th>

                                <th>
                                    Código
                                </th>

                                <th>
                                    Producto
                                </th>

                                <th class="text-center">
                                    Stock actual
                                </th>

                                <th class="text-center">
                                    Stock mínimo
                                </th>

                                <th class="text-center">
                                    Diferencia
                                </th>

                                <th class="text-center">
                                    Estado
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($products as $index => $product)
                                @php

                                    $stock = (int) ($product->stock ?? 0);

                                    $stockMin = (int) ($product->stock_min ?? 0);

                                    $difference = $stock - $stockMin;

                                    if ($stock <= 0) {
                                        $status = 'Agotado';

                                        $badge = 'danger';

                                        $icon = 'x-circle';
                                    } elseif ($stock <= $stockMin) {
                                        $status = 'Stock bajo';

                                        $badge = 'warning';

                                        $icon = 'exclamation-triangle';
                                    } else {
                                        $status = 'Normal';

                                        $badge = 'success';

                                        $icon = 'check-circle';
                                    }

                                @endphp


                                <tr>

                                    <td class="text-center">

                                        {{ $products->firstItem() + $index }}

                                    </td>


                                    <td>

                                        <span class="badge bg-light text-dark">

                                            {{ $product->code }}

                                        </span>

                                    </td>


                                    <td class="fw-semibold">

                                        {{ $product->name }}

                                    </td>


                                    <td class="text-center">

                                        <span class="fw-bold">

                                            {{ number_format($stock, 0, ',', '.') }}

                                        </span>

                                    </td>


                                    <td class="text-center">

                                        {{ number_format($stockMin, 0, ',', '.') }}

                                    </td>


                                    <td class="text-center">

                                        @if ($difference < 0)
                                            <span class="text-danger fw-bold">

                                                {{ number_format($difference, 0, ',', '.') }}

                                            </span>
                                        @elseif($difference == 0)
                                            <span class="text-warning fw-bold">

                                                0

                                            </span>
                                        @else
                                            <span class="text-success fw-bold">

                                                +{{ number_format($difference, 0, ',', '.') }}

                                            </span>
                                        @endif

                                    </td>


                                    <td class="text-center">

                                        <span class="badge bg-{{ $badge }}">

                                            <i class="bi bi-{{ $icon }}"></i>

                                            {{ $status }}

                                        </span>

                                    </td>

                                </tr>


                            @empty

                                <tr>

                                    <td colspan="7" class="text-center py-5">

                                        <i class="bi bi-box-seam fs-1 text-muted"></i>

                                        <p class="text-muted mt-2 mb-0">

                                            No existen productos registrados.

                                        </p>

                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>


            {{-- PAGINACIÓN --}}

            @if ($products->hasPages())
                <div class="card-footer bg-white">

                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

                        <div class="text-muted">

                            Mostrando

                            {{ $products->firstItem() }}

                            -

                            {{ $products->lastItem() }}

                            de

                            {{ $products->total() }}

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
