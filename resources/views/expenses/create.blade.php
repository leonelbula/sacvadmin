
@extends('layouts.app')

@section('title', 'Nuevo gasto')

@section('content')

<div class="container-fluid py-4 mt-4">

    {{-- ==========================================================
        ENCABEZADO
    =========================================================== --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">

        <div>

            <div class="d-flex align-items-center gap-2 mb-1">

                <a href="{{ route('expenses.index') }}"
                   class="btn btn-light border rounded-3">

                    <i class="bi bi-arrow-left"></i>

                </a>

                <h2 class="fw-bold mb-0">
                    Nuevo gasto
                </h2>

            </div>

            <p class="text-muted mb-0 ms-5">
                Registra un nuevo gasto de la empresa.
            </p>

        </div>

    </div>


    {{-- ==========================================================
        ERRORES GENERALES
    =========================================================== --}}
    @if($errors->any())

        <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4">

            <div class="d-flex align-items-start">

                <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>

                <div>

                    <h6 class="fw-bold mb-2">
                        No se pudo registrar el gasto
                    </h6>

                    <ul class="mb-0 ps-3">

                        @foreach($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            </div>

        </div>

    @endif


    {{-- ==========================================================
        FORMULARIO
    =========================================================== --}}
    <form id="expenseForm"
          action="{{ route('expenses.store') }}"
          method="POST">

        @csrf


        <div class="row g-4">

            {{-- ==================================================
                INFORMACIÓN DEL GASTO
            =================================================== --}}
            <div class="col-xl-8">

                <div class="card border-0 shadow-sm rounded-4">

                    <div class="card-header bg-white border-0 p-4">

                        <div class="d-flex align-items-center">

                            <div class="bg-primary bg-opacity-10
                                        text-primary rounded-3 p-2 me-3">

                                <i class="bi bi-receipt fs-4"></i>

                            </div>

                            <div>

                                <h5 class="fw-bold mb-1">
                                    Información del gasto
                                </h5>

                                <small class="text-muted">
                                    Ingresa los datos correspondientes
                                    al gasto.
                                </small>

                            </div>

                        </div>

                    </div>


                    <div class="card-body p-4">

                        <div class="row g-4">

                            {{-- DESCRIPCIÓN --}}
                            <div class="col-12">

                                <label for="description"
                                       class="form-label fw-semibold">

                                    Descripción
                                    <span class="text-danger">*</span>

                                </label>

                                <input type="text"
                                       id="description"
                                       name="description"
                                       class="form-control form-control-lg
                                              rounded-3
                                              @error('description') is-invalid @enderror"
                                       value="{{ old('description') }}"
                                       placeholder="Ej: Compra de papelería"
                                       maxlength="255"
                                       required>

                                @error('description')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>


                            {{-- TOTAL --}}
                            <div class="col-md-6">

                                <label for="total"
                                       class="form-label fw-semibold">

                                    Valor del gasto
                                    <span class="text-danger">*</span>

                                </label>

                                <div class="input-group input-group-lg">

                                    <span class="input-group-text bg-light">
                                        $
                                    </span>

                                    <input type="text"
                                           id="total"
                                           name="total"
                                           class="form-control fw-bold
                                                  @error('total') is-invalid @enderror"
                                           value="{{ old('total') }}"
                                           placeholder="0"
                                           inputmode="numeric"
                                           autocomplete="off"
                                           required>

                                </div>

                                <div class="form-text">
                                    Ingresa el valor en pesos colombianos.
                                </div>

                                @error('total')

                                    <div class="text-danger small mt-1">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>


                            {{-- FECHA --}}
                            <div class="col-md-3">

                                <label for="date"
                                       class="form-label fw-semibold">

                                    Fecha
                                    <span class="text-danger">*</span>

                                </label>

                                <input type="date"
                                       id="date"
                                       name="date"
                                       class="form-control form-control-lg
                                              rounded-3
                                              @error('date') is-invalid @enderror"
                                       value="{{ old('date', now()->format('Y-m-d')) }}"
                                       required>

                                @error('date')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>


                            {{-- HORA --}}
                            <div class="col-md-3">

                                <label for="hour"
                                       class="form-label fw-semibold">

                                    Hora
                                    <span class="text-danger">*</span>

                                </label>

                                <input type="time"
                                       id="hour"
                                       name="hour"
                                       class="form-control form-control-lg
                                              rounded-3
                                              @error('hour') is-invalid @enderror"
                                       value="{{ old('hour', now()->format('H:i')) }}"
                                       required>

                                @error('hour')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>


                            {{-- TIPO DE GASTO --}}
                            <div class="col-md-6">

                                <label for="type_expense_id"
                                       class="form-label fw-semibold">

                                    Tipo de gasto
                                    <span class="text-danger">*</span>

                                </label>

                                <select id="type_expense_id"
                                        name="type_expense_id"
                                        class="form-select form-select-lg
                                               rounded-3
                                               @error('type_expense_id') is-invalid @enderror"
                                        required>

                                    <option value="">
                                        Seleccione un tipo
                                    </option>

                                    @foreach($typeExpenses ?? [] as $typeExpense)

                                        <option value="{{ $typeExpense->id }}"
                                            @selected(
                                                old('type_expense_id')
                                                == $typeExpense->id
                                            )>

                                            {{ $typeExpense->description }}

                                        </option>

                                    @endforeach

                                </select>

                                @error('type_expense_id')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>


                            {{-- MÉTODO DE PAGO --}}
                            <div class="col-md-6">

                                <label for="payment_method_id"
                                       class="form-label fw-semibold">

                                    Método de pago
                                    <span class="text-danger">*</span>

                                </label>

                                <select id="payment_method_id"
                                        name="payment_method_id"
                                        class="form-select form-select-lg
                                               rounded-3
                                               @error('payment_method_id') is-invalid @enderror"
                                        required>

                                    <option value="">
                                        Seleccione un método
                                    </option>

                                    @foreach($paymentMethods ?? [] as $paymentMethod)

                                        <option value="{{ $paymentMethod->id }}"
                                            @selected(
                                                old('payment_method_id')
                                                == $paymentMethod->id
                                            )>

                                            {{ $paymentMethod->name }}

                                        </option>

                                    @endforeach

                                </select>

                                @error('payment_method_id')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>


                            {{-- ENTREGADO A --}}
                            <div class="col-12">

                                <label for="delivered_to"
                                       class="form-label fw-semibold">

                                    Entregado a
                                    <span class="text-danger">*</span>

                                </label>

                                <input type="text"
                                       id="delivered_to"
                                       name="delivered_to"
                                       class="form-control form-control-lg
                                              rounded-3
                                              @error('delivered_to') is-invalid @enderror"
                                       value="{{ old('delivered_to') }}"
                                       placeholder="Nombre de la persona que recibió el dinero"
                                       maxlength="255"
                                       required>

                                @error('delivered_to')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>


                            {{-- OBSERVACIÓN --}}
                            <div class="col-12">

                                <label for="observation"
                                       class="form-label fw-semibold">

                                    Observación

                                </label>

                                <textarea id="observation"
                                          name="observation"
                                          class="form-control rounded-3
                                                 @error('observation') is-invalid @enderror"
                                          rows="4"
                                          placeholder="Agrega información adicional sobre el gasto...">{{ old('observation') }}</textarea>

                                @error('observation')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ==================================================
                RESUMEN
            =================================================== --}}
            <div class="col-xl-4">

                <div class="card border-0 shadow-sm rounded-4 sticky-top"
                     style="top: 20px;">

                    <div class="card-header bg-primary text-white
                                border-0 rounded-top-4 p-4">

                        <div class="d-flex align-items-center">

                            <i class="bi bi-calculator fs-4 me-3"></i>

                            <div>

                                <h5 class="fw-bold mb-0">
                                    Resumen
                                </h5>

                                <small class="opacity-75">
                                    Información del gasto
                                </small>

                            </div>

                        </div>

                    </div>


                    <div class="card-body p-4">

                        {{-- VALOR --}}
                        <div class="d-flex justify-content-between
                                    align-items-center mb-3">

                            <span class="text-muted">
                                Valor
                            </span>

                            <strong id="summaryTotal"
                                    class="fs-4 text-danger">

                                $0

                            </strong>

                        </div>


                        <hr>


                        {{-- FECHA --}}
                        <div class="mb-3">

                            <small class="text-muted d-block mb-1">
                                Fecha
                            </small>

                            <span id="summaryDate"
                                  class="fw-semibold">

                                {{ now()->format('d/m/Y') }}

                            </span>

                        </div>


                        {{-- TIPO --}}
                        <div class="mb-3">

                            <small class="text-muted d-block mb-1">
                                Tipo de gasto
                            </small>

                            <span id="summaryType"
                                  class="fw-semibold">

                                No seleccionado

                            </span>

                        </div>


                        {{-- MÉTODO --}}
                        <div class="mb-3">

                            <small class="text-muted d-block mb-1">
                                Método de pago
                            </small>

                            <span id="summaryPayment"
                                  class="fw-semibold">

                                No seleccionado

                            </span>

                        </div>


                        {{-- ENTREGADO --}}
                        <div class="mb-4">

                            <small class="text-muted d-block mb-1">
                                Entregado a
                            </small>

                            <span id="summaryDelivered"
                                  class="fw-semibold">

                                No especificado

                            </span>

                        </div>


                        <div class="alert alert-warning border-0 rounded-3">

                            <div class="d-flex">

                                <i class="bi bi-info-circle me-2"></i>

                                <small>
                                    Verifica que la información del gasto
                                    sea correcta antes de guardarlo.
                                </small>

                            </div>

                        </div>


                        {{-- GUARDAR --}}
                        <button type="submit"
                                id="btnSaveExpense"
                                class="btn btn-primary btn-lg
                                       w-100 rounded-3">

                            <span id="saveText">

                                <i class="bi bi-check-lg me-2"></i>

                                Registrar gasto

                            </span>

                            <span id="saveLoading"
                                  class="d-none">

                                <span class="spinner-border spinner-border-sm
                                             me-2">
                                </span>

                                Guardando...

                            </span>

                        </button>


                        {{-- CANCELAR --}}
                        <a href="{{ route('expenses.index') }}"
                           id="btnCancel"
                           class="btn btn-light border
                                  btn-lg w-100 rounded-3 mt-2">

                            Cancelar

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </form>

</div>


{{-- ==============================================================
    MODAL CONFIRMAR SALIDA
================================================================ --}}
<div class="modal fade"
     id="cancelModal"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 rounded-4 shadow">

            <div class="modal-header border-0">

                <h5 class="modal-title fw-bold">

                    <i class="bi bi-exclamation-triangle text-warning me-2"></i>

                    ¿Salir del formulario?

                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body">

                <p class="text-muted mb-0">

                    Los datos que hayas ingresado no se guardarán.

                </p>

            </div>

            <div class="modal-footer border-0">

                <button type="button"
                        class="btn btn-light border rounded-3"
                        data-bs-dismiss="modal">

                    Continuar editando

                </button>

                <a href="{{ route('expenses.index') }}"
                   class="btn btn-danger rounded-3">

                    Salir

                </a>

            </div>

        </div>

    </div>

</div>



<script>

document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('expenseForm');

    const totalInput = document.getElementById('total');

    const dateInput = document.getElementById('date');

    const typeInput = document.getElementById('type_expense_id');

    const paymentInput = document.getElementById('payment_method_id');

    const deliveredInput = document.getElementById('delivered_to');

    const summaryTotal = document.getElementById('summaryTotal');

    const summaryDate = document.getElementById('summaryDate');

    const summaryType = document.getElementById('summaryType');

    const summaryPayment = document.getElementById('summaryPayment');

    const summaryDelivered = document.getElementById('summaryDelivered');

    const btnSave = document.getElementById('btnSaveExpense');

    const saveText = document.getElementById('saveText');

    const saveLoading = document.getElementById('saveLoading');

    const btnCancel = document.getElementById('btnCancel');


    /*
    |--------------------------------------------------------------------------
    | FORMATEAR MONEDA
    |--------------------------------------------------------------------------
    */

    function formatCurrency(value)
    {
        if (!value) {
            return '$0';
        }

        const number = parseInt(
            value.toString().replace(/\D/g, ''),
            10
        ) || 0;

        return '$' + new Intl.NumberFormat('es-CO').format(number);
    }


    /*
    |--------------------------------------------------------------------------
    | LIMPIAR VALOR
    |--------------------------------------------------------------------------
    */

    function getNumericValue(value)
    {
        return value
            .toString()
            .replace(/\D/g, '');
    }


    /*
    |--------------------------------------------------------------------------
    | TOTAL
    |--------------------------------------------------------------------------
    */

    function updateTotal()
    {
        const numericValue =
            getNumericValue(totalInput.value);

        totalInput.value =
            numericValue
                ? new Intl.NumberFormat('es-CO').format(numericValue)
                : '';

        summaryTotal.textContent =
            formatCurrency(numericValue);
    }


    totalInput.addEventListener('input', updateTotal);


    /*
    |--------------------------------------------------------------------------
    | FECHA
    |--------------------------------------------------------------------------
    */

    function updateDate()
    {
        if (!dateInput.value) {

            summaryDate.textContent =
                'No seleccionada';

            return;
        }

        const parts =
            dateInput.value.split('-');

        summaryDate.textContent =
            `${parts[2]}/${parts[1]}/${parts[0]}`;
    }


    dateInput.addEventListener('change', updateDate);


    /*
    |--------------------------------------------------------------------------
    | TIPO DE GASTO
    |--------------------------------------------------------------------------
    */

    typeInput.addEventListener('change', function () {

        const option =
            typeInput.options[typeInput.selectedIndex];

        summaryType.textContent =
            option.value
                ? option.text
                : 'No seleccionado';

    });


    /*
    |--------------------------------------------------------------------------
    | MÉTODO DE PAGO
    |--------------------------------------------------------------------------
    */

    paymentInput.addEventListener('change', function () {

        const option =
            paymentInput.options[paymentInput.selectedIndex];

        summaryPayment.textContent =
            option.value
                ? option.text
                : 'No seleccionado';

    });


    /*
    |--------------------------------------------------------------------------
    | ENTREGADO A
    |--------------------------------------------------------------------------
    */

    deliveredInput.addEventListener('input', function () {

        summaryDelivered.textContent =
            deliveredInput.value.trim()
                ? deliveredInput.value
                : 'No especificado';

    });


    /*
    |--------------------------------------------------------------------------
    | SUBMIT
    |--------------------------------------------------------------------------
    */

    form.addEventListener('submit', function () {

        /*
         * Antes de enviar eliminamos los separadores
         * de miles.
         *
         * Ejemplo:
         *
         * 1.500.000
         *
         * se convierte en:
         *
         * 1500000
         */

        totalInput.value =
            getNumericValue(totalInput.value);


        btnSave.disabled = true;

        saveText.classList.add('d-none');

        saveLoading.classList.remove('d-none');

    });


    /*
    |--------------------------------------------------------------------------
    | CONFIRMACIÓN AL CANCELAR
    |--------------------------------------------------------------------------
    */

    btnCancel.addEventListener('click', function (event) {

        event.preventDefault();

        const modalElement =
            document.getElementById('cancelModal');

        const modal =
            new bootstrap.Modal(modalElement);

        modal.show();

    });


    /*
    |--------------------------------------------------------------------------
    | INICIALIZAR
    |--------------------------------------------------------------------------
    */

    updateTotal();

    updateDate();

});

</script>



@endsection

