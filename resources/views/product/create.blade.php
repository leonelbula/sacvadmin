@extends('layouts.master')
@section('subtitle')
    Categorias Crear
@endsection
@section('content')
    <div class="row">

        <div class="col-12">
            <div class="card">

                <div class="card-header">

                    <ul class="nav nav-pills">
                        <li class="nav-item"><a href="{{ route('product.index') }}" type="button"
                                class="btn btn-block btn-primary">Volver</a></li>
                    </ul>
                </div>

                <!-- /.card-header -->
                <div class="card-body">

                    <form action="{{ route('product.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="codigo">Codigo:</label>
                                    <input type="text" class="form-control" name="code" id="codigo"
                                        value="{{ old('code') }}"

                                        @if ($automatic_product)
                                            disabled
                                        @endif
                                        >
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="costo">Costo:</label>
                                    <input type="number" class="form-control costo" name="cost" id="cost"
                                        value="{{ old('cost') }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nombre">Nombre:</label>
                            <input type="text" class="form-control" name="name" id="nameProduct"
                                value="{{ old('name') }}" required>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="price">Precio venta:</label>
                                    <input type="number" class="form-control Precioventa" name="price"
                                        value="{{ old('price') }}" id="price">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="utility">% de Utilidad:</label>
                                    <input type="number" class="form-control Utilidad" name="utility"
                                        value="{{ old('utility') }}" id="utility" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="Categoria">Categoria :</label>

                                    <select class="form-control seleccionarCategoria" name="category_id" required>
                                        <option value="">Selecione una Categoria</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="minimum_amount">Stop Minimo:</label>
                                    <input type="number" class="form-control" name="minimum_amount" value="0"
                                        id="minimum_amount" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="amount">Cantidad:</label>
                                    <input type="number" class="form-control" name="amount" id="amount" value="0">
                                </div>
                            </div>
                            <div class="col-6">

                            </div>
                            <div class="col-6">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="state" id="state"> Activar
                                    </label>
                                </div>
                            </div>

                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>

                    </form>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    @endsection
    @section('script')
        <script src="{{ asset('js/products.js') }}"></script>
    @endsection
