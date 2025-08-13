@extends('layouts.master')
@section('subtitle')
    Producto Detalles
@endsection
@section('content')
    <div class="row">

        <div class="col-12">
            <div class="card">

                <div class="card-header">


                    <a href="{{ route('product.index') }}" type="button" class="btn btn-block btn-success">Volver</a>
                    <a href="{{ route('product.create') }}" type="button" class="btn btn-block btn-primary">Nuevo producto</a>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="card" style="width: 50rem;">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Detalles Producto</li>
                              <li class="list-group-item">
                                <h4>Codigo: {{ $product->code }} </h4>
                            </li>
                            <li class="list-group-item">
                                <h4>Costo: {{ $product->cost }}</h4>
                            </li>
                             <li class="list-group-item">
                                <h4>Nombre: {{ $product->name }}</h4>
                            </li>
                             <li class="list-group-item">
                                <h4>Precio: {{ $product->price }}</h4>
                            </li>
                             <li class="list-group-item">
                                <h4>Utilidad: {{ $product->utility }} %</h4>
                            </li>
                             <li class="list-group-item">
                                <h4>Categoria: {{ $product->category->name }}</h4>
                            </li>
                             <li class="list-group-item">
                                <h4>Impuesto: {{ $product->tax_value }} %</h4>
                            </li>
                             <li class="list-group-item">
                                <h4>Cantidad: {{ $product->amount }} </h4>
                            </li>
                             <li class="list-group-item">
                                <h4>Cantidad Minima: {{ $product->minimum_amount }} </h4>
                            </li>

                            <li class="list-group-item">
                                @if ($product->state == true)
                                    <button type="button" class="btn btn-sm btn-success">Activa</button>
                                @else
                                    <button type="button" class="btn btn-sm btn-warning">Desactivada</button>
                                @endif

                            </li>
                            <li class="list-group-item">
                                <a href="{{ route('product.edit', $product) }}" class="btn btn-warning ">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('product.destroy', $product) }}" method="post"
                                    style="display: inline">
                                    @method('delete')
                                    @csrf
                                    <button type="submit" class="btn btn-danger "> <i class="bi bi-trash3"></i></button>
                                </form>
                                <br>
                            </li>
                        </ul>
                    </div>

                </div>
                <!-- /.card-body -->
            </div>
        </div>
    @endsection
