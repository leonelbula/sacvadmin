/*=========================================================
=            CONFIGURACIÓN                                =
=========================================================*/

const STORAGE_KEY_PRODUCTS = "datosProducts";
const STORAGE_SHOPPING = "saleInformation";
const STORAGE_CUSTOMER = "datosCustomer";

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
let datosProducts = [];

function editSale() {
    //console.log(saleData.details[0]['product']);
    console.log(saleData.details);
    let data = saleData.details;
    data.forEach((item) => {
        const id = item.product_id;
        const code = item.product.code;
        const name = item.product.name;
        const quantity = item.quantity;
        const cost = item.cost;
        const price = item.price;
        const subtotal = item.subtotal;

        const taxId = item.tax_id;
        const taxCode = item.tax?.code;
        const taxName = item.tax?.name;
        const taxValue = item.tax?.value;

        console.log({
            id,
            code,
            name,
            quantity,
            stock,
            cost,
            price,
            subtotal,
            taxValue,
        });
    });
}

/*=========================================================
=            INICIALIZACIÓN                              =
=========================================================*/

document.addEventListener("DOMContentLoaded", initShopping);

function initShopping() {
    loadProductData();
    loadShoppingInformation();
    registerEvents();
    products.value = JSON.stringify(datosProducts);

    if (saleData) {
        editSale();
    }
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
        observation.addEventListener("input", saveShoppingInformation);
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
                        onclick='selectProduct(${JSON.stringify(product)})' ${product.stock == 0 ? "disabled" : ""}>

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
        datosProducts =
            JSON.parse(sessionStorage.getItem(STORAGE_KEY_PRODUCTS)) || [];
    } catch (error) {
        console.error("Error leyendo productos:", error);
        datosProducts = [];
    }

    renderShoppingProducts();
}

function saveProducts() {
    sessionStorage.setItem(STORAGE_KEY_PRODUCTS, JSON.stringify(datosProducts));

    products.value = JSON.stringify(datosProducts);

    renderShoppingProducts();
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

    const index = datosProducts.findIndex(
        (item) => Number(item.id) === productId,
    );

    if (index >= 0) {
        // El producto ya existe
        const existingProduct = datosProducts[index];

        if (existingProduct.quantity < existingProduct.stock) {
            existingProduct.quantity++;
        } else {
            alert("La cantidad supera el stock disponible.");
        }
    } else {
        datosProducts.push({
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

function renderShoppingProducts() {
    let html = "";

    datosProducts.forEach((product, index) => {
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
                        step="100"
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
    const product = datosProducts.find((p) => Number(p.id) === Number(id));

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
    const product = datosProducts.find((p) => Number(p.id) === Number(id));

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
    const product = datosProducts.find((p) => Number(p.id) === Number(id));

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

    datosProducts = datosProducts.filter(
        (product) => Number(product.id) !== Number(id),
    );

    saveProducts();
}

/*=========================================================
=            RESUMEN DE LA FACTURA                        =
=========================================================*/

function updateSummary() {
    let subtotal = 0;
    let totalTax = 0;
    let totalQuantity = 0;
    let valtotal = 0;

    datosProducts.forEach((product) => {
        const quantity = Number(product.quantity);
        const price = Number(product.price);
        const tax = Number(product.tax ?? 0);

        const lineSubtotal = quantity * price;

        const base =
            tax > 0
                ? Math.round(lineSubtotal / (1 + tax / 100))
                : Math.round(lineSubtotal);

        const lineTax = tax > 0 ? Math.round(lineSubtotal - base) : 0;

        subtotal += base;
        valtotal += lineSubtotal;
        totalTax += lineTax;
        totalQuantity += quantity;
    });

    document.getElementById("subTotal").value = subtotal;

    document.getElementById("subtotalInvoice").textContent =
        "$ " + subtotal.toLocaleString("es-CO");

    document.getElementById("tax").value = totalTax;

    document.getElementById("iva19Invoice").textContent =
        "$ " + totalTax.toLocaleString("es-CO");

    document.getElementById("total").value = valtotal;

    document.getElementById("totalInvoice").textContent =
        "$ " + valtotal.toLocaleString("es-CO");

    document.getElementById("productsInvoice").textContent =
        datosProducts.length;

    document.getElementById("quantityInvoice").textContent = totalQuantity;

    updatePayment();
}

/*=========================================================
=            TOTAL DE LA FACTURA                          =
=========================================================*/

function getInvoiceTotal() {
    let total = 0;

    datosProducts.forEach((product) => {
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

function loadShoppingInformation() {
    try {
        const sale = JSON.parse(sessionStorage.getItem(STORAGE_SHOPPING));

        if (!sale) {
            paymentMethod.value = "1";
            receivedAmount.value = 0;
            observation.value = "";

            updatePayment();
            return;
        }

        paymentMethod.value = sale.paymentMethod ?? "1";
        receivedAmount.value = sale.receivedAmount ?? 0;
        observation.value = sale.observation ?? "";

        updatePayment();
    } catch (error) {
        console.error("Error cargando información de venta:", error);

        paymentMethod.value = "1";
        receivedAmount.value = 0;
        observation.value = "";

        updatePayment();
    }
}

function saveShoppingInformation() {
    const sale = {
        paymentMethod: paymentMethod.value,
        receivedAmount: Number(receivedAmount.value),
        observation: observation.value,
    };

    sessionStorage.setItem(STORAGE_SHOPPING, JSON.stringify(sale));
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
    saveShoppingInformation();
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
        saveShoppingInformation();
    }
}

/*=========================================================
=            LIMPIAR VENTA                                =
=========================================================*/

function clearSaleData() {
    sessionStorage.removeItem(STORAGE_KEY_PRODUCTS);
    sessionStorage.removeItem(STORAGE_SHOPPING);
    sessionStorage.removeItem(STORAGE_CUSTOMER);

    datosProducts = [];

    tbodyProducts.innerHTML = "";
    tbodySaleProducts.innerHTML = "";

    searchProduct.value = "";

    paymentMethod.value = "1";
    receivedAmount.value = 0;
    receivedAmount.disabled = false;

    changeAmount.value = 0;
    observation.value = "";

    products.value = JSON.stringify(datosProducts);

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
