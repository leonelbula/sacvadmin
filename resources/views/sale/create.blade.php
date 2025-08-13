@extends('layouts.master')

@section('content')
    <div class="container mt-2">

        <h4>Factura Venta</h4>

        <form method="POST" action="{{ route('sale.store') }}">
            @csrf

            {{-- ================= CLIENTE ================= --}}
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between">
                    <span>Datos del Cliente</span>
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                        data-bs-target="#modalClientes">Buscar Cliente</button>
                    <a href="{{ route('sale.index') }}" class="btn btn-sm btn-primary">
                        Volver
                    </a>

                </div>
                <div class="card-body ">
                    <div class="row">
                        <input type="hidden" name="customer_id" id="customer_id">
                        <div class="col-md-3">
                            <label>Nombre:</label>
                            <input type="text" class="form-control" id="customer_name" readonly>
                        </div>
                        <div class="col-md-3">
                            <label>Identificación:</label>
                            <input type="text" class="form-control" id="customer_document" readonly>
                        </div>
                        <div class="col-md-3">
                            <label>Ciudad:</label>
                            <input type="text" class="form-control" id="customer_city" readonly>
                        </div>
                        <div class="col-md-3">
                            <label>Fecha:</label>
                            <input type="date" class="form-control" id="date_sale" name="date_sale"
                                value="{{ date('Y-m-d') }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <label>Direccion:</label>
                            <input type="text" class="form-control" id="customer_address" readonly>
                        </div>
                        <div class="col-md-3">
                            <label>Forma de Pago</label>
                            <select name="payment_form" class="form-control" onchange="toggleOpcionPay(this.value)"
                                required>
                                <option>Opciones de Pago</option>
                                <option value="counted">Contado</option>
                                <option value="credit">Crédito</option>
                            </select>
                        </div>
                        <div class="col-md-3" id="payment_method_div" style="display: none;">
                            <label>Medio de Pago</label>
                            <select name="payment_method" class="form-control">
                                <option value="">selecione una opcion</option>
                                @foreach ($payments as $pay)
                                    <option value="{{ $pay->id }}">{{ $pay->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3" id="due_plazo_div" style="display: none;">
                            <label>Plazo en diaz</label>
                            <input type="number" name="plazo" class="form-control">
                        </div>
                    </div>
                </div>

            </div>

            {{-- ================= PRODUCTOS ================= --}}
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between">
                    <span>Productos</span>
                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                        data-bs-target="#modalProductos">Agregar Producto</button>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="product-table">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>IVA (%)</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            {{-- ================= TOTALES ================= --}}
            <div class="card mb-4">
                <div class="card-body row">
                    <div class="col-md-4 offset-md-8">
                        <label>Subtotal:</label>
                        <input type="text" class="form-control" id="subtotal" name="subtotal" readonly>
                        <label>IVA:</label>
                        <input type="text" class="form-control" id="iva" name="iva" readonly>
                        <label>Total:</label>
                        <input type="hidden" name="costs" id="costs">
                        <input type="text" class="form-control" id="total" name="total" readonly>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Guardar Factura</button>
        </form>
    </div>

    @include('sale.modals.customers')
    @include('sale.modals.products')


    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1055">
        <div id="precioToast" class="toast align-items-center text-white bg-warning border-0" role="alert"
            aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body" id="toastBody">
                    <!-- contenido dinámico -->
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Cerrar"></button>
            </div>
        </div>
    </div>



    <script>
        // ======================= BUSCAR CLIENTE =======================
        document.getElementById('buscarCliente').addEventListener('input', function() {
            const q = this.value;

            fetch(`/customers/search/${q}`)
                .then(res => res.json())
                .then(data => {
                    const tbody = document.querySelector('#tablaClientes tbody');
                    tbody.innerHTML = '';

                    data.forEach(cliente => {
                        tbody.innerHTML += `
                    <tr>
                        <td>${cliente.full_name}</td>
                        <td>${cliente.identification_card}</td>
                        <td>${cliente.city['name']}</td>
                        <td>
                            <button class="btn btn-sm btn-success" onclick="seleccionarCliente(${cliente.id}, '${cliente.full_name}','${cliente.identification_card}','${cliente.address}','${cliente.city['name']}')">Seleccionar</button>
                        </td>
                    </tr>`;
                    });
                });
        });

        function seleccionarCliente(id, full_name, identification_card, address, city) {
            document.getElementById('customer_id').value = id;
            document.getElementById('customer_name').value = full_name;
            document.getElementById('customer_document').value = identification_card;
            document.getElementById('customer_address').value = address;
            document.getElementById('customer_city').value = city;

            const modal = bootstrap.Modal.getInstance(document.getElementById('modalClientes'));
            modal.hide();
        }

        function toggleOpcionPay(value) {
            if (value === 'credit') {
                document.getElementById('due_plazo_div').style.display = value === 'credit' ? 'block' : 'none';
                document.getElementById('payment_method_div').style.display = 'none';
            } else {
                document.getElementById('payment_method_div').style.display = value === 'counted' ? 'block' : 'none';
                document.getElementById('due_plazo_div').style.display = 'none';
            }
        }


        // ======================= BUSCAR PRODUCTO =======================
        document.getElementById('modalProductos').addEventListener('show.bs.modal', function() {
            document.getElementById('buscarProducto').value = '';
            document.querySelector('#tablaProductos tbody').innerHTML = '';
        });

        document.getElementById('buscarProducto').addEventListener('input', function() {
            const q = this.value;
            if (q.length < 2) {
                document.querySelector('#tablaProductos tbody').innerHTML = '';
                return;
            }

            fetch(`/products/search/${q}`)
                .then(res => res.json())
                .then(data => {
                    const tbody = document.querySelector('#tablaProductos tbody');
                    tbody.innerHTML = '';

                    data.forEach(producto => {
                        tbody.innerHTML += `
                    <tr>
                        <td>${producto.id}</td>
                        <td>${producto.code}</td>
                        <td>${producto.name}</td>
                        <td>${producto.price}</td>
                        <td>${producto.tax}%</td>
                        <td>
                            <button class="btn btn-sm btn-primary" onclick='seleccionarProducto(${JSON.stringify(producto)})'>Agregar</button>
                        </td>
                    </tr>`;
                    });
                });
        });

        function seleccionarProducto(producto) {
            agregarProducto(producto);
            const modal = bootstrap.Modal.getInstance(document.getElementById('modalProductos'));
            modal.hide();
            document.getElementById('buscarProducto').value = '';
            document.querySelector('#tablaProductos tbody').innerHTML = '';
        }

        // ======================= PRODUCTOS =======================
        let productos = [];

        function agregarProducto(producto) {
            const existe = productos.find(p => p.id === producto.id);
            if (existe) return alert('Este producto ya fue agregado');

            productos.push({
                ...producto,
                quantity: 1,
                price: parseInt(producto.price),
                original_price: parseInt(producto.price),
                cost: parseInt(producto.cost),
                iva: parseInt(producto.tax),
                stock: parseInt(producto.amount) || 0
            });

            renderProductos();
        }

        function eliminarProducto(id) {
            productos = productos.filter(p => p.id !== id);
            renderProductos();
        }

        function renderProductos() {
            const tbody = document.querySelector('#product-table tbody');
            tbody.innerHTML = '';

            productos.forEach((p, index) => {
                tbody.innerHTML += `
                <tr>
                    <td>
                        ${p.name}
                        <input type="hidden" name="products[]" value="${p.id}">
                        <input type="hidden" name="tax[]" value="${p.tax}">
                        <input type="hidden" name="cost_product[]" value="${p.cost}">
                    </td>
                    <td>
                        <input type="number" class="form-control cantidad-input" data-index="${index}" name="quantities[]" value="${p.quantity}" min="1">
                    </td>
                    <td>
                        <input type="number" class="form-control precio-input" data-index="${index}" name="prices[]" value="${p.price}">
                    </td>
                    <td>${p.tax}%</td>
                    <td>${(p.price * p.quantity).toFixed(0)}</td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm" onclick="eliminarProducto(${p.id})">X</button>
                    </td>
                </tr>`;
            });

            calcularTotales();
        }

        function calcularTotales() {
            let subtotal = 0;
            let ivaTotal = 0;
            let costs = 0;

            productos.forEach(p => {
                const sub = p.price * p.quantity;
                const iva = sub * (p.iva / 100);
                const cost_t = p.cost * p.quantity;
                subtotal += sub;
                ivaTotal += iva;
                costs += cost_t;
            });



            document.getElementById('subtotal').value = subtotal.toFixed(0);
            document.getElementById('iva').value = ivaTotal.toFixed(0);
            document.getElementById('total').value = (subtotal + ivaTotal).toFixed(0);
            document.getElementById('costs').value = (costs).toFixed(0);
        }

        // ======================= TOAST =======================
        function mostrarToast(mensaje) {
            const toastBody = document.getElementById('toastBody');
            toastBody.textContent = mensaje;

            const toastElement = document.getElementById('precioToast');
            const toast = new bootstrap.Toast(toastElement);
            toast.show();
        }

        // ======================= INPUT EN CANTIDAD Y PRECIO =======================
        document.addEventListener('input', function(e) {
            const index = parseInt(e.target.dataset.index);
            const isCantidad = e.target.classList.contains('cantidad-input');
            const isPrecio = e.target.classList.contains('precio-input');

            if (isCantidad || isPrecio) {
                let cantidadInput = document.querySelector(`.cantidad-input[data-index="${index}"]`);
                let precioInput = document.querySelector(`.precio-input[data-index="${index}"]`);

                let cantidad = parseInt(cantidadInput.value) || 1;
                let precio = parseInt(precioInput.value) || 0;

                const stock = productos[index].stock;
                if (cantidad > stock) {
                    cantidad = stock;
                    cantidadInput.value = stock;
                    mostrarToast(
                        `La cantidad solicitada supera el stock disponible (${stock}). Se ha ajustado automáticamente.`
                    );
                }

                productos[index].quantity = cantidad;
                productos[index].price = precio;

                const fila = e.target.closest('tr');
                const subtotalCell = fila.querySelector('td:nth-child(5)');
                subtotalCell.textContent = (precio * cantidad).toFixed(0);

                calcularTotales();
            }
        });

        // ======================= VALIDACIÓN DE PRECIO AL SALIR =======================
        document.addEventListener('blur', function(e) {
            if (e.target.classList.contains('precio-input')) {
                const index = parseInt(e.target.dataset.index);
                const precioInput = e.target;
                let precioIngresado = parseInt(precioInput.value) || 0;

                const costo = productos[index].cost;
                const sugerido = productos[index].original_price;
                const cantidad = productos[index].quantity;

                if (precioIngresado < costo) {
                    mostrarToast(
                        `El precio ingresado es menor al costo ($${costo}). Se ha restablecido el precio sugerido.`
                    );
                    precioIngresado = sugerido;
                    precioInput.value = sugerido;
                }

                productos[index].price = precioIngresado;

                const fila = e.target.closest('tr');
                const subtotalCell = fila.querySelector('td:nth-child(5)');
                subtotalCell.textContent = (precioIngresado * cantidad).toFixed(0);

                calcularTotales();
            }
        }, true); // importante: captura true para que funcione blur correctamente
    </script>
@endsection
