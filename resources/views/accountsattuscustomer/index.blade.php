@extends('layouts.master')
@section('title')
    {{ $title }}
@endsection
@section('content')
    <div class="row">

        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    Estado de Cuenta clientes
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
                                        <a href="{{ route('accountstatecustomer.show', $customer) }}" class="btn btn-info btn-sm">
                                           <i class="bi bi-eye"></i>
                                        </a>
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
