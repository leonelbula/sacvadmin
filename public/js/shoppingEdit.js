// =========================
// CONFIGURACIÓN / LOCAL STORAGE
// =========================

const STORAGE_KEY_EDIT_SHOPPING = "datosShoppingEdit";
const STORAGE_KEY_PRODUCTS_EDIT_SHOPPING = "datosProductsShoppingEdit";
const STORAGE_SHOPPING_EDIT = "saleInformationEdit";

const shoppingData = window.shoppingData ?? null;

// =========================
// ELEMENTOS DEL DOM
// =========================

const supplierIdInput = document.getElementById("supplier_id");
const supplierNameInput = document.getElementById("full_name");
const supplierIdentificationInput = document.getElementById("identification");
const supplierPhoneInput = document.getElementById("phone");
const supplierEmailInput = document.getElementById("email");
const supplierAddressInput = document.getElementById("address");
const supplierCityInput = document.getElementById("city");

const btnSearchSupplier = document.getElementById("btnSearchSupplier");

const invoicenumberInput = document.getElementById("invoice_number");

const btnClear = document.getElementById("btn-clear-supplier");

const searchSupplier = document.getElementById("searchSupplier");

const tbody = document.querySelector("#tablaSupplier tbody");

// =========================
// CARGAR PROVEEDOR AL INICIAR
// =========================

document.addEventListener("DOMContentLoaded", () => {
    clearShoppingData();

    loadSupplierDataEdit();

    const elementmodalSupplier = document.getElementById("modalSupplier");

    const elementmodalProduct = document.getElementById("productModal");

    const modalSupplier = elementmodalSupplier
        ? new bootstrap.Modal(elementmodalSupplier)
        : null;

    const modalProduct = elementmodalProduct
        ? new bootstrap.Modal(elementmodalProduct)
        : null;

    const shortcuts = {
        F2: () => {
            if (modalSupplier) {
                modalSupplier.show();
            }
        },

        F3: () => {
            if (modalProduct) {
                modalProduct.show();
            }
        },

        F4: () => {
            clearShoppingData();
            location.reload();
        },
    };

    window.addEventListener("keydown", (event) => {
        if (shortcuts[event.key]) {
            event.preventDefault();

            shortcuts[event.key]();
        }
    });
});

// =========================
// BUSCAR PROVEEDORES
// =========================

if (searchSupplier && tbody) {
    searchSupplier.addEventListener("input", async function () {
        const query = this.value.trim();

        tbody.innerHTML = "";

        if (query.length < 3) {
            return;
        }

        try {
            const response = await fetch(
                `/supplier/search/${encodeURIComponent(query)}`,
            );

            if (!response.ok) {
                throw new Error("Error en la búsqueda");
            }

            const result = await response.json();

            const suppliers = result.data ?? [];

            const supplierUnicos = [
                ...new Map(
                    suppliers.map((supplier) => [supplier.id, supplier]),
                ).values(),
            ];

            supplierUnicos.forEach((supplier) => {
                tbody.innerHTML += `

                            <tr>

                                <td>
                                    ${supplier.identification ?? ""}
                                </td>

                                <td>
                                    ${supplier.full_name ?? ""}
                                </td>

                                <td>
                                    ${supplier.phone ?? ""}
                                </td>

                                <td>
                                    ${supplier.address ?? ""}
                                </td>

                                <td>
                                    ${
                                        supplier.city?.name ??
                                        supplier.city ??
                                        ""
                                    }
                                </td>

                                <td class="text-center">

                                    <button
                                        type="button"
                                        class="btn btn-primary btn-sm"
                                        onclick='addSupplier(${JSON.stringify(
                                            supplier,
                                        )})'
                                    >

                                        <i class="bi bi-check-circle"></i>

                                    </button>

                                </td>

                            </tr>

                        `;
            });
        } catch (error) {
            console.error("Error buscando proveedores:", error);
        }
    });
}

// =========================
// AGREGAR PROVEEDOR
// =========================

window.addSupplier = function (supplier) {
    const supplierData = {
        id: supplier.id,

        name: supplier.full_name ?? supplier.name ?? "",

        identification: supplier.identification ?? "",

        phone: supplier.phone ?? "",

        email: supplier.email ?? "",

        address: supplier.address ?? "",

        city: supplier.city?.name ?? supplier.city ?? "",
    };

    localStorage.setItem(
        STORAGE_KEY_EDIT_SHOPPING,

        JSON.stringify(supplierData),
    );

    supplierInput(supplierData);

    const modalElement = document.getElementById("modalSupplier");

    if (modalElement) {
        const modal = bootstrap.Modal.getInstance(modalElement);

        if (modal) {
            modal.hide();
        }
    }
};

// =========================
// CARGAR PROVEEDOR
// =========================

function loadSupplierDataEdit() {
    if (shoppingData) {
        const oldSupplier = {
            id: shoppingData.supplier?.id,

            name: shoppingData.supplier?.full_name,

            identification: shoppingData.supplier?.identification,

            phone: shoppingData.supplier?.phone,

            address: shoppingData.supplier?.address,

            email: shoppingData.supplier?.email,

            city:
                shoppingData.supplier?.city?.name ??
                shoppingData.supplier?.city ??
                "",
        };

        localStorage.setItem(
            STORAGE_KEY_EDIT_SHOPPING,

            JSON.stringify(oldSupplier),
        );

        const supplierEdit = JSON.parse(
            localStorage.getItem(STORAGE_KEY_EDIT_SHOPPING),
        );

        if (!supplierEdit) {
            return;
        }

        supplierInput(supplierEdit);
    } else {
        const supplierEdit = JSON.parse(
            localStorage.getItem(STORAGE_KEY_EDIT_SHOPPING),
        );

        if (!supplierEdit) {
            return;
        }

        supplierInput(supplierEdit);
    }
}

// =========================
// LLENAR INPUTS DEL PROVEEDOR
// =========================

function supplierInput(supplier) {
    if (supplierIdInput) {
        supplierIdInput.value = supplier.id ?? "";
    }

    if (supplierNameInput) {
        supplierNameInput.value = supplier.name ?? "";
    }

    if (supplierIdentificationInput) {
        supplierIdentificationInput.value = supplier.identification ?? "";
    }

    if (supplierPhoneInput) {
        supplierPhoneInput.value = supplier.phone ?? "";
    }

    if (supplierAddressInput) {
        supplierAddressInput.value = supplier.address ?? "";
    }

    if (supplierEmailInput) {
        supplierEmailInput.value = supplier.email ?? "";
    }

    if (supplierCityInput) {
        supplierCityInput.value = supplier.city ?? "";
    }
}

// =========================================================
// CONFIGURACIÓN DE PRODUCTOS
// =========================================================

// =========================
// ELEMENTOS DEL DOM
// =========================

// Buscar productos

const searchProduct = document.getElementById("searchProduct");

const btnSearchProduct = document.getElementById("btnSearchProduct");

// Tablas

const tbodyProducts = document.querySelector("#tableProducts tbody");

const tbodyShoppingProducts = document.querySelector(
    "#tableShoppingProducts tbody",
);

// Input oculto de productos

const products = document.getElementById("products");

// Información adicional

const typeSale = document.getElementById("typeSale");

const paymentMethod = document.getElementById("paymentMethod");

const receivedAmount = document.getElementById("receivedAmount");

const changeAmount = document.getElementById("changeAmount");

const observation = document.getElementById("saleObservation");

// Botón limpiar

const btnClearSale = document.getElementById("btnClear");

// =========================
// PRODUCTOS DE LA COMPRA
// =========================

let datosProductsShoppingEdit = [];

// =========================================================
// CARGAR INFORMACIÓN DE LA COMPRA PARA EDITAR
// =========================================================

function editShopping() {
    if (!shoppingData) {
        return;
    }

    datosProductsShoppingEdit = [];

    if (!Array.isArray(shoppingData.details)) {
        saveProducts();

        return;
    }

    shoppingData.details.forEach((item) => {
        const product = {
            id: Number(item.product_id),

            code: item.product?.code ?? "",

            name: item.product?.name ?? "",

            stock: Number(item.product?.stock ?? 0),

            cost: Number(item.price ?? 0),

            price: Number(item.price ?? 0),

            tax: Number(item.iva ?? 0),

            quantity: Number(item.quantity ?? 1),
        };

        datosProductsShoppingEdit.push(product);
    });

    saveProducts();
}

// =========================================================
// INICIALIZACIÓN
// =========================================================

document.addEventListener("DOMContentLoaded", initShopping);

function initShopping() {
    if (!shoppingData) {
        return;
    }

    if (paymentMethod) {
        paymentMethod.value = String(shoppingData.payment_method_id ?? "");
    }

    editShopping();

    loadSaleInformation();

    registerEvents();

    if (products) {
        products.value = JSON.stringify(datosProductsShoppingEdit);
    }
}

// =========================================================
// REGISTRO DE EVENTOS
// =========================================================

function registerEvents() {
    // =========================
    // BUSCAR PRODUCTO
    // =========================

    if (searchProduct) {
        searchProduct.addEventListener("input", handleSearchInput);
    }

    // =========================
    // BOTÓN BUSCAR
    // =========================

    if (btnSearchProduct) {
        btnSearchProduct.addEventListener("click", handleSearchButton);
    }

    // =========================
    // FORMA DE PAGO
    // =========================

    if (paymentMethod) {
        paymentMethod.addEventListener("change", updatePayment);
    }

    // =========================
    // OBSERVACIÓN
    // =========================

    if (observation) {
        observation.addEventListener("input", saveSaleInformation);
    }

    // =========================
    // LIMPIAR
    // =========================

    if (btnClearSale) {
        btnClearSale.addEventListener("click", () => {
            if (confirm("¿Desea limpiar la compra actual?")) {
                clearShoppingData();
            }
        });
    }
}

// =========================================================
// BÚSQUEDA DE PRODUCTOS
// =========================================================

function handleSearchInput() {
    if (!searchProduct) {
        return;
    }

    const search = searchProduct.value.trim();

    if (search.length < 3) {
        clearSearchTable();

        return;
    }

    searchProducts(search);
}

// =========================================================
// BÚSQUEDA CON BOTÓN
// =========================================================

function handleSearchButton() {
    if (!searchProduct) {
        return;
    }

    const search = searchProduct.value.trim();

    if (!search) {
        return;
    }

    searchProducts(search);
}

// =========================================================
// CONSULTAR PRODUCTOS
// =========================================================

async function searchProducts(search) {
    clearSearchTable();

    try {
        const response = await fetch(
            `/product/search/${encodeURIComponent(search)}`,
        );

        if (!response.ok) {
            throw new Error("Error al consultar productos.");
        }

        const products = await response.json();

        renderSearchProducts(products);
    } catch (error) {
        console.error("Error buscando productos:", error);
    }
}

// =========================================================
// TABLA DE RESULTADOS
// =========================================================

function renderSearchProducts(products) {
    if (!tbodyProducts) {
        return;
    }

    let html = "";

    if (!Array.isArray(products) || products.length === 0) {
        html = `

            <tr>

                <td
                    colspan="6"
                    class="text-center text-muted py-4"
                >

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

                <td>
                    ${product.code ?? ""}
                </td>


                <td>
                    ${product.name ?? ""}
                </td>


                <td class="text-center">

                    ${product.stock ?? 0}

                </td>


                <td class="text-end">

                    $
                    ${Number(product.cost ?? 0).toLocaleString("es-CO")}

                </td>


                <td class="text-center">

                    ${
                        product.state
                            ? `
                                <span
                                    class="badge bg-success"
                                >
                                    Activo
                                </span>
                              `
                            : `
                                <span
                                    class="badge bg-danger"
                                >
                                    Inactivo
                                </span>
                              `
                    }

                </td>


                <td class="text-center">

                    <button
                        type="button"
                        class="btn btn-primary btn-sm"
                        onclick='selectProduct(${JSON.stringify(product)})'
                    >

                        <i
                            class="bi bi-plus-circle"
                        ></i>

                    </button>

                </td>

            </tr>

        `;
    });

    tbodyProducts.innerHTML = html;
}

// =========================================================
// LIMPIAR TABLA DE BÚSQUEDA
// =========================================================

function clearSearchTable() {
    if (tbodyProducts) {
        tbodyProducts.innerHTML = "";
    }
}

// =========================================================
// LOCAL STORAGE - PRODUCTOS
// =========================================================

function loadProductData() {
    try {
        datosProductsShoppingEdit =
            JSON.parse(
                localStorage.getItem(STORAGE_KEY_PRODUCTS_EDIT_SHOPPING),
            ) || [];
    } catch (error) {
        console.error("Error leyendo productos:", error);

        datosProductsShoppingEdit = [];
    }

    renderSaleProducts();
}

// =========================================================
// GUARDAR PRODUCTOS
// =========================================================

function saveProducts() {
    localStorage.setItem(
        STORAGE_KEY_PRODUCTS_EDIT_SHOPPING,

        JSON.stringify(datosProductsShoppingEdit),
    );

    if (products) {
        products.value = JSON.stringify(datosProductsShoppingEdit);
    }

    renderSaleProducts();
}

// =========================================================
// SELECCIONAR PRODUCTO
// =========================================================

function selectProduct(product) {
    addProductToSale(product);

    const modalElement = document.getElementById("productModal");

    if (modalElement) {
        const modal = bootstrap.Modal.getInstance(modalElement);

        if (modal) {
            modal.hide();
        }
    }

    if (searchProduct) {
        searchProduct.value = "";
    }

    clearSearchTable();
}

// =========================================================
// AGREGAR PRODUCTO
// =========================================================

function addProductToSale(product) {
    const productId = Number(product.id);

    const index = datosProductsShoppingEdit.findIndex(
        (item) => Number(item.id) === productId,
    );

    if (index >= 0) {
        const existingProduct = datosProductsShoppingEdit[index];

        if (existingProduct.quantity < existingProduct.stock) {
            existingProduct.quantity++;
        } else {
            if (typeof Swal !== "undefined") {
                Swal.fire("La cantidad supera el stock disponible.");
            } else {
                alert("La cantidad supera el stock disponible.");
            }
        }
    } else {
        datosProductsShoppingEdit.push({
            id: productId,

            code: product.code ?? "",

            name: product.name ?? "",

            stock: Number(product.stock ?? 0),

            cost: Number(product.cost ?? 0),

            price: Number(product.cost ?? 0),

            tax: Number(product.tax?.value ?? product.tax ?? 0),

            quantity: 1,
        });
    }

    saveProducts();
}

// =========================================================
// TABLA DE PRODUCTOS DE LA COMPRA
// =========================================================

function renderSaleProducts() {
    if (!tbodyShoppingProducts) {
        return;
    }

    let html = "";

    datosProductsShoppingEdit.forEach((product, index) => {
        const quantity = Number(product.quantity ?? 0);

        const price = Number(product.price ?? 0);

        const subtotal = quantity * price;

        html += `

                <tr>


                    <td class="text-center">

                        ${index + 1}

                    </td>


                    <td>

                        ${product.code ?? ""}

                    </td>


                    <td>

                        ${product.name ?? ""}

                    </td>


                    <td width="80">

                        <input
                            type="number"
                            class="form-control form-control-sm text-center"
                            min="1"
                            value="${quantity}"
                            onchange="changeQuantity(
                                ${product.id},
                                this.value
                            )"
                        >

                    </td>


                    <td width="120">

                        <input
                            type="number"
                            class="form-control form-control-sm text-end"
                            min="0"
                            value="${price}"
                            onchange="changePrice(
                                ${product.id},
                                this.value
                            )"
                        >

                    </td>


                    <td class="text-center">

                        ${product.tax ?? 0}%

                    </td>


                    <td class="text-end fw-bold">

                        $

                        ${subtotal.toLocaleString("es-CO")}

                    </td>


                    <td class="text-center">

                        <button
                            type="button"
                            class="btn btn-outline-danger btn-sm"
                            onclick="removeProduct(
                                ${product.id}
                            )"
                        >

                            <i
                                class="bi bi-trash"
                            ></i>

                        </button>

                    </td>


                </tr>

            `;
    });

    tbodyShoppingProducts.innerHTML = html;

    updateSummary();
}

// =========================================================
// CAMBIAR CANTIDAD
// =========================================================

function changeQuantity(id, quantity) {
    const product = datosProductsShoppingEdit.find(
        (p) => Number(p.id) === Number(id),
    );

    if (!product) {
        return;
    }

    quantity = Number(quantity);

    if (quantity <= 0) {
        quantity = 1;
    }

    if (quantity > Number(product.stock)) {
        if (typeof Swal !== "undefined") {
            Swal.fire("La cantidad supera el stock disponible.");
        } else {
            alert("La cantidad supera el stock disponible.");
        }

        quantity = Number(product.stock);
    }

    product.quantity = quantity;

    saveProducts();
}

// =========================================================
// CAMBIAR PRECIO
// =========================================================

function changePrice(id, price) {
    const product = datosProductsShoppingEdit.find(
        (p) => Number(p.id) === Number(id),
    );

    if (!product) {
        return;
    }

    price = Number(price);

    if (Number(product.cost) < 0) {
        if (typeof Swal !== "undefined") {
            Swal.fire("El precio no puede ser menor al costo.");
        } else {
            alert("El precio no puede ser menor al costo.");
        }

        price = Number(product.cost);
    }

    product.price = price;

    saveProducts();
}

// =========================================================
// ELIMINAR PRODUCTO
// =========================================================

function removeProduct(id) {
    if (!confirm("¿Eliminar este producto de la compra?")) {
        return;
    }

    datosProductsShoppingEdit = datosProductsShoppingEdit.filter(
        (product) => Number(product.id) !== Number(id),
    );

    saveProducts();
}

// =========================================================
// RESUMEN DE LA COMPRA
// =========================================================

function updateSummary() {
    let subtotal = 0;

    let totalDiscount = 0;

    let totalTax = 0;

    let totalQuantity = 0;

    let valtotal = 0;

    datosProductsShoppingEdit.forEach((product) => {
        const quantity = Number(product.quantity ?? 0);

        const price = Number(product.price ?? 0);

        const tax = Number(product.tax ?? 0);

        // Precio total de la línea

        const lineSubtotal = quantity * price;

        /*
         * El precio ya incluye IVA.
         */

        const valor = lineSubtotal;

        /*
         * Extraer la base sin IVA.
         *
         * Ejemplo:
         *
         * $119.000 / 1.19 = $100.000
         */

        const base =
            tax > 0 ? Math.round(valor / (1 + tax / 100)) : Math.round(valor);

        /*
         * IVA incluido.
         */

        const lineTax = tax > 0 ? Math.round(valor - base) : 0;

        subtotal += base;

        valtotal += lineSubtotal;

        totalTax += lineTax;

        totalQuantity += quantity;
    });

    // =====================================================
    // ACTUALIZAR SUBTOTAL
    // =====================================================

    const subTotalInput = document.getElementById("subTotal");

    if (subTotalInput) {
        subTotalInput.value = subtotal;
    }

    const subtotalInvoice = document.getElementById("subtotalInvoice");

    if (subtotalInvoice) {
        subtotalInvoice.textContent = "$ " + subtotal.toLocaleString("es-CO");
    }

    // =====================================================
    // ACTUALIZAR IVA
    // =====================================================

    const taxInput = document.getElementById("tax");

    if (taxInput) {
        taxInput.value = totalTax;
    }

    const iva19Invoice = document.getElementById("iva19Invoice");

    if (iva19Invoice) {
        iva19Invoice.textContent = "$ " + totalTax.toLocaleString("es-CO");
    }

    // =====================================================
    // ACTUALIZAR TOTAL
    // =====================================================

    const totalInput = document.getElementById("total");

    if (totalInput) {
        totalInput.value = valtotal;
    }

    const totalInvoice = document.getElementById("totalInvoice");

    if (totalInvoice) {
        totalInvoice.textContent = "$ " + valtotal.toLocaleString("es-CO");
    }

    // =====================================================
    // CANTIDAD DE PRODUCTOS
    // =====================================================

    const productsInvoice = document.getElementById("productsInvoice");

    if (productsInvoice) {
        productsInvoice.textContent = datosProductsShoppingEdit.length;
    }

    // =====================================================
    // CANTIDAD TOTAL
    // =====================================================

    const quantityInvoice = document.getElementById("quantityInvoice");

    if (quantityInvoice) {
        quantityInvoice.textContent = totalQuantity;
    }

    // =====================================================
    // ACTUALIZAR FORMA DE PAGO
    // =====================================================

    updatePayment();
}

// =========================================================
// TOTAL DE LA COMPRA
// =========================================================

function getInvoiceTotal() {
    let total = 0;

    datosProductsShoppingEdit.forEach((product) => {
        const quantity = Number(product.quantity ?? 0);

        const price = Number(product.price ?? 0);

        /*
         * El precio ya incluye IVA.
         */

        const lineTotal = quantity * price;

        total += lineTotal;
    });

    return total;
}

// =========================================================
// INFORMACIÓN DE LA COMPRA
// =========================================================

function loadSaleInformation() {
    try {
        const sale = JSON.parse(localStorage.getItem(STORAGE_SHOPPING_EDIT));

        // =================================================
        // MÉTODO DE PAGO
        // =================================================

        if (sale?.paymentMethod && paymentMethod) {
            paymentMethod.value = String(sale.paymentMethod);
        } else if (shoppingData?.payment_method_id && paymentMethod) {
            paymentMethod.value = String(shoppingData.payment_method_id);
        }

        // =================================================
        // DINERO RECIBIDO
        // =================================================

        if (sale?.receivedAmount !== undefined && receivedAmount) {
            receivedAmount.value = sale.receivedAmount;
        } else if (receivedAmount) {
            receivedAmount.value = shoppingData?.total ?? 0;
        }

        // =================================================
        // OBSERVACIÓN
        // =================================================

        if (sale?.observation !== undefined && observation) {
            observation.value = sale.observation;
        } else if (observation) {
            observation.value = shoppingData?.observation ?? "";
        }

        // =================================================
        // ACTUALIZAR FORMA DE PAGO
        // =================================================

        updatePayment();
    } catch (error) {
        console.error("Error cargando información de compra:", error);

        if (paymentMethod) {
            paymentMethod.value = String(
                shoppingData?.payment_method_id ?? "1",
            );
        }

        if (receivedAmount) {
            receivedAmount.value = shoppingData?.total ?? 0;
        }

        if (observation) {
            observation.value = shoppingData?.observation ?? "";
        }

        updatePayment();
    }
}

// =========================================================
// GUARDAR INFORMACIÓN DE LA COMPRA
// =========================================================

function saveSaleInformation() {
    if (!paymentMethod || !receivedAmount || !observation) {
        return;
    }

    const sale = {
        paymentMethod: paymentMethod.value,

        receivedAmount: Number(receivedAmount.value),

        observation: observation.value,
    };

    localStorage.setItem(
        STORAGE_SHOPPING_EDIT,

        JSON.stringify(sale),
    );
}

// =========================================================
// FORMA DE PAGO
// =========================================================

function updatePayment() {
    if (!paymentMethod || !receivedAmount) {
        return;
    }

    const total = getInvoiceTotal();

    /*
     * EFECTIVO
     *
     * En tu código original el valor
     * utilizado para efectivo es "1".
     */

    if (paymentMethod.value === "1") {
        receivedAmount.disabled = false;

        /*
         * Si estaba en cero,
         * dejamos que el usuario
         * escriba libremente.
         */

        if (!receivedAmount.value) {
            receivedAmount.value = 0;
        }
    } else {
        /*
         * OTROS MÉTODOS DE PAGO
         */

        receivedAmount.value = total;

        receivedAmount.disabled = true;
    }

    /*
     * Calcular cambio.
     */

    calculateChange(false);

    /*
     * Guardar información.
     */

    saveSaleInformation();
}

// =========================================================
// CALCULAR CAMBIO
// =========================================================

function calculateChange(save = true) {
    if (!receivedAmount || !changeAmount) {
        return;
    }

    const total = getInvoiceTotal();

    const received = Number(receivedAmount.value) || 0;

    let change = received - total;

    if (change < 0) {
        change = 0;
    }

    changeAmount.value = change.toLocaleString("es-CO");

    /*
     * Cuando se escribe dinero recibido,
     * guardamos la información.
     */

    if (save) {
        saveSaleInformation();
    }
}

// =========================================================
// LIMPIAR INFORMACIÓN DE LA COMPRA
// =========================================================

function clearShoppingData() {
    /*
     * No utilizar:
     *
     * localStorage.clear()
     *
     * porque eliminaría todos los datos
     * almacenados por la aplicación.
     */

    localStorage.removeItem(STORAGE_KEY_PRODUCTS_EDIT_SHOPPING);

    localStorage.removeItem(STORAGE_SHOPPING_EDIT);

    datosProductsShoppingEdit = [];

    // =====================================================
    // LIMPIAR TABLA DE PRODUCTOS
    // =====================================================

    if (tbodyProducts) {
        tbodyProducts.innerHTML = "";
    }

    if (tbodyShoppingProducts) {
        tbodyShoppingProducts.innerHTML = "";
    }

    // =====================================================
    // LIMPIAR BÚSQUEDA
    // =====================================================

    if (searchProduct) {
        searchProduct.value = "";
    }

    // =====================================================
    // RESTABLECER FORMA DE PAGO
    // =====================================================

    if (paymentMethod) {
        paymentMethod.value = "1";
    }

    // =====================================================
    // RESTABLECER DINERO RECIBIDO
    // =====================================================

    if (receivedAmount) {
        receivedAmount.value = 0;

        receivedAmount.disabled = false;
    }

    // =====================================================
    // RESTABLECER CAMBIO
    // =====================================================

    if (changeAmount) {
        changeAmount.value = 0;
    }

    // =====================================================
    // RESTABLECER OBSERVACIÓN
    // =====================================================

    if (observation) {
        observation.value = "";
    }

    // =====================================================
    // ACTUALIZAR RESUMEN
    // =====================================================

    updateSummary();
}

// =========================================================
// UTILIDADES
// =========================================================

function formatCurrency(value) {
    return "$ " + Number(value).toLocaleString("es-CO");
}

function round(value) {
    return Number(Number(value).toFixed(2));
}

// =========================================================
// ACTUALIZAR COMPRA
// =========================================================

const btnUpdate = document.getElementById("btnSaveShopping");

// =========================================================
// EVENTO BOTÓN ACTUALIZAR
// =========================================================

if (btnUpdate) {
    btnUpdate.addEventListener("click", updateShopping);
}

// =========================================================
// ACTUALIZAR COMPRA
// =========================================================

async function updateShopping(event) {
    console.log("=================================");
    console.log("UPDATE SHOPPING EJECUTADO");
    console.log("=================================");

    if (event) {
        event.preventDefault();
    }

    // =====================================================
    // PROVEEDOR
    // =====================================================

    const supplier = document.getElementById("supplier_id");

    if (!supplier || !supplier.value) {
        showError("No puedes actualizar la compra sin proveedor.");
        return;
    }

    // =====================================================
    // NÚMERO DE FACTURA
    // =====================================================

    const invoiceNumber = document.getElementById("invoice_number");

    if (!invoiceNumber || !invoiceNumber.value.trim()) {
        showError("Debes ingresar el número de factura.");
        return;
    }

    // =====================================================
    // PRODUCTOS
    // =====================================================

    if (
        !Array.isArray(datosProductsShoppingEdit) ||
        datosProductsShoppingEdit.length === 0
    ) {
        showError("Debes agregar al menos un producto.");
        return;
    }

    // =====================================================
    // TOTAL
    // =====================================================

    const total = Number(getInvoiceTotal());

    if (!Number.isFinite(total) || total <= 0) {
        showError("El total de la compra debe ser mayor que cero.");
        return;
    }

    // =====================================================
    // ID DE LA COMPRA
    // =====================================================

    const shoppingId = shoppingData?.id ?? window.shoppingId ?? null;

    if (!shoppingId) {
        showError("No se encontró el ID de la compra.");
        return;
    }

    // =====================================================
    // CAMPOS
    // =====================================================

    const shoppingDate = document.getElementById("shopping_date");

    const purchaseType = document.getElementById("purchase_type");

    const expirationDate = document.getElementById("expiration_date");

    const subtotalInput = document.getElementById("subTotal");

    const taxInput = document.getElementById("tax");

    const observationInput = document.getElementById("saleObservation");

    const paymentMethod = document.getElementById("payment_method_id");

    // =====================================================
    // DATOS
    // =====================================================

    const data = {
        supplier_id: Number(supplier.value),

        invoice_number: invoiceNumber.value.trim(),

        shopping_date:
            shoppingDate?.value ?? shoppingData?.shopping_date ?? null,

        purchase_type:
            purchaseType?.value ?? shoppingData?.purchase_type ?? null,

        subtotal: Number(subtotalInput?.value ?? 0),

        iva: Number(taxInput?.value ?? 0),

        total: total,

        balance: Number(shoppingData?.balance ?? 0),

        expiration_date:
            expirationDate?.value ?? shoppingData?.expiration_date ?? null,

        payment_method_id: Number(
            paymentMethod?.value ?? shoppingData?.payment_method_id ?? 1,
        ),

        observation: observationInput?.value ?? "",

        products: datosProductsShoppingEdit,
    };

    console.log("DATOS A ENVIAR:", data);

    // =====================================================
    // CSRF
    // =====================================================

    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        ?.getAttribute("content");

    if (!csrfToken) {
        showError("No se encontró el token CSRF.");
        return;
    }

    // =====================================================
    // DESHABILITAR BOTÓN
    // =====================================================

    if (btnUpdate) {
        btnUpdate.disabled = true;

        btnUpdate.innerHTML = `
            <span
                class="spinner-border spinner-border-sm me-1"
                role="status"
                aria-hidden="true"
            ></span>
            Actualizando...
        `;
    }

    try {
        // =================================================
        // URL
        // =================================================

        const url = `/shopping/${shoppingId}`;

        // console.log("URL:", url);
        //console.log("ID COMPRA:", shoppingId);

        // =================================================
        // FETCH
        // =================================================

        const response = await fetch(url, {
            method: "PUT",

            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
                "X-CSRF-TOKEN": csrfToken,
                "X-Requested-With": "XMLHttpRequest",
            },

            body: JSON.stringify(data),
        });

        // =================================================
        // RESPUESTA HTTP
        // =================================================

        //  console.log("STATUS:", response.status);

        // console.log("RESPONSE OK:", response.ok);

        // =================================================
        // LEER RESPUESTA
        // =================================================

        const result = await response.json();

        //console.log("RESPUESTA DEL CONTROLADOR:", result);

        // =================================================
        // ERROR HTTP
        // =================================================

        if (!response.ok) {
            throw new Error(
                result.message ?? "No fue posible actualizar la compra.",
            );
        }

        // =================================================
        // VALIDAR STATUS DEL CONTROLADOR
        // =================================================

        if (result.status !== "success") {
            throw new Error(
                result.message ?? "La compra no pudo ser actualizada.",
            );
        }

        // =================================================
        // LIMPIAR LOCAL STORAGE
        // =================================================

        localStorage.removeItem(STORAGE_KEY_PRODUCTS_EDIT_SHOPPING);

        localStorage.removeItem(STORAGE_SHOPPING_EDIT);

        console.log("LOCAL STORAGE LIMPIADO");

        // =================================================
        // MENSAJE DE ÉXITO
        // =================================================

        await Swal.fire({
            position: "top-end",

            icon: "success",

            title: result.message ?? "Compra actualizada exitosamente.",

            showConfirmButton: false,

            timer: 1500,
        });

        // =================================================
        // REDIRECCIÓN
        // =================================================

        console.log("REDIRIGIENDO A /shopping");

        window.location.href = "/shopping";
    } catch (error) {
        // =================================================
        // ERROR
        // =================================================

        console.error("ERROR ACTUALIZANDO COMPRA:", error);

        showError(error.message ?? "Ocurrió un error al actualizar la compra.");
    } finally {
        // =================================================
        // RESTAURAR BOTÓN
        // =================================================

        if (btnUpdate) {
            btnUpdate.disabled = false;

            btnUpdate.innerHTML = `
                <i class="bi bi-check-circle me-1"></i>
                Actualizar compra
            `;
        }
    }
}

// =========================================================
// MOSTRAR ERROR
// =========================================================

function showError(message) {
    if (typeof Swal !== "undefined") {
        Swal.fire({
            icon: "error",

            title: "Oops...",

            text: message,
        });
    } else {
        alert(message);
    }
}

// =========================================================
// CARGAR PRODUCTOS DESDE LOCAL STORAGE
// =========================================================

document.addEventListener("DOMContentLoaded", () => {
    loadProductData();
});

// =========================================================
// GUARDAR PRODUCTOS ANTES DE SALIR
// =========================================================

window.addEventListener("beforeunload", () => {
    if (Array.isArray(datosProductsShoppingEdit)) {
        localStorage.setItem(
            STORAGE_KEY_PRODUCTS_EDIT_SHOPPING,

            JSON.stringify(datosProductsShoppingEdit),
        );
    }
});
