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
                        <input type="hidden" name="customer_id" id="customer_id" value="1">
                        <div class="col-md-3">
                            <label>Nombre:</label>
                            <input type="text" class="form-control" id="customer_name" readonly value="Ventas por mostrador">
                        </div>
                        <div class="col-md-3">
                            <label>Identificación:</label>
                            <input type="text" class="form-control" id="customer_document" readonly value="999999">
                        </div>
                        <div class="col-md-3">
                            <label>Ciudad:</label>
                            <input type="text" class="form-control" id="customer_city" readonly value="sahagun">
                        </div>
                        <div class="col-md-3">
                            <label>Fecha:</label>
                            <input type="date" class="form-control" id="date_sale" name="date_sale"
                                value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <label>Direccion:</label>
                            <input type="text" class="form-control" id="customer_address" readonly value="direccion 1">
                        </div>
                        <div class="col-md-3">
                            <label>Forma de Pago</label>
                            <select name="payment_form" class="form-control" onchange="toggleOpcionPay(this.value)"
                                required>
                                <option value="">Opciones de Pago</option>
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

        document.getElementById('buscarProducto').addEventListener('change', function() {
            const q = this.value.trim();
            const tbody = document.querySelector('#tablaProductos tbody');

            if (q.length < 1) {
                tbody.innerHTML = '';
                return;
            }

            fetch(`/products/search/${encodeURIComponent(q)}`)
                .then(res => {
                    if (!res.ok) throw new Error('Error en la búsqueda de productos');
                    return res.json();
                })
                .then(data => {
                    tbody.innerHTML = '';

                    data.forEach(producto => {
                        // Guardamos el JSON codificado en data-product para evitar problemas de comillas
                        const encoded = encodeURIComponent(JSON.stringify(producto));
                        tbody.innerHTML += `
                    <tr>
                        <td>${producto.id}</td>
                        <td>${producto.code ?? ''}</td>
                        <td>${producto.name}</td>
                        <td>${producto.cost}</td>
                        <td>${producto.price}</td>
                        <td>${producto.amount}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-primary btn-add-product" data-product="${encoded}">
                                Agregar
                            </button>
                        </td>
                    </tr>`;
                    });
                })
                .catch(err => {
                    console.error(err);
                    document.querySelector('#tablaProductos tbody').innerHTML =
                        '<tr><td colspan="6">Error al buscar productos</td></tr>';
                });
        });

        // Delegación de eventos para los botones "Agregar"
        document.querySelector('#tablaProductos tbody').addEventListener('click', function(e) {
            const btn = e.target.closest('.btn-add-product');
            if (!btn) return;
            try {
                const producto = JSON.parse(decodeURIComponent(btn.dataset.product));
                seleccionarProducto(producto);
            } catch (err) {
                console.error('No se pudo parsear el producto:', err);
            }
        });

        function seleccionarProducto(producto) {
            // console.log para depuración rápida
            console.log('seleccionarProducto ->', producto);
            agregarProducto(producto);

            const modalEl = document.getElementById('modalProductos');
            const modalInstance = bootstrap.Modal.getInstance(modalEl);
            if (modalInstance) modalInstance.hide();

            // limpiar búsqueda y resultados
            document.getElementById('buscarProducto').value = '';
            document.querySelector('#tablaProductos tbody').innerHTML = '';
        }

        // ======================= PRODUCTOS =======================
        window.productos = window.productos || [];



        function agregarProducto(producto) {
            const stock = Number(producto.amount ?? producto.stock ?? 0);

            // 🚫 Si no hay stock, no deja agregar
            if (isNaN(stock) || stock <= 0) {
                mostrarToast(`El producto "${producto.name}" no tiene stock disponible.`);
                return;
            }

            const id = Number(producto.id);

            const parsed = {
                id,
                code: producto.code ?? '',
                name: producto.name ?? 'Sin nombre',
                quantity: 1,
                price: Number(producto.price) || 0,
                original_price: Number(producto.price) || 0,
                cost: Number(producto.cost) || 0,
                tax: Number(producto.tax) || 0,
                stock // 👈 guardamos stock disponible
            };

            // 🚫 Evitar duplicados
            const existe = productos.find(p => Number(p.id) === parsed.id);
            if (existe) {
                mostrarToast('Este producto ya fue agregado');
                return;
            }

            productos.push(parsed);
            console.log("Productos en memoria:", productos); // 👈 debug
            renderProductos();
        }

        function eliminarProducto(id) {
            productos = productos.filter(p => Number(p.id) !== Number(id));
            renderProductos();
        }

        function renderProductos() {
            const tbody = document.querySelector('#product-table tbody');
            if (!tbody) {
                console.error("No existe #product-table tbody en el DOM");
                return;
            }

            let html = '';

            productos.forEach((p, index) => {
                const rowSubtotal = (p.price * p.quantity).toFixed(0);

                html += `
        <tr>
            <td>
                ${p.name}
                <input type="hidden" name="products[]" value="${p.id}">
                <input type="hidden" name="tax[]" value="${p.tax}">
                <input type="hidden" name="cost_product[]" value="${p.cost}">
            </td>
            <td>
                <input type="number" class="form-control cantidad-input"
                       data-index="${index}" name="quantities[]"
                       value="${p.quantity}" min="1" max="${p.stock}">
                <small class="text-muted">Stock: ${p.stock}</small>
            </td>
            <td>
                <input type="number" class="form-control precio-input"
                       data-index="${index}" name="prices[]"
                       value="${p.price}">
            </td>
            <td>${p.tax}%</td>
            <td class="row-subtotal">${rowSubtotal}</td>
            <td>
                <button type="button" class="btn btn-danger btn-sm"
                        onclick="eliminarProducto(${p.id})">X</button>
            </td>
        </tr>`;
            });

            tbody.innerHTML = html;
            calcularTotales();
        }

        // ======================= VALIDACIÓN EN CANTIDAD =======================
        document.querySelector('#product-table tbody').addEventListener('input', function(e) {
            const target = e.target;
            const index = parseInt(target.dataset.index);
            if (isNaN(index)) return;

            if (!target.classList.contains('cantidad-input')) return;

            let cantidad = parseInt(target.value) || 1;
            const stock = productos[index].stock;

            // 🚫 Validación de stock
            if (cantidad > stock) {
                cantidad = stock;
                target.value = stock;
                mostrarToast(
                    `La cantidad solicitada supera el stock disponible (${stock}). Se ajustó automáticamente.`
                );
            }

            if (stock === 0) {
                cantidad = 0;
                target.value = 0;
                mostrarToast(`"${productos[index].name}" no tiene stock.`);
            }

            productos[index].quantity = cantidad;

            // actualizar subtotal de la fila
            const fila = target.closest('tr');
            const subtotalCell = fila.querySelector('.row-subtotal');
            subtotalCell.textContent = (productos[index].price * cantidad).toFixed(0);

            calcularTotales();
        });




        function calcularTotales() {
            let subtotal = 0;
            let ivaTotal = 0;
            let costs = 0;

            productos.forEach(p => {
                const sub = p.price * p.quantity;
                const iva = sub * (p.tax / 100);
                const cost_t = p.cost * p.quantity;
                subtotal += sub;
                ivaTotal += iva;
                costs += cost_t;
            });

            document.getElementById('subtotal').value = subtotal.toFixed(0);
            document.getElementById('iva').value = ivaTotal.toFixed(0);
            document.getElementById('total').value = (subtotal + ivaTotal).toFixed(0);
            document.getElementById('costs').value = costs.toFixed(0);
        }

        // ======================= INPUT EN CANTIDAD Y PRECIO (delegado) =======================
        document.querySelector('#product-table tbody').addEventListener('input', function(e) {
            const target = e.target;
            const index = parseInt(target.dataset.index);
            if (isNaN(index)) return;

            const isCantidad = target.classList.contains('cantidad-input');
            const isPrecio = target.classList.contains('precio-input');
            if (!isCantidad && !isPrecio) return;

            let cantidadInput = document.querySelector(`.cantidad-input[data-index="${index}"]`);
            let precioInput = document.querySelector(`.precio-input[data-index="${index}"]`);

            let cantidad = parseInt(cantidadInput.value) || 1;
            let precio = parseInt(precioInput.value) || 0;

            const stock = productos[index].stock;
            if (cantidad > stock || stock == 0) {
                cantidad = stock;
                cantidadInput.value = stock;
                mostrarToast(
                    `La cantidad solicitada supera el stock disponible (${stock}). Se ha ajustado automáticamente.`
                );
            }

            productos[index].quantity = cantidad;
            productos[index].price = precio;

            // actualizar subtotal de la fila
            const fila = precioInput.closest('tr');
            const subtotalCell = fila.querySelector('.row-subtotal');
            subtotalCell.textContent = (precio * cantidad).toFixed(0);

            calcularTotales();
        });

        // ======================= VALIDACIÓN DE PRECIO AL SALIR (delegado blur) =======================

        document.querySelector('#product-table tbody').addEventListener('focusout', function(e) {
            const target = e.target;
            if (!target.classList.contains('precio-input')) return;

            const index = parseInt(target.dataset.index);
            if (isNaN(index)) return;

            let precioIngresado = Number(target.value) || 0;
            const costo = Number(productos[index].cost) || 0;
            const sugerido = Number(productos[index].original_price) || 0;
            const cantidad = Number(productos[index].quantity) || 1;

            if (precioIngresado < costo) {
                mostrarToast(
                    `El precio ingresado es menor al costo ($${costo}). Se ha restablecido el precio sugerido.`);
                precioIngresado = sugerido;
                target.value = sugerido;
            }

            productos[index].price = precioIngresado;

            const fila = target.closest('tr');
            const subtotalCell = fila.querySelector('.row-subtotal');
            subtotalCell.textContent = (precioIngresado * cantidad).toFixed(0);

            calcularTotales();
        }, true);

    </script>
@endsection
