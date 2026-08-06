
/*=========================================================
=            CONFIGURACIÓN                                =
=========================================================*/

const STORAGE_KEY_PRODUCTS = "datosProducts";
const STORAGE_SALE = "saleInformation";

/*=========================================================
=            ELEMENTOS DEL DOM                            =
=========================================================*/

// Buscar productos
const searchProduct = document.getElementById("searchProduct");
const btnSearchProduct = document.getElementById("btnSearchProduct");

// Tablas
const tbodyProducts = document.querySelector("#tableProducts tbody");
const tbodySaleProducts = document.querySelector("#tableSaleProducts tbody");

// Información adicional
const paymentMethod = document.getElementById("paymentMethod");
const receivedAmount = document.getElementById("receivedAmount");
const changeAmount = document.getElementById("changeAmount");
const observation = document.getElementById("saleObservation");

// Botones
const btnClear = document.getElementById("btnClear");

/*=========================================================
=            VARIABLES GLOBALES                           =
=========================================================*/

let datosProducts = [];

/*=========================================================
=            INICIALIZACIÓN                               =
=========================================================*/

document.addEventListener("DOMContentLoaded", initSale);

function initSale() {
    loadProductData();

    loadSaleInformation();

    registerEvents();
}

/*=========================================================
=            REGISTRO DE EVENTOS                          =
=========================================================*/

function registerEvents() {
    // Buscar mientras escribe
    searchProduct.addEventListener("input", handleSearchInput);

    // Buscar con botón
    btnSearchProduct.addEventListener("click", handleSearchButton);

    // Información adicional
    paymentMethod.addEventListener("change", updatePayment);

    receivedAmount.addEventListener("input", calculateChange);

    observation.addEventListener("keyup", saveSaleInformation);

    // Limpiar venta
    btnClear.addEventListener("click", () => {
        if (confirm("¿Desea limpiar la venta actual?")) {
            clearSaleData();
        }
    });
}

/*=========================================================
=            EVENTOS DE BÚSQUEDA                          =
=========================================================*/

function handleSearchInput() {
    const search = searchProduct.value.trim();

    if (search.length < 3) {
        clearSearchTable();

        return;
    }

    searchProducts(search);
}

function handleSearchButton() {
    const search = searchProduct.value.trim();

    if (!search) return;

    searchProducts(search);
}

/*=========================================================
=            BÚSQUEDA DE PRODUCTOS                        =
=========================================================*/

async function searchProducts(search) {
    clearSearchTable();

    try {
        const response = await fetch(
            `/products/search/${encodeURIComponent(search)}`,
        );

        if (!response.ok) {
            throw new Error("Error al consultar productos.");
        }

        const products = await response.json();

        renderSearchProducts(products);
    } catch (error) {
        console.error(error);
    }
}

/*=========================================================
=            TABLA DE RESULTADOS                          =
=========================================================*/

function renderSearchProducts(products) {
    let html = "";

    if (products.length === 0) {
        html = `
            <tr>

                <td colspan="6" class="text-center text-muted py-4">

                    No se encontraron productos.

                </td>

            </tr>
        `;

        tbodyProducts.innerHTML = html;

        return;
    }

    products.forEach((product) => {
        html += `

            <tr>

                <td>${product.code}</td>

                <td>${product.name}</td>

                <td class="text-center">

                    ${product.stock}

                </td>

                <td class="text-end">

                    $ ${Number(product.price).toLocaleString("es-CO")}

                </td>

                <td class="text-center">

                    ${
                        product.state
                            ? '<span class="badge bg-success">Activo</span>'
                            : '<span class="badge bg-danger">Inactivo</span>'
                    }

                </td>

                <td class="text-center">

                    <button
                        class="btn btn-primary btn-sm"
                        onclick='selectProducto(${JSON.stringify(product)})'>

                        <i class="bi bi-plus-circle"></i>

                    </button>

                </td>

            </tr>

        `;
    });

    tbodyProducts.innerHTML = html;
}

function clearSearchTable() {
    tbodyProducts.innerHTML = "";
}

/*=========================================================
=            SELECCIONAR PRODUCTO                         =
=========================================================*/

function selectProducto(product) {
    addProductToSale(product);

    const modal = bootstrap.Modal.getInstance(
        document.getElementById("productModal"),
    );

    modal.hide();

    searchProduct.value = "";

    clearSearchTable();
}

/*=========================================================
=            CARRITO DE VENTAS                            =
=========================================================*/

function addProductToSale(product) {
    const index = datosProducts.findIndex((item) => item.id === product.id);

    if (index >= 0) {
        datosProducts[index].quantity++;
    } else {
        datosProducts.push({
            id: product.id,
            code: product.code,
            name: product.name,
            stock: product.stock,
            cost: Number(product.cost),
            price: Number(product.price),
            tax: Number(product.tax ?? 0),
            quantity: 1,
            discount: 0,
        });
    }

    saveProducts();
}

/*=========================================================
=            LOCAL STORAGE                                =
=========================================================*/

function saveProducts() {
    localStorage.setItem(STORAGE_KEY_PRODUCTS, JSON.stringify(datosProducts));

    renderSaleProducts();
}

function loadProductData() {
    datosProducts =
        JSON.parse(localStorage.getItem(STORAGE_KEY_PRODUCTS)) || [];

    renderSaleProducts();
}

/*=========================================================
=            TABLA DE LA VENTA                            =
=========================================================*/

function renderSaleProducts() {
    let html = "";

    datosProducts.forEach((product, index) => {
        const subtotal = product.quantity * product.price - product.discount;

        html += `

        <tr>

            <td class="text-center">

                ${index + 1}

            </td>

            <td>

                ${product.code}

            </td>

            <td>

                ${product.name}

            </td>

            <td width="90">

                <input

                    type="number"

                    class="form-control form-control-sm text-center"

                    min="1"

                    max="${product.stock}"

                    value="${product.quantity}"

                    onchange="changeQuantity(${product.id}, this.value)">

            </td>

            <td width="120">

                <input

                    type="number"

                    class="form-control form-control-sm text-end"

                    min="${product.cost}"

                    step="100"

                    value="${product.price}"

                    onchange="changePrice(${product.id}, this.value)">

            </td>

            <td width="120">

                <input

                    type="number"

                    class="form-control form-control-sm text-end"

                    min="0"

                    value="${product.discount}"

                    onchange="changeDiscount(${product.id}, this.value)">

            </td>

            <td class="text-end fw-bold">

                $

                ${subtotal.toLocaleString("es-CO")}

            </td>

            <td class="text-center">

                <button

                    class="btn btn-outline-danger btn-sm"

                    onclick="removeProduct(${product.id})">

                    <i class="bi bi-trash"></i>

                </button>

            </td>

        </tr>

        `;
    });

    tbodySaleProducts.innerHTML = html;

    updateSummary();
}

/*=========================================================
=            CAMBIAR CANTIDAD                             =
=========================================================*/

function changeQuantity(id, quantity) {
    const product = datosProducts.find((p) => p.id === id);

    if (!product) return;

    quantity = Number(quantity);

    if (quantity <= 0) quantity = 1;

    if (quantity > product.stock) {
        alert("La cantidad supera el stock disponible.");

        quantity = product.stock;
    }

    product.quantity = quantity;

    saveProducts();
}

/*=========================================================
=            CAMBIAR PRECIO                               =
=========================================================*/

function changePrice(id, price) {
    const product = datosProducts.find((p) => p.id === id);

    if (!product) return;

    price = Number(price);

    if (price < product.cost) {
        alert("El precio no puede ser menor al costo.");

        price = product.cost;
    }

    product.price = price;

    saveProducts();
}

/*=========================================================
=            CAMBIAR DESCUENTO                            =
=========================================================*/

function changeDiscount(id, discount) {
    const product = datosProducts.find((p) => p.id === id);

    if (!product) return;

    discount = Number(discount);

    if (discount < 0) discount = 0;

    const subtotal = product.quantity * product.price;

    if (discount > subtotal) {
        alert("El descuento no puede ser mayor al subtotal.");

        discount = subtotal;
    }

    product.discount = discount;

    saveProducts();
}

/*=========================================================
=            ELIMINAR PRODUCTO                            =
=========================================================*/

function removeProduct(id) {
    if (!confirm("¿Eliminar este producto de la venta?")) return;

    datosProducts = datosProducts.filter((product) => product.id !== id);

    saveProducts();
}
/*=========================================================
=            RESUMEN DE LA FACTURA                        =
=========================================================*/

function updateSummary() {
    let subtotal = 0;
    let totalDiscount = 0;
    let totalTax = 0;
    let totalQuantity = 0;

    datosProducts.forEach((product) => {
        const quantity = Number(product.quantity);
        const price = Number(product.price);
        const discount = Number(product.discount);
        const tax = Number(product.tax ?? 0);

        const lineSubtotal = quantity * price;
        const lineTax = ((lineSubtotal - discount) * tax) / 100;

        subtotal += lineSubtotal;
        totalDiscount += discount;
        totalTax += lineTax;
        totalQuantity += quantity;
    });

    const total = subtotal - totalDiscount + totalTax;

    document.getElementById("subtotalInvoice").textContent =
        "$ " + subtotal.toLocaleString("es-CO");

    document.getElementById("discountInvoice").textContent =
        "$ " + totalDiscount.toLocaleString("es-CO");

    document.getElementById("taxInvoice").textContent =
        "$ " + totalTax.toLocaleString("es-CO");

    document.getElementById("totalInvoice").textContent =
        "$ " + total.toLocaleString("es-CO");

    document.getElementById("productsInvoice").textContent =
        datosProducts.length;

    document.getElementById("quantityInvoice").textContent = totalQuantity;

    updatePayment();
}

/*=========================================================
=            TOTAL FACTURA                               =
=========================================================*/

function getInvoiceTotal() {
    let subtotal = 0;
    let discount = 0;
    let tax = 0;

    datosProducts.forEach((product) => {
        const lineSubtotal = product.quantity * product.price;

        subtotal += lineSubtotal;

        discount += product.discount;

        tax += ((lineSubtotal - product.discount) * (product.tax ?? 0)) / 100;
    });

    return subtotal - discount + tax;
}

/*=========================================================
=            INFORMACIÓN DE LA VENTA                      =
=========================================================*/

function loadSaleInformation() {
    const sale = JSON.parse(localStorage.getItem(STORAGE_SALE));

    if (!sale) return;

    paymentMethod.value = sale.paymentMethod ?? "cash";

    receivedAmount.value = sale.receivedAmount ?? 0;

    observation.value = sale.observation ?? "";

    updatePayment();
}

function saveSaleInformation() {
    const sale = {
        paymentMethod: paymentMethod.value,

        receivedAmount: Number(receivedAmount.value),

        observation: observation.value,
    };

    localStorage.setItem(STORAGE_SALE, JSON.stringify(sale));
}

/*=========================================================
=            FORMA DE PAGO                               =
=========================================================*/

function updatePayment() {
    const total = getInvoiceTotal();

    if (paymentMethod.value === "cash") {
        receivedAmount.disabled = false;
    } else {
        receivedAmount.value = total;

        receivedAmount.disabled = true;
    }

    calculateChange();

    saveSaleInformation();
}

/*=========================================================
=            CAMBIO                                      =
=========================================================*/

function calculateChange() {
    const total = getInvoiceTotal();

    const received = Number(receivedAmount.value);

    let change = received - total;

    if (change < 0) change = 0;

    changeAmount.value = change.toLocaleString("es-CO");

    saveSaleInformation();
}

/*=========================================================
=            LIMPIAR VENTA                               =
=========================================================*/

function clearSaleData() {
    localStorage.removeItem(STORAGE_KEY_PRODUCTS);

    localStorage.removeItem(STORAGE_SALE);

    localStorage.removeItem("datosCustomer");

    datosProducts = [];

    tbodyProducts.innerHTML = "";

    tbodySaleProducts.innerHTML = "";

    searchProduct.value = "";

    paymentMethod.value = "cash";

    receivedAmount.value = 0;

    changeAmount.value = 0;

    observation.value = "";

    updateSummary();
}

/*=========================================================
=            UTILIDADES                                  =
=========================================================*/

function formatCurrency(value) {
    return "$ " + Number(value).toLocaleString("es-CO");
}

function round(value) {
    return Number(value.toFixed(2));
}
