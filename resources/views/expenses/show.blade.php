@extends('layouts.app')

@section('title', 'Detalle del gasto')

@section('content')

    <div class="container-fluid py-4">

        {{-- ==========================================================
        ENCABEZADO
    =========================================================== --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">

            <div>

                <div class="d-flex align-items-center gap-2 mb-1">

                    <a href="{{ route('expenses.index') }}" class="btn btn-light border rounded-3">

                        <i class="bi bi-arrow-left"></i>

                    </a>

                    <h2 class="fw-bold mb-0">
                        Detalle del gasto
                    </h2>

                </div>

                <p class="text-muted mb-0 ms-5">
                    Información completa del gasto #{{ $expense->id }}
                </p>

            </div>


            {{-- ACCIONES --}}
            <div class="d-flex gap-2">

                <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-warning rounded-3">

                    <i class="bi bi-pencil me-2"></i>
                    Editar

                </a>


                <button type="button" class="btn btn-danger rounded-3" id="btnDelete">

                    <i class="bi bi-trash me-2"></i>
                    Eliminar

                </button>

            </div>

        </div>


        {{-- ==========================================================
        INFORMACIÓN PRINCIPAL
    =========================================================== --}}
        <div class="row g-4">

            {{-- ======================================================
            COLUMNA PRINCIPAL
        ======================================================= --}}
            <div class="col-xl-8">

                {{-- ==================================================
                INFORMACIÓN DEL GASTO
            =================================================== --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">

                    <div class="card-header bg-white border-0 p-4">

                        <div class="d-flex align-items-center">

                            <div
                                class="bg-danger bg-opacity-10
                                    text-danger rounded-3 p-2 me-3">

                                <i class="bi bi-wallet2 fs-4"></i>

                            </div>

                            <div>

                                <h5 class="fw-bold mb-1">
                                    Información del gasto
                                </h5>

                                <small class="text-muted">
                                    Datos registrados
                                </small>

                            </div>

                        </div>

                    </div>


                    <div class="card-body p-4">

                        <div class="row g-4">

                            {{-- DESCRIPCIÓN --}}
                            <div class="col-md-8">

                                <small class="text-muted d-block mb-1">
                                    Descripción
                                </small>

                                <h5 class="fw-semibold mb-0">

                                    {{ $expense->description }}

                                </h5>

                            </div>


                            {{-- ID --}}
                            <div class="col-md-4">

                                <small class="text-muted d-block mb-1">
                                    Número de gasto
                                </small>

                                <h5 class="fw-semibold mb-0">

                                    #{{ $expense->id }}

                                </h5>

                            </div>


                            {{-- FECHA --}}
                            <div class="col-md-4">

                                <small class="text-muted d-block mb-1">
                                    Fecha
                                </small>

                                <div class="d-flex align-items-center">

                                    <i
                                        class="bi bi-calendar3
                                          text-primary me-2"></i>

                                    <span class="fw-semibold">

                                        {{ \Carbon\Carbon::parse($expense->date)->format('d/m/Y') }}

                                    </span>

                                </div>

                            </div>


                            {{-- HORA --}}
                            <div class="col-md-4">

                                <small class="text-muted d-block mb-1">
                                    Hora
                                </small>

                                <div class="d-flex align-items-center">

                                    <i class="bi bi-clock
                                          text-primary me-2"></i>

                                    <span class="fw-semibold">

                                        {{ \Carbon\Carbon::parse($expense->hour)->format('h:i A') }}

                                    </span>

                                </div>

                            </div>


                            {{-- TIPO --}}
                            <div class="col-md-4">

                                <small class="text-muted d-block mb-1">
                                    Tipo de gasto
                                </small>

                                @if ($expense->typeExpense)
                                    <span
                                        class="badge
                                             bg-primary bg-opacity-10
                                             text-primary
                                             rounded-pill px-3 py-2">

                                        {{ $expense->typeExpense->name }}

                                    </span>
                                @else
                                    <span class="text-muted">
                                        No especificado
                                    </span>
                                @endif

                            </div>


                            {{-- ENTREGADO A --}}
                            <div class="col-md-6">

                                <small class="text-muted d-block mb-1">
                                    Entregado a
                                </small>

                                <div class="d-flex align-items-center">

                                    <div class="bg-light rounded-circle
                                            d-flex align-items-center
                                            justify-content-center me-2"
                                        style="width:40px;height:40px;">

                                        <i class="bi bi-person text-muted"></i>

                                    </div>

                                    <span class="fw-semibold">

                                        {{ $expense->delivered_to }}

                                    </span>

                                </div>

                            </div>


                            {{-- MÉTODO DE PAGO --}}
                            <div class="col-md-6">

                                <small class="text-muted d-block mb-1">
                                    Método de pago
                                </small>

                                <div class="d-flex align-items-center">

                                    <div
                                        class="bg-success bg-opacity-10
                                            text-success rounded-3
                                            p-2 me-2">

                                        <i class="bi bi-credit-card"></i>

                                    </div>

                                    <span class="fw-semibold">

                                        {{ $expense->paymentMethod->name ?? 'No especificado' }}

                                    </span>

                                </div>

                            </div>


                            {{-- OBSERVACIÓN --}}
                            <div class="col-12">

                                <hr class="my-1">

                                <small class="text-muted d-block mb-2 mt-3">
                                    Observación
                                </small>

                                @if ($expense->observation)
                                    <div class="bg-light rounded-3 p-3">

                                        <div class="d-flex">

                                            <i
                                                class="bi bi-chat-left-text
                                                  text-muted me-2"></i>

                                            <span>

                                                {{ $expense->observation }}

                                            </span>

                                        </div>

                                    </div>
                                @else
                                    <span class="text-muted">
                                        Sin observaciones.
                                    </span>
                                @endif

                            </div>

                        </div>

                    </div>

                </div>


                {{-- ==================================================
                INFORMACIÓN DEL REGISTRO
            =================================================== --}}
                <div class="card border-0 shadow-sm rounded-4">

                    <div class="card-header bg-white border-0 p-4">

                        <h5 class="fw-bold mb-0">

                            <i class="bi bi-info-circle text-primary me-2"></i>

                            Información del registro

                        </h5>

                    </div>


                    <div class="card-body p-4">

                        <div class="row g-4">

                            {{-- USUARIO --}}
                            <div class="col-md-4">

                                <small class="text-muted d-block mb-1">
                                    Registrado por
                                </small>

                                @if ($expense->user)
                                    <div class="d-flex align-items-center">

                                        <div class="bg-primary bg-opacity-10
                                                text-primary rounded-circle
                                                d-flex align-items-center
                                                justify-content-center me-2"
                                            style="width:38px;height:38px;">

                                            {{ strtoupper(substr($expense->user->name, 0, 1)) }}

                                        </div>

                                        <span class="fw-semibold">

                                            {{ $expense->user->name }}

                                        </span>

                                    </div>
                                @else
                                    <span class="text-muted">
                                        Usuario no disponible
                                    </span>
                                @endif

                            </div>


                            {{-- CREADO --}}
                            <div class="col-md-4">

                                <small class="text-muted d-block mb-1">
                                    Fecha de creación
                                </small>

                                <span class="fw-semibold">

                                    {{ $expense->created_at ? $expense->created_at->format('d/m/Y h:i A') : '-' }}

                                </span>

                            </div>


                            {{-- ACTUALIZADO --}}
                            <div class="col-md-4">

                                <small class="text-muted d-block mb-1">
                                    Última actualización
                                </small>

                                <span class="fw-semibold">

                                    {{ $expense->updated_at ? $expense->updated_at->format('d/m/Y h:i A') : '-' }}

                                </span>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ======================================================
            COLUMNA RESUMEN
        ======================================================= --}}
            <div class="col-xl-4">

                <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 20px;">

                    <div class="card-header bg-danger text-white
                            border-0 rounded-top-4 p-4">

                        <div class="d-flex align-items-center">

                            <i class="bi bi-wallet2 fs-3 me-3"></i>

                            <div>

                                <h5 class="fw-bold mb-0">
                                    Total del gasto
                                </h5>

                                <small class="opacity-75">
                                    Valor registrado
                                </small>

                            </div>

                        </div>

                    </div>


                    <div class="card-body p-4">

                        {{-- TOTAL --}}
                        <div class="text-center py-3">

                            <small class="text-muted d-block mb-2">
                                Total
                            </small>

                            <h1 class="fw-bold text-danger mb-0">

                                ${{ number_format($expense->total, 0, ',', '.') }}

                            </h1>

                            <small class="text-muted">
                                Pesos colombianos
                            </small>

                        </div>


                        <hr>


                        {{-- TIPO --}}
                        <div class="d-flex justify-content-between
                                align-items-center py-2">

                            <span class="text-muted">
                                Tipo
                            </span>

                            <span class="fw-semibold text-end">

                                {{ $expense->typeExpense->name ?? '-' }}

                            </span>

                        </div>


                        {{-- MÉTODO --}}
                        <div
                            class="d-flex justify-content-between
                                align-items-center py-2">

                            <span class="text-muted">
                                Pago
                            </span>

                            <span class="fw-semibold text-end">

                                {{ $expense->paymentMethod->name ?? '-' }}

                            </span>

                        </div>


                        {{-- FECHA --}}
                        <div
                            class="d-flex justify-content-between
                                align-items-center py-2">

                            <span class="text-muted">
                                Fecha
                            </span>

                            <span class="fw-semibold">

                                {{ \Carbon\Carbon::parse($expense->date)->format('d/m/Y') }}

                            </span>

                        </div>


                        <hr>


                        {{-- EDITAR --}}
                        <a href="{{ route('expenses.edit', $expense->id) }}"
                            class="btn btn-warning btn-lg
                              rounded-3 w-100 mb-2">

                            <i class="bi bi-pencil me-2"></i>

                            Editar gasto

                        </a>


                        {{-- VOLVER --}}
                        <a href="{{ route('expenses.index') }}"
                            class="btn btn-light border btn-lg
                              rounded-3 w-100">

                            <i class="bi bi-arrow-left me-2"></i>

                            Volver a gastos

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ==============================================================
    FORMULARIO ELIMINAR
================================================================ --}}
    <form id="deleteExpenseForm" action="{{ route('expenses.destroy', $expense->id) }}" method="POST" class="d-none">

        @csrf
        @method('DELETE')

    </form>


    {{-- ==============================================================
    MODAL ELIMINAR
================================================================ --}}
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content border-0 rounded-4 shadow">

                <div class="modal-header border-0">

                    <h5 class="modal-title fw-bold">

                        <i class="bi bi-exclamation-triangle
                              text-danger me-2"></i>

                        Eliminar gasto

                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>

                </div>


                <div class="modal-body text-center py-4">

                    <div class="bg-danger bg-opacity-10
                            text-danger rounded-circle
                            d-inline-flex align-items-center
                            justify-content-center mb-3"
                        style="width:70px;height:70px;">

                        <i class="bi bi-trash fs-3"></i>

                    </div>

                    <h5 class="fw-bold">
                        ¿Deseas eliminar este gasto?
                    </h5>

                    <p class="text-muted mb-0">

                        Estás a punto de eliminar el gasto

                        <strong>
                            #{{ $expense->id }}
                        </strong>

                        por valor de

                        <strong>
                            ${{ number_format($expense->total, 0, ',', '.') }}
                        </strong>.

                        <br>

                        Esta acción no se puede deshacer.

                    </p>

                </div>


                <div class="modal-footer border-0">

                    <button type="button" class="btn btn-light border rounded-3" data-bs-dismiss="modal">

                        Cancelar

                    </button>

                    <button type="button" id="btnConfirmDelete" class="btn btn-danger rounded-3">

                        <i class="bi bi-trash me-2"></i>

                        Eliminar gasto

                    </button>

                </div>

            </div>

        </div>

    </div>




    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const btnDelete =
                document.getElementById('btnDelete');

            const btnConfirmDelete =
                document.getElementById('btnConfirmDelete');

            const deleteForm =
                document.getElementById('deleteExpenseForm');


            /*
            |--------------------------------------------------------------------------
            | ABRIR MODAL
            |--------------------------------------------------------------------------
            */

            btnDelete.addEventListener('click', function() {

                const modalElement =
                    document.getElementById('deleteModal');

                const modal =
                    new bootstrap.Modal(modalElement);

                modal.show();

            });


            /*
            |--------------------------------------------------------------------------
            | CONFIRMAR ELIMINACIÓN
            |--------------------------------------------------------------------------
            */

            btnConfirmDelete.addEventListener('click', function() {

                btnConfirmDelete.disabled = true;

                btnConfirmDelete.innerHTML = `
            <span class="spinner-border spinner-border-sm me-2">
            </span>
            Eliminando...
        `;

                deleteForm.submit();

            });

        });
    </script>



@endsection
