const PRODUCTS_RETURN_KEY = "productsReturn";

let productsReturn = [];

let searchProduct = null;
let tableProductsSearch = null;

/**
 * =========================================================
 * DOM READY
 * =========================================================
 */

document.addEventListener("DOMContentLoaded", function () {
    initializeCustomerSearch();

    searchProduct = document.getElementById("searchProduct");

    tableProductsSearch = document.getElementById("tableProductsSearch");

    /*
     * Cargar productos guardados
     */

    productsReturn = getProductsFromLocalStorage();

    const productsInput = document.getElementById("productsInputreturn");

    if (productsInput) {
        productsInput.value = JSON.stringify(productsReturn);

        console.log("Productos cargados en input:", productsInput.value);
    } else {
        console.error("No existe #productsInputreturn");
    }

    /*
     * Renderizar productos
     */

    renderProductsReturn();

    /*
     * Calcular totales
     */

    calculateReturnTotal();

    /*
     * Inicializar búsqueda
     */

    initializeProductSearch();

    /*
     * Inicializar clientes
     */

    /*
     * Limpiar cliente
     */

    const btnClearCustomer = document.getElementById("btnClearCustomer");

    if (btnClearCustomer) {
        btnClearCustomer.addEventListener("click", function () {
            document.getElementById("customerName").value = "";

            document.getElementById("customerId").value = "";
        });
    }

    /*
     * Antes de enviar
     */

    const form = document.getElementById("returnForm");

    if (form) {
        form.addEventListener("submit", function (event) {
            const products = getProductsFromLocalStorage();

            if (products.length === 0) {
                event.preventDefault();

                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Debes agregar al menos un producto a la devolución.",
                });

                //alert("Debes agregar al menos un producto a la devolución.");

                return;
            }

            /*
             * Actualizar totales
             */

            calculateReturnTotal();
        });
    }
});

/**
 * =========================================================
 * LOCAL STORAGE
 * =========================================================
 */

function getProductsFromLocalStorage() {
    const products = localStorage.getItem(PRODUCTS_RETURN_KEY);

    if (!products) {
        return [];
    }

    try {
        const parsed = JSON.parse(products);

        if (!Array.isArray(parsed)) {
            return [];
        }

        return parsed;
    } catch (error) {
        console.error("Error leyendo productos de devolución:", error);

        return [];
    }
}

function saveProductsToLocalStorage(products) {
    // Asegurar que siempre sea un array
    if (!Array.isArray(products)) {
        products = [];
    }

    // Convertir productos a JSON
    const jsonProducts = JSON.stringify(products);

    // Guardar en LocalStorage
    localStorage.setItem(PRODUCTS_RETURN_KEY, jsonProducts);

    // Actualizar variable global
    productsReturn = products;

    // Buscar el input hidden
    const input = document.getElementById("productsInputreturn");

    // Validar que exista
    if (!input) {
        console.error("❌ No existe el input #productsInputreturn en el HTML");
        return;
    }

    // Pasar los productos al input
    input.value = jsonProducts;

    console.log("✅ Productos enviados al input:", input.value);
}

function clearProductsFromLocalStorage() {
    localStorage.removeItem(PRODUCTS_RETURN_KEY);

    productsReturn = [];
}

/**
 * =========================================================
 * BUSCAR PRODUCTOS
 * =========================================================
 */

function initializeProductSearch() {
    if (!searchProduct) {
        console.error("No existe #searchProduct");

        return;
    }

    if (!tableProductsSearch) {
        console.error("No existe #tableProductsSearch");

        return;
    }

    searchProduct.addEventListener("input", function () {
        const searchTerm = searchProduct.value.trim();

        console.log("Buscando producto:", searchTerm);

        /*
         * Limpiar
         */

        if (searchTerm.length === 0) {
            tableProductsSearch.innerHTML = `
                    <tr>
                        <td colspan="4"
                            class="text-center text-muted py-4">

                            Escribe para buscar productos.

                        </td>
                    </tr>
                `;

            return;
        }

        /*
         * Mínimo 2 caracteres
         */

        if (searchTerm.length < 2) {
            tableProductsSearch.innerHTML = `
                    <tr>
                        <td colspan="4"
                            class="text-center text-muted py-4">

                            Escribe al menos 2 caracteres.

                        </td>
                    </tr>
                `;

            return;
        }

        /*
         * Mostrar cargando
         */

        tableProductsSearch.innerHTML = `
                <tr>
                    <td colspan="4"
                        class="text-center py-4">

                        <div class="spinner-border spinner-border-sm me-2">
                        </div>

                        Buscando...

                    </td>
                </tr>
            `;

        /*
         * URL
         */

        const url = `${window.productSearchUrl}/${encodeURIComponent(searchTerm)}`;

        console.log("URL búsqueda:", url);

        /*
         * FETCH
         */

        fetch(url, {
            method: "GET",

            headers: {
                Accept: "application/json",

                "X-Requested-With": "XMLHttpRequest",
            },
        })
            .then((response) => {
                console.log("Status:", response.status);

                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}`);
                }

                return response.json();
            })

            .then((data) => {
                console.log("Respuesta productos:", data);

                /*
                 * Laravel puede devolver:
                 *
                 * []
                 *
                 * o
                 *
                 * {
                 *   data: []
                 * }
                 */

                const products = Array.isArray(data) ? data : data.data || [];

                renderProductSearch(products);
            })

            .catch((error) => {
                console.error("Error buscando productos:", error);

                tableProductsSearch.innerHTML = `
                    <tr>
                        <td colspan="4"
                            class="text-center text-danger py-4">

                            <i class="bi bi-exclamation-triangle me-2"></i>

                            Error al buscar productos.

                        </td>
                    </tr>
                `;
            });
    });
}

/**
 * =========================================================
 * MOSTRAR RESULTADOS DE PRODUCTOS
 * =========================================================
 */

function renderProductSearch(products) {
    if (!tableProductsSearch) {
        return;
    }

    if (!products || products.length === 0) {
        tableProductsSearch.innerHTML = `
            <tr>
                <td colspan="4"
                    class="text-center text-muted py-4">

                    <i class="bi bi-search fs-3 d-block mb-2"></i>

                    No se encontraron productos.

                </td>
            </tr>
        `;

        return;
    }

    let html = "";

    products.forEach((product) => {
        const id = Number(product.id);

        const name = escapeHtml(product.name ?? "");

        const code = escapeHtml(product.code ?? "");

        const price = Number(product.price ?? 0);

        const stock = Number(product.stock ?? 0);

        html += `

            <tr>

                <td>

                    <div class="fw-semibold">
                        ${name}
                    </div>

                    <small class="text-muted">
                        ${code}
                    </small>

                </td>


                <td>

                    $${price.toLocaleString("es-CO")}

                </td>


                <td>

                    ${stock}

                </td>


                <td>

                    <button
                        type="button"
                        class="btn btn-primary btn-sm"
                        onclick="addProductObjectToReturn(${JSON.stringify(product).replace(/"/g, "&quot;")})">

                        <i class="bi bi-plus-lg me-1"></i>

                        Agregar

                    </button>

                </td>

            </tr>

        `;
    });

    tableProductsSearch.innerHTML = html;
}

/**
 * =========================================================
 * AGREGAR PRODUCTO
 * =========================================================
 */

function addProductToReturn(productId) {
    const id = Number(productId);

    /*
     * Buscar producto nuevamente en el servidor
     *
     * Esto evita problemas al pasar objetos JSON
     * directamente en onclick.
     */

    const url = `${window.productSearchUrl}/${encodeURIComponent(id)}`;

    /*
     * IMPORTANTE:
     *
     * Si tu endpoint /product/search/{query}
     * busca tanto por nombre como por código,
     * buscar por ID puede no funcionar.
     *
     * Por eso primero intentamos buscar el producto
     * directamente.
     */

    fetch(`/product/${id}`, {
        method: "GET",

        headers: {
            Accept: "application/json",

            "X-Requested-With": "XMLHttpRequest",
        },
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}`);
            }

            return response.json();
        })

        .then((product) => {
            addProductObjectToReturn(product);
        })

        .catch((error) => {
            console.error("No se pudo obtener el producto:", error);

            /*
             * Si /product/{id} no existe,
             * aparecerá este mensaje.
             */

            alert("No se pudo obtener la información del producto.");
        });
}

/**
 * =========================================================
 * AGREGAR OBJETO A DEVOLUCIÓN
 * =========================================================
 */

function addProductObjectToReturn(product) {
    const productId = Number(product.id);

    let products = getProductsFromLocalStorage();

    const existingIndex = products.findIndex(
        (item) => Number(item.id) === productId,
    );

    /*
     * Si ya existe
     */

    if (existingIndex !== -1) {
        const currentQuantity = Number(products[existingIndex].quantity || 0);

        const stock = Number(products[existingIndex].stock || 0);

        if (stock > 0 && currentQuantity < stock) {
            products[existingIndex].quantity = currentQuantity + 1;
        }

        saveProductsToLocalStorage(products);

        productsReturn = products;

        renderProductsReturn();

        calculateReturnTotal();

        return;
    }

    /*
     * Producto nuevo
     */

    products.push({
        id: productId,

        code: product.code ?? "",

        name: product.name ?? "",

        price: Number(product.price ?? 0),

        cost: Number(product.cost ?? 0),

        stock: Number(product.stock ?? 0),

        quantity: 1,
    });

    /*
     * Guardar
     */

    saveProductsToLocalStorage(products);

    productsReturn = products;

    /*
     * Renderizar
     */

    renderProductsReturn();

    /*
     * Calcular
     */

    calculateReturnTotal();

    /*
     * Limpiar búsqueda
     */

    if (searchProduct) {
        searchProduct.value = "";
    }

    if (tableProductsSearch) {
        tableProductsSearch.innerHTML = `
            <tr>
                <td colspan="4"
                    class="text-center text-success py-4">

                    <i class="bi bi-check-circle fs-3 d-block mb-2"></i>

                    Producto agregado correctamente.

                </td>
            </tr>
        `;
    }
}

/**
 * =========================================================
 * RENDER PRODUCTOS DE DEVOLUCIÓN
 * =========================================================
 */

function renderProductsReturn() {
    const products = getProductsFromLocalStorage();

    const tableBody = document.getElementById("returnProducts");

    if (!tableBody) {
        console.error("No existe #returnProducts");

        return;
    }

    /*
     * No productos
     */

    if (!products || products.length === 0) {
        tableBody.innerHTML = `

            <tr>

                <td colspan="6"
                    class="text-center py-5 text-muted">

                    <i class="bi bi-box2 fs-1 d-block mb-3"></i>

                    <h6 class="fw-semibold">
                        No hay productos
                    </h6>

                    <p class="mb-0">
                        Agrega productos para realizar la devolución.
                    </p>

                </td>

            </tr>

        `;

        return;
    }

    let html = "";

    products.forEach((product) => {
        const id = Number(product.id);

        const quantity = Number(product.quantity || 1);

        const price = Number(product.price || 0);

        const cost = Number(product.cost || 0);

        const subtotal = quantity * price;

        html += `

            <tr>

                <td class="ps-4">

                    <div class="fw-semibold">

                        ${escapeHtml(product.name ?? "")}

                    </div>

                    <small class="text-muted">

                        ${escapeHtml(product.code ?? "")}

                    </small>

                </td>


                <td>

                    <input
                        type="number"
                        class="form-control"
                        min="1"
                        value="${quantity}"
                        onchange="updateProductQuantity(${id}, this.value)"
                    >

                </td>


                <td>

                    <input
                        type="number"
                        class="form-control"
                        min="0"
                        step="0.01"
                        value="${price}"
                        onchange="updateProductPrice(${id}, this.value)"
                    >

                </td>


                <td>

                    $${cost.toLocaleString("es-CO")}

                </td>


                <td class="fw-semibold">

                    $${subtotal.toLocaleString("es-CO")}

                </td>


                <td>

                    <button
                        type="button"
                        class="btn btn-sm btn-outline-danger"
                        onclick="removeProductReturn(${id})">

                        <i class="bi bi-trash"></i>

                    </button>

                </td>

            </tr>

        `;
    });

    tableBody.innerHTML = html;
}

/**
 * =========================================================
 * ACTUALIZAR CANTIDAD
 * =========================================================
 */

function updateProductQuantity(productId, quantity) {
    let products = getProductsFromLocalStorage();

    let newQuantity = Number(quantity);

    if (isNaN(newQuantity) || newQuantity < 1) {
        newQuantity = 1;
    }

    products = products.map((product) => {
        if (Number(product.id) === Number(productId)) {
            const stock = Number(product.stock || 0);

            if (stock > 0 && newQuantity > stock) {
                alert(
                    `La cantidad no puede ser mayor al stock disponible (${stock}).`,
                );

                newQuantity = stock;
            }

            return {
                ...product,

                quantity: newQuantity,
            };
        }

        return product;
    });

    saveProductsToLocalStorage(products);

    productsReturn = products;

    renderProductsReturn();

    calculateReturnTotal();
}

/**
 * =========================================================
 * ACTUALIZAR PRECIO
 * =========================================================
 */

function updateProductPrice(productId, price) {
    let products = getProductsFromLocalStorage();

    let newPrice = Number(price);

    if (isNaN(newPrice) || newPrice < 0) {
        newPrice = 0;
    }

    products = products.map((product) => {
        if (Number(product.id) === Number(productId)) {
            return {
                ...product,

                price: newPrice,
            };
        }

        return product;
    });

    saveProductsToLocalStorage(products);

    productsReturn = products;

    renderProductsReturn();

    calculateReturnTotal();
}

/**
 * =========================================================
 * ELIMINAR PRODUCTO
 * =========================================================
 */

function removeProductReturn(productId) {
    let products = getProductsFromLocalStorage();

    products = products.filter(
        (product) => Number(product.id) !== Number(productId),
    );

    saveProductsToLocalStorage(products);

    productsReturn = products;

    renderProductsReturn();

    calculateReturnTotal();
}

/**
 * =========================================================
 * CALCULAR TOTAL
 * =========================================================
 */

function calculateReturnTotal() {
    const products = getProductsFromLocalStorage();

    let totalProducts = products.length;

    let totalQuantity = 0;

    let subtotal = 0;

    products.forEach((product) => {
        const quantity = Number(product.quantity || 0);

        const price = Number(product.price || 0);

        totalQuantity += quantity;

        subtotal += quantity * price;
    });

    const discount = 0;

    const total = subtotal - discount;

    /*
     * ELEMENTOS
     */

    const productsElement = document.getElementById("totalProducts");

    const quantityElement = document.getElementById("totalQuantity");

    const subtotalElement = document.getElementById("subtotalReturn");

    const discountElement = document.getElementById("discountReturn");

    const totalElement = document.getElementById("totalReturn");

    const subtotalInput = document.getElementById("subtotalInput");

    const totalInput = document.getElementById("totalInput");

    /*
     * MOSTRAR
     */

    if (productsElement) {
        productsElement.textContent = totalProducts;
    }

    if (quantityElement) {
        quantityElement.textContent = totalQuantity;
    }

    if (subtotalElement) {
        subtotalElement.textContent = `$${subtotal.toLocaleString("es-CO")}`;
    }

    if (discountElement) {
        discountElement.textContent = `$${discount.toLocaleString("es-CO")}`;
    }

    if (totalElement) {
        totalElement.textContent = `$${total.toLocaleString("es-CO")}`;
    }

    /*
     * INPUTS
     */

    if (subtotalInput) {
        subtotalInput.value = subtotal;
    }

    if (totalInput) {
        totalInput.value = total;
    }
}

/**
 * =========================================================
 * CLIENTES - DEVOLUCIONES
 * =========================================================
 */

let searchCustomers = {};

/**
 * =========================================================
 * INICIALIZAR BUSCADOR DE CLIENTES
 * =========================================================
 */

function initializeCustomerSearch() {
    const searchInput = document.getElementById("searchCustomer");

    const table = document.getElementById("tableCustomersSearch");

    if (!searchInput) {
        console.error("No existe el elemento #searchCustomer");
        return;
    }

    if (!table) {
        console.error("No existe el elemento #tableCustomersSearch");
        return;
    }

    /*
    |--------------------------------------------------------------------------
    | BUSCAR CLIENTES
    |--------------------------------------------------------------------------
    */

    searchInput.addEventListener("input", function () {
        const term = this.value.trim();

        /*
        |--------------------------------------------------------------------------
        | CAMPO VACÍO
        |--------------------------------------------------------------------------
        */

        if (term.length === 0) {
            table.innerHTML = `
                <tr>
                    <td colspan="4"
                        class="text-center text-muted py-4">

                        <i class="bi bi-person-search fs-3 d-block mb-2"></i>

                        Escribe el nombre, documento o teléfono.

                    </td>
                </tr>
            `;

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | MÍNIMO 2 CARACTERES
        |--------------------------------------------------------------------------
        */

        if (term.length < 2) {
            table.innerHTML = `
                <tr>
                    <td colspan="4"
                        class="text-center text-muted py-4">

                        Escribe al menos 2 caracteres.

                    </td>
                </tr>
            `;

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | CARGANDO
        |--------------------------------------------------------------------------
        */

        table.innerHTML = `
            <tr>
                <td colspan="4"
                    class="text-center py-4">

                    <div class="spinner-border spinner-border-sm me-2">
                    </div>

                    Buscando clientes...

                </td>
            </tr>
        `;

        /*
        |--------------------------------------------------------------------------
        | URL
        |--------------------------------------------------------------------------
        |
        | Esta URL debe existir en el Blade:
        |
        | window.customerSearchUrl
        |
        */

        const url = `${window.customerSearchUrl}/${encodeURIComponent(term)}`;

        console.log("Buscando clientes:", url);

        /*
        |--------------------------------------------------------------------------
        | PETICIÓN
        |--------------------------------------------------------------------------
        */

        fetch(url, {
            method: "GET",

            headers: {
                Accept: "application/json",
                "X-Requested-With": "XMLHttpRequest",
            },
        })
            .then((response) => {
                console.log("Status búsqueda cliente:", response.status);

                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}`);
                }

                return response.json();
            })

            .then((data) => {
                console.log("Respuesta clientes:", data);

                /*
            |--------------------------------------------------------------------------
            | SOPORTAR ARRAY O PAGINACIÓN
            |--------------------------------------------------------------------------
            */

                const customers = Array.isArray(data) ? data : data.data || [];

                renderCustomerSearch(customers);
            })

            .catch((error) => {
                console.error("Error buscando clientes:", error);

                table.innerHTML = `
                <tr>
                    <td colspan="4"
                        class="text-center text-danger py-4">

                        <i class="bi bi-exclamation-triangle me-2"></i>

                        Error al buscar clientes.

                    </td>
                </tr>
            `;
            });
    });
}

/**
 * =========================================================
 * MOSTRAR CLIENTES
 * =========================================================
 */

function renderCustomerSearch(customers) {
    const table = document.getElementById("tableCustomersSearch");

    if (!table) {
        console.error("No existe #tableCustomersSearch");

        return;
    }

    /*
    |--------------------------------------------------------------------------
    | LIMPIAR CLIENTES ANTERIORES
    |--------------------------------------------------------------------------
    */

    searchCustomers = {};

    /*
    |--------------------------------------------------------------------------
    | SIN RESULTADOS
    |--------------------------------------------------------------------------
    */

    if (!customers || customers.length === 0) {
        table.innerHTML = `
            <tr>
                <td colspan="4"
                    class="text-center text-muted py-4">

                    <i class="bi bi-person-x fs-2 d-block mb-2"></i>

                    No se encontraron clientes.

                </td>
            </tr>
        `;

        return;
    }

    let html = "";

    /*
    |--------------------------------------------------------------------------
    | RECORRER CLIENTES
    |--------------------------------------------------------------------------
    */

    customers.forEach((customer) => {
        const id = Number(customer.id);

        /*
        |--------------------------------------------------------------------------
        | GUARDAR CLIENTE
        |--------------------------------------------------------------------------
        */

        searchCustomers[id] = customer;

        /*
        |--------------------------------------------------------------------------
        | NOMBRE
        |--------------------------------------------------------------------------
        |
        | Primero intenta full_name.
        | Si no existe utiliza name.
        |
        */

        const name = customer.full_name ?? customer.name ?? "";

        /*
        |--------------------------------------------------------------------------
        | DOCUMENTO
        |--------------------------------------------------------------------------
        |
        | Soporta document e identification.
        |
        */

        const documentNumber =
            customer.document ?? customer.identification ?? "";

        /*
        |--------------------------------------------------------------------------
        | TELÉFONO
        |--------------------------------------------------------------------------
        */

        const phone = customer.phone ?? "";

        html += `

            <tr>

                <td>

                    <div class="fw-semibold">

                        ${escapeHtml(name)}

                    </div>

                </td>


                <td>

                    ${escapeHtml(documentNumber)}

                </td>


                <td>

                    ${escapeHtml(phone)}

                </td>


                <td>

                    <button
                        type="button"
                        class="btn btn-primary btn-sm"
                        onclick="selectCustomerFromSearch(${id})">

                        <i class="bi bi-check-lg me-1"></i>

                        Seleccionar

                    </button>

                </td>

            </tr>

        `;
    });

    table.innerHTML = html;
}

/**
 * =========================================================
 * SELECCIONAR CLIENTE
 * =========================================================
 */

function selectCustomerFromSearch(customerId) {
    console.log("ID cliente seleccionado:", customerId);

    const customer = searchCustomers[Number(customerId)];

    /*
    |--------------------------------------------------------------------------
    | VALIDAR
    |--------------------------------------------------------------------------
    */

    if (!customer) {
        console.error("Cliente no encontrado:", customerId);

        alert("No se encontró la información del cliente.");

        return;
    }

    console.log("Cliente seleccionado:", customer);

    /*
    |--------------------------------------------------------------------------
    | OBTENER NOMBRE
    |--------------------------------------------------------------------------
    */

    const customerName = customer.full_name ?? customer.name ?? "";

    /*
    |--------------------------------------------------------------------------
    | INPUT ID
    |--------------------------------------------------------------------------
    */

    const customerIdInput = document.getElementById("customerId");

    /*
    |--------------------------------------------------------------------------
    | INPUT NOMBRE
    |--------------------------------------------------------------------------
    */

    const customerNameInput = document.getElementById("customerName");

    /*
    |--------------------------------------------------------------------------
    | GUARDAR ID
    |--------------------------------------------------------------------------
    */

    if (customerIdInput) {
        customerIdInput.value = customer.id;
    }

    /*
    |--------------------------------------------------------------------------
    | MOSTRAR NOMBRE
    |--------------------------------------------------------------------------
    */

    if (customerNameInput) {
        customerNameInput.value = customerName;
    }

    /*
    |--------------------------------------------------------------------------
    | CERRAR MODAL
    |--------------------------------------------------------------------------
    */

    const modalElement = document.getElementById("customerModal");

    if (modalElement) {
        if (typeof bootstrap !== "undefined") {
            let modal = bootstrap.Modal.getInstance(modalElement);

            if (!modal) {
                modal = new bootstrap.Modal(modalElement);
            }

            modal.hide();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | LIMPIAR BUSCADOR
    |--------------------------------------------------------------------------
    */

    const searchInput = document.getElementById("searchCustomer");

    if (searchInput) {
        searchInput.value = "";
    }

    /*
    |--------------------------------------------------------------------------
    | LIMPIAR RESULTADOS
    |--------------------------------------------------------------------------
    */

    const table = document.getElementById("tableCustomersSearch");

    if (table) {
        table.innerHTML = `
            <tr>
                <td colspan="4"
                    class="text-center text-success py-4">

                    <i class="bi bi-check-circle fs-3 d-block mb-2"></i>

                    Cliente seleccionado correctamente.

                </td>
            </tr>
        `;
    }
}

/**
 * =========================================================
 * LIMPIAR CLIENTE
 * =========================================================
 */

function clearCustomer() {
    const customerName = document.getElementById("customerName");

    const customerId = document.getElementById("customerId");

    if (customerName) {
        customerName.value = "";
    }

    if (customerId) {
        customerId.value = "";
    }

    console.log("Cliente eliminado.");
}

/**
 * =========================================================
 * ESCAPAR HTML
 * =========================================================
 */

function escapeHtml(value) {
    return String(value ?? "")
        .replaceAll("&", "&amp;")

        .replaceAll("<", "&lt;")

        .replaceAll(">", "&gt;")

        .replaceAll('"', "&quot;")

        .replaceAll("'", "&#039;");
}

/**
 * =========================================================
 * FUNCIONES GLOBALES
 * =========================================================
 *
 * Necesarias porque los botones usan onclick=""
 */

window.selectCustomerFromSearch = selectCustomerFromSearch;

window.clearCustomer = clearCustomer;

/**
 * =========================================================
 * INICIAR CUANDO CARGUE LA PÁGINA
 * =========================================================
 */

document.addEventListener("DOMContentLoaded", function () {
    initializeCustomerSearch();

    /*
        |--------------------------------------------------------------------------
        | BOTÓN LIMPIAR CLIENTE
        |--------------------------------------------------------------------------
        */

    const btnClearCustomer = document.getElementById("btnClearCustomer");

    if (btnClearCustomer) {
        btnClearCustomer.addEventListener("click", clearCustomer);
    }
});
