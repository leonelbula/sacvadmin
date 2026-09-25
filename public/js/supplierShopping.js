const supplierIdInput = document.getElementById("supplier_id");
const supplierNameInput = document.getElementById("full_name");
const supplierIdentificationInput = document.getElementById("identification");
const supplierPhoneInput = document.getElementById("phone");
const supplierEmailInput = document.getElementById("email");
const supplierAddressInput = document.getElementById("address");
const supplierCityInput = document.getElementById("city");
const invoicenumberInput = document.getElementById("invoice_number");
const btnSearchSupplier = document.getElementById("btnSearchSupplier");

const btnClear = document.getElementById("btn-clear-supplier");
const searchSupplier = document.getElementById("searchSupplier");
const tbody = document.querySelector("#tablaSupplier tbody");




const STORAGE_KEY_SUPPLIER = "datosSupplier";
const shopplingData = window.shopplingDataData ?? null;

// =========================
// CARGAR CLIENTE AL INICIAR
// =========================
document.addEventListener("DOMContentLoaded", () => {
    loadSupplierData();

    const elementmodalSupplier = document.getElementById("modalSupplier");
    const elementmodalProduct = document.getElementById("productModal");

    // Ahora 'bootstrap' ya estará definido con seguridad
    const modalSupplier = new bootstrap.Modal(elementmodalSupplier);
    const modalProduct = new bootstrap.Modal(elementmodalProduct);

    const shortcuts = {
        F2: () => modalSupplier.show(),
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
searchSupplier.addEventListener("input", async function () {
    const query = this.value.trim();

    // Limpiar resultados anteriores
    tbody.innerHTML = "";

    if (query.length === 0 || query.length <= 2) return;
    //if(q.length <= 2) return;

    try {
        const response = await fetch(
            `/supplier/search/${encodeURIComponent(query)}`,
        );

        //console.log(response);

        if (!response.ok) {
            throw new Error("Error en la búsqueda");
        }

        const result = await response.json();

        const suppliers = result.data ?? [];

        // ==========================================
        // ELIMINAR CLIENTES DUPLICADOS
        // ==========================================

        const supplierUnicos = [
            ...new Map(
                suppliers.map((supplier) => [supplier.id, supplier]),
            ).values(),
        ];

        //console.log("Clientes:", clientesUnicos);

        // ==========================================
        // MOSTRAR CLIENTES
        // ==========================================

        supplierUnicos.forEach((supplier) => {
            tbody.innerHTML += `
                <tr>

                    <td>${supplier.identification ?? ""}</td>

                    <td>${supplier.full_name ?? ""}</td>

                    <td>${supplier.phone ?? ""}</td>

                    <td>${supplier.address ?? ""}</td>

                    <td>${supplier.city ?? ""}</td>

                    <td class="text-center">

                        <button
                            type="button"
                            class="btn btn-primary btn-sm"
                            onclick="addSupplier(
                                ${supplier.id},
                                '${supplier.full_name ?? ""}',
                                '${supplier.identification ?? ""}',
                                '${supplier.phone ?? ""}',
                                '${supplier.address ?? ""}',
                                '${supplier.email ?? ""}',
                                '${supplier.city ?? ""}'
                            )">

                            <i class="bi bi-check-circle"></i>

                        </button>

                    </td>

                </tr>
            `;
        });
    } catch (error) {
        console.error("Error buscando Proveedor:", error);
    }
});

// =========================
// AGREGAR CLIENTE
// =========================
window.addSupplier = function (
    id,
    name,
    identification,
    phone,
    email,
    address,
    city,
) {
    const supplier = {
        id,
        name,
        identification,
        phone,
        address,
        email,
        city,
    };

    //Guardar LocalStorage
    localStorage.setItem(STORAGE_KEY_SUPPLIER, JSON.stringify(supplier));

    //Mostrar datos
    supplierInput(supplier);

    //Cerrar modal
    bootstrap.Modal.getOrCreateInstance(
        document.getElementById("modalSupplier"),
    ).hide();
};

// =========================
// CARGAR CLIENTE
// =========================
function loadSupplierData() {
    const supplier = JSON.parse(localStorage.getItem(STORAGE_KEY_SUPPLIER));
    if (!supplier) return;

    supplierInput(supplier);
}

// =========================
// LLENAR INPUTS
// =========================
function supplierInput(supplier) {
    console.log(supplier);
    supplierIdInput.value = supplier.id;
    supplierNameInput.value = supplier.name;
    supplierIdentificationInput.value = supplier.identification;
    supplierPhoneInput.value = supplier.phone;
    supplierAddressInput.value = supplier.address;
    supplierEmailInput.value = supplier.email;
    supplierCityInput.value = supplier.city;
}
