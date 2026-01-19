@extends('layouts.master')
@section('title')
    {{ $title }}
@endsection
@section('content')
    <div class="row">

        <div class="col-12">
            <div class="card">

                <div class="card-header">

                    <ul class="nav nav-pills">
                        <li class="nav-item"><a href="{{ route('customer.create') }}" type="button"
                                class="btn btn-block btn-primary">Nuevo Cliente</a></li>
                    </ul>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="productTable" class="table table-bordered table-striped">
                        <tr>
                            <th style="width:10px">Codigo</th>
                            <th>Razon Social o Nombre</th>
                            <th>Nit</th>
                            <th>Ciudad</th>
                            <th>Departamento</th>
                            <th>Acciones</th>
                        </tr>
                        <tbody>
                            @foreach ($customers as $customer)
                                <tr>
                                    <td>{{ $customer->id }}</td>
                                    <td>{{ $customer->full_name }}</td>
                                    <td>{{ $customer->identification_card }}</td>
                                    <td>{{ $customer->city->name }}</td>
                                    <td>{{ $customer->departament->name }}</td>
                                    <td>
                                        <a href="{{ route('customer.show', $customer) }}" class="btn btn-info btn-sm " >
                                           <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('customer.edit', $customer) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('customer.destroy', $customer) }}" method="post"
                                            style="display: inline">
                                            @method('delete')
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm"><i
                                                    class="bi bi-trash"></i></button>
                                        </form>

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
        </div>
    @endsection
