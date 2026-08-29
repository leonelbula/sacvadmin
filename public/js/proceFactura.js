const btnSubmitSave = document.getElementById("btnSaveSale");
const formSale = document.querySelector("#formSale");

btnSubmitSave.addEventListener("click", async function (event) {
    event.preventDefault();

    const productsInput = document.getElementById("products");
    const customer = document.getElementById("customer_id");

    // 2. Verificar si está vacío o si es un array JSON vacío "[]"
    if (!productsInput.value.trim() || productsInput.value === "[]") {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "No puedes guardar la ventas sin productos",
        });
        return; // DETIENE EL ENVÍO por completo aquí
    }
    if (!customer.value.trim() || customer.value === "") {
        //alert("Por favor, agregue al menos un producto a la venta.");
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "No puedes guardar la ventas sin cliente",
        });
        return; // DETIENE EL ENVÍO por completo aquí
    }

    const token = document.querySelector('input[name="_token"]').value;
    const formData = new FormData(formSale);

    try {
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
            localStorage.clear();
            //
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Venta guardada con éxito:",
                showConfirmButton: false,
                timer: 1500,
            }).then(() => {
                location.reload();
            });
        } else {
            // El servidor respondió con un error (ej. error 422 de validación)

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
    }
});
