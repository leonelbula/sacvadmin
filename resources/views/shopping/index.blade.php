@extends('layouts.app')


@section('content')

    <div class="container-fluid px-4 py-4 mt-5">

        {{-- Encabezado --}}
        <div
            class="d-flex flex-column flex-md-row
                justify-content-between align-items-md-center
                gap-3 mb-4">

            <div>

                <div class="d-flex align-items-center gap-2 mb-1">

                    <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-2">
                        <i class="bi bi-cart-check fs-4"></i>
                    </div>

                    <div>

                        <h4 class="fw-bold mb-0">
                            Compras
                        </h4>

                        <small class="text-muted">
                            Gestiona y consulta las compras realizadas
                        </small>

                    </div>

                </div>

            </div>


            <a href="{{ route('shopping.create') }}" class="btn btn-primary">

                <i class="bi bi-plus-lg me-1"></i>
                Nueva compra

            </a>

        </div>


        {{-- Resumen --}}
        <div class="row g-3 mb-4">

            {{-- Total compras --}}
            <div class="col-12 col-sm-6 col-xl-3">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body d-flex align-items-center">

                        <div
                            class="bg-primary bg-opacity-10
                                text-primary rounded-3 p-3 me-3">

                            <i class="bi bi-cart-check fs-4"></i>

                        </div>

                        <div>

                            <small class="text-muted">
                                Total compras
                            </small>

                            <h4 class="fw-bold mb-0">
                                {{ $shoppings->total() }}
                            </h4>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Valor compras --}}
            <div class="col-12 col-sm-6 col-xl-3">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body d-flex align-items-center">

                        <div
                            class="bg-success bg-opacity-10
                                text-success rounded-3 p-3 me-3">

                            <i class="bi bi-cash-stack fs-4"></i>

                        </div>

                        <div>

                            <small class="text-muted">
                                Valor compras
                            </small>

                            <h4 class="fw-bold mb-0">

                                ${{ number_format($total ?? 0, 0, ',', '.') }}

                            </h4>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Compras a crédito --}}
            <div class="col-12 col-sm-6 col-xl-3">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body d-flex align-items-center">

                        <div
                            class="bg-warning bg-opacity-10
                                text-warning rounded-3 p-3 me-3">

                            <i class="bi bi-credit-card fs-4"></i>

                        </div>

                        <div>

                            <small class="text-muted">
                                Saldo a crédito
                            </small>

                            <h4 class="fw-bold mb-0">

                                ${{ number_format($balance ?? 0, 0, ',', '.') }}

                            </h4>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Pendiente --}}
            <div class="col-12 col-sm-6 col-xl-3">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body d-flex align-items-center">

                        <div class="bg-danger bg-opacity-10
                                text-danger rounded-3 p-3 me-3">

                            <i class="bi bi-hourglass-split fs-4"></i>

                        </div>

                        <div>

                            <small class="text-muted">
                                Saldo pendiente
                            </small>

                            <h4 class="fw-bold mb-0">

                                ${{ number_format($totalPending ?? 0, 0, ',', '.') }}

                            </h4>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Tabla principal --}}
        <div class="card border-0 shadow-sm">


            {{-- Barra de búsqueda --}}
            <div class="card-header bg-white border-0 p-3">

                <form action="{{ route('shopping.index') }}" method="GET">

                    <div class="row g-3 align-items-center">

                        {{-- Buscar --}}
                        <div class="col-12 col-lg-5">

                            <div class="input-group">

                                <span class="input-group-text bg-light border-end-0">

                                    <i class="bi bi-search text-muted"></i>

                                </span>

                                <input type="text" name="search" value="{{ request('search') }}"
                                    class="form-control bg-light border-start-0"
                                    placeholder="Buscar compra, proveedor o identificación...">

                                @if (request('search'))
                                    <a href="{{ route('shopping.index') }}" class="btn btn-light border">

                                        <i class="bi bi-x-lg"></i>

                                    </a>
                                @endif

                                <button type="submit" class="btn btn-primary">

                                    Buscar

                                </button>

                            </div>

                        </div>


                        {{-- Estado --}}
                        <div class="col-12 col-md-4 col-lg-2">

                            <select name="state" class="form-select">

                                <option value="">
                                    Todos los estados
                                </option>

                                <option value="paid" @selected(request('state') === 'paid')>
                                    Pagada
                                </option>

                                <option value="pending" @selected(request('state') === 'pending')>
                                    Pendiente
                                </option>

                                <option value="credit" @selected(request('state') === 'credit')>
                                    Crédito
                                </option>

                            </select>

                        </div>


                        {{-- Fecha --}}
                        <div class="col-12 col-md-4 col-lg-2">

                            <input type="date" name="date" value="{{ request('date') }}" class="form-control">

                        </div>


                        {{-- Limpiar --}}
                        <div class="col-12 col-md-4 col-lg-3">

                            <div class="d-flex gap-2">

                                <button type="submit" class="btn btn-outline-primary flex-grow-1">

                                    <i class="bi bi-funnel me-1"></i>
                                    Filtrar

                                </button>

                                <a href="{{ route('shopping.index') }}" class="btn btn-light border">

                                    <i class="bi bi-arrow-counterclockwise"></i>

                                </a>

                            </div>

                        </div>

                    </div>

                </form>

            </div>


            {{-- Información de resultados --}}
            <div class="px-4 py-3 border-top border-bottom bg-light">

                <div
                    class="d-flex flex-column flex-md-row
                        justify-content-between
                        align-items-md-center gap-2">

                    <span class="text-muted small">

                        Mostrando

                        <strong>
                            {{ $shoppings->firstItem() ?? 0 }}
                        </strong>

                        -

                        <strong>
                            {{ $shoppings->lastItem() ?? 0 }}
                        </strong>

                        de

                        <strong>
                            {{ $shoppings->total() }}
                        </strong>

                        compras

                    </span>

                    @if (request()->hasAny(['search', 'state', 'date']))
                        <span class="badge bg-primary-subtle text-primary">

                            <i class="bi bi-funnel me-1"></i>
                            Filtros activos

                        </span>
                    @endif

                </div>

            </div>


            {{-- Tabla --}}
            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th class="px-4">
                                Compra
                            </th>

                            <th>
                                Proveedor
                            </th>

                            <th>
                                Fecha
                            </th>

                            <th>
                                Usuario
                            </th>

                            <th>
                                Método de pago
                            </th>

                            <th class="text-end">
                                Total
                            </th>

                            <th class="text-center">
                                Estado
                            </th>

                            <th class="text-center">
                                Acción
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($shoppings as $shopping)
                            <tr>

                                {{-- Compra --}}
                                <td class="px-4">

                                    <div class="d-flex align-items-center">

                                        <div
                                            class="bg-primary bg-opacity-10
                                            text-primary rounded-3 p-2 me-3">

                                            <i class="bi bi-receipt"></i>

                                        </div>

                                        <div>

                                            <div class="fw-semibold">

                                                #{{ $shopping->id }}

                                            </div>

                                            <small class="text-muted">

                                                {{ $shopping->created_at ? $shopping->created_at->format('d/m/Y H:i') : 'Sin fecha' }}

                                            </small>

                                        </div>

                                    </div>

                                </td>


                                {{-- Proveedor --}}
                                <td>

                                    @if ($shopping->supplier)
                                        <div class="fw-semibold">

                                            {{ $shopping->supplier->full_name }}

                                        </div>

                                        <small class="text-muted">

                                           Nit:  {{ $shopping->supplier->identification }}

                                        </small>
                                    @else
                                        <span class="text-muted">
                                            Sin proveedor
                                        </span>
                                    @endif

                                </td>


                                {{-- Fecha --}}
                                <td>

                                    @if (isset($shopping->shopping_date))
                                        {{ \Carbon\Carbon::parse($shopping->shopping_date)->format('d/m/Y') }}
                                    @elseif(isset($shopping->due_date))
                                        {{ \Carbon\Carbon::parse($shopping->due_date)->format('d/m/Y') }}
                                    @else
                                        <span class="text-muted">
                                            —
                                        </span>
                                    @endif

                                </td>


                                {{-- Usuario --}}
                                <td>

                                    @if ($shopping->user_id)
                                        <div class="d-flex align-items-center">

                                            <div class="rounded-circle bg-light
                                                border d-flex
                                                align-items-center
                                                justify-content-center me-2"
                                                style="width:34px;height:34px;">

                                                <i class="bi bi-person text-muted"></i>

                                            </div>

                                            <span>
                                                {{ $shopping->user->name }}
                                            </span>

                                        </div>
                                    @else
                                        <span class="text-muted">
                                            —
                                        </span>
                                    @endif

                                </td>


                                {{-- Método de pago --}}
                                <td>

                                    @if ($shopping->purchase_type == 'counted')
                                        <span>

                                            <i
                                                class="bi bi-credit-card
                                              text-primary me-1"></i>

                                            Contado

                                        </span>
                                    @else
                                        <span class="text-muted">
                                           Credito
                                        </span>
                                    @endif

                                </td>


                                {{-- Total --}}
                                <td class="text-end">

                                    <span class="fw-bold">

                                        ${{ number_format($shopping->total ?? 0, 0, ',', '.') }}

                                    </span>

                                </td>


                                {{-- Estado --}}
                                <td class="text-center">

                                    @php
                                        $state = $shopping->balance ?? null;
                                    @endphp

                                    @if ($state == 0 )
                                        <span class="badge bg-success-subtle text-success">

                                            <i class="bi bi-check-circle me-1"></i>
                                            Pagada

                                        </span>
                                    @elseif($state > 0 )
                                        <span class="badge bg-danger-subtle text-danger">

                                            <i class="bi bi-credit-card me-1"></i>
                                            Crédito

                                        </span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary">

                                            {{ $state ?? 'Sin estado' }}

                                        </span>
                                    @endif

                                </td>


                                {{-- Acciones --}}
                                <td class="text-center">

                                    <div class="dropdown">

                                        <button type="button" class="btn btn-sm btn-light border"
                                            data-bs-toggle="dropdown" aria-expanded="false">

                                            <i class="bi bi-three-dots-vertical"></i>

                                        </button>


                                        <ul
                                            class="dropdown-menu dropdown-menu-end
                                           shadow-sm border-0">

                                            <li>

                                                <a href="{{ route('shopping.show', $shopping->id) }}"
                                                    class="dropdown-item">

                                                    <i class="bi bi-eye text-primary me-2"></i>

                                                    Ver compra

                                                </a>

                                            </li>


                                            <li>

                                                <a href="{{ route('shopping.edit', $shopping->id) }}"
                                                    class="dropdown-item">

                                                    <i class="bi bi-pencil text-warning me-2"></i>

                                                    Editar

                                                </a>

                                            </li>


                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>


                                            <li>

                                                <form action="{{ route('shopping.destroy', $shopping->id) }}"
                                                    method="POST" class="delete-shopping-form">

                                                    @csrf

                                                    @method('DELETE')

                                                    <button type="submit" class="dropdown-item text-danger">

                                                        <i class="bi bi-trash me-2"></i>

                                                        Eliminar

                                                    </button>

                                                </form>

                                            </li>

                                        </ul>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="8">

                                    <div class="text-center py-5">

                                        <div class="mb-3">

                                            <div class="rounded-circle bg-light
                                               d-inline-flex
                                               align-items-center
                                               justify-content-center"
                                                style="width:75px;height:75px;">

                                                <i class="bi bi-cart-x fs-2 text-muted"></i>

                                            </div>

                                        </div>


                                        @if (request()->hasAny(['search', 'state', 'date']))
                                            <h5 class="fw-semibold">
                                                No se encontraron compras
                                            </h5>

                                            <p class="text-muted mb-3">

                                                No existen compras que coincidan
                                                con los filtros seleccionados.

                                            </p>

                                            <a href="{{ route('shopping.index') }}" class="btn btn-outline-primary">

                                                <i class="bi bi-arrow-counterclockwise me-1"></i>

                                                Limpiar filtros

                                            </a>
                                        @else
                                            <h5 class="fw-semibold">
                                                No hay compras registradas
                                            </h5>

                                            <p class="text-muted mb-3">

                                                Comienza registrando tu primera compra.

                                            </p>

                                            <a href="{{ route('shopping.create') }}" class="btn btn-primary">

                                                <i class="bi bi-plus-lg me-1"></i>

                                                Nueva compra

                                            </a>
                                        @endif

                                    </div>

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- Paginación --}}
            @if ($shoppings->hasPages())
                <div class="card-footer bg-white border-0 px-4 py-3">

                    <div
                        class="d-flex flex-column flex-md-row
                            justify-content-between
                            align-items-center gap-3">

                        <small class="text-muted">

                            Página
                            {{ $shoppings->currentPage() }}
                            de
                            {{ $shoppings->lastPage() }}

                        </small>

                        {{ $shoppings->withQueryString()->links() }}

                    </div>

                </div>
            @endif

        </div>

    </div>

@endsection


<script>
    document.addEventListener('DOMContentLoaded', function() {

        document
            .querySelectorAll('.delete-shopping-form')
            .forEach(function(form) {

                form.addEventListener('submit', function(event) {

                    const confirmed = confirm(
                        '¿Está seguro de eliminar esta compra?'
                    );

                    if (!confirmed) {
                        event.preventDefault();
                    }

                });

            });

    });
</script>
