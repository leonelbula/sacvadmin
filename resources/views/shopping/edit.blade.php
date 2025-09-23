@extends('layouts.master')

@section('content')
    <div class="container mt-2">

        <h4>Editar Factura Compra</h4>

        <form method="POST" action="{{ route('shopping.update', $shopping->id) }}">
            @csrf
            @method('PUT')

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
                        <input type="hidden" name="supplier_id" id="supplier_id" value="{{$shopping->supplier->id}}">
                        <div class="col-md-3">
                            <label>Nombre:</label>
                            <input type="text" class="form-control" id="supplier_name" readonly value="{{$shopping->supplier->full_name}}">
                        </div>
                        <div class="col-md-3">
                            <label>Identificación:</label>
                            <input type="text" class="form-control" id="supplier_document" readonly value="{{$shopping->supplier->identification_card}}">
                        </div>
                        <div class="col-md-3">
                            <label>Ciudad:</label>
                            <input type="text" class="form-control" id="supplier_city" readonly value="{{$shopping->supplier->city}}">
                        </div>
                        <div class="col-md-3">
                            <label>Fecha:</label>
                            <input type="date" class="form-control" id="date_sale" name="date_sale"
                                value="{{$shopping->shopping_date }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <label>Direccion:</label>
                            <input type="text" class="form-control" id="supplier_address" readonly  value="{{$shopping->supplier->address }}">
                        </div>
                        <div class="col-md-3">
                            <label>N° Factura:</label>
                            <input type="number" class="form-control" id="invoice_number" name="invoice_number"  value="{{$shopping->invoice_number }}">
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
                        <input type="text" class="form-control" id="subtotal" name="subtotal"
                            value="{{ $shopping->subtotal }}" readonly>
                        <label>IVA:</label>
                        <input type="text" class="form-control" id="iva" name="iva"
                            value="{{ $shopping->iva }}" readonly>
                        <label>Total:</label>
                        <input type="text" class="form-control" id="total" name="total" value="{{ $shopping->total }}"
                            readonly>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Actualizar Factura</button>
        </form>
    </div>

    @include('shopping.modals.suppliers')
    @include('sale.modals.products')




    <script>
        window.productos = @json($lineItems);
    </script>


    <script>
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
                        <td>${producto.cost}</td>
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
                price: parseInt(producto.cost),
                original_price: parseInt(producto.cost),
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
                const sub = (p.cost * p.quantity);
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
                        <input type="number" class="form-control precio-input" data-index="${index}" name="prices[]" value="${p.cost}">
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
                const sub = p.cost * p.quantity;
                const taxPercent = (p.tax ?? p.iva ?? 0);
                const iva = sub * (taxPercent / 100);

                subtotal += sub;
                ivaTotal += iva;

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


                window.productos[index].quantity = cantidad;
                window.productos[index].cost = precio;

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
