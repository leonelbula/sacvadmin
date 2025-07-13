@extends('layouts.master')

@section('content')
<div class="container">
    <h2>Crear Venta</h2>
    <form action="{{ route('sales.store') }}" method="POST">
        @csrf

        {{-- Cliente --}}
        <div class="form-group">
            <label for="client_id">Cliente</label>
            <select name="client_id" class="form-control" required>
                <option value="">Seleccione un cliente</option>
                @foreach ($customers as $cusomers)
                    <option value="{{ $cusomers->id }}">{{ $cusomers->full_name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Tipo de venta --}}
        <div class="form-group">
            <label for="sale_type">Tipo de venta</label>
            <select name="sale_type" class="form-control" id="sale_type" required>
                <option value="contado">Contado</option>
                <option value="credito">Crédito</option>
            </select>
        </div>

        {{-- Fecha de vencimiento (solo para crédito) --}}
        <div class="form-group d-none" id="due_date_group">
            <label for="due_date">Fecha de vencimiento</label>
            <input type="date" name="due_date" class="form-control">
        </div>

        <hr>

        {{-- Productos dinámicos --}}
        <h4>Productos</h4>
        <table class="table table-bordered" id="products_table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Descuento</th>
                    <th>IVA</th>
                    <th>Subtotal</th>
                    <th><button type="button" class="btn btn-sm btn-primary" id="add_row">+</button></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <select name="products[0][product_id]" class="form-control product-select" required>
                            <option value="">Seleccione</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="number" step="0.01" name="products[0][price]" class="form-control price" required></td>
                    <td><input type="number" name="products[0][quantity]" class="form-control quantity" required></td>
                    <td><input type="number" name="products[0][discount]" class="form-control discount" value="0" required></td>
                    <td class="text-center">
                        <input type="checkbox" name="products[0][iva]" class="form-check-input iva">
                    </td>
                    <td><input type="text" class="form-control subtotal" readonly></td>
                    <td><button type="button" class="btn btn-sm btn-danger remove_row">X</button></td>
                </tr>
            </tbody>
        </table>

        {{-- Totales --}}
        <div class="form-group">
            <label>Subtotal:</label>
            <input type="text" name="subtotal" id="subtotal" class="form-control" readonly>
        </div>
        <div class="form-group">
            <label>Total IVA:</label>
            <input type="text" name="total_iva" id="total_iva" class="form-control" readonly>
        </div>
        <div class="form-group">
            <label>Total:</label>
            <input type="text" name="total" id="total" class="form-control" readonly>
        </div>

        <button type="submit" class="btn btn-success">Guardar Venta</button>
    </form>
</div>

<script>
    let rowIdx = 1;

    function calculateTotals() {
        let subtotal = 0;
        let totalIVA = 0;
        $('#products_table tbody tr').each(function() {
            const row = $(this);
            const price = parseFloat(row.find('.price').val()) || 0;
            const quantity = parseFloat(row.find('.quantity').val()) || 0;
            const discount = parseFloat(row.find('.discount').val()) || 0;
            const hasIVA = row.find('.iva').is(':checked');

            let lineTotal = (price * quantity) - discount;
            let iva = hasIVA ? lineTotal * 0.19 : 0;

            row.find('.subtotal').val((lineTotal + iva).toFixed(2));
            subtotal += lineTotal;
            totalIVA += iva;
        });
        $('#subtotal').val(subtotal.toFixed(2));
        $('#total_iva').val(totalIVA.toFixed(2));
        $('#total').val((subtotal + totalIVA).toFixed(2));
    }

    $(document).on('change keyup', '.price, .quantity, .discount, .iva', calculateTotals);

    $(document).on('change', '.product-select', function() {
        const price = $(this).find(':selected').data('price');
        $(this).closest('tr').find('.price').val(price);
        calculateTotals();
    });

    $('#add_row').click(function() {
        const newRow = $('#products_table tbody tr:first').clone();
        newRow.find('input, select').each(function() {
            const name = $(this).attr('name');
            if (name) {
                const newName = name.replace(/\[\d+\]/, `[${rowIdx}]`);
                $(this).attr('name', newName);
            }
            $(this).val('');
            if ($(this).is(':checkbox')) {
                $(this).prop('checked', false);
            }
        });
        newRow.appendTo('#products_table tbody');
        rowIdx++;
    });

    $(document).on('click', '.remove_row', function() {
        if ($('#products_table tbody tr').length > 1) {
            $(this).closest('tr').remove();
            calculateTotals();
        }
    });

    $('#sale_type').change(function() {
        if ($(this).val() === 'credito') {
            $('#due_date_group').removeClass('d-none');
        } else {
            $('#due_date_group').addClass('d-none');
        }
    });

    // Inicial
    calculateTotals();
</script>
@endsection




<script>
    let products = @json($products); // lista de productos con id, name, price
    let rowCount = 0;

    $(document).ready(function () {
        $('.select2').select2();

        $('#add-product').click(function () {
            rowCount++;
            let row = `
                <tr>
                    <td>
                        <select name="products[${rowCount}][product_id]" class="form-control select-product" required>
                            <option value="">Seleccione</option>
                            ${products.map(p => `<option value="${p.id}" data-price="${p.price}">${p.name}</option>`).join('')}
                        </select>
                    </td>
                    <td><input type="number" name="products[${rowCount}][quantity]" class="form-control quantity" min="1" value="1"></td>
                    <td><input type="number" name="products[${rowCount}][price]" class="form-control price" step="0.01" readonly></td>
                    <td><input type="number" name="products[${rowCount}][discount]" class="form-control discount" min="0" max="100" value="0"></td>
                    <td class="text-center">
                        <input type="checkbox" name="products[${rowCount}][iva]" class="form-check-input iva-check">
                    </td>
                    <td><input type="text" class="form-control line-total" readonly></td>
                    <td><button type="button" class="btn btn-danger btn-sm remove-row">X</button></td>
                </tr>
            `;
            $('#product-rows').append(row);
        });

        // Delegar eventos
        $('#product-rows').on('change', '.select-product', function () {
            let price = $(this).find(':selected').data('price') || 0;
            $(this).closest('tr').find('.price').val(price);
            calculateRowTotal($(this).closest('tr'));
        });

        $('#product-rows').on('input change', '.quantity, .discount, .iva-check', function () {
            calculateRowTotal($(this).closest('tr'));
        });

        $('#product-rows').on('click', '.remove-row', function () {
            $(this).closest('tr').remove();
            calculateTotals();
        });

        function calculateRowTotal(row) {
            let quantity = parseFloat(row.find('.quantity').val()) || 0;
            let price = parseFloat(row.find('.price').val()) || 0;
            let discount = parseFloat(row.find('.discount').val()) || 0;
            let ivaChecked = row.find('.iva-check').is(':checked');

            let base = quantity * price;
            let discountAmount = base * (discount / 100);
            let subtotal = base - discountAmount;
            let iva = ivaChecked ? subtotal * 0.19 : 0;
            let total = subtotal + iva;

            row.find('.line-total').val(total.toFixed(2));
            calculateTotals();
        }

        function calculateTotals() {
            let subtotal = 0, totalIva = 0, total = 0;
            $('#product-rows tr').each(function () {
                let row = $(this);
                let quantity = parseFloat(row.find('.quantity').val()) || 0;
                let price = parseFloat(row.find('.price').val()) || 0;
                let discount = parseFloat(row.find('.discount').val()) || 0;
                let ivaChecked = row.find('.iva-check').is(':checked');

                let base = quantity * price;
                let discountAmount = base * (discount / 100);
                let net = base - discountAmount;
                let iva = ivaChecked ? net * 0.19 : 0;

                subtotal += net;
                totalIva += iva;
                total += net + iva;
            });

            $('#subtotal').val(subtotal.toFixed(2));
            $('#total_iva').val(totalIva.toFixed(2));
            $('#total').val(total.toFixed(2));
        }
    });
</script>
@endsection
