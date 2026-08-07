// =========================
// ELEMENTOS DEL DOM
// =========================
const customerIdInput = document.getElementById("customer_id");
const customerNameInput = document.getElementById("full_name");
const customerIdentificationInput = document.getElementById("identification");
const customerPhoneInput = document.getElementById("phone");
const customerAddressInput = document.getElementById("address");
const customerCityInput = document.getElementById("city");
const btnSearchCustomer = document.getElementById("btnSearchCustomer");

const btnClear = document.getElementById("btnClear");
const searchCustomer = document.getElementById("searchCustomer");
const tbody = document.querySelector("#tablaCustomer tbody");

const STORAGE_KEY = "datosCustomer";

// =========================
// CARGAR CLIENTE AL INICIAR
// =========================
document.addEventListener("DOMContentLoaded", () => {
    loadCustomerData();
});

// =========================
// BUSCAR CLIENTES
// =========================
searchCustomer.addEventListener("input", async function () {
    const q = this.value.trim();

    tbody.innerHTML = "";

    if (q.length === 0) return;

    try {
        const response = await fetch(`/customers/search/${q}`);

        const data = await response.json();

        data.forEach((cliente) => {
            tbody.innerHTML += `
                <tr>

                    <td>${cliente.identification}</td>

                    <td>${cliente.full_name}</td>

                    <td>${cliente.phone ?? ""}</td>

                    <td>${cliente.city ?? ""}</td>

                    <td class="text-center">

                        <button
                            class="btn btn-primary btn-sm"
                            onclick="addCustomer(
                                ${cliente.id},
                                '${cliente.full_name}',
                                '${cliente.identification}',
                                '${cliente.phone ?? ""}',
                                '${cliente.address ?? ""}'
                            )">

                            <i class="bi bi-check-circle"></i>

                        </button>

                    </td>

                </tr>
            `;
        });
    } catch (error) {
        console.error(error);
    }
});

// =========================
// AGREGAR CLIENTE
// =========================
window.addCustomer = function (id, name, identification, phone, address) {
    const customer = {
        id,
        name,
        identification,
        phone,
        address,
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
}
