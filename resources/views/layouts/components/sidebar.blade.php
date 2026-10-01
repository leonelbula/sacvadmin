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



        <!-- ventas -->
        @can('sale.view')
            <div class="menu-group">
                <button class="menu-item menu-toggle-item">
                    <i class="bi bi-cart"></i>
                    <span>
                        Ventas
                    </span>
                    <i class="bi bi-chevron-down arrow"></i>
                </button>
                <div class="submenu">
                    @can('sale.view')
                        <a href="{{ route('sale.index') }}">
                            <i class="bi bi-receipt"></i>
                            Ventas
                        </a>
                    @endcan

                    @can('salereturn.view')
                        <a href="{{ route('salereturn.index') }}">
                            <i class="bi bi-arrow-return-left"></i>
                            Devoluciones
                        </a>
                    @endcan
                    @can('pos.view')
                        <a href="{{ route('pos.index') }}">
                            <i class="bi bi-shop"></i>
                            Punto de Venta
                        </a>
                    @endcan

                </div>
            </div>
        @endcan

        <!-- Inventario -->

        @can('product.view')
            <div class="menu-group">
                <button class="menu-item menu-toggle-item">
                    <i class="bi bi-box-seam"></i>
                    <span>
                        Inventario
                    </span>
                    <i class="bi bi-chevron-down arrow"></i>
                </button>
                <div class="submenu">
                    @can('product.view')
                        <a href="{{ route('product.index') }}">
                            Productos
                        </a>
                    @endcan
                    @can('category.view')
                        <a href="{{ route('category.index') }}">
                            Categorías
                        </a>
                    @endcan

                    <a href="{{ route('inventory.adjustments.index') }}">
                        Ajustes Inventario
                    </a>
                    @can('kardex.view')
                        <a href="{{ route('kardex.index') }}">
                            Kardex
                        </a>
                    @endcan

                </div>


            </div>
        @endcan



        @can('customer.view')
            <a href="{{ route('customer.index') }}" class="menu-item">

                <i class="bi bi-people"></i>

                <span>
                    Clientes
                </span>

            </a>
        @endcan


        @can('supplier.view')
            <a href="{{ route('supplier.index') }}" class="menu-item">

                <i class="bi bi-truck"></i>

                <span>
                    Proveedores
                </span>

            </a>
        @endcan


        @can('shopping.view')
            <div class="menu-group">
                <button class="menu-item menu-toggle-item">
                    <i class="bi bi-box-seam"></i>
                    <span>
                        Compras
                    </span>
                    <i class="bi bi-chevron-down arrow"></i>
                </button>
                <div class="submenu">
                    <a href="{{ route('shopping.index') }}">
                        listas de compras
                    </a>
                </div>
            </div>
        @endcan

        @can('expense.view')
            <div class="menu-group">


                <button class="menu-item menu-toggle-item">


                    <i class="bi bi-cash-stack me-2"></i>


                    <span>
                        Gastos
                    </span>


                    <i class="bi bi-chevron-down arrow"></i>


                </button>


                <div class="submenu">

                    <a href="{{ route('expense.index') }}">
                        Lista de Gastos
                    </a>

                </div>


            </div>
        @endcan


        @can('report.view')
            <a href="{{ route('reports.index') }}" class="menu-item">

                <i class="bi bi-bar-chart"></i>

                <span>
                    Reportes
                </span>

            </a>
        @endcan

        @can('user.view')
            <a href="{{ route('user.index') }}" class="menu-item">

                <i class="bi bi-people"></i>

                <span>
                    Usuarios
                </span>

            </a>
        @endcan

        @can('role.view')
            <a href="{{ route('role.index') }}" class="menu-item">

                <i class="bi bi-lock"></i>

                <span>
                    Roles
                </span>

            </a>
        @endcan


        <a href="#" class="menu-item">

            <i class="bi bi-gear"></i>

            <span>
                Configuración
            </span>

        </a>


    </nav>


</aside>
