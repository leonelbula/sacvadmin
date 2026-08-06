export default class SaleManager {
    constructor() {
        this.STORAGE_KEY = "sale";

        this.sale = this.defaultSale();

        this.cacheDOM();

        this.bindEvents();

        this.loadStorage();

        this.render();
    }

    defaultSale() {
        return {
            customer: null,

            payment: {
                method: "cash",

                received: 0,

                change: 0,

                observation: "",
            },

            products: [],

            totals: {
                subtotal: 0,

                discount: 0,

                tax19: 0,

                tax5: 0,

                exempt: 0,

                excluded: 0,

                total: 0,
            },
        };
    }

    cacheDOM() {
        this.tableProducts = document.querySelector("#tableSaleProducts tbody");

        this.totalInvoice = document.getElementById("totalInvoice");

        this.subtotalInvoice = document.getElementById("subtotalInvoice");

        this.discountInvoice = document.getElementById("discountInvoice");

        this.productsInvoice = document.getElementById("productsInvoice");

        this.quantityInvoice = document.getElementById("quantityInvoice");
    }
    bindEvents() {
        document.addEventListener("click", (e) => {
            if (e.target.closest(".btn-remove-product")) {
                const id = e.target.closest(".btn-remove-product").dataset.id;

                this.removeProduct(id);
            }
        });
    }
    saveStorage() {
        localStorage.setItem(
            this.STORAGE_KEY,

            JSON.stringify(this.sale),
        );
    }
    loadStorage() {
        const storage = localStorage.getItem(this.STORAGE_KEY);

        if (storage) {
            this.sale = JSON.parse(storage);
        }
    }
    clearStorage() {
        localStorage.removeItem(this.STORAGE_KEY);

        this.sale = this.defaultSale();
    }
    addProduct(product) {
        const exist = this.sale.products.find((p) => p.id === product.id);

        if (exist) {
            exist.quantity++;
        } else {
            this.sale.products.push({
                id: product.id,

                code: product.code,

                name: product.name,

                price: product.price,

                quantity: 1,

                discount: 0,

                tax: 19,

                subtotal: product.price,
            });
        }

        this.saveStorage();

        this.render();
    }
    removeProduct(id) {
        this.sale.products = this.sale.products.filter((p) => p.id != id);

        this.saveStorage();

        this.render();
    }

    renderProducts() {
        this.tableProducts.innerHTML = "";

        this.sale.products.forEach((product, index) => {
            this.tableProducts.innerHTML += `

        <tr>

            <td>${index + 1}</td>

            <td>${product.code}</td>

            <td>${product.name}</td>

            <td>${product.quantity}</td>

            <td>${product.price}</td>

            <td>$0</td>

            <td>$${product.subtotal}</td>

            <td>

                <button

                    class="btn btn-danger btn-sm btn-remove-product"

                    data-id="${product.id}">

                    <i class="bi bi-trash"></i>

                </button>

            </td>

        </tr>

        `;
        });
    }
    render(){

    this.renderProducts();

}

}
