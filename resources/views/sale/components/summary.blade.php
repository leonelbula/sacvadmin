<!-- ==========================================================
    RESUMEN DE LA FACTURA
=========================================================== -->

<div class="card border-0 shadow rounded-4 sticky-top" style="top:90px;">

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

                <span>

                    <i class="bi bi-cart text-primary me-2"></i>

                    Subtotal

                </span>

                <strong id="subtotalInvoice">

                    $0

                </strong>

            </div>

            <div class="list-group-item d-flex justify-content-between">

                <span>

                    <i class="bi bi-percent text-warning me-2"></i>

                    Descuento

                </span>

                <strong
                    class="text-danger"
                    id="discountInvoice">

                    $0

                </strong>

            </div>

            <div class="list-group-item d-flex justify-content-between">

                <span>

                    <i class="bi bi-calculator text-secondary me-2"></i>

                    Base Gravable

                </span>

                <strong id="taxableInvoice">

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

                        IVA 19%

                    </span>

                    <strong id="iva19Invoice">

                        $0

                    </strong>

                </div>

                <div class="d-flex justify-content-between mb-2">

                    <span>

                        IVA 5%

                    </span>

                    <strong id="iva5Invoice">

                        $0

                    </strong>

                </div>

                <div class="d-flex justify-content-between mb-2">

                    <span>

                        Exentos

                    </span>

                    <strong id="exemptInvoice">

                        $0

                    </strong>

                </div>

                <div class="d-flex justify-content-between">

                    <span>

                        Excluidos

                    </span>

                    <strong id="excludedInvoice">

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

            <h1
                class="fw-bold mb-0"
                id="totalInvoice">

                $0

            </h1>

        </div>

        <!-- Indicadores -->

        <div class="row text-center g-3 mb-3">

            <div class="col-6">

                <div class="border rounded-4 p-3">

                    <i class="bi bi-box-seam fs-3 text-primary"></i>

                    <h3
                        class="fw-bold mt-2 mb-0"
                        id="productsInvoice">

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

                    <h3
                        class="fw-bold mt-2 mb-0"
                        id="quantityInvoice">

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

                    <span>

                        Recibido

                    </span>

                    <strong id="receivedText">

                        $0

                    </strong>

                </div>

                <div class="d-flex justify-content-between">

                    <span>

                        Cambio

                    </span>

                    <strong
                        class="text-success"
                        id="changeText">

                        $0

                    </strong>

                </div>

            </div>

        </div>

        <!-- Estado -->

        <div class="alert alert-warning text-center mt-4 mb-0">

            <i class="bi bi-info-circle me-2"></i>

            <strong id="invoiceStatus">

                Factura en edición

            </strong>

        </div>

    </div>

</div>