const btnSubmitShopping = document.getElementById("btnSaveShopping");
const formShopping = document.querySelector("#formShopping");

btnSubmitShopping.addEventListener("click", async function (event) {
    event.preventDefault();

    const productsInput = document.getElementById("products");
    const supplier = document.getElementById("supplier_id");
    const invoice_number = document.getElementById("invoice_number");

    // 2. Verificar si está vacío o si es un array JSON vacío "[]"
    if (!productsInput.value.trim() || productsInput.value === "[]") {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "No puedes guardar la compra sin productos",
        });
        return; // DETIENE EL ENVÍO por completo aquí
    }
    if (!supplier.value.trim() || supplier.value === "") {
        //alert("Por favor, agregue al menos un producto a la venta.");
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "No puedes guardar la compra sin cliente",
        });
        return; // DETIENE EL ENVÍO por completo aquí
    }

     if (!invoice_number.value.trim() || invoice_number.value === "") {
        //alert("Por favor, agregue al menos un producto a la venta.");
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "No puedes guardar la compra sin N° de compra",
        });
        return; // DETIENE EL ENVÍO por completo aquí
    }

    const token = document.querySelector('input[name="_token"]').value;
    const formData = new FormData(formShopping);

    try {
        const response = await fetch("/shopping/store", {
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
                title: "Compra guardada con éxito:",
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
