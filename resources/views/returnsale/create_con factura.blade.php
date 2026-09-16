@extends('layouts.app')

@section('title', 'Nueva devolución de venta')

@section('content')

    <div class="container-fluid py-4 mt-4">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h3 class="fw-bold mb-1">
                    <i class="bi bi-arrow-return-left me-2"></i>
                    Nueva devolución
                </h3>

                <p class="text-muted mb-0">
                    Registra una devolución de productos de una venta.
                </p>
            </div>

            <a href="{{ route('returnsale.index') }}" class="btn btn-outline-secondary rounded-3">

                <i class="bi bi-arrow-left me-1"></i>
                Volver
            </a>

        </div>


        <div class="row g-4">

            {{-- ========================================================= --}}
            {{-- COLUMNA PRINCIPAL --}}
            {{-- ========================================================= --}}

            <div class="col-lg-8">

                {{-- BUSCAR FACTURA --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">

                    <div class="card-header bg-white border-0 rounded-top-4 p-4">

                        <div class="d-flex align-items-center">

                            <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-2 me-3">
                                <i class="bi bi-receipt fs-4"></i>
                            </div>

                            <div>
                                <h5 class="fw-bold mb-1">
                                    Venta original
                                </h5>

                                <small class="text-muted">
                                    Busca la factura que contiene los productos a devolver.
                                </small>
                            </div>

                        </div>

                    </div>


                    <div class="card-body p-4">

                        <div class="row g-3">

                            <div class="col-md-8">

                                <label class="form-label fw-semibold">
                                    Número de factura
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-search"></i>
                                    </span>

                                    <input type="text" id="saleNumber" class="form-control border-start-0"
                                        placeholder="Ej: 000125">

                                    <button type="button" class="btn btn-primary" id="btnSearchSale">

                                        <i class="bi bi-search me-1"></i>
                                        Buscar

                                    </button>

                                </div>

                            </div>


                            <div class="col-md-4">

                                <label class="form-label fw-semibold">
                                    Fecha de venta
                                </label>

                                <input type="date" id="saleDate" class="form-control bg-light" readonly>

                            </div>

                        </div>


                        {{-- INFORMACIÓN DE LA VENTA --}}

                        <div id="saleInformation" class="mt-4 d-none">

                            <div class="alert alert-light border rounded-3 mb-0">

                                <div class="row g-3">

                                    <div class="col-md-4">

                                        <small class="text-muted d-block">
                                            Factura
                                        </small>

                                        <strong id="saleNumberResult">
                                            -
                                        </strong>

                                    </div>


                                    <div class="col-md-4">

                                        <small class="text-muted d-block">
                                            Cliente
                                        </small>

                                        <strong id="customerName">
                                            -
                                        </strong>

                                    </div>


                                    <div class="col-md-4">

                                        <small class="text-muted d-block">
                                            Total venta
                                        </small>

                                        <strong id="saleTotal">
                                            $0
                                        </strong>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- PRODUCTOS --}}
                <div class="card border-0 shadow-sm rounded-4">

                    <div class="card-header bg-white border-0 rounded-top-4 p-4">

                        <div class="d-flex justify-content-between align-items-center">

                            <div class="d-flex align-items-center">

                                <div class="bg-success bg-opacity-10 text-success rounded-3 p-2 me-3">

                                    <i class="bi bi-box-seam fs-4"></i>

                                </div>

                                <div>

                                    <h5 class="fw-bold mb-1">
                                        Productos de la venta
                                    </h5>

                                    <small class="text-muted">
                                        Selecciona los productos y cantidades que serán devueltos.
                                    </small>

                                </div>

                            </div>

                            <span id="productsSelected" class="badge bg-primary rounded-pill">

                                0 seleccionados

                            </span>

                        </div>

                    </div>


                    <div class="card-body p-0">

                        <div class="table-responsive">

                            <table class="table align-middle mb-0">

                                <thead class="table-light">

                                    <tr>

                                        <th width="50" class="ps-4">
                                            #
                                        </th>

                                        <th>
                                            Producto
                                        </th>

                                        <th class="text-center">
                                            Vendido
                                        </th>

                                        <th width="140" class="text-center">
                                            Devolver
                                        </th>

                                        <th class="text-end">
                                            Precio
                                        </th>

                                        <th class="text-end pe-4">
                                            Total
                                        </th>

                                    </tr>

                                </thead>

                                <tbody id="returnProducts">

                                    <tr id="emptyProducts">

                                        <td colspan="6" class="text-center py-5">

                                            <div class="text-muted">

                                                <i class="bi bi-box-seam fs-1 d-block mb-3"></i>

                                                <h6 class="fw-semibold">
                                                    No hay productos
                                                </h6>

                                                <small>
                                                    Busca una factura para cargar sus productos.
                                                </small>

                                            </div>

                                        </td>

                                    </tr>

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>


                {{-- MOTIVO --}}
                <div class="card border-0 shadow-sm rounded-4 mt-4">

                    <div class="card-body p-4">

                        <label class="form-label fw-semibold">
                            Motivo de la devolución
                        </label>

                        <select name="reason" id="returnReason" class="form-select">

                            <option value="">
                                Selecciona un motivo
                            </option>

                            <option value="defective">
                                Producto defectuoso
                            </option>

                            <option value="wrong_product">
                                Producto equivocado
                            </option>

                            <option value="customer_request">
                                Solicitud del cliente
                            </option>

                            <option value="damaged">
                                Producto dañado
                            </option>

                            <option value="other">
                                Otro motivo
                            </option>

                        </select>


                        <div class="mt-3">

                            <label class="form-label fw-semibold">
                                Observaciones
                            </label>

                            <textarea id="observation" name="observation" rows="3" class="form-control"
                                placeholder="Escribe una observación sobre la devolución..."></textarea>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ========================================================= --}}
            {{-- RESUMEN --}}
            {{-- ========================================================= --}}

            <div class="col-lg-4 ">

                <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 20px;  z-index: 10;">

                    <div class="card-header bg-primary text-white border-0 rounded-top-4 p-4">

                        <div class="d-flex align-items-center">

                            <i class="bi bi-calculator fs-4 me-2"></i>

                            <h5 class="mb-0 fw-bold">
                                Resumen devolución
                            </h5>

                        </div>

                    </div>


                    <div class="card-body p-4">

                        {{-- FACTURA --}}
                        <div class="d-flex justify-content-between mb-3">

                            <span class="text-muted">
                                Factura
                            </span>

                            <strong id="summarySale">
                                -
                            </strong>

                        </div>


                        {{-- PRODUCTOS --}}
                        <div class="d-flex justify-content-between mb-3">

                            <span class="text-muted">
                                Productos
                            </span>

                            <strong id="summaryProducts">
                                0
                            </strong>

                        </div>


                        {{-- CANTIDAD --}}
                        <div class="d-flex justify-content-between mb-3">

                            <span class="text-muted">
                                Cantidad
                            </span>

                            <strong id="summaryQuantity">
                                0
                            </strong>

                        </div>


                        <hr>


                        {{-- TOTAL --}}
                        <div class="d-flex justify-content-between align-items-center mb-4">

                            <span class="fw-semibold">
                                Total devolución
                            </span>

                            <span id="summaryTotal" class="fs-3 fw-bold text-primary">

                                $0

                            </span>

                        </div>


                        {{-- TIPO DE DEVOLUCIÓN --}}
                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Tipo de devolución
                            </label>

                            <select name="refund_type" id="refundType" class="form-select">

                                <option value="cash">
                                    Devolver dinero
                                </option>

                                <option value="balance">
                                    Saldo a favor del cliente
                                </option>

                                <option value="exchange">
                                    Cambio por otro producto
                                </option>

                            </select>

                        </div>


                        {{-- ESTADO --}}
                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Estado
                            </label>

                            <select name="state" id="returnState" class="form-select">

                                <option value="completed">
                                    Completada
                                </option>

                                <option value="pending">
                                    Pendiente
                                </option>

                            </select>

                        </div>


                        {{-- BOTÓN --}}
                        <button type="button" id="btnCreateReturn"
                            class="btn btn-primary w-100 py-3 rounded-3 fw-semibold">

                            <i class="bi bi-check-circle me-2"></i>

                            Registrar devolución

                        </button>


                        <a href="{{ route('returnsale.index') }}" class="btn btn-light w-100 mt-2 py-2 rounded-3">

                            Cancelar

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection



<script>
    document.addEventListener('DOMContentLoaded', function() {

        const saleNumber = document.getElementById('saleNumber');
        const btnSearchSale = document.getElementById('btnSearchSale');

        const saleInformation = document.getElementById('saleInformation');

        const returnProducts = document.getElementById('returnProducts');

        const summarySale = document.getElementById('summarySale');
        const summaryProducts = document.getElementById('summaryProducts');
        const summaryQuantity = document.getElementById('summaryQuantity');
        const summaryTotal = document.getElementById('summaryTotal');

        const productsSelected = document.getElementById('productsSelected');


        /*
        |--------------------------------------------------------------------------
        | FORMATO MONEDA
        |--------------------------------------------------------------------------
        */

        function formatMoney(value) {

            return new Intl.NumberFormat('es-CO', {
                style: 'currency',
                currency: 'COP',
                maximumFractionDigits: 0
            }).format(value);

        }


        /*
        |--------------------------------------------------------------------------
        | BUSCAR VENTA
        |--------------------------------------------------------------------------
        */

        btnSearchSale.addEventListener('click', async function() {

            const number = saleNumber.value.trim();

            if (!number) {

                alert('Ingrese el número de factura.');

                return;
            }


            try {

                btnSearchSale.disabled = true;

                btnSearchSale.innerHTML = `
                <span class="spinner-border spinner-border-sm me-1"></span>
                Buscando...
            `;


                /*
                |--------------------------------------------------------------------------
                | CAMBIA ESTA URL SEGÚN TU RUTA
                |--------------------------------------------------------------------------
                */

                const response = await fetch(
                    `/sales/search-sale/${number}`
                );


                if (!response.ok) {

                    throw new Error('Venta no encontrada');

                }


                const sale = await response.json();


                loadSale(sale);


            } catch (error) {

                console.error(error);
                Swal.fire("No se encontró la factura.");

                //alert('No se encontró la factura.');

            } finally {

                btnSearchSale.disabled = false;

                btnSearchSale.innerHTML = `
                <i class="bi bi-search me-1"></i>
                Buscar
            `;

            }

        });


        /*
        |--------------------------------------------------------------------------
        | CARGAR VENTA
        |--------------------------------------------------------------------------
        */

        function loadSale(sale) {

            saleInformation.classList.remove('d-none');


            document.getElementById('saleNumberResult').textContent =
                sale.sale_number;


            document.getElementById('customerName').textContent =
                sale.customer?.full_name ?? 'Cliente general';


            document.getElementById('saleTotal').textContent =
                formatMoney(sale.total);


            document.getElementById('saleDate').value =
                sale.date_sale ?? '';


            summarySale.textContent =
                sale.sale_number;


            returnProducts.innerHTML = '';


            /*
            |--------------------------------------------------------------------------
            | PRODUCTOS
            |--------------------------------------------------------------------------
            */

            if (!sale.details || sale.details.length === 0) {

                returnProducts.innerHTML = `

                <tr>

                    <td colspan="6"
                        class="text-center py-5 text-muted">

                        Esta venta no tiene productos.

                    </td>

                </tr>

            `;

                return;

            }


            sale.details.forEach(function(detail, index) {

                const product = detail.product;



                dataproduct = detail.product;
                console.log('Producto parseado:', dataproduct);


                const quantity = Number(detail.quantity);

                const price = Number(detail.price);


                const row = document.createElement('tr');


                row.innerHTML = `

                <td class="ps-4">
                    ${index + 1}
                </td>


                <td>

                    <div class="fw-semibold">
                        ${product?.name ?? 'Producto'}
                    </div>

                    <small class="text-muted">
                        ${product?.code ?? ''}
                    </small>

                </td>


                <td class="text-center">

                    <span class="badge bg-light text-dark">
                        ${quantity}
                    </span>

                </td>


                <td>

                    <input
                        type="number"
                        class="form-control form-control-sm text-center return-quantity"
                        min="0"
                        max="${quantity}"
                        value="0"
                        data-price="${price}"
                        data-product-detail="${JSON.stringify(dataproduct)}"
                    >

                </td>


                <td class="text-end">

                    ${formatMoney(price)}

                </td>


                <td class="text-end pe-4 fw-semibold return-subtotal">

                    ${formatMoney(0)}

                </td>

            `;


                returnProducts.appendChild(row);


                const quantityInput =
                    row.querySelector('.return-quantity');


                quantityInput.addEventListener(
                    'input',
                    calculateReturn
                );

            });


            calculateReturn();

        }


        /*
        |--------------------------------------------------------------------------
        | CALCULAR DEVOLUCIÓN
        |--------------------------------------------------------------------------
        */

        function calculateReturn() {

            let total = 0;

            let quantity = 0;

            let products = 0;


            document
                .querySelectorAll('.return-quantity')
                .forEach(function(input) {

                    let qty = Number(input.value) || 0;

                    const max = Number(input.max);

                    if (qty > max) {

                        qty = max;

                        input.value = max;

                    }

                    const productData = input.dataset.productDetail;

                    console.log('Producto seleccionado:', productData);

                    const price =
                        Number(input.dataset.price) || 0;


                    const subtotal =
                        qty * price;


                    const row =
                        input.closest('tr');


                    row.querySelector('.return-subtotal')
                        .textContent =
                        formatMoney(subtotal);


                    if (qty > 0) {

                        products++;

                    }


                    quantity += qty;

                    total += subtotal;

                });


            summaryProducts.textContent =
                products;


            summaryQuantity.textContent =
                quantity;


            summaryTotal.textContent =
                formatMoney(total);


            productsSelected.textContent =
                `${products} seleccionados`;

        }



        /*
        |--------------------------------------------------------------------------
        | REGISTRAR DEVOLUCIÓN
        |--------------------------------------------------------------------------
        */

        document
            .getElementById('btnCreateReturn')
            .addEventListener('click', function() {

                const quantities =
                    document.querySelectorAll('.return-quantity');


                let hasProducts = false;


                quantities.forEach(function(input) {

                    if (Number(input.value) > 0) {

                        hasProducts = true;

                    }

                });


                if (!hasProducts) {


                     Swal.fire("Debe seleccionar al menos un producto para devolver.");

                    return;

                }


                const reason =
                    document.getElementById('returnReason').value;


                if (!reason) {

                    Swal.fire("Seleccione el motivo de la devolución.");

                    return;

                }


                /*
                |--------------------------------------------------------------------------
                | AQUÍ POSTERIORMENTE ENVIAREMOS LA DEVOLUCIÓN
                |--------------------------------------------------------------------------
                */

                console.log('Devolución lista para guardar');

            });

    });
</script>
