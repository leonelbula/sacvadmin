/* ==========================================================
   SACVADMIN
   EDITAR VENTA
=========================================================== */

const STORAGE_KEY = "editSale";

/* ==========================================================
   DATOS DE LARAVEL
=========================================================== */

const saleData = window.saleData ?? null;

/* ==========================================================
   ELEMENTOS
=========================================================== */

const customerId = document.getElementById("customer_id");

const identification = document.getElementById("identification");

const documentType = document.getElementById("document_type");

const fullName = document.getElementById("full_name");

const dateSale = document.getElementById("date_sale");

const city = document.getElementById("city");

const address = document.getElementById("address");

const email = document.getElementById("email");

const phone = document.getElementById("phone");

const typeSale = document.getElementById("typeSale");

const paymentMethod = document.getElementById("paymentMethod");

const dueDate = document.getElementById("dueDate");

const receivedAmount = document.getElementById("receivedAmount");

const changeAmount = document.getElementById("changeAmount");

const saleObservation = document.getElementById("saleObservation");

const tbodySaleProducts = document.getElementById("tbodySaleProducts");

const productsInput = document.getElementById("products");

const subTotal = document.getElementById("subTotal");

const taxInput = document.getElementById("tax");

const totalInput = document.getElementById("total");

const subtotalInvoice = document.getElementById("subtotalInvoice");

const iva19Invoice = document.getElementById("iva19Invoice");

const totalInvoice = document.getElementById("totalInvoice");

const productsInvoice = document.getElementById("productsInvoice");

const quantityInvoice = document.getElementById("quantityInvoice");

const creditDateContainer = document.getElementById("creditDateContainer");

const btnClear = document.getElementById("btnClear");

/* ==========================================================
   MONEDA
=========================================================== */

function money(value) {
    return new Intl.NumberFormat("es-CO", {
        style: "currency",
        currency: "COP",
        maximumFractionDigits: 0,
    }).format(Number(value) || 0);
}

/* ==========================================================
   LEER LOCAL STORAGE
=========================================================== */

function getSale() {
    const data = localStorage.getItem(STORAGE_KEY);

    if (!data) {
        return null;
    }

    try {
        return JSON.parse(data);
    } catch (error) {
        console.error("Error leyendo localStorage:", error);

        return null;
    }
}

/* ==========================================================
   GUARDAR LOCAL STORAGE
=========================================================== */

function saveSale(sale) {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(sale));
}

/* ==========================================================
   CREAR OBJETO DE EDICIÓN
=========================================================== */

function buildSaleData() {
    return {
        sale: {
            id: saleData.id,

            sale_number: saleData.sale_number,

            subtotal: Number(saleData.subtotal ?? 0),

            taxes: Number(saleData.taxes ?? 0),

            total: Number(saleData.total ?? 0),

            payment_form: saleData.payment_form ?? "counted",

            payment_method_id: saleData.payment_method_id ?? "",

            term: Number(saleData.term ?? 0),

            observation: saleData.observation ?? "",

            date_sale: saleData.date_sale ?? "",
        },

        customer: saleData.customer
            ? {
                  id: saleData.customer.id,

                  identification: saleData.customer.identification ?? "",

                  full_name: saleData.customer.full_name ?? "",

                  document_type: saleData.customer.identityDocument?.name ?? "",

                  city: saleData.customer.city?.name ?? "",

                  address: saleData.customer.address ?? "",

                  email: saleData.customer.email ?? "",

                  phone: saleData.customer.phone ?? "",
              }
            : null,

        products: (saleData.details ?? []).map((detail) => {
            const product = detail.product ?? {};

            return {
                id: product.id ?? detail.product_id,

                product_id: detail.product_id ?? product.id,

                code: product.code ?? "",

                name: product.name ?? "",

                quantity: Number(detail.quantity ?? 1),

                price: Number(detail.price ?? 0),

                cost: Number(detail.cost ?? 0),

                tax_rate: Number(detail.tax?.value ?? 0),

                //tax: Number(detail.tax ?? 0),
                tax_id: detail.tax_id ?? null,

                subtotal: Number(detail.subtotal ?? 0),
            };
        }),
    };
}

/* ==========================================================
   INICIALIZAR
=========================================================== */

function initialize() {
    if (!saleData) {
        console.error("No se recibió saleData desde Laravel.");

        return;
    }

    const current = getSale();

    /*
     * Solo reemplazamos el localStorage
     * cuando pertenece a otra venta.
     */

    if (!current || Number(current.sale?.id) !== Number(saleData.id)) {
        saveSale(buildSaleData());
    }

    loadCustomer();

    loadPayment();

    loadProducts();

    calculateTotals();
}

/* ==========================================================
   CARGAR CLIENTE
=========================================================== */

function loadCustomer() {
    const data = getSale();

    if (!data?.customer) {
        return;
    }

    const customer = data.customer;

    customerId.value = customer.id ?? "";

    identification.value = customer.identification ?? "";

    documentType.value = customer.document_type ?? "";

    fullName.value = customer.full_name ?? "";

    city.value = customer.city ?? "";

    address.value = customer.address ?? "";

    email.value = customer.email ?? "";

    phone.value = customer.phone ?? "";

    if (dateSale) {
        dateSale.value = data.sale.date_sale ?? "";
    }
}

/* ==========================================================
   CARGAR PAGO
=========================================================== */

function loadPayment() {
    const data = getSale();

    if (!data?.sale) {
        return;
    }

    const sale = data.sale;

    typeSale.value = sale.payment_form ?? "counted";

    paymentMethod.value = sale.payment_method_id ?? "";

    dueDate.value = sale.term ?? 0;

    saleObservation.value = sale.observation ?? "";

    updatePaymentUI();
}

/* ==========================================================
   ACTUALIZAR INTERFAZ PAGO
=========================================================== */

function updatePaymentUI() {
    if (typeSale.value === "credit") {
        creditDateContainer.style.display = "block";

        dueDate.disabled = false;

        receivedAmount.value = 0;

        receivedAmount.disabled = true;

        changeAmount.value = 0;

        changeAmount.style.display = "none";
    } else {
        creditDateContainer.style.display = "none";

        dueDate.value = 0;

        dueDate.disabled = true;

        receivedAmount.disabled = false;

        changeAmount.style.display = "block";

        calculateChange();
    }
}

/* ==========================================================
   GUARDAR PAGO
=========================================================== */

function savePayment() {
    const data = getSale();

    if (!data) {
        return;
    }

    data.sale.payment_form = typeSale.value;

    data.sale.payment_method_id = paymentMethod.value;

    data.sale.term = Number(dueDate.value || 0);

    data.sale.observation = saleObservation.value ?? "";

    saveSale(data);
}

/* ==========================================================
   CARGAR PRODUCTOS
=========================================================== */

function loadProducts() {
    const data = getSale();

    if (!data || !tbodySaleProducts) {
        return;
    }

    tbodySaleProducts.innerHTML = "";

    data.products.forEach((product, index) => {
        renderProduct(product, index);
    });

    updateProductsInput();
}

/* ==========================================================
   RENDER PRODUCTO
=========================================================== */

function renderProduct(product, index) {
    const row = document.createElement("tr");

    const productId = product.product_id ?? product.id;
    const taxRate = Number(product.tax ?? 0);
    row.dataset.id = productId;

    row.innerHTML = `

        <td class="text-center">
            ${index + 1}
        </td>


        <td>
            ${escapeHtml(product.code)}
        </td>


        <td>

            <div class="fw-semibold">
                ${escapeHtml(product.name)}
            </div>

        </td>


        <td>

            <input
                type="number"
                min="1"
                step="1"
                class="form-control product-quantity"
                value="${product.quantity}"
                data-id="${productId}"
            >

        </td>


        <td>

            <input
                type="number"
                min="${product.cost}"
                step="1"
                class="form-control product-price"
                value="${product.price}"
                data-id="${productId}"
            >

        </td>


        <td class="text-center">
    ${taxRate > 0 ? `${taxRate}%` : "Exento"}
</td>


        <td class="text-end fw-bold product-subtotal">

            ${money(product.subtotal)}

        </td>


        <td class="text-center">

            <button
                type="button"
                class="btn btn-outline-danger btn-sm btn-remove-product"
                data-id="${productId}"
            >

                <i class="bi bi-trash"></i>

            </button>

        </td>

    `;

    tbodySaleProducts.appendChild(row);
}

/* ==========================================================
   ESCAPAR HTML
=========================================================== */

function escapeHtml(value) {
    const div = document.createElement("div");

    div.textContent = value ?? "";

    return div.innerHTML;
}

/* ==========================================================
   ACTUALIZAR PRODUCTO
=========================================================== */

function updateProduct(productId, row) {
    const data = getSale();

    if (!data) {
        return;
    }

    const product = data.products.find(
        (item) => Number(item.product_id ?? item.id) === Number(productId),
    );

    if (!product) {
        return;
    }

    const quantity = Number(row.querySelector(".product-quantity")?.value || 1);

    const price = Number(row.querySelector(".product-price")?.value || 0);

    const taxRate = Number(row.querySelector(".product-tax")?.value || 0);

    product.quantity = quantity;

     if (price < product.cost) {
        //alert("El precio no puede ser menor al costo.");
        Swal.fire("El precio no puede ser menor al costo.");

        price = product.cost;
    }

    product.price = price;
    product.price = price;

    product.tax_rate = taxRate;

    /*
     * Valor de la línea.
     */

    const value = quantity * price;

    /*
     * IVA incluido.
     */

    if (taxRate > 0) {
        const base = value / (1 + taxRate / 100);

        product.tax = Math.round(value - base);
    } else {
        product.tax = 0;
    }

    product.subtotal = Math.round(value);

    saveSale(data);

    updateRowSubtotal(row, product.subtotal);

    calculateTotals();
}

/* ==========================================================
   ACTUALIZAR SUBTOTAL FILA
=========================================================== */

function updateRowSubtotal(row, value) {
    const element = row.querySelector(".product-subtotal");

    if (element) {
        element.textContent = money(value);
    }
}

/* ==========================================================
   ELIMINAR PRODUCTO
=========================================================== */

function removeProduct(productId) {
    const data = getSale();

    if (!data) {
        return;
    }

    data.products = data.products.filter(
        (product) =>
            Number(product.product_id ?? product.id) !== Number(productId),
    );

    saveSale(data);

    loadProducts();

    calculateTotals();
}

/* ==========================================================
   EVENTOS TABLA
=========================================================== */

if (tbodySaleProducts) {
    tbodySaleProducts.addEventListener("input", (event) => {
        const target = event.target;

        if (
            !target.classList.contains("product-quantity") &&
            !target.classList.contains("product-price") &&
            !target.classList.contains("product-tax")
        ) {
            return;
        }

        const row = target.closest("tr");

        if (!row) {
            return;
        }

        updateProduct(row.dataset.id, row);
    });

    tbodySaleProducts.addEventListener("click", (event) => {
        const button = event.target.closest(".btn-remove-product");

        if (!button) {
            return;
        }

        removeProduct(button.dataset.id);
    });
}

/* ==========================================================
   CALCULAR TOTALES
=========================================================== */

function calculateTotals() {
    const data = getSale();

    if (!data) {
        return;
    }

    let subtotalBruto = 0;

    let taxes = 0;

    let quantity = 0;

    data.products.forEach((product) => {
        const value = Number(product.quantity) * Number(product.price);

        subtotalBruto += value;

        taxes += Number(product.tax ?? 0);

        quantity += Number(product.quantity);
    });

    /*
     * Base sin IVA.
     */

    const subtotal = Math.round(subtotalBruto - taxes);

    const total = Math.round(subtotalBruto);

    data.sale.subtotal = subtotal;

    data.sale.taxes = Math.round(taxes);

    data.sale.total = total;

    saveSale(data);

    /*
     * Valores hidden.
     */

    subTotal.value = subtotal;

    taxInput.value = Math.round(taxes);

    totalInput.value = total;

    /*
     * Valores visuales.
     */

    subtotalInvoice.textContent = money(subtotal);

    iva19Invoice.textContent = money(taxes);

    totalInvoice.textContent = money(total);

    productsInvoice.textContent = data.products.length;

    quantityInvoice.textContent = quantity;

    updateProductsInput();

    calculateChange();
}

/* ==========================================================
   GUARDAR PRODUCTOS EN INPUT HIDDEN
=========================================================== */

function updateProductsInput() {
    const data = getSale();

    if (!data || !productsInput) {
        return;
    }

    /*
     * Laravel recibirá el JSON.
     */

    productsInput.value = JSON.stringify(data.products);
}

/* ==========================================================
   CALCULAR CAMBIO
=========================================================== */

function calculateChange() {
    if (!receivedAmount || !changeAmount) {
        return;
    }

    if (typeSale.value === "credit") {
        changeAmount.value = 0;

        return;
    }

    const data = getSale();

    if (!data) {
        return;
    }

    const total = Number(data.sale.total) || 0;

    const received = Number(receivedAmount.value) || 0;

    const change = received - total;

    changeAmount.value = Math.max(Math.round(change), 0);
}

/* ==========================================================
   EVENTO FORMA DE PAGO
=========================================================== */

if (typeSale) {
    typeSale.addEventListener("change", () => {
        updatePaymentUI();

        savePayment();
    });
}

/* ==========================================================
   EVENTO MÉTODO DE PAGO
=========================================================== */

if (paymentMethod) {
    paymentMethod.addEventListener("change", () => {
        savePayment();
    });
}

/* ==========================================================
   EVENTO PLAZO
=========================================================== */

if (dueDate) {
    dueDate.addEventListener("input", () => {
        savePayment();
    });
}

/* ==========================================================
   EVENTO OBSERVACIÓN
=========================================================== */

if (saleObservation) {
    saleObservation.addEventListener("input", () => {
        savePayment();
    });
}

/* ==========================================================
   EVENTO RECIBIDO
=========================================================== */

if (receivedAmount) {
    receivedAmount.addEventListener("input", calculateChange);
}

/* ==========================================================
   BORRAR CLIENTE
=========================================================== */

const btnClearCustomer = document.getElementById("btn-clear-customer");

if (btnClearCustomer) {
    btnClearCustomer.addEventListener("click", () => {
        customerId.value = "";

        identification.value = "";

        documentType.value = "";

        fullName.value = "";

        city.value = "";

        address.value = "";

        email.value = "";

        phone.value = "";

        const data = getSale();

        if (data) {
            data.customer = null;

            saveSale(data);
        }
    });
}

/* ==========================================================
   NUEVA FACTURA
=========================================================== */

if (btnClear) {
    btnClear.addEventListener("click", () => {
        localStorage.removeItem(STORAGE_KEY);

        window.location.href = btnClear.dataset.url ?? "/sales/create";
    });
}

/* ==========================================================
   ANTES DE ENVIAR
=========================================================== */

const editSaleForm = document.getElementById("editSaleForm");

if (editSaleForm) {
    editSaleForm.addEventListener("submit", () => {
        const data = getSale();

        if (!data) {
            return;
        }

        /*
         * Actualizar cliente.
         */

        data.customer = {
            id: customerId.value,

            identification: identification.value,

            full_name: fullName.value,

            document_type: documentType.value,

            city: city.value,

            address: address.value,

            email: email.value,

            phone: phone.value,
        };

        /*
         * Actualizar fecha.
         */

        data.sale.date_sale = dateSale.value;

        /*
         * Actualizar pago.
         */

        data.sale.payment_form = typeSale.value;

        data.sale.payment_method_id = paymentMethod.value;

        data.sale.term = Number(dueDate.value || 0);

        data.sale.observation = saleObservation.value;

        /*
         * Asegurarnos de que los
         * totales estén actualizados.
         */

        calculateTotals();

        /*
         * Enviar productos.
         */

        updateProductsInput();

        saveSale(data);
    });
}

/* ==========================================================
   INICIAR
=========================================================== */

document.addEventListener("DOMContentLoaded", () => {
    initialize();
});

// =========================
// BUSCAR CLIENTES
// =========================
/* ==========================================================
   BÚSQUEDA DE CLIENTES
=========================================================== */

const searchCustomer = document.getElementById("searchCustomer");

const tbodyCustomers = document.getElementById("tbodyCustomers");

if (searchCustomer) {
    searchCustomer.addEventListener("input", async function () {
        const q = this.value.trim();

        tbodyCustomers.innerHTML = "";

        /*
         * No buscar con menos de 2 caracteres.
         */

        if (q.length < 2) {
            return;
        }

        try {
            const response = await fetch(
                `/customers/search/${encodeURIComponent(q)}`,
            );

            if (!response.ok) {
                throw new Error("Error buscando clientes");
            }

            const result = await response.json();

            const customers = result.data ?? [];

            /*
             * Evitar duplicados.
             */

            const uniqueCustomers = Array.from(
                new Map(
                    customers.map((customer) => [customer.id, customer]),
                ).values(),
            );

            uniqueCustomers.forEach((cliente) => {
                const row = document.createElement("tr");

                row.innerHTML = `

                            <td>
                                ${escapeHtml(cliente.identification ?? "")}
                            </td>

                            <td>
                                ${escapeHtml(cliente.full_name ?? "")}
                            </td>

                            <td>
                                ${escapeHtml(cliente.phone ?? "")}
                            </td>

                            <td>
                                ${escapeHtml(cliente.address ?? "")}
                            </td>

                            <td>
                                ${escapeHtml(cliente.city?.name ?? "")}
                            </td>

                            <td class="text-center">

                                <button
                                    type="button"
                                    class="btn btn-primary btn-sm btn-select-customer"
                                >

                                    <i class="bi bi-check-circle"></i>

                                </button>

                            </td>

                        `;

                /*
                 * Guardamos el cliente en
                 * el botón para evitar onclick
                 * con problemas de comillas.
                 */

                const button = row.querySelector(".btn-select-customer");

                button.addEventListener("click", () => {
                    selectCustomer(cliente);
                });

                tbodyCustomers.appendChild(row);
            });
        } catch (error) {
            console.error("Error buscando cliente:", error);
        }
    });
}

/* ==========================================================
   SELECCIONAR CLIENTE
=========================================================== */

function selectCustomer(cliente) {
    /*
     * Campos de la vista
     */

    customerId.value = cliente.id ?? "";

    identification.value = cliente.identification ?? "";

    documentType.value =
        cliente.identity_document?.name ?? cliente.identityDocument?.name ?? "";

    fullName.value = cliente.full_name ?? "";

    city.value = cliente.city?.name ?? "";

    address.value = cliente.address ?? "";

    email.value = cliente.email ?? "";

    phone.value = cliente.phone ?? "";

    /*
     * Actualizar localStorage
     */

    const data = getSale();

    if (data) {
        data.customer = {
            id: cliente.id ?? "",

            identification: cliente.identification ?? "",

            full_name: cliente.full_name ?? "",

            document_type:
                cliente.identity_document?.name ??
                cliente.identityDocument?.name ??
                "",

            city: cliente.city?.name ?? "",

            address: cliente.address ?? "",

            email: cliente.email ?? "",

            phone: cliente.phone ?? "",
        };

        saveSale(data);
    }

    /*
     * Cerrar modal
     */

    const modalElement = document.getElementById("customerModal");

    if (modalElement) {
        const modal = bootstrap.Modal.getInstance(modalElement);

        if (modal) {
            modal.hide();
        }
    }
}

function closeProductModal() {
    const modalElement = document.getElementById("productModal");

    if (!modalElement) {
        return;
    }

    const modal =
        bootstrap.Modal.getInstance(modalElement) ||
        new bootstrap.Modal(modalElement);

    modal.hide();
}
/* ==========================================================
   BÚSQUEDA DE PRODUCTOS
=========================================================== */

const searchProduct = document.getElementById("searchProduct");

const tbodyProducts = document.getElementById("tbodyProducts");

if (searchProduct) {
    searchProduct.addEventListener("input", async function () {
        const q = this.value.trim();

        tbodyProducts.innerHTML = "";

        /*
         * Mínimo 2 caracteres.
         */

        if (q.length < 2) {
            return;
        }

        try {
            const response = await fetch(
                `/products/search/${encodeURIComponent(q)}`,
            );

            if (!response.ok) {
                throw new Error("Error buscando productos");
            }

            const result = await response.json();

            /*
             * Dependiendo de tu controlador,
             * puede venir:
             *
             * { data: [...] }
             *
             * o directamente [...]
             */

            const products = Array.isArray(result)
                ? result
                : (result.data ?? []);

            /*
             * Eliminar productos duplicados
             */

            const uniqueProducts = Array.from(
                new Map(
                    products.map((product) => [product.id, product]),
                ).values(),
            );

            uniqueProducts.forEach((product) => {
                const row = document.createElement("tr");

                row.innerHTML = `

                            <td>
                                ${escapeHtml(product.code ?? "")}
                            </td>

                            <td>
                                ${escapeHtml(product.name ?? "")}
                            </td>

                            <td>
                                ${money(product.price ?? 0)}
                            </td>

                            <td>
                                ${product.stock ?? product.amount ?? 0}
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
                                    type="button"
                                    class="btn btn-success btn-sm btn-select-product"
                                >

                                    <i class="bi bi-plus-circle"></i>

                                </button>

                            </td>

                        `;

                const button = row.querySelector(".btn-select-product");

                button.addEventListener("click", function () {
                    addProductToSale(product);
                });

                tbodyProducts.appendChild(row);
            });
        } catch (error) {
            console.error("Error buscando producto:", error);
        }
    });
}

/* ==========================================================
   AGREGAR PRODUCTO A LA FACTURA
=========================================================== */

function addProductToSale(product) {
    const data = getSale();

    if (!data) {
        return;
    }

    if (!Array.isArray(data.products)) {
        data.products = [];
    }

    /*
     * Buscar si el producto ya existe
     */
    const existingProduct = data.products.find(
        (item) => Number(item.product_id ?? item.id) === Number(product.id),
    );

    /*
     * =====================================================
     * PRODUCTO YA EXISTE
     * =====================================================
     */

    if (existingProduct) {
        /*
         * Aumentar cantidad
         */
        existingProduct.quantity = Number(existingProduct.quantity ?? 0) + 1;

        /*
         * Mantener precio
         */
        existingProduct.price = Number(
            existingProduct.price ?? product.price ?? 0,
        );

        /*
         * Mantener impuesto
         */
        existingProduct.tax_id =
            existingProduct.tax_id ?? product.tax_id ?? null;

        existingProduct.tax_rate = Number(
            existingProduct.tax_rate ?? product.tax_rate ?? 0,
        );

        /*
         * ================================================
         * RECALCULAR SUBTOTAL
         * ================================================
         */

        const value = existingProduct.quantity * existingProduct.price;

        existingProduct.subtotal = Math.round(value);

        /*
         * ================================================
         * RECALCULAR IVA INCLUIDO
         * ================================================
         */

        const taxRate = Number(existingProduct.tax_rate ?? 0);

        if (taxRate > 0) {
            const base = value / (1 + taxRate / 100);

            existingProduct.tax = Math.round(value - base);
        } else {
            existingProduct.tax = 0;
        }

        /*
         * Guardar
         */
        saveSale(data);

        /*
         * Actualizar tabla
         */
        loadProducts();

        /*
         * Actualizar totales
         */
        calculateTotals();

        closeProductModal();

        return;
    }

    /*
     * =====================================================
     * PRODUCTO NUEVO
     * =====================================================
     */

    const quantity = 1;

    const price = Number(product.price ?? 0);

    const taxRate = Number(product.tax_rate ?? product.tax?.value ?? 0);

    const value = quantity * price;

    let tax = 0;

    if (taxRate > 0) {
        const base = value / (1 + taxRate / 100);

        tax = Math.round(value - base);
    }

    data.products.push({
        id: product.id,

        product_id: product.id,

        code: product.code ?? "",

        name: product.name ?? "",

        quantity: quantity,

        price: price,

        cost: product.cost,

        tax_id: product.tax_id ?? null,

        tax_rate: taxRate,

        tax: tax,

        subtotal: Math.round(value),
    });

    /*
     * Guardar
     */
    saveSale(data);

    /*
     * Actualizar
     */
    loadProducts();

    calculateTotals();
}
/* ==========================================================
   BOTÓN VOLVER
=========================================================== */

const btnBackSale = document.getElementById("btnBackSale");

if (btnBackSale) {
    btnBackSale.addEventListener("click", function () {
        localStorage.removeItem("editSale");
        localStorage.removeItem("datosProducts");
    });
}
