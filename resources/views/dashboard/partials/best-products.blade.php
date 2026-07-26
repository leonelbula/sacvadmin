<div class="dashboard-card">

    <div class="card-header-custom">

        <div>

            <h5>Productos Más Vendidos</h5>

            <small class="text-muted">
                Top 5 del mes
            </small>

        </div>

    </div>

    <div class="card-body">

        @php

            $products = [
                ['Laptop Dell', 92],

                ['Mouse Logitech', 81],

                ['Monitor LG', 73],

                ['Teclado Mecánico', 64],

                ['Impresora Epson', 58],
            ];

        @endphp

        @foreach ($products as $product)
            <div class="mb-4">

                <div class="d-flex justify-content-between mb-2">

                    <span>{{ $product[0] }}</span>

                    <strong>{{ $product[1] }}%</strong>

                </div>

                <div class="progress modern-progress">

                    <div class="progress-bar" style="width:{{ $product[1] }}%">
                    </div>

                </div>

            </div>
        @endforeach

    </div>

</div>
