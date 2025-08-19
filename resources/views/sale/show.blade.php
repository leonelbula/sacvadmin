@extends('layouts.master')

@section('content')
    <div class="container mt-2">

        <h4>Ver Factura Venta</h4>

        <form method="POST" action="{{ route('sale.update', $sale->id) }}">
            @csrf
            @method('PUT')

            {{-- ================= CLIENTE ================= --}}
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between">
                    <span>Datos del Cliente</span>

                    <a href="{{ route('sale.index') }}" class="btn btn-sm btn-primary">
                        Volver
                    </a>
                </div>
                <div class="card-body ">
                    <div class="row">
                        <input type="hidden" name="customer_id" id="customer_id" value="{{ $sale->customer->id }}">
                        <div class="col-md-3">
                            <label>Nombre:</label>
                            <input type="text" class="form-control" id="customer_name"
                                value="{{ $sale->customer->full_name }}" readonly>
                        </div>
                        <div class="col-md-3">
                            <label>Identificación:</label>
                            <input type="text" class="form-control" id="customer_document"
                                value="{{ $sale->customer->identification_card }}" readonly>
                        </div>
                        <div class="col-md-3">
                            <label>Ciudad:</label>
                            <input type="text" class="form-control" id="customer_city"
                                value="{{ $sale->customer->city->name }}" readonly>
                        </div>
                        <div class="col-md-3">
                            <label>Fecha:</label>
                            <input type="date" class="form-control" id="date_sale" name="date_sale"
                                value="{{ $sale->date_sale }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <label>Direccion:</label>
                            <input type="text" class="form-control" id="customer_address"
                                value="{{ $sale->customer->address }}" readonly>
                        </div>
                        <div class="col-md-3">
                            <label>Forma de Pago</label>
                            <select name="payment_form" class="form-control" onchange="toggleOpcionPay(this.value)"
                                disabled>
                                <option value="counted" {{ $sale->payment_form == 'counted' ? 'selected' : '' }}>Contado
                                </option>
                                <option value="credit" {{ $sale->payment_form == 'credit' ? 'selected' : '' }}>Crédito
                                </option>
                            </select>
                        </div>
                        <div class="col-md-3" id="payment_method_div"
                            style="display: {{ $sale->payment_form == 'counted' ? 'block' : 'none' }};">
                            <label>Medio de Pago</label>
                            <select name="payment_method" class="form-control" disabled>
                                <option value="">Seleccione una opción</option>
                                @foreach ($payments as $pay)
                                    <option value="{{ $pay->id }}"
                                        {{ $sale->payment_method == $pay->id ? 'selected' : '' }}>{{ $pay->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3" id="due_plazo_div"
                            style="display: {{ $sale->payment_form == 'credit' ? 'block' : 'none' }};">
                            <label>Plazo en días</label>
                            <input type="number" name="plazo" class="form-control" value="{{ $sale->plazo }}" readonly>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================= PRODUCTOS ================= --}}
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between">
                    <span>Productos</span>
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
                            value="{{ $sale->subtotal }}" readonly>
                        <label>IVA:</label>
                        <input type="text" class="form-control" id="iva" name="iva"
                            value="{{ $sale->iva }}" readonly>
                        <label>Total:</label>
                        <input type="hidden" name="costs" id="costs" value="{{ $sale->costs }}">
                        <input type="text" class="form-control" id="total" name="total"
                            value="{{ $sale->total }}" readonly>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        window.productos = @json($lineItems);
    </script>


    <script>
        window.productos = window.productos || []; // si viene vacío desde create, será []

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
                        <input type="number" class="form-control cantidad-input" readonly data-index="${index}" name="quantities[]" value="${p.quantity}" min="1">
                    </td>
                    <td>
                        <input type="number" class="form-control precio-input" readonly data-index="${index}" name="prices[]" value="${p.price}">
                    </td>
                    <td>${p.tax ?? p.iva ?? 0}%</td>
                    <td>${(sub).toFixed(0)}</td>
                    <td>

                    </td>
                </tr>
            `);
            });


        }



        // Inicial
        document.addEventListener('DOMContentLoaded', renderProductos);
    </script>
@endsection
