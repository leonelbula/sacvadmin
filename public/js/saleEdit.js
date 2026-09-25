// =========================
// ELEMENTOS DEL DOM
// =========================
const customerIdInput = document.getElementById("customer_id");
const customerNameInput = document.getElementById("full_name");
const customerIdentificationInput = document.getElementById("identification");
const customerPhoneInput = document.getElementById("phone");
const customerEmailInput = document.getElementById("email");
const customerAddressInput = document.getElementById("address");
const customerCityInput = document.getElementById("city");
const btnSearchCustomer = document.getElementById("btnSearchCustomer");

const btnClear = document.getElementById("btn-clear-customer");
const searchCustomer = document.getElementById("searchCustomer");
const tbody = document.querySelector("#tablaCustomer tbody");

const STORAGE_KEY_EDIT = "datosCustomerEdit";
const saleData = window.saleData ?? null;

// =========================
// CARGAR CLIENTE AL INICIAR
// =========================
document.addEventListener("DOMContentLoaded", () => {
    clearSaleData();
    loadCustomerDataEdit();

    const elementmodalCustomer = document.getElementById("customerModal");
    const elementmodalProduct = document.getElementById("productModal");

    // Ahora 'bootstrap' ya estará definido con seguridad
    const modalCustomer = new bootstrap.Modal(elementmodalCustomer);
    const modalProduct = new bootstrap.Modal(elementmodalProduct);

    const shortcuts = {
        F2: () => modalCustomer.show(),
        F3: () => modalProduct.show(),
        F4: () => {
            localStorage.clear();
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
// BUSCAR CLIENTES
// =========================
searchCustomer.addEventListener("input", async function () {
    const q = this.value.trim();

    // Limpiar resultados anteriores
    tbody.innerHTML = "";

    if (q.length === 0 && q.length <= 2) return;
    //if(q.length <= 2) return;

    try {
        const response = await fetch(
            `/customers/search/${encodeURIComponent(q)}`,
        );

        //console.log(response);

        if (!response.ok) {
            throw new Error("Error en la búsqueda");
        }

        const result = await response.json();

        const customers = result.data ?? [];

        // ==========================================
        // ELIMINAR CLIENTES DUPLICADOS
        // ==========================================

        const clientesUnicos = [
            ...new Map(
                customers.map((cliente) => [cliente.id, cliente]),
            ).values(),
        ];

        //console.log("Clientes:", clientesUnicos);

        // ==========================================
        // MOSTRAR CLIENTES
        // ==========================================

        clientesUnicos.forEach((cliente) => {
            tbody.innerHTML += `
                <tr>

                    <td>${cliente.identification ?? ""}</td>

                    <td>${cliente.full_name ?? ""}</td>

                    <td>${cliente.phone ?? ""}</td>

                    <td>${cliente.address ?? ""}</td>

                    <td>${cliente.city?.name ?? ""}</td>

                    <td class="text-center">

                        <button
                            type="button"
                            class="btn btn-primary btn-sm"
                            onclick="addCustomer(
                                ${cliente.id},
                                '${cliente.full_name ?? ""}',
                                '${cliente.identification ?? ""}',
                                '${cliente.phone ?? ""}',
                                '${cliente.address ?? ""}',
                                '${cliente.email ?? ""}',
                                '${cliente.city?.name ?? ""}'
                            )">

                            <i class="bi bi-check-circle"></i>

                        </button>

                    </td>

                </tr>
            `;
        });
    } catch (error) {
        console.error("Error buscando clientes:", error);
    }
});

// =========================
// AGREGAR CLIENTE
// =========================
window.addCustomer = function (
    id,
    name,
    identification,
    phone,
    email,
    address,
    city,
) {
    const customer = {
        id,
        name,
        identification,
        phone,
        address,
        email,
        city,
    };

    //Guardar LocalStorage
    localStorage.setItem(STORAGE_KEY_EDIT, JSON.stringify(customer));

    //Mostrar datos
    customerInput(customer);

    //Cerrar modal
    bootstrap.Modal.getOrCreateInstance(
        document.getElementById("customerModal"),
    ).hide();
};

// =========================
// CARGAR CLIENTE
// =========================
function loadCustomerDataEdit() {
    if (saleData) {
        // console.log(saleData.customer);

        const oldcustomer = {
            id: saleData.customer.id,
            name: saleData.customer.full_name,
            identification: saleData.customer.identification,
            phone: saleData.customer.phone,
            address: saleData.customer.address,
            email: saleData.customer.email,
            city: saleData.customer.city.name,
        };
        localStorage.setItem(STORAGE_KEY_EDIT, JSON.stringify(oldcustomer));
        const customerEdit = JSON.parse(localStorage.getItem(STORAGE_KEY_EDIT));
        //console.log(customer);
        if (!customerEdit) return;
        //localStorage.clear();

        customerInput(customerEdit);
    } else {
        const customerEdit = JSON.parse(localStorage.getItem(STORAGE_KEY_EDIT));
        if (!customerEdit) return;

        customerInput(customerEdit);
    }
}

// =========================
// LLENAR INPUTS
// =========================
function customerInput(customer) {
    customerIdInput.value = customer.id;
    customerNameInput.value = customer.name;
    customerIdentificationInput.value = customer.identification;
    customerPhoneInput.value = customer.phone;
    customerAddressInput.value = customer.address;
    customerEmailInput.value = customer.email;
    customerCityInput.value = customer.city;
}

/*=========================================================
=            CONFIGURACIÓN DE PRODUCTO                   =
=========================================================*/

const STORAGE_KEY_PRODUCTS_EDIT = "datosProductsEdit";
const STORAGE_SALE_EDIT = "saleInformationEdit";

/*=========================================================
=            ELEMENTOS DEL DOM                            =
=========================================================*/

// Buscar productos
const searchProduct = document.getElementById("searchProduct");
const btnSearchProduct = document.getElementById("btnSearchProduct");

// Tablas
const tbodyProducts = document.querySelector("#tableProducts tbody");
const tbodySaleProducts = document.querySelector("#tableSaleProducts tbody");

const products = document.getElementById("products");

// Información adicional
const typeSale = document.getElementById("typeSale");
const paymentMethod = document.getElementById("paymentMethod");
const receivedAmount = document.getElementById("receivedAmount");
const changeAmount = document.getElementById("changeAmount");
const observation = document.getElementById("saleObservation");

// Botón limpiar
const btnClearSale = document.getElementById("btnClear");

// Productos de la venta
let datosProductsEdit = [];

function editSale() {
    //console.log("Detalles de la venta:", saleData.details);

    // IMPORTANTE:
    // Limpiar primero los productos anteriores
    datosProductsEdit = [];

    saleData.details.forEach((item) => {
        const product = {
            id: Number(item.product_id),

            code: item.product.code,

            name: item.product.name,

            stock: Number(item.product.stock),

            // El costo también debe venir del detalle de la venta
            cost: Number(item.cost),

            // IMPORTANTE:
            // Usar el precio guardado en sale_details
            // NO item.product.price
            price: Number(item.price),

            // Impuesto de la venta
            tax: Number(item.tax?.value?.value ?? item.tax?.value ?? 0),

            // Cantidad guardada en la factura
            quantity: Number(item.quantity),
        };

        datosProductsEdit.push(product);
    });

    // Guardar TODO el estado actual de la factura
    saveProducts();

    //console.log("Datos de productos cargados para edición:", datosProductsEdit);
}
/*=========================================================
=            INICIALIZACIÓN                              =
=========================================================*/

document.addEventListener("DOMContentLoaded", initSale);

function initSale() {
    if (!saleData) {
        return;
    }
    if (paymentMethod) {
        paymentMethod.value = String(saleData.payment_method_id);
    }
    editSale();

    loadSaleInformation();

    registerEvents();

    products.value = JSON.stringify(datosProductsEdit);
}
/*=========================================================
=            REGISTRO DE EVENTOS                          =
=========================================================*/

function registerEvents() {
    // Buscar mientras escribe
    if (searchProduct) {
        searchProduct.addEventListener("input", handleSearchInput);
    }

    // Buscar con botón
    if (btnSearchProduct) {
        btnSearchProduct.addEventListener("click", handleSearchButton);
    }

    // Forma de pago
    if (paymentMethod) {
        paymentMethod.addEventListener("change", updatePayment);
    }

    // Dinero recibido
    if (receivedAmount) {
        receivedAmount.addEventListener("input", calculateChange);
    }

    // Observaciones
    if (observation) {
        observation.addEventListener("input", saveSaleInformation);
    }

    // Limpiar venta
    if (btnClearSale) {
        btnClearSale.addEventListener("click", () => {
            if (confirm("¿Desea limpiar la venta actual?")) {
                clearSaleData();
            }
        });
    }
}

/*=========================================================
=            BÚSQUEDA DE PRODUCTOS                       =
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

    if (!search) {
        return;
    }

    searchProducts(search);
}

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

/*=========================================================
=            TABLA DE RESULTADOS                          =
=========================================================*/

function renderSearchProducts(products) {
    let html = "";

    if (!Array.isArray(products) || products.length === 0) {
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
                        type="button"
                        class="btn btn-primary btn-sm"
                        onclick='selectProduct(${JSON.stringify(product)})'>

                        <i class="bi bi-plus-circle"></i>

                    </button>

                </td>

            </tr>
        `;
    });

    tbodyProducts.innerHTML = html;
}

function clearSearchTable() {
    if (tbodyProducts) {
        tbodyProducts.innerHTML = "";
    }
}

/*=========================================================
=            LOCAL STORAGE - PRODUCTOS                    =
=========================================================*/

function loadProductData() {
    try {
        datosProductsEdit =
            JSON.parse(localStorage.getItem(STORAGE_KEY_PRODUCTS_EDIT)) || [];
    } catch (error) {
        console.error("Error leyendo productos:", error);

        datosProductsEdit = [];
    }

    renderSaleProducts();
}

function saveProducts() {
    localStorage.setItem(
        STORAGE_KEY_PRODUCTS_EDIT,
        JSON.stringify(datosProductsEdit),
    );

    products.value = JSON.stringify(datosProductsEdit);
    renderSaleProducts();
}

/*=========================================================
=            SELECCIONAR PRODUCTO                         =
=========================================================*/

function selectProduct(product) {
    addProductToSale(product);

    const modalElement = document.getElementById("productModal");

    if (modalElement) {
        const modal = bootstrap.Modal.getInstance(modalElement);

        if (modal) {
            modal.hide();
        }
    }

    searchProduct.value = "";

    clearSearchTable();
}

/*=========================================================
=            AGREGAR PRODUCTO A LA VENTA                  =
=========================================================*/

function addProductToSale(product) {
    const productId = Number(product.id);

    const index = datosProductsEdit.findIndex(
        (item) => Number(item.id) === productId,
    );

    if (index >= 0) {
        // El producto ya existe
        const existingProduct = datosProductsEdit[index];

        if (existingProduct.quantity < existingProduct.stock) {
            existingProduct.quantity++;
        } else {
            alert("La cantidad supera el stock disponible.");
        }
    } else {
        datosProductsEdit.push({
            id: productId,

            code: product.code,

            name: product.name,

            stock: Number(product.stock),

            cost: Number(product.cost),

            price: Number(product.price),

            /*
             * Puede venir:
             *
             * tax = 19
             *
             * o:
             *
             * tax = {
             *     value: 19
             * }
             */
            tax: Number(product.tax?.value ?? product.tax ?? 0),

            quantity: 1,
        });
    }

    saveProducts();
}

/*=========================================================
=            TABLA DE LA VENTA                            =
=========================================================*/

function renderSaleProducts() {
    let html = "";

    datosProductsEdit.forEach((product, index) => {
        const quantity = Number(product.quantity);
        const price = Number(product.price);
        //const discount = Number(product.discount);

        const subtotal = quantity * price;

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

                <td width="80">

                    <input
                        type="number"
                        class="form-control form-control-sm text-center"
                        min="1"
                        max="${product.stock}"
                        value="${quantity}"
                        onchange="changeQuantity(${product.id}, this.value)"
                    >

                </td>

                <td width="120">

                    <input
                        type="number"
                        class="form-control form-control-sm text-end"
                        min="${product.cost}"

                        value="${price}"
                        onchange="changePrice(${product.id}, this.value)"
                    >

                </td>



                <td class="text-center">
                    ${product.tax}%
                </td>

                <td class="text-end fw-bold">

                    $
                    ${subtotal.toLocaleString("es-CO")}

                </td>

                <td class="text-center">

                    <button
                        type="button"
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
    const product = datosProductsEdit.find((p) => Number(p.id) === Number(id));

    if (!product) {
        return;
    }

    quantity = Number(quantity);

    if (quantity <= 0) {
        quantity = 1;
    }

    if (quantity > product.stock) {
        // alert("La cantidad supera el stock disponible.");
        Swal.fire("La cantidad supera el stock disponible.");

        quantity = product.stock;
    }

    product.quantity = quantity;

    saveProducts();
}

/*=========================================================
=            CAMBIAR PRECIO                               =
=========================================================*/

function changePrice(id, price) {
    const product = datosProductsEdit.find((p) => Number(p.id) === Number(id));

    if (!product) {
        return;
    }

    price = Number(price);

    if (price < product.cost) {
        //alert("El precio no puede ser menor al costo.");
        Swal.fire("El precio no puede ser menor al costo.");

        price = product.cost;
    }

    product.price = price;

    saveProducts();
}

/*=========================================================
=            CAMBIAR DESCUENTO                            =
=========================================================*/

function changeDiscount(id, discount) {
    const product = datosProductsEdit.find((p) => Number(p.id) === Number(id));

    if (!product) {
        return;
    }

    discount = Number(discount);

    if (discount < 0) {
        discount = 0;
    }

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
    if (!confirm("¿Eliminar este producto de la venta?")) {
        return;
    }

    datosProductsEdit = datosProductsEdit.filter(
        (product) => Number(product.id) !== Number(id),
    );

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

    let valtotal = 0;

    datosProductsEdit.forEach((product) => {
        const quantity = Number(product.quantity);

        const price = Number(product.price);

        // const discount = Number(product.discount);

        const tax = Number(product.tax ?? 0);

        /*
         * El precio YA INCLUYE IVA.
         */
        const lineSubtotal = quantity * price;

        /*
         * Valor después del descuento.
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

    /*
     * IMPORTANTE:
     *
     * Como el precio ya incluye IVA,
     * NO debemos sumar nuevamente el IVA.
     */
    //const total = subtotal - totalDiscount;

    document.getElementById("subTotal").value = subtotal;

    document.getElementById("subtotalInvoice").textContent =
        "$ " + subtotal.toLocaleString("es-CO");

    document.getElementById("tax").value = totalTax;
    document.getElementById("iva19Invoice").textContent =
        "$ " + totalTax.toLocaleString("es-CO");

    document.getElementById("total").value = total;
    document.getElementById("totalInvoice").textContent =
        "$ " + valtotal.toLocaleString("es-CO");

    document.getElementById("productsInvoice").textContent =
        datosProductsEdit.length;

    document.getElementById("quantityInvoice").textContent = totalQuantity;

    /*
     * Actualizamos forma de pago.
     */
    updatePayment();
}

/*=========================================================
=            TOTAL DE LA FACTURA                          =
=========================================================*/

function getInvoiceTotal() {
    let total = 0;

    datosProductsEdit.forEach((product) => {
        const quantity = Number(product.quantity);

        const price = Number(product.price);

        /*
         * El precio ya incluye IVA.
         */
        const lineTotal = quantity * price;

        total += lineTotal;
    });

    return total;
}

/*=========================================================
=            INFORMACIÓN DE LA VENTA                      =
=========================================================*/

function loadSaleInformation() {
    try {
        const sale = JSON.parse(localStorage.getItem(STORAGE_SALE_EDIT));

        /*
        |--------------------------------------------------------------------------
        | Método de pago
        |--------------------------------------------------------------------------
        |
        | Primero usamos el método de la factura.
        | Si existe en LocalStorage, usamos ese valor.
        |
        */

        if (sale?.paymentMethod) {
            paymentMethod.value = String(sale.paymentMethod);
        } else if (saleData?.payment_method_id) {
            paymentMethod.value = String(saleData.payment_method_id);
        }

        /*
        |--------------------------------------------------------------------------
        | Dinero recibido
        |--------------------------------------------------------------------------
        */

        if (sale?.receivedAmount !== undefined) {
            receivedAmount.value = sale.receivedAmount;
        } else {
            receivedAmount.value =
                saleData?.payment_form === "counted" ? saleData.total : 0;
        }

        /*
        |--------------------------------------------------------------------------
        | Observación
        |--------------------------------------------------------------------------
        */

        if (sale?.observation !== undefined) {
            observation.value = sale.observation;
        } else {
            observation.value = saleData?.observation ?? "";
        }

        /*
        |--------------------------------------------------------------------------
        | Actualizar forma de pago
        |--------------------------------------------------------------------------
        */

        updatePayment();
    } catch (error) {
        console.error("Error cargando información de venta:", error);

        /*
        | Si falla LocalStorage,
        | usamos directamente la información
        | de la factura.
        */

        paymentMethod.value = String(saleData?.payment_method_id ?? "1");

        receivedAmount.value = saleData?.total ?? 0;

        observation.value = saleData?.observation ?? "";

        updatePayment();
    }
}

function saveSaleInformation() {
    const sale = {
        paymentMethod: paymentMethod.value,

        receivedAmount: Number(receivedAmount.value),

        observation: observation.value,
    };

    localStorage.setItem(STORAGE_SALE_EDIT, JSON.stringify(sale));
}

/*=========================================================
=            FORMA DE PAGO                                =
=========================================================*/

function updatePayment() {
    const total = getInvoiceTotal();

    /*
     * EFECTIVO
     */
    if (paymentMethod.value === "1") {
        receivedAmount.disabled = false;

        /*
         * Si estaba en cero, dejamos que
         * el usuario escriba libremente.
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
     * Guardar solamente una vez.
     */
    saveSaleInformation();
}

/*=========================================================
=            CALCULAR CAMBIO                              =
=========================================================*/

function calculateChange(save = true) {
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

/*=========================================================
=            LIMPIAR VENTA                                =
=========================================================*/

function clearSaleData() {
    /*
     * NO usar localStorage.clear()
     *
     * porque eliminaría todos los datos
     * almacenados por tu aplicación.
     */

    localStorage.removeItem(STORAGE_KEY_PRODUCTS_EDIT);

    localStorage.removeItem(STORAGE_SALE_EDIT);

    localStorage.removeItem("datosCustomer");

    datosProductsEdit = [];

    tbodyProducts.innerHTML = "";

    tbodySaleProducts.innerHTML = "";

    searchProduct.value = "";

    paymentMethod.value = "cash";

    receivedAmount.value = 0;

    receivedAmount.disabled = false;

    changeAmount.value = 0;

    observation.value = "";

    /*
     * Actualizar resumen.
     */
    updateSummary();
}

/*=========================================================
=            UTILIDADES                                   =
=========================================================*/

function formatCurrency(value) {
    return "$ " + Number(value).toLocaleString("es-CO");
}

function round(value) {
    return Number(Number(value).toFixed(2));
}

const btnSaleEdit = document.getElementById("btnSaleEdit");

if (btnSaleEdit) {
    btnSaleEdit.addEventListener("click", function (event) {
        event.preventDefault();

        if (datosProductsEdit.length === 0) {
            Swal.fire("Debe agregar al menos un producto a la venta.");
            return;
        }

        const total = getInvoiceTotal();

        if (total <= 0) {
            Swal.fire("El total de la venta debe ser mayor a cero.");
            return;
        }

        this.closest("form").submit();
    });
}

const btnSubmitSave = document.getElementById("btnSaveSale");
const formSale = document.querySelector("#formSaleUpdate");

if (btnSubmitSave && formSale) {
    btnSubmitSave.addEventListener("click", async function (event) {
        event.preventDefault();

        const productsInput = document.getElementById("products");

        const customer = document.getElementById("customer_id");

        /*
        |--------------------------------------------------------------------------
        | Productos actuales
        |--------------------------------------------------------------------------
        */

        productsInput.value = JSON.stringify(datosProductsEdit);

        /*
        |--------------------------------------------------------------------------
        | Validar productos
        |--------------------------------------------------------------------------
        */

        if (!datosProductsEdit.length) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "No puedes actualizar la venta sin productos",
            });

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Validar cliente
        |--------------------------------------------------------------------------
        */

        if (!customer.value) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "No puedes actualizar la venta sin cliente",
            });

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | FormData
        |--------------------------------------------------------------------------
        */

        const formData = new FormData(formSale);

        /*
        |--------------------------------------------------------------------------
        | Productos
        |--------------------------------------------------------------------------
        */

        formData.set("products", JSON.stringify(datosProductsEdit));

        /*
        |--------------------------------------------------------------------------
        | Forma de pago
        |--------------------------------------------------------------------------
        */

        formData.set("payment_method_id", paymentMethod.value);

        /*
        |--------------------------------------------------------------------------
        | PUT Laravel
        |--------------------------------------------------------------------------
        */

        formData.set("_method", "PUT");

        /*
        |--------------------------------------------------------------------------
        | CSRF
        |--------------------------------------------------------------------------
        */

        const token = document.querySelector('input[name="_token"]').value;

        /*
        |--------------------------------------------------------------------------
        | Debug
        |--------------------------------------------------------------------------
        */

        console.log("URL:", formSale.action);

        console.log("Venta:", saleData.id);

        console.log("Productos:", datosProductsEdit);

        /*
        |--------------------------------------------------------------------------
        | AJAX
        |--------------------------------------------------------------------------
        */

        try {
            const response = await fetch(formSale.action, {
                method: "POST",

                headers: {
                    "X-CSRF-TOKEN": token,
                    Accept: "application/json",
                },

                body: formData,
            });

            const data = await response.json();
            
            /*
            |--------------------------------------------------------------------------
            | Éxito
            |--------------------------------------------------------------------------
            */

            if (response.ok) {
                localStorage.removeItem(STORAGE_KEY_PRODUCTS_EDIT);

                localStorage.removeItem(STORAGE_SALE_EDIT);

                await Swal.fire({
                    position: "top-end",

                    icon: "success",

                    title: "Venta actualizada con éxito",

                    showConfirmButton: false,

                    timer: 1500,
                });

                location.reload();

                return;
            }

            /*
            |--------------------------------------------------------------------------
            | Error
            |--------------------------------------------------------------------------
            */

            let errorText = data.message || "Error desconocido";

            if (data.errors) {
                const firstErrorKey = Object.keys(data.errors)[0];

                errorText = data.errors[firstErrorKey][0];
            }

            Swal.fire({
                icon: "error",

                title: "Error",

                text: errorText,
            });

            console.error("Errores Laravel:", data.errors);
        } catch (error) {
            console.error("Error AJAX:", error);

            Swal.fire({
                icon: "error",

                title: "Error",

                text: "No se pudo conectar con el servidor.",
            });
        }
    });
}
