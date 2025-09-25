 <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
     <!--begin::Sidebar Brand-->
     <div class="sidebar-brand">
         <!--begin::Brand Link-->
         <a href="./index.html" class="brand-link">
             <!--begin::Brand Image-->

             <!--end::Brand Image-->
             <!--begin::Brand Text-->
             <span class="brand-text fw-light">SACVADMIN</span>
             <!--end::Brand Text-->
         </a>
         <!--end::Brand Link-->
     </div>
     <!--end::Sidebar Brand-->
     <!--begin::Sidebar Wrapper-->
     <div class="sidebar-wrapper">
         <nav class="mt-2">
             <!--begin::Sidebar Menu-->
             <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                 <li class="nav-item menu-open">
                     <a href="{{ route('dashboard') }}" class="nav-link ">
                         <i class="nav-icon bi bi-speedometer"></i>
                         <p>
                             INICIO

                         </p>
                     </a>
                 </li>
                 @if (Auth::user()->type == 'vendor')
                     <li class="nav-item">
                         <a href="#" class="nav-link">
                             <i class="nav-icon bi bi-box-seam-fill"></i>
                             <p>
                                 INVENTARIO
                                 <i class="nav-arrow bi bi-chevron-right"></i>
                             </p>
                         </a>
                         <ul class="nav nav-treeview">
                             <li class="nav-item">
                                 <a href="{{ route('category.index') }}" class="nav-link">
                                     <i class="nav-icon bi bi-circle"></i>
                                     <p>CATEGORIAS</p>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="{{ route('product.index') }}" class="nav-link">
                                     <i class="nav-icon bi bi-circle"></i>
                                     <p>PRODUCTOS</p>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="" class="nav-link">
                                     <i class="nav-icon bi bi-circle"></i>
                                     <p>REPORTES</p>
                                 </a>
                             </li>

                         </ul>
                     </li>
                     <li class="nav-item">
                         <a href="#" class="nav-link">
                             <i class="nav-icon bi bi-clipboard-fill"></i>
                             <p>
                                 CLIENTES

                                 <i class="nav-arrow bi bi-chevron-right"></i>
                             </p>
                         </a>
                         <ul class="nav nav-treeview">
                             <li class="nav-item">
                                 <a href="{{ route('customer.index') }}" class="nav-link">
                                     <i class="nav-icon bi bi-circle"></i>
                                     <p>LISTA DE CLIENTES</p>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="" class="nav-link">
                                     <i class="nav-icon bi bi-circle"></i>
                                     <p>ESTADO DE CUENTAS</p>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="" class="nav-link">
                                     <i class="nav-icon bi bi-circle"></i>
                                     <p>REPORTES</p>
                                 </a>
                             </li>
                         </ul>
                     </li>
                     <li class="nav-item">
                         <a href="#" class="nav-link">
                             <i class="nav-icon bi bi-ui-checks-grid"></i>
                             <p>
                                 PROVEEDORES
                                 <i class="nav-arrow bi bi-chevron-right"></i>
                             </p>
                         </a>
                         <ul class="nav nav-treeview">
                             <li class="nav-item">
                                 <a href="{{ route('supplier.index') }}" class="nav-link">
                                     <i class="nav-icon bi bi-circle"></i>
                                     <p>LISTA DE PROVEEDORES</p>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="" class="nav-link">
                                     <i class="nav-icon bi bi-circle"></i>
                                     <p>ESTADO DE CUENTAS</p>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="" class="nav-link">
                                     <i class="nav-icon bi bi-circle"></i>
                                     <p>REPORTES</p>
                                 </a>
                             </li>
                         </ul>
                     </li>
                     <li class="nav-item">
                         <a href="#" class="nav-link">
                             <i class="nav-icon bi bi-pencil-square"></i>
                             <p>
                                 VENTAS
                                 <i class="nav-arrow bi bi-chevron-right"></i>
                             </p>
                         </a>
                         <ul class="nav nav-treeview">
                             <li class="nav-item">
                                 <a href="{{ route('sale.index') }}" class="nav-link">
                                     <i class="nav-icon bi bi-circle"></i>
                                     <p>POS</p>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="{{ route('sale.index') }}" class="nav-link">
                                     <i class="nav-icon bi bi-circle"></i>
                                     <p>LISTA DE VENTAS</p>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="" class="nav-link">
                                     <i class="nav-icon bi bi-circle"></i>
                                     <p>REPORTES</p>
                                 </a>
                             </li>
                         </ul>
                     </li>
                     <li class="nav-item">
                         <a href="#" class="nav-link">
                             <i class="nav-icon bi bi-pencil-square"></i>
                             <p>
                                 POS
                                 <i class="nav-arrow bi bi-chevron-right"></i>
                             </p>
                         </a>
                         <ul class="nav nav-treeview">
                             <li class="nav-item">
                                 <a href="{{ route('pos.index') }}" class="nav-link">
                                     <i class="nav-icon bi bi-circle"></i>
                                     <p>INICIAR POS</p>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="{{ route('sale.index') }}" class="nav-link">
                                     <i class="nav-icon bi bi-circle"></i>
                                     <p>LISTA DE VENTAS</p>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="" class="nav-link">
                                     <i class="nav-icon bi bi-circle"></i>
                                     <p>REPORTES</p>
                                 </a>
                             </li>
                         </ul>
                     </li>
                     <li class="nav-item">
                         <a href="#" class="nav-link">
                             <i class="nav-icon bi bi-download"></i>
                             <p>
                                 DEVOLUCIONES
                                 <i class="nav-arrow bi bi-chevron-right"></i>
                             </p>
                         </a>
                         <ul class="nav nav-treeview">
                             <li class="nav-item">
                                 <a href="{{ route('returnsale.index') }}" class="nav-link">
                                     <i class="nav-icon bi bi-circle"></i>
                                     <p>LISTA DE VOLUCIONES</p>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="" class="nav-link">
                                     <i class="nav-icon bi bi-circle"></i>
                                     <p>REPORTES</p>
                                 </a>
                             </li>
                         </ul>
                     </li>
                     <li class="nav-item">
                         <a href="#" class="nav-link">
                             <i class="nav-icon bi bi-table"></i>
                             <p>
                                 COMPRAS
                                 <i class="nav-arrow bi bi-chevron-right"></i>
                             </p>
                         </a>
                         <ul class="nav nav-treeview">
                             <li class="nav-item">
                                 <a href="{{ route('shopping.index') }}" class="nav-link">
                                     <i class="nav-icon bi bi-circle"></i>
                                     <p>Lista Compras</p>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="{{ route('shopping.index') }}" class="nav-link">
                                     <i class="nav-icon bi bi-circle"></i>
                                     <p>Reportes</p>
                                 </a>
                             </li>
                         </ul>
                     </li>
                     <li class="nav-item">
                         <a href="#" class="nav-link">
                             <i class="bi bi-clipboard-check"></i>
                             <p>
                                 GASTOS
                                 <i class="nav-arrow bi bi-chevron-right"></i>
                             </p>
                         </a>
                         <ul class="nav nav-treeview">
                             <li class="nav-item">
                                 <a href="{{ route('spent.index') }}" class="nav-link">
                                     <i class="nav-icon bi bi-circle"></i>
                                     <p>Lista Gastos</p>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="" class="nav-link">
                                     <i class="nav-icon bi bi-circle"></i>
                                     <p>Reportes</p>
                                 </a>
                             </li>
                         </ul>
                     </li>
                     <li class="nav-header">DOCUMENTOS</li>

                     <li class="nav-item">
                         <a class="nav-link">
                             <i class="nav-icon bi bi-filetype-js"></i>
                             <p>
                                 REPORTES
                                 <i class="nav-arrow bi bi-chevron-right"></i>
                             </p>
                         </a>
                         <ul class="nav nav-treeview">
                             <li class="nav-item">
                                 <a href="{{route('report.reporteinventario')}}" class="nav-link">
                                     <i class="nav-icon bi bi-circle"></i>
                                     <p>Reportes de Inventario</p>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="" class="nav-link">
                                     <i class="nav-icon bi bi-circle"></i>
                                     <p>Reportes de Productos</p>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="" class="nav-link">
                                     <i class="nav-icon bi bi-circle"></i>
                                     <p>Reportes de Ventas</p>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="" class="nav-link">
                                     <i class="nav-icon bi bi-circle"></i>
                                     <p>Reportes de Compras</p>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="" class="nav-link">
                                     <i class="nav-icon bi bi-circle"></i>
                                     <p>Reportes de Pos</p>
                                 </a>
                             </li>
                         </ul>
                     </li>

                     <li class="nav-header">CONFIGURACIONES</li>
                     <li class="nav-item">
                         <a href="#" class="nav-link">
                             <i class="nav-icon bi bi-box-arrow-in-right"></i>
                             <p>
                                 Paramentros
                                 <i class="nav-arrow bi bi-chevron-right"></i>
                             </p>
                         </a>
                         <ul class="nav nav-treeview">
                             <li class="nav-item">
                                 <a href="#" class="nav-link">
                                     <i class="nav-icon bi bi-box-arrow-in-right"></i>
                                     <p>
                                         Datos Empresa
                                         <i class="nav-arrow bi bi-chevron-right"></i>
                                     </p>
                                 </a>
                                 <ul class="nav nav-treeview">
                                     <li class="nav-item">
                                         <a href="./examples/login.html" class="nav-link">
                                             <i class="nav-icon bi bi-circle"></i>
                                             <p>Datos empresa</p>
                                         </a>
                                     </li>
                                     <li class="nav-item">
                                         <a href="./examples/login.html" class="nav-link">
                                             <i class="nav-icon bi bi-circle"></i>
                                             <p>Config. automaticas</p>
                                         </a>
                                     </li>
                                     <li class="nav-item">
                                         <a href="./examples/register.html" class="nav-link">
                                             <i class="nav-icon bi bi-circle"></i>
                                             <p>Cargar Inventario</p>
                                         </a>
                                     </li>
                                     <li class="nav-item">
                                         <a href="./examples/register.html" class="nav-link">
                                             <i class="nav-icon bi bi-circle"></i>
                                             <p>Iniciar - Cerrar Inventario</p>
                                         </a>
                                     </li>
                                 </ul>
                             </li>
                             <li class="nav-item">
                                 <a href="#" class="nav-link">
                                     <i class="nav-icon bi bi-box-arrow-in-right"></i>
                                     <p>
                                         Resoluciones
                                         <i class="nav-arrow bi bi-chevron-right"></i>
                                     </p>
                                 </a>
                                 <ul class="nav nav-treeview">
                                     <li class="nav-item">
                                         <a href="" class="nav-link">
                                             <i class="nav-icon bi bi-circle"></i>
                                             <p>Nueva resolucion</p>
                                         </a>
                                     </li>
                                     <li class="nav-item">
                                         <a href="" class="nav-link">
                                             <i class="nav-icon bi bi-circle"></i>
                                             <p>Lista de resoluciones</p>
                                         </a>
                                     </li>
                                 </ul>
                             </li>
                             <li class="nav-item">
                                 <a href="" class="nav-link">
                                     <i class="nav-icon bi bi-circle"></i>
                                     <p>Comprar paquetes</p>
                                 </a>
                             </li>
                         </ul>
                     </li>
                 @else
                     <li class="nav-item">
                         <a href="#" class="nav-link">
                             <i class="nav-icon bi bi-clipboard-fill"></i>
                             <p>
                                 CLIENTES

                                 <i class="nav-arrow bi bi-chevron-right"></i>
                             </p>
                         </a>
                         <ul class="nav nav-treeview">
                             <li class="nav-item">
                                 <a href="{{ route('customer.index') }}" class="nav-link">
                                     <i class="nav-icon bi bi-circle"></i>
                                     <p>LISTA DE CLIENTES</p>
                                 </a>
                             </li>
                         </ul>
                     </li>

                     <li class="nav-item">
                         <a href="#" class="nav-link">
                             <i class="nav-icon bi bi-pencil-square"></i>
                             <p>
                                 VENTAS
                                 <i class="nav-arrow bi bi-chevron-right"></i>
                             </p>
                         </a>
                         <ul class="nav nav-treeview">
                             <li class="nav-item">
                                 <a href="{{ route('sale.index') }}" class="nav-link">
                                     <i class="nav-icon bi bi-circle"></i>
                                     <p>POS</p>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="{{ route('sale.index') }}" class="nav-link">
                                     <i class="nav-icon bi bi-circle"></i>
                                     <p>LISTA DE VENTAS</p>
                                 </a>
                             </li>
                         </ul>
                     </li>
                     <li class="nav-item">
                         <a href="#" class="nav-link">
                             <i class="nav-icon bi bi-pencil-square"></i>
                             <p>
                                 POS
                                 <i class="nav-arrow bi bi-chevron-right"></i>
                             </p>
                         </a>
                         <ul class="nav nav-treeview">
                             <li class="nav-item">
                                 <a href="{{ route('pos.index') }}" class="nav-link">
                                     <i class="nav-icon bi bi-circle"></i>
                                     <p>INICIAR POS</p>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="{{ route('sale.index') }}" class="nav-link">
                                     <i class="nav-icon bi bi-circle"></i>
                                     <p>LISTA DE VENTAS</p>
                                 </a>
                             </li>
                         </ul>
                     </li>
                     <li class="nav-item">
                         <a href="#" class="nav-link">
                             <i class="nav-icon bi bi-download"></i>
                             <p>
                                 DEVOLUCIONES
                                 <i class="nav-arrow bi bi-chevron-right"></i>
                             </p>
                         </a>
                         <ul class="nav nav-treeview">
                             <li class="nav-item">
                                 <a href="{{ route('returnsale.index') }}" class="nav-link">
                                     <i class="nav-icon bi bi-circle"></i>
                                     <p>LISTA DE VOLUCIONES</p>
                                 </a>
                             </li>

                         </ul>
                     </li>

                     <li class="nav-item">
                         <a href="#" class="nav-link">
                             <i class="bi bi-clipboard-check"></i>
                             <p>
                                 GASTOS
                                 <i class="nav-arrow bi bi-chevron-right"></i>
                             </p>
                         </a>
                         <ul class="nav nav-treeview">
                             <li class="nav-item">
                                 <a href="{{ route('spent.index') }}" class="nav-link">
                                     <i class="nav-icon bi bi-circle"></i>
                                     <p>Lista Gastos</p>
                                 </a>
                             </li>

                         </ul>
                     </li>
                     <li class="nav-header">DOCUMENTOS</li>


                 @endif




             </ul>
             <!--end::Sidebar Menu-->
         </nav>
     </div>
     <!--end::Sidebar Wrapper-->
 </aside>
