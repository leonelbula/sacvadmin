@extends('layouts.master')
@section('subtitle')
    Editar producto
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

                    <form action="{{ route('product.update', $product) }}" method="POST">
                        @method('put')
                        @csrf

                        <div class="row mb-3">
                            <div class="col-4">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="code" id="codigo"
                                        value="{{ $product->code }}" @if ($automatic_product) disabled @endif
                                        placeholder="Codigo">
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="name" id="nameProduct"
                                        value="{{ $product->name }}" required placeholder="Nombre del Producto">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-2">
                                <div class="form-group">
                                    <input type="number" class="form-control costo" name="cost" id="cost"
                                        value="{{ $product->cost }}" placeholder="Costo">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <input type="number" class="form-control Utilidad" name="utility"
                                        value="{{ $product->utility }}" id="utility" required placeholder="Utilidad %">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <input type="hidden" value="{{ $product->tax_value }}" name="tax_value" id="value_tax">
                                    <input type="text" class="form-control Utilidad" value="{{ $product->tax_value }}"
                                        id="tax_value" required placeholder="Iva %" readonly>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <input type="number" class="form-control Precioventa" name="price"
                                        value="{{ $product->price }}" id="price" placeholder="Precio Venta">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <select class="form-control seleccionarCategoria" name="taxes_id" id="taxes_id"
                                        required>
                                        <option value="">Selecione un Impuesto</option>
                                        @foreach ($taxes as $tax)
                                            <option value="{{ $tax->id }}"
                                                {{ $tax->id == $product->taxes_id ? 'selected' : '' }}
                                                data-tax_value="{{ $tax->value }}">
                                                {{ $tax->description }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                        <hr>
                        <div class="row mb-2">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="Categoria">Categoria :</label>

                                    <select class="form-control seleccionarCategoria" name="category_id" required>
                                        <option >Selecione una Categoria</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }} "
                                                {{$product->category_id ==  $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <label for="amount">Cantidad:</label>
                                    <input type="number" class="form-control" name="amount" id="amount"
                                        value="{{ $product->amount }}">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <label for="minimum_amount">Stop Minimo:</label>
                                    <input type="number" class="form-control" name="minimum_amount"
                                        value="{{ $product->minimum_amount }}" id="minimum_amount" required>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="Categoria">Tipor de producto :</label>

                                    <select class="form-control" name="product_type_id" required>
                                        <option>Tipo de Producto</option>
                                        @foreach ($productTypes as $productType)
                                            <option value="{{ $productType->id }}"
                                                {{ $product->product_type_id == $productType->id ? 'selected' : '' }}>
                                                {{ $productType->name }}</option>
                                        @endforeach



                                    </select>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <label for="Categoria">Activar :</label>

                                    <select class="form-control" name="state" required>
                                        <option value="1" {{$product->state == true ? 'selected':''}}>Activo</option>
                                        <option value="0" {{$product->state == false ? 'selected':''}}>Desactivado</option>

                                    </select>
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
