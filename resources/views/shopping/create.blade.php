@extends('layouts.master')
@section('subtitle')
    Nueva Compra
@endsection
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
                    <form action="{{ route('shopping.store') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="provider_id" class="form-label">Proveedor</label>
                                <select class="form-select select2" name="supplier_id" required>
                                    <option value="">Seleccione proveedor</option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->full_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="invoice_number" class="form-label">Número de Factura</label>
                                <input type="text" name="invoice_number" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label for="due_date" class="form-label">Fecha de Factura</label>
                                <input type="date" name="purchase_date" class="form-control">
                            </div>

                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="purchase_type" class="form-label">Tipo de Compra</label>
                                <select name="purchase_type" class="form-select" required
                                    onchange="toggleDueDate(this.value)">
                                    <option value="counted">Contado</option>
                                    <option value="credit">Crédito</option>
                                </select>
                            </div>

                            <div class="col-md-4" id="due_date_div" style="display: none;">
                                <label for="due_date" class="form-label">Fecha de Vencimiento</label>
                                <input type="date" name="due_date" class="form-control">
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
                            <tbody></tbody>
                        </table>

                        <div class="row">
                            <div class="col-md-4 offset-md-8">
                                <div class="mb-2">
                                    <strong>Subtotal:</strong> $<span id="subtotal">0</span>
                                </div>
                                <div class="mb-2">
                                    <strong>IVA:</strong> $<span id="iva_total">0</span>
                                </div>
                                <div class="mb-2">
                                    <strong>Total:</strong> $<span id="total">0</span>
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-primary" type="submit">Guardar Compra</button>
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
                let table = document.querySelector("#products_table tbody");
                let row = document.createElement("tr");

                row.innerHTML = `
            <td>
                <select name="products[]" class="form-select select2" required>
                    <option value="">Seleccione producto</option>
                    ${products.map(product => `<option value="${product.id}" data-price="${product.price}">${product.name}</option>`).join('')}
                </select>
            </td>
            <td><input type="number" name="quantities[]" class="form-control quantity" min="1" value="1"></td>
            <td><input type="number" name="prices[]" class="form-control price" min="0" step="0.01"></td>
            <td class="text-center">
                <input type="checkbox" name="ivas[]" class="form-check-input iva_check" checked>
            </td>
            <td class="subtotal_cell">$0</td>
            <td><button type="button" class="btn btn-danger btn-sm" onclick="this.closest('tr').remove(); calculateTotals()">-</button></td>
        `;

                table.appendChild(row);
                $('.select2').select2(); // activa select2 si estás usándolo
                row.querySelectorAll("input, select").forEach(input => {
                    input.addEventListener("input", calculateTotals);
                    input.addEventListener("change", calculateTotals);
                });
            }

            function calculateTotals() {
                let subtotal = 0;
                let iva_total = 0;

                document.querySelectorAll("#products_table tbody tr").forEach(row => {
                    let qty = parseFloat(row.querySelector(".quantity").value) || 0;
                    let price = parseFloat(row.querySelector(".price").value) || 0;
                    let hasIva = row.querySelector(".iva_check").checked;

                    let sub = qty * price;
                    let iva = hasIva ? sub * 0.19 : 0;

                    subtotal += sub;
                    iva_total += iva;

                    row.querySelector(".subtotal_cell").textContent = `$${(sub + iva).toFixed(0)}`;
                });

                document.getElementById("subtotal").textContent = subtotal.toFixed(0);
                document.getElementById("iva_total").textContent = iva_total.toFixed(0);
                document.getElementById("total").textContent = (subtotal + iva_total).toFixed(0);
            }
        </script>
    @endsection
