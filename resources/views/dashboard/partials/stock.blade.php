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

        @foreach ([['Mouse Logitech', 2], ['Monitor LG', 3], ['Teclado Gamer', 4], ['Memoria USB', 1], ['Impresora Epson', 5]] as $product)
            <div class="stock-item">

                <div>

                    <strong>{{ $product[0] }}</strong>

                    <div class="text-muted">

                        Stock actual

                    </div>

                </div>

                <span class="stock-badge">

                    {{ $product[1] }}

                </span>

            </div>
        @endforeach

    </div>

</div>
