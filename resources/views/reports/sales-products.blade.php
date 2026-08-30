@extends('layouts.app')

@section('title', 'Productos Vendidos')

@section('content')

    <div class="container-fluid py-4 mt-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h3 class="fw-bold">
                    <i class="bi bi-box-seam me-2"></i>
                    Productos Vendidos
                </h3>

                <p class="text-muted">
                    Productos con mayor cantidad de ventas.
                </p>
            </div>

            <a href="{{ route('reports.sales.products.pdf') }}" target="_blank" class="btn btn-danger rounded-3">

                <i class="bi bi-file-earmark-pdf me-2"></i>
                PDF

            </a>

        </div>


        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead class="table-light">

                            <tr>
                                <th>#</th>
                                <th>Código</th>
                                <th>Producto</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-end">Total</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($products as $item)
                                <tr>

                                    <td>{{ $loop->iteration }}</td>

                                    <td>
                                        {{ $item->product->code ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $item->product->name ?? 'Producto eliminado' }}
                                    </td>

                                    <td class="text-center">
                                        {{ $item->quantity }}
                                    </td>

                                    <td class="text-end fw-semibold">

                                        $
                                        {{ number_format($item->total ?? 0, 0, ',', '.') }}

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="5" class="text-center text-muted py-5">

                                        No hay productos vendidos.

                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                        <tfoot>

                            <tr class="fw-bold">

                                <td colspan="4" class="text-end">

                                    TOTAL

                                </td>

                                <td class="text-end">

                                    $
                                    {{ number_format($total ?? 0, 0, ',', '.') }}

                                </td>

                            </tr>

                        </tfoot>

                    </table>

                </div>

            </div>

        </div>

    </div>

@endsection
