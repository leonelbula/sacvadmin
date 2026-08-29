@extends('layouts.app')

@section('title', 'Cierre de Caja')

@section('content')

    <div class="container-fluid py-4 mt-4">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h3 class="fw-bold mb-1">
                    <i class="bi bi-safe2 me-2 text-primary"></i>
                    Cierre de Caja
                </h3>

                <p class="text-muted mb-0">
                    Realiza el arqueo y cierre de la caja actual.
                </p>
            </div>

            <div>
                <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                    <i class="bi bi-circle-fill small me-1"></i>
                    Caja abierta
                </span>
            </div>

        </div>


        <div class="row g-4">

            {{-- ===================================================== --}}
            {{-- COLUMNA PRINCIPAL --}}
            {{-- ===================================================== --}}

            <div class="col-xl-8">

                {{-- INFORMACIÓN DE CAJA --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">

                    <div class="card-header bg-white border-0 rounded-top-4 p-4">

                        <div class="d-flex align-items-center">

                            <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-3 me-3">
                                <i class="bi bi-shop fs-4"></i>
                            </div>

                            <div>
                                <h5 class="fw-bold mb-1">
                                    Información de la caja
                                </h5>

                                <small class="text-muted">
                                    Datos de la jornada actual
                                </small>
                            </div>

                        </div>

                    </div>


                    <div class="card-body pt-0">

                        <div class="row g-3">

                            <div class="col-md-4">

                                <label class="text-muted small">
                                    Caja
                                </label>

                                <div class="fw-semibold mt-1">
                                    Caja Principal
                                </div>

                            </div>


                            <div class="col-md-4">

                                <label class="text-muted small">
                                    Usuario
                                </label>

                                <div class="fw-semibold mt-1">
                                    {{ $box->user->name }}
                                </div>

                            </div>


                            <div class="col-md-4">

                                <label class="text-muted small">
                                    Código
                                </label>

                                <div class="fw-semibold mt-1">
                                    POS-{{ $box->id }}
                                </div>

                            </div>


                            <div class="col-md-4">

                                <label class="text-muted small">
                                    Fecha de apertura
                                </label>

                                <div class="fw-semibold mt-1">
                                    {{ $box->start_date }}
                                </div>

                            </div>


                            <div class="col-md-4">

                                <label class="text-muted small">
                                    Hora de apertura
                                </label>

                                <div class="fw-semibold mt-1">
                                    {{ date('h:i:s A', strtotime($box->start_time)) }}
                                </div>

                            </div>


                            <div class="col-md-4">

                                <label class="text-muted small">
                                    Base inicial
                                </label>

                                <div class="fw-semibold mt-1">
                                    {{ number_format($box->box_base, 0, ',', '.') }}
                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- RESUMEN DE VENTAS --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">

                    <div class="card-header bg-white border-0 rounded-top-4 p-4">

                        <h5 class="fw-bold mb-1">
                            <i class="bi bi-graph-up-arrow me-2 text-primary"></i>
                            Resumen de ventas
                        </h5>

                        <small class="text-muted">
                            Ventas realizadas durante la jornada
                        </small>

                    </div>


                    <div class="card-body pt-0">

                        <div class="row g-3">

                            <div class="col-md-4">

                                <div class="bg-light rounded-4 p-3">

                                    <span class="text-muted small">
                                        Número de ventas
                                    </span>

                                    <h4 class="fw-bold mb-0 mt-1">
                                        {{ $quantity }}
                                    </h4>

                                </div>

                            </div>


                            <div class="col-md-4">

                                <div class="bg-light rounded-4 p-3">

                                    <span class="text-muted small">

                                    </span>

                                    <h4 class="fw-bold mb-0 mt-1">

                                    </h4>

                                </div>

                            </div>


                            <div class="col-md-4">

                                <div class="bg-primary bg-opacity-10 rounded-4 p-3">

                                    <span class="text-primary small">
                                        Total ventas
                                    </span>

                                    <h4 class="fw-bold text-primary mb-0 mt-1">
                                        {{ number_format($totalSales, 0, ',', '.') }}
                                    </h4>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- MEDIOS DE PAGO --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">

                    <div class="card-header bg-white border-0 rounded-top-4 p-4">

                        <h5 class="fw-bold mb-1">
                            <i class="bi bi-credit-card me-2 text-primary"></i>
                            Resumen por medio de pago
                        </h5>

                        <small class="text-muted">
                            Valores registrados en el sistema
                        </small>

                    </div>


                    <div class="card-body pt-0">
                        @php
                            $efectivo = 0
                        @endphp
                        @foreach ($sales as $sale)
                            @if ($sale->paymentMethod->name == 'Efectivo')
                                <div class="d-flex justify-content-between align-items-center border-bottom py-3">

                                    <div class="d-flex align-items-center">

                                        <div class="bg-success bg-opacity-10 text-success rounded-3 p-2 me-3">
                                            <i class="bi bi-cash-stack fs-5"></i>
                                        </div>

                                        <div>
                                            <div class="fw-semibold">
                                                Efectivo
                                            </div>

                                            <small class="text-muted">
                                                {{ $sale->quantity }} operaciones
                                            </small>
                                        </div>

                                    </div>

                                    <span class="fw-bold">
                                        @php
                                            $efectivo = $sale->total
                                        @endphp
                                      $  {{ number_format($sale->total, 0, ',', '.') }}
                                    </span>

                                </div>
                            @elseif ($sale->paymentMethod->name == 'NEQUI')
                                <div class="d-flex justify-content-between align-items-center border-bottom py-3">

                                    <div class="d-flex align-items-center">

                                        <div class="bg-info bg-opacity-10 text-info rounded-3 p-2 me-3">
                                            <i class="bi bi-bank fs-5"></i>
                                        </div>

                                        <div>
                                            <div class="fw-semibold">
                                                {{ $sale->paymentMethod->name }}
                                            </div>

                                            <small class="text-muted">
                                                {{ $sale->quantity }} operaciones
                                            </small>
                                        </div>

                                    </div>

                                    <span class="fw-bold">
                                       $  {{ number_format($sale->total, 0, ',', '.') }}
                                    </span>

                                </div>
                            @else
                            <div class="d-flex justify-content-between align-items-center border-bottom py-3">

                                    <div class="d-flex align-items-center">

                                        <div class="bg-info bg-opacity-10 text-info rounded-3 p-2 me-3">
                                            <i class="bi bi-bank fs-5"></i>
                                        </div>

                                        <div>
                                            <div class="fw-semibold">
                                                {{ $sale->paymentMethod->name }}
                                            </div>

                                            <small class="text-muted">
                                                {{ $sale->quantity }} operaciones
                                            </small>
                                        </div>

                                    </div>

                                    <span class="fw-bold">
                                        $850.000
                                    </span>

                                </div>
                            @endif
                        @endforeach
                        {{-- EFECTIVO --}}



                        {{-- TRANSFERENCIA --}}



                        {{-- TARJETA --}}
                        <div class="d-flex justify-content-between align-items-center border-bottom py-3">

                            <div class="d-flex align-items-center">

                                <div class="bg-warning bg-opacity-10 text-warning rounded-3 p-2 me-3">
                                    <i class="bi bi-credit-card-2-front fs-5"></i>
                                </div>

                                <div>
                                    <div class="fw-semibold">
                                        Gastos Registrados
                                    </div>

                                    <small class="text-muted">
                                        15 operaciones
                                    </small>
                                </div>

                            </div>

                            <span class="fw-bold">
                                $850.000
                            </span>

                        </div>


                        {{-- TOTAL --}}
                        <div class="d-flex justify-content-between align-items-center pt-4">

                            <span class="fw-bold">
                                Total ventas
                            </span>

                            <span class="fs-5 fw-bold text-primary">
                                $ {{ number_format($totalSales, 0, ',', '.') }}
                            </span>

                        </div>

                    </div>

                </div>




            </div>


            {{-- ===================================================== --}}
            {{-- COLUMNA ARQUEO --}}
            {{-- ===================================================== --}}

            <div class="col-xl-4 ">

                <div class="card border-0 shadow rounded-4 sticky-top" style="top: 20px; z-index: 10">

                    <div class="card-header bg-primary text-white border-0 rounded-top-4 p-4">

                        <h5 class="fw-bold mb-1">
                            <i class="bi bi-calculator me-2"></i>
                            Arqueo de Caja
                        </h5>

                        <small class="opacity-75">
                            Verifique el efectivo antes de cerrar
                        </small>

                    </div>


                    <div class="card-body p-4">

                        {{-- BASE INICIAL --}}
                        <div class="d-flex justify-content-between mb-3">

                            <span class="text-muted">
                                Base inicial
                            </span>

                            <span class="fw-semibold">
                                {{ number_format($box->box_base, 0, ',', '.') }}
                            </span>

                        </div>


                        {{-- VENTAS EFECTIVO --}}
                        <div class="d-flex justify-content-between mb-3">

                            <span class="text-muted">
                                Ventas en efectivo
                            </span>

                            <span class="fw-semibold">
                              {{ number_format($efectivo, 0, ',', '.') }}
                            </span>

                        </div>


                        <hr>


                        {{-- EFECTIVO ESPERADO --}}
                        <div class="d-flex justify-content-between align-items-center mb-4">

                            <span class="fw-bold">
                                Efectivo esperado
                            </span>
                            <input type="hidden" id="cash" value="{{$efectivo}}">
                            <span class="fs-5 fw-bold text-primary">
                               {{ number_format($efectivo, 0, ',', '.') }}
                            </span>

                        </div>


                        {{-- EFECTIVO RECIBIDO --}}
                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Efectivo recibido
                            </label>

                            <div class="input-group input-group-lg">

                                <span class="input-group-text">
                                    $
                                </span>

                                <input type="number" name="deliveredValue" id="deliveredValue" class="form-control text-end fw-bold"
                                    placeholder="0" value="0">

                            </div>

                            <small class="text-muted">
                                Digite el dinero contado físicamente.
                            </small>

                        </div>


                        {{-- DIFERENCIA --}}
                        <div class="rounded-4 p-4 bg-success bg-opacity-10 mb-4">

                            <div class="d-flex justify-content-between align-items-center">

                                <div>

                                    <small class="text-muted d-block">
                                        Diferencia
                                    </small>

                                    <span class="fw-bold text-success" id="tex_box">
                                        -
                                    </span>

                                </div>

                                <div class="text-end">

                                    <span class="fs-4 fw-bold text-success" id="tex_val_box">
                                        $0
                                    </span>

                                </div>

                            </div>

                        </div>




                        {{-- ALERTA --}}
                        <div class="alert alert-warning border-0 rounded-3 small">

                            <i class="bi bi-exclamation-triangle me-2"></i>

                            Una vez realizado el cierre no podrá modificar
                            los valores de esta caja.

                        </div>


                        {{-- BOTÓN CERRAR --}}
                        <button type="button" class="btn btn-danger btn-lg w-100 rounded-3" data-bs-toggle="modal"
                            data-bs-target="#confirmCloseModal">

                            <i class="bi bi-lock-fill me-2"></i>
                            Cerrar Caja

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ===================================================== --}}
    {{-- MODAL CONFIRMAR CIERRE --}}
    {{-- ===================================================== --}}

    <div class="modal fade" id="confirmCloseModal" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content border-0 shadow rounded-4">

                <div class="modal-header border-0">

                    <h5 class="modal-title fw-bold">
                        <i class="bi bi-lock-fill text-danger me-2"></i>
                        Confirmar cierre
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                </div>


                <div class="modal-body text-center px-4">

                    <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-inline-flex p-3 mb-3">

                        <i class="bi bi-safe2 fs-2"></i>

                    </div>

                    <h5 class="fw-bold">
                        ¿Desea cerrar esta caja?
                    </h5>

                    <p class="text-muted mb-0">
                        Está a punto de finalizar la jornada de caja.
                        Esta operación no podrá deshacerse.
                    </p>

                </div>


                <div class="modal-footer border-0">

                    <button type="button" class="btn btn-light border rounded-3" data-bs-dismiss="modal">
                        Cancelar
                    </button>

                    <button type="button" class="btn btn-danger rounded-3 px-4">
                        <i class="bi bi-lock-fill me-2"></i>
                        Confirmar cierre
                    </button>

                </div>

            </div>

        </div>

    </div>
<script>
    const deliveredValue = document.getElementById('deliveredValue');
    const cash = document.getElementById('cash');
    const tex_box = document.getElementById('tex_box');
    const tex_val_box = document.getElementById('tex_val_box');
    deliveredValue.addEventListener("change", validarbox);

    function validarbox() {
        let cashV = parseInt(cash.value, 10);
        let deliveredVal = parseInt(deliveredValue.value, 10);
        let total = deliveredVal -  cashV;

       if(total == 0){
        tex_box.textContent = 'Caja cuadrada';
        tex_val_box.textContent = total

         tex_box.classList.remove('text-danger');
        tex_val_box.classList.remove('text-danger');

        tex_box.classList.add('text-success');
        tex_val_box.classList.add('text-success');
       }else{
        tex_box.textContent = 'Caja descuadrada';
        tex_val_box.textContent = total
        tex_box.classList.remove('text-success');
        tex_val_box.classList.remove('text-success');

        tex_box.classList.add('text-danger');
        tex_val_box.classList.add('text-danger');
       }

    }
</script>

@endsection

