<!-- ==========================================================
  proveedor
=========================================================== -->

<div class="card border-0 shadow-sm rounded-4 mb-4">

    <div class="card-header bg-white border-0">

        <div class="d-flex justify-content-between align-items-center flex-wrap">

            <div>

                <h4 class="fw-bold mb-1">

                    <i class="bi bi-person-vcard text-primary me-2"></i>

                    Información del Proveedor

                </h4>

                <small class="text-muted">

                    Seleccione el adquirente de la factura electrónica.

                </small>

            </div>

            <div class="d-flex gap-2 mt-3 mt-lg-0">

                @if (Route::is('shopping.create'))
                    <button class="btn btn-outline-success rounded-pill px-4" id="btn-clear-supplier">

                        <i class="bi bi-trash"></i>

                        Borrar

                    </button>
                @endif




                <button type="button" class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal"
                    data-bs-target="#modalSupplier">

                    <i class="bi bi-search"></i>

                    Buscar Proveedor

                </button>
                <a href="{{ route('shopping.index') }}" id="btnBackSale"
                    class="btn btn-outline-secondary rounded-pill px-4">
                    <i class="bi bi-arrow-left-circle"></i>
                    Volver
                </a>

            </div>

        </div>

    </div>

    <div class="card-body">

        <input type="hidden" id="supplier_id" name="supplier_id">

        <div class="row g-3">

            <!-- Documento -->

            <div class="col-lg-2">

                <label class="form-label fw-semibold">

                    Documento

                </label>

                <input type="text" class="form-control" id="identification" readonly>

            </div>



            <!-- proveedor -->

            <div class="col-lg-6">

                <label class="form-label fw-semibold">

                    Proveedor

                </label>

                <input type="text" class="form-control fw-semibold" id="full_name" readonly>

            </div>

            <!-- fecha -->

            <div class="col-lg-2">

                <label class="form-label fw-semibold">

                    Fecha

                </label>

                <input type="date" class="form-control" id="shopping_date" name="shopping_date" value="{{ date('Y-m-d') }}">

            </div>
             <div class="col-lg-2">

                <label class="form-label fw-semibold">

                    N° Fact

                </label>

                <input type="text" class="form-control" id="invoice_number" name="invoice_number" value="{{old('invoicenumberInput', $shopping->invoice_number ?? '')}}" required>

            </div>


            <!-- Organización -->

            <div class="col-lg-3">


                <label class="form-label fw-semibold">

                    Ciudad

                </label>

                <input type="text" class="form-control" id="city" readonly>


            </div>

            <!-- Régimen -->

            <div class="col-lg-3">
                <label class="form-label fw-semibold">

                    Dirección

                </label>

                <input type="text" class="form-control" id="address" readonly>
            </div>

            <!-- Responsabilidad -->

            <div class="col-lg-3">


                <label class="form-label fw-semibold">

                    Correo Electrónico

                </label>

                <input type="email" class="form-control" id="email" readonly>

            </div>

            <!-- Teléfono -->

            <div class="col-lg-3">

                <label class="form-label fw-semibold">

                    Teléfono

                </label>

                <input type="text" class="form-control" id="phone" readonly>

            </div>



        </div>

        <hr class="my-4">



    </div>

</div>
