const $cost = document.getElementById("cost");
const $price = document.getElementById("price");
const $utility = document.getElementById("utility");


$cost.addEventListener("change", (e)=>{
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

