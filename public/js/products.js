const $cost = document.getElementById("cost");
const $price = document.getElementById("price");
const $utility = document.getElementById("utility");

$cost.addEventListener("change", (e) => {
    $price.value = $cost.value;

    let valor = Number(($cost.value * $utility.value) / 100);
    let precio = Number($cost.value) + valor;
    $price.value = parseInt(precio);
});

$price.addEventListener("change", (e) => {
    let valor = Number($price.value - $cost.value);
    let utility = Number(valor / $cost.value) * 100;
    $utility.value = parseInt(utility);
});

$utility.addEventListener("change", (e) => {
    let valor = Number(($cost.value * $utility.value) / 100);
    let precio = Number($cost.value) + valor;
    $price.value = parseInt(precio);
});

document.getElementById("taxes_id").addEventListener("change", function () {
    let tax_value = this.options[this.selectedIndex];
    //alert(tax_value.dataset.tax_value);
    document.getElementById("tax_value").value =
        tax_value.dataset.tax_value + " %";
    document.getElementById("value_tax").value = tax_value.dataset.tax_value;
});


document.addEventListener("DOMContentLoaded", function() {
    const formulario = document.getElementById("createProduct");
    const btnGuardar = document.getElementById("btnSave");

    // Bloquea el envío por defecto
    formulario.addEventListener("submit", function(e) {
        e.preventDefault();
    });

    // Solo envía si se hace clic en Guardar
    btnGuardar.addEventListener("click", function() {
        formulario.submit();
    });
});

