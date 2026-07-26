@extends('layouts.app')

@section('title', 'Productos')

@section('content')


    <div class="container py-4 mt-4">

        <div class="card shadow-lg border-0 rounded-4">

            <div class="card-header bg-primary text-white rounded-top-4">
                <h4 class="mb-0">
                    <i class="bi bi-box-seam me-2"></i>
                    Nuevo Producto
                </h4>
            </div>

            <div class="card-body p-4">

                <form>

                    <div class="row g-4">

                        <!-- Código -->
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">
                                Código
                            </label>

                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-upc-scan"></i>
                                </span>

                                <input type="text" class="form-control" placeholder="Código del producto"
                                    value="{{ old('code') }}" @if ($automatic_product != 1) disabled @endif>
                            </div>
                        </div>

                        <!-- Nombre -->
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">
                                Nombre
                            </label>

                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-box"></i>
                                </span>

                                <input type="text" class="form-control" name="name" id="nameProduct"
                                    value="{{ old('name') }}" placeholder="Nombre del producto">
                            </div>
                        </div>

                        <!-- Costo -->
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">
                                Costo
                            </label>

                            <div class="input-group">
                                <span class="input-group-text">$</span>

                                <input type="number" class="form-control costo" name="cost"
                                    id="cost"
                                value="{{ old('cost') }}" placeholder="0">
                            </div>
                        </div>

                        <!-- Precio -->
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">
                                Precio
                            </label>

                            <div class="input-group">
                                <span class="input-group-text">$</span>

                                <input type="number" class="form-control Precioventa" name="price"
                                    value="{{ old('price') }}" id="price" placeholder="0">
                            </div>
                        </div>

                        <!-- Utilidad -->
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">
                                Utilidad (%)
                            </label>

                            <div class="input-group">
                                <input type="number" name="utility" id="utility" value="{{ old('utility') }}"
                                    class="form-control Utilidad" readonly>

                                <span class="input-group-text">
                                    %
                                </span>
                            </div>
                        </div>

                        <!-- Categoría -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Categoría
                            </label>

                            <select class="form-select seleccionarCategoria " name="category_id" required>
                                <option selected>
                                    Seleccione una categoría
                                </option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Stock mínimo -->
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">
                                Stock Mínimo
                            </label>

                            <input type="number" class="form-control" name="minimum_amount" value="0"
                                id="minimum_amount" required value="1">
                        </div>

                        <!-- Stock -->
                        <div class="col-md-3">
                            <label class="form-label fw-semibold" name="amount" id="amount" value="0"
                                {{ Auth::user()->type == 'ingreso' ? 'readonly' : '' }}>
                                Stock Actual
                            </label>

                            <input type="number" class="form-control">
                        </div>

                        <!-- Estado -->
                        <div class="col-md-12">

                            <div class="form-check form-switch fs-5">

                                <input class="form-check-input" type="checkbox" checked name="state" required>

                                <label class="form-check-label fw-semibold">
                                    Producto Activo
                                </label>

                            </div>

                        </div>

                    </div>

                </form>

            </div>

            <div class="card-footer bg-white">

                <div class="d-flex justify-content-end gap-2">

                    <button class="btn btn-outline-secondary px-4">
                        <i class="bi bi-x-circle"></i>
                        Cancelar
                    </button>

                    <button class="btn btn-primary px-4">

                        <i class="bi bi-check-circle"></i>

                        Guardar Producto

                    </button>

                </div>

            </div>

        </div>

    </div>


  
    @endsection
    @section('script')
        <script src="{{ asset('js/products.js') }}"></script>
    @endsection
