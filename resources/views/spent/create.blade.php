```html
@extends('layouts.app')

@section('title', 'Nuevo gasto')

@section('content')

    <div class="container-fluid py-4">

        {{-- ============================================================
         ENCABEZADO
    ============================================================ --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">

            <div>
                <div class="d-flex align-items-center gap-2 mb-1">

                    <a href="{{ route('spent.index') }}" class="btn btn-light border rounded-3">

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


        {{-- ============================================================
         FORMULARIO
    ============================================================ --}}
        <form action="{{ route('spent.store') }}" method="POST" enctype="multipart/form-data">

            @csrf

            <div class="row g-4">

                {{-- ====================================================
                 INFORMACIÓN DEL GASTO
            ==================================================== --}}
                <div class="col-xl-8">

                    <div class="card border-0 shadow-sm rounded-4">

                        <div class="card-header bg-white border-0 p-4">

                            <h5 class="fw-bold mb-1">
                                <i class="bi bi-receipt text-primary me-2"></i>
                                Información del gasto
                            </h5>

                            <p class="text-muted small mb-0">
                                Ingresa los datos correspondientes al gasto.
                            </p>

                        </div>


                        <div class="card-body p-4">

                            <div class="row g-4">

                                {{-- Descripción --}}
                                <div class="col-12">

                                    <label for="description" class="form-label fw-semibold">

                                        Descripción
                                        <span class="text-danger">*</span>

                                    </label>

                                    <input type="text" id="description" name="description"
                                        class="form-control form-control-lg
                                              @error('description') is-invalid @enderror"
                                        value="{{ old('description') }}" placeholder="Ej: Pago servicio de energía"
                                        maxlength="255" required>

                                    @error('description')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>


                                {{-- Categoría --}}
                                <div class="col-md-6">

                                    <label for="expense_category_id" class="form-label fw-semibold">

                                        Categoría
                                        <span class="text-danger">*</span>

                                    </label>

                                    <select id="expense_category_id" name="expense_category_id"
                                        class="form-select
                                               @error('expense_category_id') is-invalid @enderror"
                                        required>

                                        <option value="">
                                            Seleccionar categoría
                                        </option>

                                        @foreach ($categories ?? [] as $category)
                                            <option value="{{ $category->id }}" @selected(old('expense_category_id') == $category->id)>

                                                {{ $category->name }}

                                            </option>
                                        @endforeach

                                    </select>

                                    @error('expense_category_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>


                                {{-- Fecha --}}
                                <div class="col-md-6">

                                    <label for="expense_date" class="form-label fw-semibold">

                                        Fecha del gasto
                                        <span class="text-danger">*</span>

                                    </label>

                                    <input type="date" id="expense_date" name="expense_date"
                                        class="form-control
                                              @error('expense_date') is-invalid @enderror"
                                        value="{{ old('expense_date', date('Y-m-d')) }}" required>

                                    @error('expense_date')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>


                                {{-- Valor --}}
                                <div class="col-md-6">

                                    <label for="amount" class="form-label fw-semibold">

                                        Valor del gasto
                                        <span class="text-danger">*</span>

                                    </label>

                                    <div class="input-group input-group-lg">

                                        <span class="input-group-text">
                                            $
                                        </span>

                                        <input type="number" id="amount" name="amount"
                                            class="form-control
                                                  @error('amount') is-invalid @enderror"
                                            value="{{ old('amount') }}" min="0" step="1" placeholder="0"
                                            required>

                                    </div>

                                    @error('amount')
                                        <div class="text-danger small mt-1">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                    <small class="text-muted">
                                        Ingresa el valor total del gasto.
                                    </small>

                                </div>


                                {{-- Método de pago --}}
                                <div class="col-md-6">

                                    <label for="payment_method_id" class="form-label fw-semibold">

                                        Método de pago
                                        <span class="text-danger">*</span>

                                    </label>

                                    <select id="payment_method_id" name="payment_method_id"
                                        class="form-select form-select-lg
                                               @error('payment_method_id') is-invalid @enderror"
                                        required>

                                        <option value="">
                                            Seleccionar método
                                        </option>

                                        @foreach ($paymentMethods ?? [] as $paymentMethod)
                                            <option value="{{ $paymentMethod->id }}" @selected(old('payment_method_id') == $paymentMethod->id)>

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


                                {{-- Proveedor / Beneficiario --}}
                                <div class="col-12">

                                    <label for="beneficiary" class="form-label fw-semibold">

                                        Proveedor / Beneficiario

                                    </label>

                                    <input type="text" id="beneficiary" name="beneficiary"
                                        class="form-control
                                              @error('beneficiary') is-invalid @enderror"
                                        value="{{ old('beneficiary') }}"
                                        placeholder="Nombre del proveedor o persona que recibió el pago" maxlength="255">

                                    @error('beneficiary')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>


                                {{-- Observaciones --}}
                                <div class="col-12">

                                    <label for="observations" class="form-label fw-semibold">

                                        Observaciones

                                    </label>

                                    <textarea id="observations" name="observations" rows="5"
                                        class="form-control
                                                 @error('observations') is-invalid @enderror"
                                        placeholder="Agrega información adicional sobre el gasto...">{{ old('observations') }}</textarea>

                                    @error('observations')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                     COMPROBANTE
                ================================================== --}}
                    <div class="card border-0 shadow-sm rounded-4 mt-4">

                        <div class="card-header bg-white border-0 p-4">

                            <h5 class="fw-bold mb-1">

                                <i class="bi bi-paperclip text-primary me-2"></i>

                                Comprobante

                            </h5>

                            <p class="text-muted small mb-0">
                                Adjunta una factura, recibo o comprobante del gasto.
                            </p>

                        </div>


                        <div class="card-body p-4">

                            <div
                                class="border border-2 border-dashed
                                    rounded-4 p-5 text-center">

                                <div class="mb-3">

                                    <i class="bi bi-cloud-arrow-up
                                          text-primary"
                                        style="font-size: 3rem;">
                                    </i>

                                </div>

                                <h6 class="fw-bold">
                                    Adjuntar comprobante
                                </h6>

                                <p class="text-muted small mb-3">
                                    PDF, JPG, JPEG o PNG.
                                </p>

                                <label for="attachment" class="btn btn-outline-primary rounded-3">

                                    <i class="bi bi-upload me-2"></i>
                                    Seleccionar archivo

                                </label>

                                <input type="file" id="attachment" name="attachment" class="d-none"
                                    accept=".pdf,.jpg,.jpeg,.png">

                                <div id="fileName" class="text-muted small mt-3">
                                </div>

                            </div>

                            @error('attachment')
                                <div class="text-danger small mt-2">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>

                </div>


                {{-- ====================================================
                 RESUMEN
            ==================================================== --}}
                <div class="col-xl-4">

                    <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 20px; z-index: 10">

                        <div
                            class="card-header bg-primary text-white
                                border-0 rounded-top-4 p-4">

                            <div class="d-flex align-items-center">

                                <div
                                    class="bg-white bg-opacity-25
                                        rounded-3 p-2 me-3">

                                    <i class="bi bi-wallet2 fs-4"></i>

                                </div>

                                <div>

                                    <h5 class="mb-0 fw-bold">
                                        Resumen del gasto
                                    </h5>

                                    <small class="opacity-75">
                                        Información del registro
                                    </small>

                                </div>

                            </div>

                        </div>


                        <div class="card-body p-4">

                            {{-- Valor --}}
                            <div
                                class="d-flex justify-content-between
                                    align-items-center mb-3">

                                <span class="text-muted">
                                    Valor
                                </span>

                                <span id="summaryAmount" class="fw-bold fs-5">

                                    $ 0

                                </span>

                            </div>


                            <hr>


                            {{-- Categoría --}}
                            <div
                                class="d-flex justify-content-between
                                    align-items-center mb-3">

                                <span class="text-muted">
                                    Categoría
                                </span>

                                <span id="summaryCategory" class="fw-semibold">

                                    Sin seleccionar

                                </span>

                            </div>


                            {{-- Método --}}
                            <div
                                class="d-flex justify-content-between
                                    align-items-center mb-3">

                                <span class="text-muted">
                                    Método de pago
                                </span>

                                <span id="summaryPayment" class="fw-semibold">

                                    Sin seleccionar

                                </span>

                            </div>


                            {{-- Fecha --}}
                            <div
                                class="d-flex justify-content-between
                                    align-items-center mb-3">

                                <span class="text-muted">
                                    Fecha
                                </span>

                                <span id="summaryDate" class="fw-semibold">

                                    {{ date('d/m/Y') }}

                                </span>

                            </div>


                            <hr>


                            {{-- Total --}}
                            <div
                                class="d-flex justify-content-between
                                    align-items-center">

                                <span class="fw-bold">
                                    Total
                                </span>

                                <span id="summaryTotal" class="fw-bold text-danger fs-4">

                                    $ 0

                                </span>

                            </div>

                        </div>


                        <div class="card-footer bg-white border-0 p-4">

                            <button type="submit"
                                class="btn btn-primary btn-lg
                                       w-100 rounded-3 mb-2">

                                <i class="bi bi-check-lg me-2"></i>
                                Guardar gasto

                            </button>


                            <a href="{{ route('spent.index') }}"
                                class="btn btn-light border btn-lg
                                  w-100 rounded-3">

                                Cancelar

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </form>

    </div>


    {{-- ================================================================
     JAVASCRIPT
================================================================ --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const amount = document.getElementById('amount');
            const category = document.getElementById('expense_category_id');
            const payment = document.getElementById('payment_method_id');
            const date = document.getElementById('expense_date');

            const summaryAmount = document.getElementById('summaryAmount');
            const summaryTotal = document.getElementById('summaryTotal');
            const summaryCategory = document.getElementById('summaryCategory');
            const summaryPayment = document.getElementById('summaryPayment');
            const summaryDate = document.getElementById('summaryDate');

            const attachment = document.getElementById('attachment');
            const fileName = document.getElementById('fileName');


            // ============================================================
            // FORMATEAR DINERO
            // ============================================================

            function formatMoney(value) {

                value = Number(value) || 0;

                return '$ ' + value.toLocaleString('es-CO');

            }


            // ============================================================
            // ACTUALIZAR RESUMEN
            // ============================================================

            function updateSummary() {

                const value = amount.value;

                summaryAmount.textContent = formatMoney(value);

                summaryTotal.textContent = formatMoney(value);


                // Categoría
                if (category.value) {

                    summaryCategory.textContent =
                        category.options[category.selectedIndex].text;

                } else {

                    summaryCategory.textContent = 'Sin seleccionar';

                }


                // Método de pago
                if (payment.value) {

                    summaryPayment.textContent =
                        payment.options[payment.selectedIndex].text;

                } else {

                    summaryPayment.textContent = 'Sin seleccionar';

                }


                // Fecha
                if (date.value) {

                    const dateParts = date.value.split('-');

                    summaryDate.textContent =
                        `${dateParts[2]}/${dateParts[1]}/${dateParts[0]}`;

                }

            }


            // ============================================================
            // EVENTOS
            // ============================================================

            amount.addEventListener('input', updateSummary);

            category.addEventListener('change', updateSummary);

            payment.addEventListener('change', updateSummary);

            date.addEventListener('change', updateSummary);


            // ============================================================
            // ARCHIVO
            // ============================================================

            attachment.addEventListener('change', function() {

                if (this.files.length > 0) {

                    fileName.innerHTML =
                        `<i class="bi bi-file-earmark-check me-1"></i>
                 ${this.files[0].name}`;

                } else {

                    fileName.textContent = '';

                }

            });


            // Inicializar
            updateSummary();

        });
    </script>

@endsection
```
