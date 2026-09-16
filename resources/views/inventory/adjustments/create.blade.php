@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4 mt-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1">
                    <i class="bi bi-boxes me-2"></i>
                    Nuevo ajuste de inventario
                </h4>
                <p class="text-muted mb-0">
                    Registra una entrada o salida manual de inventario.
                </p>
            </div>

            <a href="{{ route('inventory.adjustments.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i>
                Volver
            </a>
        </div>



        <form action="{{ route('inventory.adjustments.store') }}" method="POST" id="adjustmentForm">

            @csrf

            <input type="hidden" name="product_id" id="product_id" value="{{ old('product_id') }}">

            <div class="row g-4">

                <div class="col-lg-8">

                    <div class="card border-0 shadow-sm rounded-4">

                        <div class="card-header bg-white border-0 p-4">
                            <h5 class="fw-bold mb-0">
                                <i class="bi bi-box-seam me-2"></i>
                                Producto
                            </h5>
                        </div>

                        <div class="card-body p-4">

                            <div id="productEmpty" class="text-center py-5">

                                <div class="mb-3">
                                    <i class="bi bi-search display-4 text-muted"></i>
                                </div>

                                <h5 class="fw-semibold">
                                    Selecciona un producto
                                </h5>

                                <p class="text-muted">
                                    Busca el producto por código o nombre.
                                </p>

                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#productSearchModal">

                                    <i class="bi bi-search me-1"></i>
                                    Buscar producto
                                </button>

                            </div>

                            <div id="productSelected" class="d-none">

                                <div class="border rounded-4 p-4">

                                    <div class="d-flex justify-content-between align-items-start">

                                        <div class="d-flex gap-3">

                                            <div class="bg-light rounded-3 p-3">
                                                <i class="bi bi-box-seam fs-3"></i>
                                            </div>

                                            <div>
                                                <span class="text-muted small">
                                                    Código
                                                </span>

                                                <h6 class="fw-bold mb-1" id="selectedProductCode">
                                                </h6>

                                                <div id="selectedProductName" class="text-muted">
                                                </div>
                                            </div>

                                        </div>

                                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                            data-bs-target="#productSearchModal">

                                            <i class="bi bi-search me-1"></i>
                                            Cambiar
                                        </button>

                                    </div>

                                    <hr>

                                    <div class="row g-3">

                                        <div class="col-md-6">

                                            <div class="bg-light rounded-3 p-3">

                                                <div class="text-muted small">
                                                    Stock actual
                                                </div>

                                                <div class="fs-4 fw-bold" id="selectedProductStock">
                                                    0
                                                </div>

                                            </div>

                                        </div>

                                        <div class="col-md-6">

                                            <div class="bg-light rounded-3 p-3">

                                                <div class="text-muted small">
                                                    Costo
                                                </div>

                                                <div class="fs-5 fw-bold" id="selectedProductCost">
                                                    $0
                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>

                </div>


                <div class="col-lg-4">

                    <div class="card border-0 shadow-sm rounded-4">

                        <div class="card-header bg-white border-0 p-4">
                            <h5 class="fw-bold mb-0">
                                <i class="bi bi-sliders me-2"></i>
                                Datos del ajuste
                            </h5>
                        </div>

                        <div class="card-body p-4">

                            <div class="mb-3">

                                <label class="form-label fw-semibold">
                                    Tipo de movimiento
                                </label>

                                <select name="movement_type" id="movement_type" class="form-select" required>

                                    <option value="">
                                        Seleccionar
                                    </option>

                                    <option value="income" {{ old('movement_type') === 'income' ? 'selected' : '' }}>
                                        Entrada
                                    </option>

                                    <option value="output" {{ old('movement_type') === 'output' ? 'selected' : '' }}>
                                        Salida
                                    </option>

                                </select>

                            </div>


                            <div class="mb-3">

                                <label class="form-label fw-semibold">
                                    Cantidad
                                </label>

                                <input type="number" name="quantity" id="quantity" class="form-control" min="1"
                                    value="{{ old('quantity', 1) }}" required>

                                <div class="form-text">
                                    La cantidad debe ser un número entero.
                                </div>

                            </div>


                            <div class="mb-4">

                                <label class="form-label fw-semibold">
                                    Observación
                                </label>

                                <textarea name="observation" class="form-control" rows="4" maxlength="500" placeholder="Motivo del ajuste...">{{ old('observation') }}</textarea>

                            </div>


                            <div class="d-grid gap-2">

                                <button type="submit" class="btn btn-primary" id="saveAdjustment">

                                    <i class="bi bi-check-circle me-1"></i>
                                    Registrar ajuste

                                </button>

                                <a href="{{ route('inventory.adjustments.index') }}" class="btn btn-light">

                                    Cancelar

                                </a>

                            </div>

                        </div>
                    </div>

                </div>

            </div>

        </form>

    </div>


    <div class="modal fade" id="productSearchModal" tabindex="-1" aria-labelledby="productSearchModalLabel"
        aria-hidden="true">

        <div class="modal-dialog modal-lg modal-dialog-centered">

            <div class="modal-content border-0 shadow rounded-4">

                <div class="modal-header">

                    <h5 class="modal-title fw-bold" id="productSearchModalLabel">

                        <i class="bi bi-search me-2"></i>
                        Buscar producto

                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body p-4">

                    <div class="input-group mb-4">

                        <span class="input-group-text bg-white">
                            <i class="bi bi-search"></i>
                        </span>

                        <input type="text" id="productSearch" class="form-control"
                            placeholder="Buscar por código o nombre..." autocomplete="off">

                    </div>


                    <div id="productSearchLoading" class="text-center py-4 d-none">

                        <div class="spinner-border" role="status">
                        </div>

                        <div class="text-muted mt-2">
                            Buscando productos...
                        </div>

                    </div>


                    <div id="productSearchEmpty" class="text-center text-muted py-4">

                        <i class="bi bi-search display-6"></i>

                        <p class="mt-2 mb-0">
                            Escribe el código o nombre del producto.
                        </p>

                    </div>


                    <div class="table-responsive">

                        <table class="table table-hover align-middle d-none" id="productsSearchTable">

                            <thead class="table-light">

                                <tr>
                                    <th>Código</th>
                                    <th>Producto</th>
                                    <th>Stock</th>
                                    <th>Precio</th>
                                    <th></th>
                                </tr>

                            </thead>

                            <tbody id="productsSearchBody">
                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection



<script>
    document.addEventListener('DOMContentLoaded', function() {

        const productId = document.getElementById('product_id');

        const productEmpty = document.getElementById('productEmpty');

        const productSelected = document.getElementById('productSelected');

        const selectedProductCode =
            document.getElementById('selectedProductCode');

        const selectedProductName =
            document.getElementById('selectedProductName');

        const selectedProductStock =
            document.getElementById('selectedProductStock');

        const selectedProductCost =
            document.getElementById('selectedProductCost');

        const productSearch =
            document.getElementById('productSearch');

        const productsSearchTable =
            document.getElementById('productsSearchTable');

        const productsSearchBody =
            document.getElementById('productsSearchBody');

        const productSearchEmpty =
            document.getElementById('productSearchEmpty');

        const productSearchLoading =
            document.getElementById('productSearchLoading');

        let searchTimeout = null;


        function formatMoney(value) {

            return new Intl.NumberFormat('es-CO', {
                style: 'currency',
                currency: 'COP',
                maximumFractionDigits: 0
            }).format(value || 0);

        }


        function selectProduct(product) {

            productId.value = product.id;

            selectedProductCode.textContent =
                product.code ?? '';

            selectedProductName.textContent =
                product.name ?? '';

            selectedProductStock.textContent =
                product.stock ?? 0;

            selectedProductCost.textContent =
                formatMoney(product.cost);

            productEmpty.classList.add('d-none');

            productSelected.classList.remove('d-none');

            const modalElement =
                document.getElementById('productSearchModal');

            const modal =
                bootstrap.Modal.getInstance(modalElement);

            if (modal) {
                modal.hide();
            }

        }


        function renderProducts(products) {

            productsSearchBody.innerHTML = '';

            if (!products.length) {

                productsSearchTable.classList.add('d-none');

                productSearchEmpty.classList.remove('d-none');

                productSearchEmpty.innerHTML = `
                <i class="bi bi-box display-6"></i>
                <p class="mt-2 mb-0">
                    No se encontraron productos.
                </p>
            `;

                return;
            }


            productSearchEmpty.classList.add('d-none');

            productsSearchTable.classList.remove('d-none');


            products.forEach(product => {

                const row = document.createElement('tr');

                row.innerHTML = `

                <td>
                    <span class="badge text-bg-light">
                        ${product.code ?? ''}
                    </span>
                </td>

                <td>
                    <div class="fw-semibold">
                        ${product.name ?? ''}
                    </div>
                </td>

                <td>
                    <span class="fw-semibold">
                        ${product.stock ?? 0}
                    </span>
                </td>

                <td>
                    ${formatMoney(product.price)}
                </td>

                <td class="text-end">

                    <button type="button"
                            class="btn btn-sm btn-primary select-product">

                        <i class="bi bi-check2"></i>
                        Seleccionar

                    </button>

                </td>

            `;

                row.querySelector('.select-product')
                    .addEventListener('click', function() {

                        selectProduct(product);

                    });


                productsSearchBody.appendChild(row);

            });

        }


        async function searchProducts(term) {

            if (!term.trim()) {

                productsSearchTable.classList.add('d-none');

                productSearchEmpty.classList.remove('d-none');

                productSearchEmpty.innerHTML = `
                <i class="bi bi-search display-6"></i>
                <p class="mt-2 mb-0">
                    Escribe el código o nombre del producto.
                </p>
            `;

                return;

            }


            productSearchLoading.classList.remove('d-none');

            productSearchEmpty.classList.add('d-none');

            productsSearchTable.classList.add('d-none');


            try {

                const response =
                    await fetch(
                        `/product/search/${encodeURIComponent(term)}`
                    );

                if (!response.ok) {
                    throw new Error('Error en la búsqueda');
                }

                const data = await response.json();

                const products =
                    Array.isArray(data) ?
                    data :
                    (data.data ?? data.products ?? []);


                renderProducts(products);

            } catch (error) {

                console.error(error);

                productSearchEmpty.classList.remove('d-none');

                productSearchEmpty.innerHTML = `
                <i class="bi bi-exclamation-triangle display-6 text-danger"></i>
                <p class="mt-2 mb-0">
                    No se pudo realizar la búsqueda.
                </p>
            `;

            } finally {

                productSearchLoading.classList.add('d-none');

            }

        }


        productSearch.addEventListener('input', function() {

            clearTimeout(searchTimeout);

            const term = this.value;

            searchTimeout = setTimeout(function() {

                searchProducts(term);

            }, 350);

        });


        document
            .getElementById('productSearchModal')
            .addEventListener('shown.bs.modal', function() {

                productSearch.focus();

            });


        document
            .getElementById('productSearchModal')
            .addEventListener('hidden.bs.modal', function() {

                productSearch.value = '';

                productsSearchBody.innerHTML = '';

                productsSearchTable.classList.add('d-none');

                productSearchEmpty.classList.remove('d-none');

                productSearchEmpty.innerHTML = `
                <i class="bi bi-search display-6"></i>
                <p class="mt-2 mb-0">
                    Escribe el código o nombre del producto.
                </p>
            `;

            });


        document
            .getElementById('adjustmentForm')
            .addEventListener('submit', function(event) {

                if (!productId.value) {

                    event.preventDefault();

                    alert('Debes seleccionar un producto.');

                    return;

                }


                const movementType =
                    document.getElementById('movement_type').value;

                if (!movementType) {

                    event.preventDefault();

                    alert('Debes seleccionar el tipo de movimiento.');

                    return;

                }

            });


        @if (old('product_id'))

            fetch(`/product/search/${encodeURIComponent('{{ old('product_id') }}')}`)
                .then(response => response.json())
                .then(data => {

                    const products =
                        Array.isArray(data) ?
                        data :
                        (data.data ?? data.products ?? []);

                    const product =
                        products.find(
                            item => String(item.id) === String('{{ old('product_id') }}')
                        );

                    if (product) {
                        selectProduct(product);
                    }

                })
                .catch(error => {
                    console.error(error);
                });
        @endif

    });
</script>
