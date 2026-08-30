@extends('layouts.app')

@section('title', 'Gastos')

@section('content')

<div class="container-fluid py-4 mt-4">

    {{-- ==========================================================
        ENCABEZADO
    =========================================================== --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-wallet2 text-primary me-2"></i>
                Gastos
            </h2>

            <p class="text-muted mb-0">
                Administra los gastos registrados de la empresa.
            </p>
        </div>

        <a href="{{ route('expenses.create') }}"
           class="btn btn-primary rounded-3 px-4">

            <i class="bi bi-plus-lg me-2"></i>
            Nuevo gasto

        </a>

    </div>


    {{-- ==========================================================
        MENSAJE DE ÉXITO
    =========================================================== --}}
    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show rounded-3"
             role="alert">

            <i class="bi bi-check-circle me-2"></i>

            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- ==========================================================
        MENSAJE DE ERROR
    =========================================================== --}}
    @if(session('error'))

        <div class="alert alert-danger alert-dismissible fade show rounded-3"
             role="alert">

            <i class="bi bi-exclamation-triangle me-2"></i>

            {{ session('error') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- ==========================================================
        TARJETAS DE RESUMEN
    =========================================================== --}}
    <div class="row g-4 mb-4">

        {{-- Total --}}
        <div class="col-xl-4 col-md-6">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <span class="text-muted small">
                                Total de gastos
                            </span>

                            <h3 class="fw-bold mt-2 mb-0">

                                ${{ number_format($expenses->sum('total'), 0, ',', '.') }}

                            </h3>

                        </div>

                        <div class="bg-danger bg-opacity-10
                                    text-danger rounded-4 p-3">

                            <i class="bi bi-wallet2 fs-3"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Cantidad --}}
        <div class="col-xl-4 col-md-6">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <span class="text-muted small">
                                Gastos registrados
                            </span>

                            <h3 class="fw-bold mt-2 mb-0">
                                {{ $expenses->total() }}
                            </h3>

                        </div>

                        <div class="bg-primary bg-opacity-10
                                    text-primary rounded-4 p-3">

                            <i class="bi bi-receipt fs-3"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Promedio --}}
        <div class="col-xl-4 col-md-6">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <span class="text-muted small">
                                Promedio por gasto
                            </span>

                            <h3 class="fw-bold mt-2 mb-0">

                                @php
                                    $promedio = $expenses->count()
                                        ? $expenses->sum('total') / $expenses->count()
                                        : 0;
                                @endphp

                                ${{ number_format($promedio, 0, ',', '.') }}

                            </h3>

                        </div>

                        <div class="bg-success bg-opacity-10
                                    text-success rounded-4 p-3">

                            <i class="bi bi-graph-up-arrow fs-3"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ==========================================================
        FILTROS
    =========================================================== --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-body p-4">

            <form method="GET"
                  action="{{ route('expenses.index') }}">

                <div class="row g-3 align-items-end">

                    {{-- Buscar --}}
                    <div class="col-lg-4">

                        <label class="form-label fw-semibold">
                            Buscar
                        </label>

                        <div class="input-group">

                            <span class="input-group-text bg-white">

                                <i class="bi bi-search text-muted"></i>

                            </span>

                            <input type="text"
                                   name="search"
                                   class="form-control"
                                   value="{{ request('search') }}"
                                   placeholder="Descripción o entregado a...">

                        </div>

                    </div>


                    {{-- Tipo --}}
                    <div class="col-lg-2">

                        <label class="form-label fw-semibold">
                            Tipo de gasto
                        </label>

                        <select name="type_expense_id"
                                class="form-select">

                            <option value="">
                                Todos
                            </option>

                            @foreach($typeExpenses ?? [] as $typeExpense)

                                <option value="{{ $typeExpense->id }}"
                                    @selected(request('type_expense_id') == $typeExpense->id)>

                                    {{ $typeExpense->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Método --}}
                    <div class="col-lg-2">

                        <label class="form-label fw-semibold">
                            Método de pago
                        </label>

                        <select name="payment_method_id"
                                class="form-select">

                            <option value="">
                                Todos
                            </option>

                            @foreach($paymentMethods ?? [] as $paymentMethod)

                                <option value="{{ $paymentMethod->id }}"
                                    @selected(request('payment_method_id') == $paymentMethod->id)>

                                    {{ $paymentMethod->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Desde --}}
                    <div class="col-lg-2">

                        <label class="form-label fw-semibold">
                            Desde
                        </label>

                        <input type="date"
                               name="date_from"
                               class="form-control"
                               value="{{ request('date_from') }}">

                    </div>


                    {{-- Hasta --}}
                    <div class="col-lg-2">

                        <label class="form-label fw-semibold">
                            Hasta
                        </label>

                        <input type="date"
                               name="date_to"
                               class="form-control"
                               value="{{ request('date_to') }}">

                    </div>


                    {{-- Botones --}}
                    <div class="col-12">

                        <div class="d-flex gap-2">

                            <button type="submit"
                                    class="btn btn-primary rounded-3">

                                <i class="bi bi-search me-2"></i>
                                Filtrar

                            </button>

                            <a href="{{ route('expenses.index') }}"
                               class="btn btn-light border rounded-3">

                                <i class="bi bi-arrow-clockwise me-2"></i>
                                Limpiar

                            </a>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- ==========================================================
        TABLA
    =========================================================== --}}
    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-header bg-white border-0 p-4">

            <div class="d-flex flex-wrap justify-content-between
                        align-items-center">

                <div>

                    <h5 class="fw-bold mb-1">
                        Lista de gastos
                    </h5>

                    <span class="text-muted small">
                        {{ $expenses->total() }} registros encontrados
                    </span>

                </div>

            </div>

        </div>


        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th class="ps-4">
                            #
                        </th>

                        <th>
                            Fecha
                        </th>

                        <th>
                            Descripción
                        </th>

                        <th>
                            Tipo
                        </th>

                        <th>
                            Entregado a
                        </th>

                        <th>
                            Método
                        </th>

                        <th>
                            Usuario
                        </th>

                        <th class="text-end">
                            Total
                        </th>

                        <th class="text-center pe-4">
                            Acciones
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($expenses as $expense)

                        <tr>

                            {{-- ID --}}
                            <td class="ps-4">

                                <span class="fw-semibold text-muted">
                                    #{{ $expense->id }}
                                </span>

                            </td>


                            {{-- Fecha --}}
                            <td>

                                <div class="fw-semibold">

                                    {{ \Carbon\Carbon::parse($expense->date)
                                        ->format('d/m/Y') }}

                                </div>

                                <small class="text-muted">

                                    {{ \Carbon\Carbon::parse($expense->hour)
                                        ->format('h:i A') }}

                                </small>

                            </td>


                            {{-- Descripción --}}
                            <td>

                                <div class="fw-semibold">

                                    {{ $expense->description }}

                                </div>

                                @if($expense->observation)

                                    <small class="text-muted">

                                        {{ Str::limit($expense->observation, 45) }}

                                    </small>

                                @endif

                            </td>


                            {{-- Tipo --}}
                            <td>

                                @if($expense->typeExpense)

                                    <span class="badge
                                                 bg-primary bg-opacity-10
                                                 text-primary rounded-pill px-3">

                                        {{ $expense->typeExpense->name }}

                                    </span>

                                @else

                                    <span class="text-muted">
                                        -
                                    </span>

                                @endif

                            </td>


                            {{-- Entregado --}}
                            <td>

                                {{ $expense->delivered_to }}

                            </td>


                            {{-- Método --}}
                            <td>

                                @if($expense->paymentMethod)

                                    <span class="text-muted">

                                        {{ $expense->paymentMethod->name }}

                                    </span>

                                @else

                                    <span class="text-muted">
                                        -
                                    </span>

                                @endif

                            </td>


                            {{-- Usuario --}}
                            <td>

                                @if($expense->user)

                                    <div class="d-flex align-items-center">

                                        <div class="rounded-circle
                                                    bg-primary bg-opacity-10
                                                    text-primary
                                                    d-flex align-items-center
                                                    justify-content-center me-2"
                                             style="width:35px;height:35px;">

                                            {{ strtoupper(
                                                substr($expense->user->name, 0, 1)
                                            ) }}

                                        </div>

                                        <span>
                                            {{ $expense->user->name }}
                                        </span>

                                    </div>

                                @else

                                    <span class="text-muted">
                                        -
                                    </span>

                                @endif

                            </td>


                            {{-- Total --}}
                            <td class="text-end">

                                <span class="fw-bold text-danger">

                                    ${{ number_format(
                                        $expense->total,
                                        0,
                                        ',',
                                        '.'
                                    ) }}

                                </span>

                            </td>


                            {{-- Acciones --}}
                            <td class="text-center pe-4">

                                <div class="dropdown">

                                    <button class="btn btn-light border
                                                   btn-sm rounded-3"
                                            type="button"
                                            data-bs-toggle="dropdown">

                                        <i class="bi bi-three-dots-vertical"></i>

                                    </button>


                                    <ul class="dropdown-menu dropdown-menu-end">

                                        {{-- Ver --}}
                                        <li>

                                            <a class="dropdown-item"
                                               href="{{ route(
                                                   'expenses.show',
                                                   $expense->id
                                               ) }}">

                                                <i class="bi bi-eye me-2"></i>
                                                Ver detalle

                                            </a>

                                        </li>


                                        {{-- Editar --}}
                                        <li>

                                            <a class="dropdown-item"
                                               href="{{ route(
                                                   'expenses.edit',
                                                   $expense->id
                                               ) }}">

                                                <i class="bi bi-pencil me-2"></i>
                                                Editar

                                            </a>

                                        </li>


                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>


                                        {{-- Eliminar --}}
                                        <li>

                                            <button type="button"
                                                    class="dropdown-item text-danger"
                                                    onclick="confirmDelete(
                                                        {{ $expense->id }}
                                                    )">

                                                <i class="bi bi-trash me-2"></i>
                                                Eliminar

                                            </button>

                                        </li>

                                    </ul>

                                </div>


                                {{-- Formulario eliminar oculto --}}
                                <form id="delete-form-{{ $expense->id }}"
                                      action="{{ route(
                                          'expenses.destroy',
                                          $expense->id
                                      ) }}"
                                      method="POST"
                                      class="d-none">

                                    @csrf

                                    @method('DELETE')

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="9"
                                class="text-center py-5">

                                <div class="mb-3">

                                    <i class="bi bi-wallet2 text-muted"
                                       style="font-size: 4rem;">
                                    </i>

                                </div>

                                <h5 class="fw-bold">
                                    No hay gastos registrados
                                </h5>

                                <p class="text-muted mb-4">
                                    No encontramos gastos con los
                                    filtros seleccionados.
                                </p>

                                <a href="{{ route('expenses.create') }}"
                                   class="btn btn-primary rounded-3">

                                    <i class="bi bi-plus-lg me-2"></i>
                                    Registrar primer gasto

                                </a>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- ======================================================
            FOOTER / PAGINACIÓN
        ======================================================= --}}
        @if($expenses->hasPages())

            <div class="card-footer bg-white border-0 p-4">

                <div class="d-flex flex-wrap
                            justify-content-between
                            align-items-center">

                    <small class="text-muted">

                        Mostrando
                        <strong>{{ $expenses->firstItem() }}</strong>
                        -
                        <strong>{{ $expenses->lastItem() }}</strong>
                        de
                        <strong>{{ $expenses->total() }}</strong>

                    </small>

                    <div>

                        {{ $expenses->withQueryString()->links() }}

                    </div>

                </div>

            </div>

        @endif

    </div>

</div>


{{-- ==============================================================
    MODAL CONFIRMAR ELIMINACIÓN
================================================================ --}}
<div class="modal fade"
     id="deleteModal"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 rounded-4 shadow">

            <div class="modal-header border-0">

                <h5 class="modal-title fw-bold">

                    <i class="bi bi-exclamation-triangle text-danger me-2"></i>

                    Eliminar gasto

                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>

            </div>


            <div class="modal-body text-center py-4">

                <div class="mb-3">

                    <div class="bg-danger bg-opacity-10
                                text-danger rounded-circle
                                d-inline-flex align-items-center
                                justify-content-center"
                         style="width:70px;height:70px;">

                        <i class="bi bi-trash fs-3"></i>

                    </div>

                </div>

                <h5 class="fw-bold">
                    ¿Deseas eliminar este gasto?
                </h5>

                <p class="text-muted mb-0">

                    Esta acción no se puede deshacer.

                </p>

            </div>


            <div class="modal-footer border-0">

                <button type="button"
                        class="btn btn-light border rounded-3"
                        data-bs-dismiss="modal">

                    Cancelar

                </button>

                <button type="button"
                        id="btnConfirmDelete"
                        class="btn btn-danger rounded-3">

                    <i class="bi bi-trash me-2"></i>
                    Eliminar

                </button>

            </div>

        </div>

    </div>

</div>


{{-- ==============================================================
    JAVASCRIPT
================================================================ --}}
@push('scripts')

<script>

let expenseIdToDelete = null;


/**
 * Abrir modal de confirmación.
 */
function confirmDelete(id)
{
    expenseIdToDelete = id;

    const modalElement =
        document.getElementById('deleteModal');

    const modal =
        new bootstrap.Modal(modalElement);

    modal.show();
}


/**
 * Confirmar eliminación.
 */
document.addEventListener('DOMContentLoaded', function () {

    const button =
        document.getElementById('btnConfirmDelete');

    button.addEventListener('click', function () {

        if (!expenseIdToDelete) {
            return;
        }

        const form =
            document.getElementById(
                `delete-form-${expenseIdToDelete}`
            );

        if (form) {

            form.submit();

        }

    });

});

</script>

@endpush

@endsection

