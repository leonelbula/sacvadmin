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

const STORAGE_KEY = "datosCustomer";

// =========================
// CARGAR CLIENTE AL INICIAR
// =========================
document.addEventListener("DOMContentLoaded", () => {
    loadCustomerData();

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

        console.log(response);

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

        console.log("Clientes:", clientesUnicos);

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
    localStorage.setItem(STORAGE_KEY, JSON.stringify(customer));

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
function loadCustomerData() {
    const customer = JSON.parse(localStorage.getItem(STORAGE_KEY));

    if (!customer) return;

    customerInput(customer);
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

//===========================
//borrar todos loc campos
//===========================
btnClear.addEventListener("click", function () {
    customerIdInput.value = "";
    customerNameInput.value = "";
    customerIdentificationInput.value = "";
    customerPhoneInput.value = "";
    customerAddressInput.value = "";
    customerEmailInput.value = "";
    customerCityInput.value = "";
    localStorage.clear();
    location.reload();
});

/*
window.addEventListener("keydown", (event) => {
    const elementmodalCustomer = document.getElementById("customerModal");
    const elementmodalProduct = document.getElementById("productModal");
    if (event.key === "F2") {
        const modalCustomer = new bootstrap.Modal(elementmodalCustomer);
        modalCustomer.show();
    }
    if (event.key === "F3") {
        const modalProduct = new bootstrap.Modal(elementmodalProduct);
        modalProduct.show();
    }
    if (event.key === "F4") {
        localStorage.clear();
        location.reload();
    }
});*/
/*document.addEventListener("DOMContentLoaded", () => {
    // Tu código optimizado aquí dentro:
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
*/
