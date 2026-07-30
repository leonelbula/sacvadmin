@extends('layouts.app')

@section('content')
    <div class="page-header">

        <div>

            <h2 class="page-title">

                Clientes

            </h2>

            <p class="text-muted">

                Listado de clientes registrados en el sistema

            </p>



        </div>

        <div>
            <a href="{{ route('customer.create') }}" class="btn btn-primary">

                <i class="bi bi-plus-circle"></i>

                Nuevo Cliente
            </a>


        </div>

    </div>

    <div class="dashboard-card">

        <div class="card-header-custom row">


            <div class="align-items-center col-9">
                <form method="GET" action="{{ route('product.index') }}" class="mb-3">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control"
                            placeholder="Buscar por nombre o identificacion..." value="{{$search}}">
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
                        <th>Razon Social o Nombre</th>
                        <th>Nit</th>
                        <th>Ciudad</th>
                        <th>Departamento</th>
                        <th>Accion</th>
                    </tr>

                    </tr>

                </thead>

                <tbody>

                    @php
                        $i = 1;
                    @endphp

                    @foreach ($customers as $customer)
                        <tr>
                            <td>{{ $customer->id }}</td>
                            <td>{{ $customer->full_name }}</td>
                            <td>{{ $customer->identification }}</td>
                            <td>{{ $customer->city }}</td>
                            <td>{{ $customer->department }}</td>
                            <td>
                                <div class="btn-group">


                                    <a href="{{ route('customer.show', $customer) }}" class="btn btn-primary ">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('customer.edit', $customer) }}" class="btn btn-warning ">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('customer.destroy', $customer) }}" method="post"
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
                {{ $customers->links() }}
            </div>
        </div>

    </div>
@endsection
