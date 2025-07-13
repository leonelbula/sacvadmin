@extends('layouts.master')

@section('content')
    <div class="row">

        <div class="col-12">
            <div class="card">

                <div class="card-header">

                    <ul class="nav nav-pills">
                        <li class="nav-item"><a href="{{ route('shopping.index') }}" type="button"
                                class="btn btn-block btn-primary">Volver</a></li>
                    </ul>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <h4>Editar Compra #{{ $shopping->id }}</h4>

                    <form action="{{ route('shopping.update', $shopping->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Proveedor</label>
                                <select class="form-select select2" name="supplier_id" required>
                                    <option value="">Seleccione proveedor</option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}"
                                            {{ $supplier->id == $shopping->supplier_id ? 'selected' : '' }}>
                                            {{ $supplier->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Número de Factura</label>
                                <input type="text" name="invoice_number" class="form-control"
                                    value="{{ $shopping->invoice_number }}" required>
                            </div>
                            <div class="col-md-4">
                                <label for="due_date" class="form-label">Fecha de Factura</label>
                                <input type="date" name="purchase_date" class="form-control"
                                    value="{{ $shopping->shopping_date }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label">Tipo de Compra</label>
                                <select name="purchase_type" class="form-select" onchange="toggleDueDate(this.value)">
                                    <option value="counted" {{ $shopping->purchase_type === 'counted' ? 'selected' : '' }}>
                                        Contado
                                    </option>
                                    <option value="credit" {{ $shopping->purchase_type === 'credit' ? 'selected' : '' }}>
                                        Crédito
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3" id="due_date_div"
                            style="{{ $shopping->purchase_type === 'credito' ? '' : 'display: none;' }}">
                            <div class="col-md-4">
                                <label class="form-label">Fecha de Vencimiento</label>
                                <input type="date" name="due_date" class="form-control"
                                    value="{{ $shopping->due_date }}">
                            </div>
                        </div>

                        <hr>

                        <h5>Productos</h5>
                        <table class="table table-bordered" id="products_table">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio</th>
                                    <th>IVA</th>
                                    <th>Subtotal</th>
                                    <th><button type="button" class="btn btn-success btn-sm"
                                            onclick="addProductRow()">+</button></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($shopping->details as $index => $detail)
                                    <tr>
                                        <td>
                                            <select name="products[]" class="form-select select2" required>
                                                <option value="">Seleccione producto</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}" data-price="{{ $product->price }}"
                                                        {{ $detail->product_id == $product->id ? 'selected' : '' }}>
                                                        {{ $product->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td><input type="number" name="quantities[]" class="form-control quantity"
                                                value="{{ $detail->quantity }}" required></td>
                                        <td><input type="number" name="prices[]" class="form-control price"
                                                value="{{ $detail->price }}" step="0.01" required></td>
                                        <td class="text-center">
                                            <input type="checkbox" name="ivas[{{ $index }}]"
                                                class="form-check-input iva_check" {{ $detail->has_iva ? 'checked' : '' }}>
                                        </td>
                                        <td class="subtotal_cell">$0.00</td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm"
                                                onclick="this.closest('tr').remove(); calculateTotals()">-</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="row">
                            <div class="col-md-4 offset-md-8">
                                <div class="mb-2"><strong>Subtotal:</strong> $<span id="subtotal">0</span></div>
                                <div class="mb-2"><strong>IVA:</strong> $<span id="iva_total">0</span></div>
                                <div class="mb-2"><strong>Total:</strong> $<span id="total">0</span></div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Actualizar Compra</button>
                    </form>
                  </div>

                <!-- /.card-body -->
            </div>
        </div>


                <script>
                    const products = @json($products);

                    function toggleDueDate(value) {
                        document.getElementById('due_date_div').style.display = value === 'credito' ? 'block' : 'none';
                    }

                    function addProductRow() {
                        const table = document.querySelector("#products_table tbody");
                        const row = document.createElement("tr");

                        row.innerHTML = `
            <td>
                <select name="products[]" class="form-select select2" required>
                    <option value="">Seleccione producto</option>
                    ${products.map(p => `<option value="${p.id}" data-price="${p.price}">${p.name}</option>`).join('')}
                </select>
            </td>
            <td><input type="number" name="quantities[]" class="form-control quantity" value="1" required></td>
            <td><input type="number" name="prices[]" class="form-control price" value="0" step="0.01" required></td>
            <td class="text-center">
                <input type="checkbox" name="ivas[]" class="form-check-input iva_check" checked>
            </td>
            <td class="subtotal_cell">$0</td>
            <td>
                <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('tr').remove(); calculateTotals()">-</button>
            </td>
        `;

                        table.appendChild(row);
                        $('.select2').select2();
                        row.querySelectorAll('input, select').forEach(e => {
                            e.addEventListener('input', calculateTotals);
                            e.addEventListener('change', calculateTotals);
                        });

                        calculateTotals();
                    }

                    function calculateTotals() {
                        let subtotal = 0;
                        let iva_total = 0;

                        document.querySelectorAll('#products_table tbody tr').forEach(row => {
                            const qty = parseFloat(row.querySelector('.quantity').value) || 0;
                            const price = parseFloat(row.querySelector('.price').value) || 0;
                            const hasIva = row.querySelector('.iva_check').checked;

                            const sub = qty * price;
                            const iva = hasIva ? sub * 0.19 : 0;

                            subtotal += sub;
                            iva_total += iva;

                            row.querySelector('.subtotal_cell').textContent = `$${(sub + iva).toFixed(0)}`;
                        });

                        document.getElementById('subtotal').textContent = subtotal.toFixed(0);
                        document.getElementById('iva_total').textContent = iva_total.toFixed(0);
                        document.getElementById('total').textContent = (subtotal + iva_total).toFixed(0);
                    }

                    document.addEventListener('DOMContentLoaded', function() {
                        $('.select2').select2();
                        calculateTotals();
                    });
                </script>
            @endsection
