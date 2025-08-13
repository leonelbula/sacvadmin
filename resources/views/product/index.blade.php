@extends('layouts.master')
@section('subtitle')
    Lista de Productos
@endsection
@section('content')
    <div class="row">

        <div class="col-12">
            <div class="card">

                <div class="card-header">

                    <ul class="nav nav-pills">
                        <li class="nav-item"><a href="{{ route('product.create') }}" type="button"
                                class="btn btn-block btn-primary">Nuevo</a></li>
                    </ul>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <form method="GET" action="{{ route('product.index') }}" class="mb-3">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Buscar por nombre o código..." value="{{ $search }}">
                                    <button type="submit" class="btn btn-primary">Buscar</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-3">
                            <a href="{{ route('product.index') }}" type="button"
                                class="btn btn-block btn-primary">Mostrar todos</a>

                        </div>
                    </div>



                    <table id="tablecategories" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Codigo</th>
                                <th>Nombre</th>
                                <th>Costo</th>
                                <th>Precio</th>
                                <th>Categoria</th>
                                <th>Cantidad</th>
                                <th>Estado</th>
                                <th>Accion</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $product->code }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->cost }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->category->name }}</td>
                                    <td>{{ $product->amount }}</td>
                                    <td>
                                        @if ($product->state == 1)
                                            <button type="button" class="btn btn-sm btn-success btn-sm">Activada</button>
                                        @else
                                            <button type="button" class="btn btn-warning btn-sm">Desactivada</button>
                                        @endif

                                    </td>
                                    <td>
                                        <div class="btn-group">

                                            <a href="{{ route('product.show', $product) }}" class="btn btn-primary ">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('product.edit', $product) }}" class="btn btn-warning ">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('product.destroy', $product) }}" method="post"
                                                style="display: inline">
                                                @method('delete')
                                                @csrf
                                                <button type="submit" class="btn btn-danger "> <i
                                                        class="bi bi-trash3"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach



                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center mt-4">
                        {{ $products->links() }}
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    @endsection
