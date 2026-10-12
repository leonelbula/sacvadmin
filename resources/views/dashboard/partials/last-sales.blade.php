<div class="dashboard-card">

    <div class="card-header-custom">

        <div>
            <h5>Últimas Ventas</h5>
            <small class="text-muted">
                Últimas transacciones registradas
            </small>
        </div>
        @can('sale.view')
            <a href="{{ route('sale.index') }}" class="btn btn-primary btn-sm">
                Ver Todas
            </a>
        @endcan


    </div>

    <div class="table-responsive">

        <table class="table sales-table align-middle">

            <thead>

                <tr>

                    <th>Factura</th>
                    <th>Cliente</th>
                    <th>Total</th>

                    <th>Fecha</th>

                </tr>

            </thead>

            <tbody>

                @foreach ($lisSale as $sale)
                    <tr>
                        <td>{{ $sale->sale_number }}</td>
                        <td>{{ $sale->customer->full_name }}</td>
                        <td>{{ $sale->total }}</td>
                        <td>
                            <span class="payment {{ $sale->id }}">
                                {{ ucfirst($sale->id) }}
                            </span>
                        </td>

                    </tr>
                @endforeach

            </tbody>

        </table>

    </div>

</div>
