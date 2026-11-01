const btnSubmitSave = document.getElementById("btnSaveSale");
const formSale = document.querySelector("#formSale");

btnSubmitSave.addEventListener("click", async function (event) {
    event.preventDefault();

    const productsInput = document.getElementById("products");
    const customer = document.getElementById("customer_id");

    if (!productsInput.value.trim() || productsInput.value === "[]") {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "No puedes guardar la venta sin productos",
        });

        return;
    }

    if (!customer.value.trim()) {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "No puedes guardar la venta sin cliente",
        });

        return;
    }

    const token = document.querySelector('input[name="_token"]').value;
    const formData = new FormData(formSale);

    try {
        btnSubmitSave.disabled = true;

        const response = await fetch("/sale/store", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": token,
                Accept: "application/json",
            },
            body: formData,
        });

        const data = await response.json();

        if (response.ok) {
            sessionStorage.removeItem("datosProducts");
            sessionStorage.removeItem("saleInformation");
            sessionStorage.removeItem("datosCustomer");

            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Venta guardada con éxito",
                showConfirmButton: false,
                timer: 1500,
            }).then(() => {
                location.reload();
            });
        } else {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text:
                    "Error al guardar: " +
                    (data.message || "Error desconocido"),
            });

            console.log("Errores de validación:", data.errors);
        }
    } catch (error) {
        console.error("Error en la petición:", error);

        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "No se pudo conectar con el servidor.",
        });
    } finally {
        btnSubmitSave.disabled = false;
    }
});
