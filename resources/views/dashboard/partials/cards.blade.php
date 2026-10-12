<div class="row g-4">
    <!-- Ventas -->

    @can('sale.view')
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="kpi-card sales">
                <div class="kpi-icon">
                    <i class="bi bi-currency-dollar"></i>
                </div>

                <div class="kpi-body">
                    <span class="kpi-title">Ventas Hoy</span>

                    <h3>${{ number_format($sales['total'], 0, ',', '.') }}</h3>

                    <small class="text-success">
                        <i class="bi bi-arrow-up"></i>

                    </small>
                </div>
            </div>
        </div>
    @endcan


    @can('shopping.view')
        <!-- Compras -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="kpi-card purchase">
                <div class="kpi-icon">
                    <i class="bi bi-cart-check"></i>
                </div>

                <div class="kpi-body">
                    <span class="kpi-title">Compras</span>

                    <h3>${{ number_format($totalShoppig, 0, ',', '.') }}</h3>

                    <small class="text-danger">
                        <i class="bi bi-arrow-down"></i>
                       
                    </small>
                </div>
            </div>
        </div>
    @endcan

    @can('product.view')
        <!-- Productos -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="kpi-card inventory">
                <div class="kpi-icon">
                    <i class="bi bi-box-seam"></i>
                </div>

                <div class="kpi-body">
                    <span class="kpi-title">Productos</span>

                    <h3>{{$countProducts}}</h3>

                    <small class="text-primary">
                        Inventario activo
                    </small>
                </div>
            </div>
        </div>
    @endcan

    @can('customer.view')
        <!-- Clientes -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="kpi-card customers">
                <div class="kpi-icon">
                    <i class="bi bi-people-fill"></i>
                </div>

                <div class="kpi-body">
                    <span class="kpi-title">Clientes</span>

                    <h3>{{$countCustomers}}</h3>

                </div>
            </div>
        </div>
    @endcan



</div>
