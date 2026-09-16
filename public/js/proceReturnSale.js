document.addEventListener("DOMContentLoaded", function () {

    const btnSubmitSaveReturn = document.getElementById("btnReturnSale");
    const formSaleReturn = document.querySelector("#returnForm");

    if (!btnSubmitSaveReturn || !formSaleReturn) {
        console.warn("No se encontró #btnReturnSale o #returnForm");
        return;
    }

    btnSubmitSaveReturn.addEventListener("click", async function (event) {
        event.preventDefault();

        const productsInput = document.getElementById("productsInputreturn");
        const customer = document.getElementById("customerId");

        if (!productsInput) {
            console.error("No existe el elemento #productsInputreturn");
            return;
        }

        if (!customer) {
            console.error("No existe el elemento #customer_id");
            return;
        }

        if (!productsInput.value.trim() || productsInput.value === "[]") {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "No puedes guardar la devolución sin productos",
            });

            return;
        }

        if (!customer.value.trim()) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "No puedes guardar la devolución sin cliente",
            });

            return;
        }

        const tokenElement = document.querySelector('input[name="_token"]');

        if (!tokenElement) {
            console.error("No se encontró el token CSRF");
            return;
        }

        const token = tokenElement.value;

        const formData = new FormData(formSaleReturn);

        try {
            const response = await fetch("/salereturn", {
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

                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "Devolución guardada con éxito",
                    showConfirmButton: false,
                    timer: 1500,
                }).then(() => {
                    window.location.reload();
                });

            } else {

                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text:
                        "Error al guardar: " +
                        (data.message || "Error desconocido"),
                });

                console.log(
                    "Errores de validación:",
                    data.errors
                );
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
});

