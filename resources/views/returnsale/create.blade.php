```blade
@extends('layouts.app')

@section('title', 'Nueva devolución')

@section('content')

    <div class="container-fluid py-4">

        {{-- ENCABEZADO --}}
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h3 class="fw-bold mb-1">
                    <i class="bi bi-arrow-return-left me-2"></i>
                    Nueva devolución
                </h3>

                <p class="text-muted mb-0">
                    Registra una nueva devolución de productos.
                </p>
            </div>

            <a href="{{ route('salereturn.index') }}" class="btn btn-outline-secondary">

                <i class="bi bi-arrow-left me-1"></i>
                Volver
            </a>

        </div>


        {{-- FORMULARIO --}}
        <form id="returnForm">

            @csrf

            {{-- PRODUCTOS PARA ENVIAR AL BACKEND --}}
           <input type="hidden" name="products" id="productsInputreturn">


            <div class="row g-4">

                {{-- =====================================================
                COLUMNA PRINCIPAL
            ====================================================== --}}
                <div class="col-lg-8">

                    {{-- INFORMACIÓN DE LA DEVOLUCIÓN --}}
                    <div class="card border-0 shadow-sm rounded-4 mb-4">

                        <div class="card-header bg-white border-0 p-4">

                            <h5 class="fw-bold mb-0">
                                <i class="bi bi-info-circle me-2 text-primary"></i>
                                Información de la devolución
                            </h5>

                        </div>

                        <div class="card-body p-4">

                            <div class="row g-3">

                                {{-- FECHA --}}
                                <div class="col-md-4">

                                    <label class="form-label fw-semibold">
                                        Fecha
                                    </label>

                                    <input type="date" name="date" class="form-control"
                                        value="{{ old('date', date('Y-m-d')) }}" required>

                                </div>


                                {{-- TIPO --}}
                                <div class="col-md-4">

                                    <label class="form-label fw-semibold">
                                        Tipo de devolución
                                    </label>

                                    <select name="refund_type"  class="form-select" required>

                                        <option value="money">
                                            Devolución de dinero
                                        </option>

                                        <option value="exchange">
                                            Cambio de producto
                                        </option>

                                        <option value="credit">
                                            Saldo a favor
                                        </option>

                                    </select>

                                </div>


                                {{-- MOTIVO --}}
                                <div class="col-md-4">

                                    <label class="form-label fw-semibold">
                                        Motivo
                                    </label>

                                    <select name="reason" class="form-select" required>

                                        <option value="customer_request">
                                            Solicitud del cliente
                                        </option>

                                        <option value="defective">
                                            Producto defectuoso
                                        </option>

                                        <option value="wrong_product">
                                            Producto equivocado
                                        </option>

                                        <option value="damaged">
                                            Producto dañado
                                        </option>

                                        <option value="other">
                                            Otro
                                        </option>

                                    </select>

                                </div>


                                {{-- CLIENTE --}}
                                <div class="col-md-8">

                                    <label class="form-label fw-semibold">
                                        Cliente
                                    </label>

                                    <div class="input-group">

                                        {{-- NOMBRE VISIBLE --}}
                                        <input type="text" id="customerName" class="form-control"
                                            placeholder="Cliente" readonly>

                                        {{-- ID DEL CLIENTE --}}
                                        <input type="hidden" name="customer_id" id="customerId">

                                        {{-- BUSCAR --}}
                                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                            data-bs-target="#customerModal">

                                            <i class="bi bi-search"></i>

                                        </button>

                                        {{-- LIMPIAR --}}
                                        <button type="button" class="btn btn-outline-danger" id="btnClearCustomer">

                                            <i class="bi bi-x-lg"></i>

                                        </button>

                                    </div>

                                </div>


                                {{-- RESPONSABLE --}}
                                <div class="col-md-4">

                                    <label class="form-label fw-semibold">
                                        Responsable
                                    </label>

                                    <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>

                                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- =====================================================
                    PRODUCTOS
                ====================================================== --}}
                    <div class="card border-0 shadow-sm rounded-4">

                        <div class="card-header bg-white border-0 p-4">

                            <div class="d-flex justify-content-between align-items-center">

                                <div>

                                    <h5 class="fw-bold mb-1">
                                        <i class="bi bi-box-seam me-2 text-primary"></i>
                                        Productos
                                    </h5>

                                    <small class="text-muted">
                                        Agrega los productos que serán devueltos.
                                    </small>

                                </div>


                                {{-- BOTÓN AGREGAR --}}
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#productModal">

                                    <i class="bi bi-plus-lg me-1"></i>
                                    Agregar producto

                                </button>

                            </div>

                        </div>


                        <div class="card-body p-0">

                            <div class="table-responsive">

                                <table class="table table-hover align-middle mb-0">

                                    <thead class="table-light">

                                        <tr>

                                            <th class="ps-4">
                                                Producto
                                            </th>

                                            <th width="130">
                                                Cantidad
                                            </th>

                                            <th width="150">
                                                Precio
                                            </th>

                                            <th width="130">
                                                Costo
                                            </th>

                                            <th width="150">
                                                Subtotal
                                            </th>

                                            <th width="70">
                                                Acción
                                            </th>

                                        </tr>

                                    </thead>


                                    <tbody id="returnProducts">

                                        <tr>

                                            <td colspan="6" class="text-center py-5 text-muted">

                                                <i class="bi bi-box2 fs-1 d-block mb-3"></i>

                                                <h6 class="fw-semibold">
                                                    No hay productos
                                                </h6>

                                                <p class="mb-0">
                                                    Agrega productos para realizar la devolución.
                                                </p>

                                            </td>

                                        </tr>

                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>


                    {{-- OBSERVACIÓN --}}
                    <div class="card border-0 shadow-sm rounded-4 mt-4">

                        <div class="card-body p-4">

                            <label class="form-label fw-semibold">
                                Observación
                            </label>

                            <textarea name="observation" class="form-control" rows="4" placeholder="Observaciones de la devolución...">{{ old('observation') }}</textarea>

                        </div>

                    </div>

                </div>


                {{-- =====================================================
                RESUMEN
            ====================================================== --}}
                <div class="col-lg-4">

                    <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 20px; z-index: 1;">

                        <div class="card-header bg-primary text-white border-0 rounded-top-4 p-4">

                            <h5 class="mb-0 fw-bold">

                                <i class="bi bi-calculator me-2"></i>

                                Resumen

                            </h5>

                        </div>


                        <div class="card-body p-4">

                            {{-- PRODUCTOS --}}
                            <div class="d-flex justify-content-between mb-3">

                                <span class="text-muted">
                                    Productos
                                </span>

                                <span class="fw-semibold" id="totalProducts">
                                    0
                                </span>

                            </div>


                            {{-- CANTIDAD --}}
                            <div class="d-flex justify-content-between mb-3">

                                <span class="text-muted">
                                    Cantidad
                                </span>

                                <span class="fw-semibold" id="totalQuantity">
                                    0
                                </span>

                            </div>


                            <hr>


                            {{-- SUBTOTAL --}}
                            <div class="d-flex justify-content-between mb-3">

                                <span class="text-muted">
                                    Subtotal
                                </span>

                                <span class="fw-semibold">

                                    <span id="subtotalReturn">
                                        0
                                    </span>

                                </span>

                            </div>


                            {{-- DESCUENTO --}}
                            <div class="d-flex justify-content-between mb-3">

                                <span class="text-muted">
                                    Descuento
                                </span>

                                <span class="fw-semibold">

                                    <span id="discountReturn">
                                        0
                                    </span>

                                </span>

                            </div>


                            <hr>


                            {{-- TOTAL --}}
                            <div class="d-flex justify-content-between align-items-center mb-4">

                                <span class="fs-5 fw-bold">
                                    Total
                                </span>

                                <span class="fs-3 fw-bold text-primary">

                                    <span id="totalReturn">
                                        0
                                    </span>

                                </span>

                            </div>


                            {{-- INPUTS OCULTOS --}}
                            <input type="hidden" name="subtotal" id="subtotalInput" value="0">

                            <input type="hidden" name="total" id="totalInput" value="0">


                            {{-- GUARDAR --}}
                            <button type="submit" class="btn btn-primary btn-lg w-100 rounded-3" id="btnReturnSale">

                                <i class="bi bi-check-circle me-2"></i>

                                Registrar devolución

                            </button>


                            {{-- CANCELAR --}}
                            <a href="{{ route('salereturn.index') }}" class="btn btn-outline-secondary w-100 mt-2">

                                Cancelar

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </form>

    </div>


    {{-- ============================================================
    MODAL PRODUCTOS
============================================================= --}}
    <div class="modal fade" id="productModal" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog modal-xl modal-dialog-centered">

            <div class="modal-content border-0 rounded-4 shadow">

                <div class="modal-header">

                    <h5 class="modal-title fw-bold">

                        <i class="bi bi-box-seam me-2 text-primary"></i>

                        Buscar producto

                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>

                </div>


                <div class="modal-body">

                    {{-- BUSCADOR --}}
                    <div class="input-group mb-4">

                        <span class="input-group-text bg-white">

                            <i class="bi bi-search"></i>

                        </span>

                        <input type="text" id="searchProduct" class="form-control"
                            placeholder="Buscar por nombre o código...">

                    </div>


                    {{-- RESULTADOS --}}
                    <div class="table-responsive">

                        <table class="table table-hover align-middle">

                            <thead class="table-light">

                                <tr>

                                    <th>
                                        Producto
                                    </th>

                                    <th>
                                        Precio
                                    </th>

                                    <th>
                                        Stock
                                    </th>

                                    <th width="100">
                                        Acción
                                    </th>

                                </tr>

                            </thead>


                            <tbody id="tableProductsSearch">

                                <tr>

                                    <td colspan="4" class="text-center text-muted py-4">

                                        Escribe para buscar productos.

                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ============================================================
    MODAL CLIENTES
============================================================= --}}
    <div class="modal fade" id="customerModal" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog modal-lg modal-dialog-centered">

            <div class="modal-content border-0 rounded-4 shadow">

                <div class="modal-header">

                    <h5 class="modal-title fw-bold">

                        <i class="bi bi-person-search me-2 text-primary"></i>

                        Buscar cliente

                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>

                </div>


                <div class="modal-body">

                    {{-- BUSCADOR --}}
                    <div class="input-group mb-4">

                        <span class="input-group-text bg-white">

                            <i class="bi bi-search"></i>

                        </span>

                        <input type="text" id="searchCustomer" class="form-control"
                            placeholder="Buscar por nombre, documento o teléfono...">

                    </div>


                    {{-- RESULTADOS --}}
                    <div class="table-responsive">

                        <table class="table table-hover align-middle">

                            <thead class="table-light">

                                <tr>

                                    <th>
                                        Cliente
                                    </th>

                                    <th>
                                        Documento
                                    </th>

                                    <th>
                                        Teléfono
                                    </th>

                                    <th width="100">
                                        Acción
                                    </th>

                                </tr>

                            </thead>


                            <tbody id="tableCustomersSearch">

                                <tr>

                                    <td colspan="4" class="text-center text-muted py-4">

                                        Escribe para buscar clientes.

                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>


@endsection




<script>
    /*
    |--------------------------------------------------------------------------
    | URL PARA BUSCAR PRODUCTOS
    |--------------------------------------------------------------------------
    */

    window.productSearchUrl = "{{ url('/product/search') }}";


    /*
    |--------------------------------------------------------------------------
    | URL PARA BUSCAR CLIENTES
    |--------------------------------------------------------------------------
    */

    window.customerSearchUrl = "{{ url('/customers/search') }}";
</script>


<script src="{{ asset('js/returnsale.js') }}"></script>
<script src="{{asset('js/proceReturnSale.js')}}"></script>
