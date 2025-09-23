@extends('layouts.master')

@section('content')
    <div class="container mt-2">

        <h4>Factura Venta</h4>

        <form method="POST" action="{{ route('shopping.store') }}">
            @csrf

            {{-- ================= CLIENTE ================= --}}
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between">
                    <span>Datos del Proveedor</span>
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                        data-bs-target="#modalSupplier">Buscar Proveedor</button>
                    <a href="{{ route('shopping.index') }}" class="btn btn-sm btn-primary">
                        Volver
                    </a>

                </div>
                <div class="card-body ">
                    <div class="row">
                        <input type="hidden" name="supplier_id" id="supplier_id">
                        <div class="col-md-3">
                            <label>Nombre:</label>
                            <input type="text" class="form-control" id="supplier_name" readonly>
                        </div>
                        <div class="col-md-3">
                            <label>Identificación:</label>
                            <input type="text" class="form-control" id="supplier_document" readonly>
                        </div>
                        <div class="col-md-3">
                            <label>Ciudad:</label>
                            <input type="text" class="form-control" id="supplier_city" readonly >
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
                            <input type="text" class="form-control" id="supplier_address" readonly>
                        </div>
                         <div class="col-md-3">
                            <label>N° Factura:</label>
                            <input type="number" class="form-control" id="invoice_number" name="invoice_number">
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

    @include('shopping.modals.suppliers')
    @include('shopping.modals.products')


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
        document.getElementById('buscarSupplier').addEventListener('input', function() {
            const q = this.value;

            fetch(`/suppliers/search/${q}`)
                .then(res => res.json())
                .then(data => {
                    const tbody = document.querySelector('#tableSuppliers tbody');
                    tbody.innerHTML = '';

                    data.forEach(supplier => {
                        tbody.innerHTML += `
                    <tr>
                        <td>${supplier.full_name}</td>
                        <td>${supplier.identification_card}</td>
                        <td>${supplier.city}</td>
                        <td>
                            <button class="btn btn-sm btn-success" onclick="selectSupplier(${supplier.id}, '${supplier.full_name}','${supplier.identification_card}','${supplier.address}','${supplier.city}')">Seleccionar</button>
                        </td>
                    </tr>`;
                    });
                });
        });

        function selectSupplier(id, full_name, identification_card, address, city) {
            document.getElementById('supplier_id').value = id;
            document.getElementById('supplier_name').value = full_name;
            document.getElementById('supplier_document').value = identification_card;
            document.getElementById('supplier_address').value = address;
            document.getElementById('supplier_city').value = city;

            const modal = bootstrap.Modal.getInstance(document.getElementById('modalSupplier'));
            modal.hide();
        }

        function toggleOpcionPay(value) {
            if (value === 'credit') {
                document.getElementById('due_plazo_div').style.display = value === 'credit' ? 'block' : 'none';
            }
        }

        // ======================= BUSCAR PRODUCTO =======================
        document.getElementById('modalProductos').addEventListener('show.bs.modal', function() {
            document.getElementById('buscarProducto').value = '';
            document.querySelector('#tablaProductos tbody').innerHTML = '';
        });

        document.getElementById('buscarProducto').addEventListener('input', function() {
            const q = this.value.trim();
            const tbody = document.querySelector('#tablaProductos tbody');

            if (q.length < 2) {
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
                        <td>${producto.tax ?? 0}%</td>
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
            const id = Number(producto.id);

            const parsed = {
                id,
                code: producto.code ?? '',
                name: producto.name ?? 'Sin nombre',
                quantity: 1,
                cost: Number(producto.cost) || 0,
                tax: Number(producto.tax) || 0,
                stock: Number(producto.amount ?? producto.stock ?? 0) // 👈 más seguro
            };

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
                const rowSubtotal = (p.cost * p.quantity).toFixed(0);

                html += `
            <tr>
                <td>
                    ${p.name}
                    <input type="hidden" name="products[]" value="${p.id}">
                    <input type="hidden" name="tax[]" value="${p.tax}">
                </td>
                <td>
                    <input type="number" class="form-control cantidad-input"
                           data-index="${index}" name="quantities[]"
                           value="${p.quantity}" min="1">
                </td>
                <td>
                    <input type="number" class="form-control precio-input"
                           data-index="${index}" name="prices[]"
                           value="${p.cost}">
                </td>
                <td>${p.tax}%</td>
                <td class="row-subtotal">${rowSubtotal}</td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm"
                            onclick="eliminarProducto(${p.id})">X</button>
                </td>
            </tr>`;
            });

            tbody.innerHTML = html; // 👈 actualizamos de una sola vez
            calcularTotales();
        }


        function calcularTotales() {
            let subtotal = 0;
            let ivaTotal = 0;
            let costs = 0;

            productos.forEach(p => {
                const sub = p.cost * p.quantity;
                const iva = sub * (p.tax / 100);
                const cost_t = p.cost * p.quantity;
                subtotal += sub;
                ivaTotal += iva;

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


            productos[index].quantity = cantidad;
            productos[index].cost = precio;

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



            productos[index].cost = precioIngresado;

            const fila = target.closest('tr');
            const subtotalCell = fila.querySelector('.row-subtotal');
            subtotalCell.textContent = (precioIngresado * cantidad).toFixed(0);

            calcularTotales();
        }, true);

          </script>
@endsection
