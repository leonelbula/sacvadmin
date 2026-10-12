 @extends('layouts.app')

 @section('title', 'Cuentas por cobrar')

 @section('content')
     <div class="container-fluid py-4 mt-4">

         {{-- Encabezado --}}
         <div class="d-flex justify-content-between align-items-center mb-4">
             <div>
                 <h3 class="mb-1">Cuentas por cobrar</h3>
                 <p class="text-muted mb-0">
                     Gestión y seguimiento de ventas pendientes de pago.
                 </p>
             </div>

             <a href="{{ route('sale.index') }}" class="btn btn-outline-secondary">
                 <i class="bi bi-arrow-left"></i>
                 Volver a ventas
             </a>
         </div>

         {{-- Mensajes --}}
         @if (session('success'))
             <div class="alert alert-success alert-dismissible fade show">
                 {{ session('success') }}
                 <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
             </div>
         @endif

         @if (session('error'))
             <div class="alert alert-danger alert-dismissible fade show">
                 {{ session('error') }}
                 <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
             </div>
         @endif

         {{-- Resumen --}}
         <div class="row g-3 mb-4">

             <div class="col-12 col-md-4">
                 <div class="card border-0 shadow-sm h-100">
                     <div class="card-body">
                         <div class="d-flex justify-content-between">
                             <div>
                                 <p class="text-muted mb-1">Total por cobrar</p>
                                 <h4 class="fw-bold text-danger mb-0">
                                     ${{ number_format($totalPorCobrar ?? 0, 0, ',', '.') }}
                                 </h4>
                             </div>
                             <i class="bi bi-cash-stack fs-2 text-danger"></i>
                         </div>
                     </div>
                 </div>
             </div>

             <div class="col-12 col-md-4">
                 <div class="card border-0 shadow-sm h-100">
                     <div class="card-body">
                         <div class="d-flex justify-content-between">
                             <div>
                                 <p class="text-muted mb-1">Cuentas pendientes</p>
                                 <h4 class="fw-bold mb-0">
                                     {{ $cantidadCuentas ?? 0 }}
                                 </h4>
                             </div>
                             <i class="bi bi-receipt fs-2 text-warning"></i>
                         </div>
                     </div>
                 </div>
             </div>

             <div class="col-12 col-md-4">
                 <div class="card border-0 shadow-sm h-100">
                     <div class="card-body">
                         <div class="d-flex justify-content-between">
                             <div>
                                 <p class="text-muted mb-1">Clientes con deuda</p>
                                 <h4 class="fw-bold mb-0">
                                     {{ $cantidadClientes ?? 0 }}
                                 </h4>
                             </div>
                             <i class="bi bi-people fs-2 text-primary"></i>
                         </div>
                     </div>
                 </div>
             </div>

         </div>

         {{-- Filtros --}}
         <div class="card border-0 shadow-sm mb-4">
             <div class="card-body">
                 <form action="{{ route('accounts-receivable.index') }}" method="GET">

                     <div class="row g-3 align-items-end">

                         <div class="col-12 col-md-4">
                             <label for="search" class="form-label">
                                 Buscar cliente o factura
                             </label>

                             <input type="text" id="search" name="search" class="form-control"
                                 placeholder="Nombre, identificación o factura" value="{{ request('search') }}">
                         </div>

                         <div class="col-12 col-md-3">
                             <label for="fecha_desde" class="form-label">
                                 Fecha desde
                             </label>

                             <input type="date" id="fecha_desde" name="fecha_desde" class="form-control"
                                 value="{{ request('fecha_desde') }}">
                         </div>

                         <div class="col-12 col-md-3">
                             <label for="fecha_hasta" class="form-label">
                                 Fecha hasta
                             </label>

                             <input type="date" id="fecha_hasta" name="fecha_hasta" class="form-control"
                                 value="{{ request('fecha_hasta') }}">
                         </div>

                         <div class="col-12 col-md-2 d-flex gap-2">
                             <button type="submit" class="btn btn-primary">
                                 <i class="bi bi-search"></i>
                                 Filtrar
                             </button>

                             <a href="{{ route('accounts-receivable.index') }}" class="btn btn-outline-secondary"
                                 title="Limpiar filtros">
                                 <i class="bi bi-arrow-counterclockwise"></i>
                             </a>
                         </div>

                     </div>
                 </form>
             </div>
         </div>

         {{-- Tabla --}}
         <div class="card border-0 shadow-sm">

             <div class="card-header bg-white py-3">
                 <h5 class="mb-0">Detalle de cuentas pendientes</h5>
             </div>

             <div class="card-body p-0">
                 <div class="table-responsive">

                     <table class="table table-hover align-middle mb-0">

                         <thead class="table-light">
                             <tr>
                                 <th>Factura</th>
                                 <th>Fecha</th>
                                 <th>Cliente</th>
                                 <th class="text-end">Total venta</th>
                                 <th class="text-end">Saldo pendiente</th>
                                 <th>Vencimiento</th>
                                 <th>Estado</th>
                                 <th class="text-center">Acciones</th>
                             </tr>
                         </thead>

                         <tbody>
                             @forelse ($cuentas as $cuenta)
                                 <tr>
                                     <td class="fw-semibold">
                                         {{ $cuenta->sale_number }}
                                     </td>

                                     <td>
                                         {{ $cuenta->date_sale ? \Illuminate\Support\Carbon::parse($cuenta->date_sale)->format('d/m/Y') : '—' }}
                                     </td>

                                     <td>
                                         <div class="fw-semibold">
                                             {{ $cuenta->customer?->full_name ?? 'Cliente no disponible' }}
                                         </div>

                                         <small class="text-muted">
                                             {{ $cuenta->customer?->identification ?? '' }}
                                         </small>
                                     </td>

                                     <td class="text-end">
                                         ${{ number_format($cuenta->total, 0, ',', '.') }}
                                     </td>

                                     <td class="text-end fw-bold text-danger">
                                         ${{ number_format($cuenta->balance, 0, ',', '.') }}
                                     </td>

                                     <td>
                                         {{ $cuenta->expiration_date
                                             ? \Illuminate\Support\Carbon::parse($cuenta->expiration_date)->format('d/m/Y')
                                             : 'Sin fecha' }}
                                     </td>

                                     <td>
                                         @if (
                                             $cuenta->expiration_date &&
                                                 \Illuminate\Support\Carbon::parse($cuenta->expiration_date)->startOfDay()->lt(now()->startOfDay()))
                                             <span class="badge bg-danger">
                                                 Vencida
                                             </span>
                                         @else
                                             <span class="badge bg-warning text-dark">
                                                 Pendiente
                                             </span>
                                         @endif
                                     </td>

                                     <td class="text-center">
                                         <div class="d-flex justify-content-center gap-2">

                                             <a href="{{ route('sale.show', $cuenta->id) }}"
                                                 class="btn btn-sm btn-outline-primary" title="Ver factura">
                                                 <i class="bi bi-eye"></i>
                                             </a>

                                             <a href="{{ route('accounts-receivable.show', $cuenta->id) }}"
                                                 class="btn btn-sm btn-outline-success" title="Gestionar cuenta">
                                                 <i class="bi bi-wallet2"></i>
                                             </a>

                                         </div>
                                     </td>
                                 </tr>

                             @empty
                                 <tr>
                                     <td colspan="8" class="text-center py-5">
                                         <i class="bi bi-inbox fs-1 text-muted"></i>

                                         <p class="text-muted mt-2 mb-0">
                                             No se encontraron cuentas por cobrar.
                                         </p>
                                     </td>
                                 </tr>
                             @endforelse
                         </tbody>

                         @if ($cuentas->count() > 0)
                             <tfoot class="table-light">
                                 <tr>
                                     <th colspan="4" class="text-end">
                                         Saldo pendiente en esta página:
                                     </th>

                                     <th class="text-end text-danger">
                                         ${{ number_format($cuentas->sum('balance'), 0, ',', '.') }}
                                     </th>

                                     <th colspan="3"></th>
                                 </tr>
                             </tfoot>
                         @endif

                     </table>

                 </div>
             </div>

             @if ($cuentas instanceof \Illuminate\Contracts\Pagination\Paginator)
                 <div class="card-footer bg-white">
                     {{ $cuentas->withQueryString()->links() }}
                 </div>
             @endif

         </div>

     </div>
 @endsection
