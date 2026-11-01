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
const saleData = window.saleData ?? null;

document.addEventListener("DOMContentLoaded", () => {
    loadCustomerData();

    const elementmodalCustomer = document.getElementById("customerModal");
    const elementmodalProduct = document.getElementById("productModal");

    const modalCustomer = elementmodalCustomer
        ? bootstrap.Modal.getOrCreateInstance(elementmodalCustomer)
        : null;

    const modalProduct = elementmodalProduct
        ? bootstrap.Modal.getOrCreateInstance(elementmodalProduct)
        : null;

    const shortcuts = {
        F2: () => modalCustomer?.show(),
        F3: () => modalProduct?.show(),
        F4: () => {
            if (confirm("¿Desea limpiar la venta actual?")) {
                sessionStorage.removeItem("datosProducts");
                sessionStorage.removeItem("saleInformation");
                sessionStorage.removeItem(STORAGE_KEY);

                location.reload();
            }
        },
    };

    window.addEventListener("keydown", (event) => {
        if (event.key in shortcuts) {
            event.preventDefault();
            shortcuts[event.key]();
        }
    });
});

if (searchCustomer && tbody) {
    searchCustomer.addEventListener("input", async function () {
        const q = this.value.trim();

        tbody.innerHTML = "";

        if (q.length < 3) return;

        try {
            const response = await fetch(
                `/customers/search/${encodeURIComponent(q)}`,
            );

            if (!response.ok) {
                throw new Error("Error en la búsqueda");
            }

            const result = await response.json();
            const customers = result.data ?? [];

            const clientesUnicos = [
                ...new Map(
                    customers.map((cliente) => [cliente.id, cliente]),
                ).values(),
            ];

            clientesUnicos.forEach((cliente) => {
                const row = document.createElement("tr");

                const values = [
                    cliente.identification ?? "",
                    cliente.full_name ?? "",
                    cliente.phone ?? "",
                    cliente.address ?? "",
                    cliente.city?.name ?? "",
                ];

                values.forEach((value) => {
                    const cell = document.createElement("td");
                    cell.textContent = value;
                    row.appendChild(cell);
                });

                const actionCell = document.createElement("td");
                actionCell.className = "text-center";

                const button = document.createElement("button");
                button.type = "button";
                button.className = "btn btn-primary btn-sm";
                button.innerHTML = '<i class="bi bi-check-circle"></i>';

                button.addEventListener("click", () => {
                    addCustomer(
                        cliente.id,
                        cliente.full_name ?? "",
                        cliente.identification ?? "",
                        cliente.phone ?? "",
                        cliente.email ?? "",
                        cliente.address ?? "",
                        cliente.city?.name ?? "",
                    );
                });

                actionCell.appendChild(button);
                row.appendChild(actionCell);
                tbody.appendChild(row);
            });
        } catch (error) {
            console.error("Error buscando clientes:", error);
        }
    });
}

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
        email,
        address,
        city,
    };

    sessionStorage.setItem(STORAGE_KEY, JSON.stringify(customer));

    customerInput(customer);

    bootstrap.Modal.getOrCreateInstance(
        document.getElementById("customerModal"),
    ).hide();
};

function loadCustomerData() {
    try {
        const customer = JSON.parse(sessionStorage.getItem(STORAGE_KEY));

        if (customer) {
            customerInput(customer);
        }
    } catch (error) {
        console.error("Error cargando cliente:", error);
    }
}

function customerInput(customer) {
    customerIdInput.value = customer.id ?? "";
    customerNameInput.value = customer.name ?? "";
    customerIdentificationInput.value = customer.identification ?? "";
    customerPhoneInput.value = customer.phone ?? "";
    customerAddressInput.value = customer.address ?? "";
    customerEmailInput.value = customer.email ?? "";
    customerCityInput.value = customer.city ?? "";
}
