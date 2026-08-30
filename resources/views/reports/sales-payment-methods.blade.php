@extends('layouts.app')

@section('title', 'Ventas por Método de Pago')

@section('content')

    <div class="container-fluid py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h3 class="fw-bold">
                    <i class="bi bi-credit-card me-2"></i>
                    Ventas por Método de Pago
                </h3>

                <p class="text-muted">
                    Distribución de las ventas según el método de pago.
                </p>
            </div>

            <a href="{{ route('reports.sales.payment-methods.pdf') }}" target="_blank" class="btn btn-danger">

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
                                <th>Método de pago</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-end">Total</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($payments as $payment)
                                <tr>

                                    <td>
                                        {{ $loop->iteration }}
                                    </td>

                                    <td>
                                        {{ $payment->name ?? '-' }}
                                    </td>

                                    <td class="text-center">
                                        {{ $payment->quantity ?? 0 }}
                                    </td>

                                    <td class="text-end fw-semibold">

                                        $
                                        {{ number_format($payment->total ?? 0, 0, ',', '.') }}

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

                        <tfoot>

                            <tr class="fw-bold">

                                <td colspan="3" class="text-end">

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
