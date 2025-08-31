@extends('layouts.master')

@section('content')
    <div class="container mt-2">

        <h4>Ver Factura Venta</h4>

        <form method="POST" action="">
            @csrf
            @method('PUT')

            {{-- ================= CLIENTE ================= --}}
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between">
                    <span>Datos del Cliente</span>

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
                             value="{{$returnsale->reason}}" readonly>
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
                        <input type="text" class="form-control" id="total" name="total"
                            value="{{ $returnsale->total }}" readonly>
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
                </tr>
            `);
            });


        }



        // Inicial
        document.addEventListener('DOMContentLoaded', renderProductos);
    </script>
@endsection
