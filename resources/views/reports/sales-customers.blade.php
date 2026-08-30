@extends('layouts.app')

@section('title', 'Ventas por Cliente')

@section('content')

    <div class="container-fluid py-4 mt-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h3 class="fw-bold">
                    <i class="bi bi-people me-2"></i>
                    Ventas por Cliente
                </h3>

                <p class="text-muted">
                    Clientes con mayor volumen de compras.
                </p>
            </div>

            <a href="{{ route('reports.sales.customers.pdf') }}" target="_blank" class="btn btn-danger">

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
                                <th>Cliente</th>
                                <th class="text-center">Ventas</th>
                                <th class="text-end">Total comprado</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($customers as $item)
                                <tr>

                                    <td>
                                        {{ $loop->iteration }}
                                    </td>

                                    <td>
                                        {{ $item->customer->full_name ?? 'Cliente eliminado' }}
                                    </td>

                                    <td class="text-center">
                                        {{ $item->sales ?? 0 }}
                                    </td>

                                    <td class="text-end fw-semibold">

                                        $
                                        {{ number_format($item->total ?? 0, 0, ',', '.') }}

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="4" class="text-center text-muted py-5">

                                        No hay información disponible.

                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

@endsection
