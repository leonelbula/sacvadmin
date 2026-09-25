<div class="card border-0 shadow-sm rounded-4 mb-4">

    <div class="card-header bg-white border-0">

        <div class="d-flex justify-content-between align-items-center flex-wrap">

            <div>

                <h4 class="fw-bold mb-1">

                    <i class="bi bi-cart4 text-success me-2"></i>

                    Productos de la Factura

                </h4>

                <small class="text-muted">

                    Busque un producto por código de barras, referencia o nombre.

                </small>

            </div>

            <div class="d-flex gap-2">

                <button type="button" class="btn btn-success rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#productModal">

                    <i class="bi bi-plus-circle"></i>

                    Agregar Producto

                </button>

            </div>

        </div>

    </div>

    <div class="card-body">

        <!-- Búsqueda rápida -->



        <!-- Tabla -->

        <div class="table-responsive">

            <table class="table table-hover align-middle" id="tableSaleProducts">

                <thead class="table-light">

                    <tr>

                        <th width="40">#</th>

                        <th width="80">

                            Código

                        </th>

                        <th>

                            Producto

                        </th>



                        <th width="110">

                            Cantidad

                        </th>

                        <th width="140">

                            Precio

                        </th>

                       

                        <th width="120">

                            IVA

                        </th>

                        <th width="170">

                            Subtotal

                        </th>

                        <th width="90">

                            Acción

                        </th>

                    </tr>

                </thead>

                <tbody id="tbodySaleProducts">

                    <!-- JavaScript -->

                </tbody>
                <input type="hidden" id="products" name="products">
            </table>

        </div>

        <!-- Pie -->

        <div class="row mt-4">

            <div class="col-lg-4">

                <div class="alert alert-light border mb-0">

                    <i class="bi bi-lightning-charge-fill text-warning"></i>

                    <strong>F2</strong> Buscar Cliente

                </div>

            </div>

            <div class="col-lg-4">

                <div class="alert alert-light border mb-0">

                    <i class="bi bi-lightning-charge-fill text-warning"></i>

                    <strong>F3</strong> Buscar Producto

                </div>

            </div>

            <div class="col-lg-4">

                <div class="alert alert-light border mb-0">

                    <i class="bi bi-lightning-charge-fill text-warning"></i>

                    <strong>F4</strong> Borrar Factura

                </div>

            </div>

        </div>

    </div>

</div>
