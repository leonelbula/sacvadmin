@extends('layouts.master')
@section('subtitle')
    Ajustes Producto
@endsection
@section('content')
    <div class="row">

        <div class="col-12">
            <div class="card">

                <div class="card-header">

                    <a href="{{ route('product.index') }}">
                        <button type="button" class="btn btn-primary">Volver</button>
                    </a>
                     <a href="{{ route('product.create') }}">
                        <button type="button" class="btn btn-primary">Nuevo Producto</button>
                    </a>

                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                        data-bs-target="#productModal">Agregar Producto</button>
                </div>

                <!-- /.card-header -->
                <div class="card-body">

                    <form action="{{ route('product.saveSettings') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <input type="hidden" name="product_id" id="product_id" value="">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="Code">Codigo :</label>
                                    <input type="text" class="form-control code" id="code" value=""
                                        placeholder="Cantidad Actual" disabled>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="form-group">
                                    <label for="Categoria">Nombre del Producto :</label>
                                    <input type="text" class="form-control" name="name" id="nameProduct"
                                        value=""  placeholder="Nombre del Producto" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-2">
                                <div class="form-group">
                                    <label for="Categoria">Cantidad Actutal :</label>
                                    <input type="text" class="form-control " name="amount" id="amount" value=""
                                        placeholder="Cantidad" disabled>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <label for="newAmount">Agregar :</label>
                                    <input type="number" class="form-control newAmount" name="newAmount" min="1"
                                        value="{{ old('newAmount') }}" id="newAmount" required placeholder="Agregar">
                                </div>
                            </div>

                        </div>
                        <hr>


                        <button type="submit" class="btn btn-primary" id="btnSave">Guardar</button>

                    </form>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="productModal" tabindex="-1">
        <div class="modal-dialog modal-lg ">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Buscar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <input type="text" id="searchProductModal" class="form-control mb-3"
                        placeholder="Buscar por nombre o código">

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Producto</th>
                                    <th>Stock</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody id="productTable"></tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const modalElement = document.getElementById('productModal');
            const modalInstance = new bootstrap.Modal(modalElement);

            const searchInput = document.getElementById('searchProductModal');
            const productTable = document.getElementById('productTable');

            searchInput.addEventListener('keyup', () => {

                const query = searchInput.value.trim();

                if (query.length < 2) {
                    productTable.innerHTML = '';
                    return;
                }

                fetch(`/products/search/${encodeURIComponent(query)}`)
                    .then(res => res.json())
                    .then(products => {

                        productTable.innerHTML = '';

                        products.forEach(product => {

                            const row = document.createElement('tr');
                            row.innerHTML = `
                        <td>${product.code}</td>
                        <td>${product.name}</td>
                        <td>${product.amount}</td>
                        <td>
                            <button class="btn btn-sm btn-primary btn-select">
                                Seleccionar
                            </button>
                        </td>
                    `;

                            row.querySelector('.btn-select').addEventListener('click', () => {
                                console.log(product.id);

                                // Llenar formulario principal
                                document.getElementById('code').value = product.code;
                                document.getElementById('nameProduct').value = product
                                    .name;
                                document.getElementById('amount').value = product
                                    .amount;
                                document.getElementById('product_id').value = product
                                    .id;

                                document.getElementById('nameProduct').disabled = false;

                                // Cerrar modal
                                const modal = bootstrap.Modal.getInstance(
                                    document.getElementById('productModal')
                                );

                                if (modal) {
                                    modal.hide();
                                }
                            });

                            productTable.appendChild(row);
                        });
                    });
            });

            // ✅ Limpiar modal al cerrarse
            modalElement.addEventListener('hidden.bs.modal', () => {
                searchInput.value = '';
                productTable.innerHTML = '';
            });

        });
    </script>
@endsection
