<aside class="sidebar" id="sidebar">

    <div class="sidebar-header">

        <a href="#" class="brand">

            <div class="brand-icon">
                <i class="bi bi-shop"></i>
            </div>

            <div class="brand-text">

                <h5>SACVAdmin</h5>

            </div>

        </a>

    </div>



    <nav class="sidebar-menu">


        <a href="#" class="menu-item active">

            <i class="bi bi-grid"></i>

            <span>
                Dashboard
            </span>

        </a>



        <!-- Ventas -->

        <div class="menu-group">


            <button class="menu-item menu-toggle-item">

                <i class="bi bi-cart"></i>

                <span>
                    Ventas
                </span>

                <i class="bi bi-chevron-down arrow"></i>

            </button>


            <div class="submenu">


                <a href="{{route('sale.index')}}">
                    <i class="bi bi-receipt"></i>
                    Facturas
                </a>


                <a href="#">
                    <i class="bi bi-arrow-return-left"></i>
                    Devoluciones
                </a>


                <a href="#">
                    <i class="bi bi-shop"></i>
                    Punto de Venta
                </a>


            </div>


        </div>



        <!-- Inventario -->


        <div class="menu-group">


            <button class="menu-item menu-toggle-item">


                <i class="bi bi-box-seam"></i>


                <span>
                    Inventario
                </span>


                <i class="bi bi-chevron-down arrow"></i>


            </button>


            <div class="submenu">


                <a href="{{ route('product.index') }}">
                    Productos
                </a>


                <a href="{{ route('category.index') }}">
                    Categorías
                </a>


                <a href="{{ route('kardex.index') }}">
                    Kardex
                </a>


            </div>


        </div>



        <a href="{{route('customer.index')}}" class="menu-item">

            <i class="bi bi-people"></i>

            <span>
                Clientes
            </span>

        </a>



        <a href="#" class="menu-item">

            <i class="bi bi-truck"></i>

            <span>
                Proveedores
            </span>

        </a>



        <a href="#" class="menu-item">

            <i class="bi bi-bar-chart"></i>

            <span>
                Reportes
            </span>

        </a>



        <a href="#" class="menu-item">

            <i class="bi bi-gear"></i>

            <span>
                Configuración
            </span>

        </a>


    </nav>


</aside>
