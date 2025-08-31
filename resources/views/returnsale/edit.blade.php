@extends('layouts.master')

@section('content')
    <div class="container mt-2">

        <h4>Editar devolucion</h4>

        <form method="POST" action="{{ route('returnsale.update', $returnsale->id) }}">
            @csrf
            @method('PUT')

            {{-- ================= CLIENTE ================= --}}
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between">
                    <span>Datos del Cliente</span>
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                        data-bs-target="#modalClientes">Buscar Cliente</button>
                    <a href="{{ route('returnsale.index') }}" class="btn btn-sm btn-primary">
                        Volver
                    </a>
                </div>
                <div class="card-body ">
                    <div class="row">
                        <input type="hidden" name="customer_id" id="customer_id" value="{{ $returnsale->customer->id }}">
                        <div class="col-md-3">
                            <label>Nombre:</label>
                            <input type="text" class="form-control" id="customer_name"
                                value="{{ $returnsale->customer->full_name }}" readonly>
                        </div>
                        <div class="col-md-3">
                            <label>Identificación:</label>
                            <input type="text" class="form-control" id="customer_document"
                                value="{{ $returnsale->customer->identification_card }}" readonly>
                        </div>
                        <div class="col-md-3">
                            <label>Ciudad:</label>
                            <input type="text" class="form-control" id="customer_city"
                                value="{{ $returnsale->customer->city->name }}" readonly>
                        </div>
                        <div class="col-md-3">
                            <label>Fecha:</label>
                            <input type="date" class="form-control" id="date_sale" name="date_sale"
                                value="{{ $returnsale->date_sale }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <label>Direccion:</label>
                            <input type="text" class="form-control" id="customer_address"
                                value="{{ $returnsale->customer->address }}" readonly>
                        </div>
                         <div class="col-md-9">
                            <label>Motivo</label>
                            <input type="tex" name="reason" class="form-control"
                             value="{{$returnsale->reason}}">
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
                        <input type="text" class="form-control" id="subtotal" name="subtotal"
                            value="{{ $returnsale->subtotal }}" readonly>
                        <label>IVA:</label>
                        <input type="text" class="form-control" id="iva" name="iva"
                            value="{{ $returnsale->total_iva }}" readonly>
                        <label>Total:</label>
                        <input type="hidden" name="costs" id="costs" value="{{ $returnsale->costs }}">
                        <input type="text" class="form-control" id="total" name="total"
                            value="{{ $returnsale->total }}" readonly>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>

    @include('sale.modals.customers')
    @include('sale.modals.products')




    <script>
        window.productos = @json($lineItems);
    </script>


    <script>
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

        window.productos = window.productos || []; // si viene vacío desde create, será []
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
        //let productos = [];

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




        // ======================= VARIABLES GLOBALES =======================

        // Helpers de UI
        function mostrarToast(mensaje) {
            const toastBody = document.getElementById('toastBody');
            toastBody.textContent = mensaje;
            const toastElement = document.getElementById('precioToast');
            const toast = new bootstrap.Toast(toastElement);
            toast.show();
        }

        // ======================= RENDERIZAR PRODUCTOS =======================
        function renderProductos() {
            const tbody = document.querySelector('#product-table tbody');
            tbody.innerHTML = '';

            window.productos.forEach((p, index) => {
                const sub = (p.price * p.quantity);
                const iva = sub * ((p.tax ?? p.iva ?? 0) / 100);

                tbody.insertAdjacentHTML('beforeend', `
                <tr>
                    <td>
                        ${p.name}
                        <input type="hidden" name="products[]" value="${p.id}">
                        <input type="hidden" name="tax[]" value="${p.tax ?? p.iva ?? 0}">
                        <input type="hidden" name="cost_product[]" value="${p.cost ?? 0}">
                    </td>
                    <td>
                        <input type="number" class="form-control cantidad-input" data-index="${index}" name="quantities[]" value="${p.quantity}" min="1">
                    </td>
                    <td>
                        <input type="number" class="form-control precio-input" data-index="${index}" name="prices[]" value="${p.price}">
                    </td>
                    <td>${p.tax ?? p.iva ?? 0}%</td>
                    <td>${(sub).toFixed(0)}</td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm" onclick="eliminarProducto(${p.id})">X</button>
                    </td>
                </tr>
            `);
            });

            calcularTotales();
        }

        // ======================= CALCULAR TOTALES =======================
        function calcularTotales() {
            let subtotal = 0,
                ivaTotal = 0,
                costs = 0;

            window.productos.forEach(p => {
                const sub = p.price * p.quantity;
                const taxPercent = (p.tax ?? p.iva ?? 0);
                const iva = sub * (taxPercent / 100);
                const cost_t = (p.cost ?? 0) * p.quantity;
                subtotal += sub;
                ivaTotal += iva;
                costs += cost_t;
            });

            document.getElementById('subtotal').value = subtotal.toFixed(0);
            document.getElementById('iva').value = ivaTotal.toFixed(0);
            document.getElementById('total').value = (subtotal + ivaTotal).toFixed(0);
            document.getElementById('costs').value = costs.toFixed(0);
        }

        // ======================= EVENTOS DE ENTRADA =======================
        document.addEventListener('input', function(e) {
            const index = parseInt(e.target.dataset.index);
            const isCantidad = e.target.classList.contains('cantidad-input');
            const isPrecio = e.target.classList.contains('precio-input');

            if (isCantidad || isPrecio) {
                let cantidadInput = document.querySelector(`.cantidad-input[data-index="${index}"]`);
                let precioInput = document.querySelector(`.precio-input[data-index="${index}"]`);

                let cantidad = parseInt(cantidadInput.value) || 1;
                let precio = parseInt(precioInput.value) || 0;

                const stock = window.productos[index].stock ?? 0;
                if (cantidad > stock) {
                    cantidad = stock;
                    cantidadInput.value = stock;
                    mostrarToast(
                        `La cantidad solicitada supera el stock disponible (${stock}). Se ha ajustado automáticamente.`
                    );
                }

                window.productos[index].quantity = cantidad;
                window.productos[index].price = precio;

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

                const costo = window.productos[index].cost ?? 0;
                const sugerido = window.productos[index].original_price ?? precioIngresado;
                const cantidad = window.productos[index].quantity;

                if (precioIngresado < costo) {
                    mostrarToast(
                        `El precio ingresado es menor al costo ($${costo}). Se ha restablecido el precio sugerido.`
                    );
                    precioIngresado = sugerido;
                    precioInput.value = sugerido;
                }

                window.productos[index].price = precioIngresado;

                const fila = e.target.closest('tr');
                const subtotalCell = fila.querySelector('td:nth-child(5)');
                subtotalCell.textContent = (precioIngresado * cantidad).toFixed(0);

                calcularTotales();
            }
        }, true);

        // ======================= UTILIDADES =======================
        function eliminarProducto(id) {
            window.productos = window.productos.filter(p => p.id !== id);
            renderProductos();
        }

        // Si necesitas mantener las funciones de buscar cliente/producto, puedes
        // reusar las que ya tienes en tu create sin cambios.

        // Inicial
        document.addEventListener('DOMContentLoaded', renderProductos);
    </script>
@endsection
