@extends('layouts.app')

@section('title', 'Nueva Venta')

@section('content')

    <div class="container-fluid py-4 mt-4">

        <!-- Encabezado -->

        <div class="card shadow border-0 rounded-4 mb-4">

            <div class="card-body">

                <div class="row align-items-center">

                    <div class="col-lg-6">

                        <h2 class="fw-bold mb-1">

                            <i class="bi bi-receipt-cutoff text-primary me-2"></i>

                            Nueva Venta

                        </h2>

                        <p class="text-muted mb-0">

                            Registre una nueva factura de venta.

                        </p>

                    </div>

                    <div class="col-lg-6 text-end">

                        <div class="row">

                            <div class="col">

                                <label class="form-label fw-semibold">

                                    No. Factura

                                </label>

                                <input type="text" class="form-control text-center fw-bold" value="FV-000001" readonly>

                            </div>

                            <div class="col">

                                <label class="form-label fw-semibold">

                                    Fecha

                                </label>

                                <input type="date" class="form-control">

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- Cliente -->

        <div class="card shadow border-0 rounded-4 mb-4">

            <div class="card-header bg-white">

                <div class="d-flex justify-content-between align-items-center">

                    <h5 class="mb-0">

                        <i class="bi bi-person-fill text-primary me-2"></i>

                        Información del Cliente

                    </h5>

                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#customerModal">

                        <i class="bi bi-search"></i>

                        Buscar Cliente

                    </button>

                </div>

            </div>

            <div class="card-body">
                <input type="hidden" id="customer_id" name="customer_id" value="">
                <div class="row">

                    <div class="col-lg-2 mb-3">

                        <label class="form-label">

                            Documento

                        </label>

                        <input type="text" class="form-control" readonly id="identification" name="identification"
                            value="">

                    </div>

                    <div class="col-lg-4 mb-3">

                        <label class="form-label">

                            Cliente

                        </label>

                        <input type="text" class="form-control" readonly id="full_name" name="full_name" value="">

                    </div>

                    <div class="col-lg-2 mb-3">

                        <label class="form-label">

                            Teléfono

                        </label>

                        <input type="text" class="form-control" readonly id="phone" name="phone" value="">

                    </div>

                    <div class="col-lg-4 mb-3">

                        <label class="form-label">

                            Dirección

                        </label>

                        <input type="text" class="form-control" readonly id="address" name="address" value="">

                    </div>

                </div>



            </div>

        </div>


        <!-- Modal Clientes -->

        @include('sale.modals.customers')

        <!-- AQUÍ CONTINÚA LA PARTE 2 -->
        <!-- Productos -->

        <div class="card shadow border-0 rounded-4 mb-4">

            <div class="card-header bg-white">

                <div class="d-flex justify-content-between align-items-center">

                    <h5 class="mb-0">

                        <i class="bi bi-box-seam text-primary me-2"></i>

                        Productos de la Venta

                    </h5>

                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#productModal">

                        <i class="bi bi-plus-circle"></i>

                        Agregar Producto

                    </button>

                </div>

            </div>

            <div class="card-body">

                <!-- Barra rápida -->


                <!-- Tabla -->

                <div class="table-responsive">

                    <table class="table table-hover align-middle" id="tableSaleProducts">

                        <thead class="table-primary">

                            <tr>

                                <th width="50">#</th>

                                <th>Código</th>

                                <th>Producto</th>

                                <th width="110">Cantidad</th>

                                <th width="130">Precio</th>

                                <th width="110">Desc.</th>

                                <th width="150">Subtotal</th>

                                <th width="120" class="text-center">

                                    Acciones

                                </th>

                            </tr>

                        </thead>

                        <tbody>



                        </tbody>

                    </table>

                </div>

            </div>

        </div>


        <!-- Modal Productos -->

        @include('sale.modals.products')

        <!-- AQUÍ CONTINÚA LA PARTE 3 -->
        <!-- Resumen de la Venta -->

        <div class="row">

            <!-- Observaciones y Forma de Pago -->

            <div class="col-lg-8">

                <div class="card shadow border-0 rounded-4 mb-4">

                    <div class="card-header bg-white">

                        <h5 class="mb-0">
                            <i class="bi bi-chat-left-text text-primary me-2"></i>
                            Información Adicional
                        </h5>

                    </div>

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-6 mb-3">

                                <label class="form-label fw-semibold">

                                    Forma de Pago

                                </label>

                                <select class="form-select" id="paymentMethod">

                                    <option value="cash">Efectivo</option>
                                    <option value="transfer">Transferencia</option>
                                    <option value="debit">Tarjeta Débito</option>
                                    <option value="credit_card">Tarjeta Crédito</option>
                                    <option value="credit">Crédito</option>

                                </select>

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label fw-semibold">

                                    Vendedor

                                </label>

                                <input type="text" class="form-control" value="Administrador" readonly>

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label fw-semibold">

                                    Valor Recibido

                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">$</span>

                                    <input type="number" id="receivedAmount" class="form-control text-end"
                                        value="0">

                                </div>

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label fw-semibold">

                                    Cambio

                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">$</span>

                                    <input type="text" id="changeAmount" class="form-control text-end bg-light"
                                        readonly value="0">

                                </div>

                            </div>

                            <div class="col-12">

                                <label class="form-label fw-semibold">

                                    Observaciones

                                </label>

                                <textarea id="saleObservation" class="form-control" rows="4"
                                    placeholder="Escriba una observación para la venta..."></textarea>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <!-- Totales -->
            <div class="col-lg-4">

                <div class="card shadow border-0 rounded-4">

                    <div class="card-header bg-success text-white">

                        <h5 class="mb-0">
                            <i class="bi bi-calculator me-2"></i>
                            Resumen
                        </h5>

                    </div>

                    <div class="card-body">

                        <div class="d-flex justify-content-between mb-3">

                            <span>Subtotal</span>

                            <strong id="subtotalInvoice">
                                $0
                            </strong>

                        </div>

                        <div class="d-flex justify-content-between mb-3">

                            <span>IVA</span>

                            <strong id="taxInvoice">
                                $0
                            </strong>

                        </div>

                        <div class="d-flex justify-content-between mb-3">

                            <span>Descuento</span>

                            <strong class="text-danger" id="discountInvoice">
                                $0
                            </strong>

                        </div>

                        <hr>

                        <div class="d-flex justify-content-between">

                            <h4>TOTAL</h4>

                            <h3 class="text-success fw-bold" id="totalInvoice">
                                $0
                            </h3>

                        </div>

                        <hr>

                        <div class="row text-center">

                            <div class="col-6">

                                <div class="border rounded p-3">

                                    <small class="text-muted">

                                        Productos

                                    </small>

                                    <h4 id="productsInvoice">
                                        0
                                    </h4>

                                </div>

                            </div>

                            <div class="col-6">

                                <div class="border rounded p-3">

                                    <small class="text-muted">

                                        Cantidad

                                    </small>

                                    <h4 id="quantityInvoice">
                                        0
                                    </h4>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <!-- Botones -->

        <div class="card shadow border-0 rounded-4 mt-4">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center flex-wrap">

                    <div>

                        <button type="button" class="btn btn-outline-secondary">

                            <i class="bi bi-arrow-left-circle"></i>

                            Volver

                        </button>

                    </div>

                    <div class="d-flex gap-2 flex-wrap">

                        <button type="reset" class="btn btn-warning" id="btnClear">

                            <i class="bi bi-arrow-clockwise"></i>

                            Limpiar

                        </button>

                        <button type="submit" class="btn btn-primary">

                            <i class="bi bi-check-circle"></i>

                            Guardar Venta

                        </button>

                        <button type="submit" class="btn btn-success">

                            <i class="bi bi-printer"></i>

                            Guardar e Imprimir

                        </button>


                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
@section('script')
    <script src="{{ asset('js/saleCustomer.js') }}"></script>
    <script src="{{ asset('js/saleProduct.js') }}"></script>

@endsection
