@extends('layouts.app')

@section('title', 'Productos')

@section('content')
    <div class="page-header">

        <div>

            <h2 class="page-title">

                Productos

            </h2>

            <p class="text-muted">

                Listado de productos registrados en el sistema

            </p>



        </div>

        <div>
            <a href="{{ route('product.create') }}" class="btn btn-primary">

                <i class="bi bi-plus-circle"></i>

                Nuevo Producto
            </a>


        </div>

    </div>

    <div class="dashboard-card">

        <div class="card-header-custom row">


            <div class="align-items-center col-9">
                <form method="GET" action="{{ route('product.index') }}" class="mb-3">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control"
                            placeholder="Buscar por nombre o código..." value="{{ $search }}">
                        <button type="submit" class="btn btn-primary">Buscar</button>
                    </div>
                </form>

            </div>

            <div class="align-items-center col-3 mb-3">
                <a href="{{ route('product.index') }}" type="button" class="btn btn-block btn-primary">Mostrar
                    todos</a>

            </div>

        </div>

        <div class="table-responsive">

            <table class="table sales-table align-middle">

                <thead>

                    <tr>

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
                            <td>{{ $product->stock }}</td>
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

    </div>





@endsection
