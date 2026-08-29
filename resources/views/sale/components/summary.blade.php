<!-- ==========================================================
    RESUMEN DE LA FACTURA
=========================================================== -->

<div class="card border-0 shadow rounded-4 sticky-top" style="top:80px; z-index: 10;">
    <div class="card-header bg-success text-white rounded-top-4 border-0">

        <div class="d-flex justify-content-between align-items-center">

            <h4 class="mb-0">

                <i class="bi bi-calculator me-2"></i>

                Resumen de la Factura

            </h4>

            <span class="badge bg-light text-success fs-6">

                POS

            </span>

        </div>

    </div>

    <div class="card-body">

        <!-- Totales principales -->

        <div class="list-group list-group-flush mb-3">

            <div class="list-group-item d-flex justify-content-between">

                <input type="hidden" id="subTotal" name="subtotal">

                <span>

                    <i class="bi bi-cart text-primary me-2"></i>

                    Subtotal

                </span>

                <strong id="subtotalInvoice">

                    $0

                </strong>

            </div>


        </div>

        <!-- IVA -->

        <div class="card bg-light border-0 mb-3">

            <div class="card-body py-3">

                <h6 class="fw-bold mb-3">

                    Impuestos

                </h6>

                <div class="d-flex justify-content-between mb-2">

                    <span>

                        IVA

                    </span>
                    <input type="hidden" name="tax" id="tax">
                    <strong id="iva19Invoice">

                        $0

                    </strong>

                </div>




            </div>

        </div>

        <!-- Total -->

        <div class="bg-success rounded-4 text-white p-4 text-center mb-4">

            <small>

                TOTAL A PAGAR

            </small>
            <input type="hidden" name="total" id="total">
            <h1 class="fw-bold mb-0" id="totalInvoice">

                $0

            </h1>

        </div>

        <!-- Indicadores -->

        <div class="row text-center g-3 mb-3">

            <div class="col-6">

                <div class="border rounded-4 p-3">

                    <i class="bi bi-box-seam fs-3 text-primary"></i>

                    <h3 class="fw-bold mt-2 mb-0" id="productsInvoice">

                        0

                    </h3>

                    <small class="text-muted">

                        Productos

                    </small>

                </div>

            </div>

            <div class="col-6">

                <div class="border rounded-4 p-3">

                    <i class="bi bi-123 fs-3 text-success"></i>

                    <h3 class="fw-bold mt-2 mb-0" id="quantityInvoice">

                        0

                    </h3>

                    <small class="text-muted">

                        Cantidad

                    </small>

                </div>

            </div>

        </div>

        <!-- Pago -->

        <div class="card border-0 bg-light">

            <div class="card-body">

                <div class="d-flex justify-content-between mb-2">

                    @if (Route::is('sale.create'))
                        <button type="button" id="btnClear" class="btn btn-outline-warning rounded-pill px-4">

                            <i class="bi bi-arrow-clockwise"></i>

                            Nueva Factura

                        </button>
                    @endif


                    <button type="submit" id="btnSaveSale" class="btn btn-primary rounded-pill px-4">

                        <i class="bi bi-check-circle"></i>

                        Guardar

                    </button>

                </div>


            </div>

        </div>


    </div>

</div>
