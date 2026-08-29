<!-- ==========================================================
    INFORMACIÓN DE PAGO
=========================================================== -->

<div class="card border-0 shadow-sm rounded-4 mb-4">

    <div class="card-header bg-white border-0">

        <div class="d-flex align-items-center">

            <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">

                <i class="bi bi-credit-card fs-4 text-primary"></i>

            </div>

            <div>

                <h4 class="fw-bold mb-0">

                    Información de Pago

                </h4>

                <small class="text-muted">

                    Complete la información financiera de la factura.

                </small>

            </div>

        </div>

    </div>

    <div class="card-body">

        <div class="row g-4">

            <!-- Forma de pago -->

            <div class="col-lg-4">

                <label class="form-label fw-semibold">

                    Forma de Pago

                </label>

                <select class="form-select" id="typeSale" name="payment_form">

                    <option value="counted">

                        Contado

                    </option>

                    <option value="credit">

                        Crédito

                    </option>

                </select>

            </div>

            <!-- Medio de pago -->

            <div class="col-lg-4">

                <label class="form-label fw-semibold">

                    Medio de Pago

                </label>

                <select class="form-select" id="paymentMethod" name="payment_method_id">

                    @foreach ($payments as $pay)
                        <option value="{{ $pay->id }}">

                            {{ $pay->name }}

                        </option>
                    @endforeach


                </select>

            </div>

            <!-- Vendedor -->

            <div class="col-lg-4">

                <label class="form-label fw-semibold">

                    Vendedor

                </label>

                <input type="text" class="form-control" value="{{ Auth::user()->name }}" readonly>

            </div>

            <!-- Fecha vencimiento -->

            <div class="col-lg-4" id="creditDateContainer" style="display:none;">

                <label class="form-label fw-semibold">

                    Plazo

                </label>

                <input type="number" class="form-control" id="dueDate" name="term" value="0">

            </div>

            <!-- Valor recibido -->

            <div class="col-lg-4">

                <label class="form-label fw-semibold">

                    Valor Recibido

                </label>

                <div class="input-group">

                    <span class="input-group-text">

                        $

                    </span>

                    <input type="number" id="receivedAmount" class="form-control text-end" value="0">

                </div>

            </div>

            <!-- Cambio -->

            <div class="col-lg-4">

                <label class="form-label fw-semibold">

                    Cambio

                </label>

                <div class="input-group">

                    <span class="input-group-text">

                        $

                    </span>

                    <input type="text" id="changeAmount" class="form-control text-end bg-light fw-bold"
                        value="0" readonly>

                </div>

            </div>

        </div>

        <hr class="my-4">

        <div class="row">

            <!-- Observaciones -->

            <div class="col-lg-12">

                <label class="form-label fw-semibold">

                    Observaciones

                </label>

                <textarea id="saleObservation" name="observation" rows="4" class="form-control"
                    placeholder="Observaciones de la factura..."></textarea>

            </div>

        </div>


        <hr class="my-4">
        <!-- Acciones
        <div class="row text-center">

            <div class="col-md-3">

                <div class="border rounded-4 p-3">

                    <i class="bi bi-wallet2 fs-2 text-success"></i>

                    <h6 class="mt-2">

                        Medio

                    </h6>

                    <strong id="paymentTypeText">

                        Efectivo

                    </strong>

                </div>

            </div>

            <div class="col-md-3">

                <div class="border rounded-4 p-3">

                    <i class="bi bi-cash-stack fs-2 text-primary"></i>

                    <h6 class="mt-2">

                        Recibido

                    </h6>

                    <strong id="receivedText">

                        $0

                    </strong>

                </div>

            </div>

            <div class="col-md-3">

                <div class="border rounded-4 p-3">

                    <i class="bi bi-arrow-left-right fs-2 text-warning"></i>

                    <h6 class="mt-2">

                        Cambio

                    </h6>

                    <strong id="changeText">

                        $0

                    </strong>

                </div>

            </div>

            <div class="col-md-3">

                <div class="border rounded-4 p-3">

                    <i class="bi bi-calendar-check fs-2 text-danger"></i>

                    <h6 class="mt-2">

                        Estado

                    </h6>

                    <strong id="invoiceStatus">

                        Pendiente

                    </strong>

                </div>

            </div>

        </div>-->

    </div>

</div>

<script>
    document.getElementById('typeSale').addEventListener('change', function() {

        document.getElementById('creditDateContainer').style.display =

            this.value == 'credit' ? 'block' : 'none';

            let receivedAmount = document.getElementById('receivedAmount')

            if(this.value == 'credit'){
                receivedAmount.value = 0;
                receivedAmount.disabled  = true;
            }else{
                 receivedAmount.disabled  = false;
            }

             document.getElementById('changeAmount').style.display =

            this.value == 'credit' ? 'none' : 'block';

    });
</script>
