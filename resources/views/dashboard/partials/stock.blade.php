@can('product.view')
<div class="dashboard-card">

    <div class="card-header-custom">

        <div>

            <h5>Bajo Stock</h5>

            <small class="text-muted">

                Productos por reabastecer

            </small>

        </div>

    </div>

    <div class="stock-list">

        @foreach ($LowStockProduct as $product)
            <div class="stock-item">

                <div>

                    <strong>{{ $product->name }}</strong>

                    <div class="text-muted">

                        Stock actual

                    </div>

                </div>

                <span class="stock-badge">

                    {{ $product->stock }}

                </span>

            </div>
        @endforeach

    </div>

</div>
@endcan

