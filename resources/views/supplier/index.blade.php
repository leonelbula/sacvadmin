@extends('layouts.master')
@section('subtitle')
    Lista de Productos
@endsection
@section('content')
    <div class="row">

        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <a href="{{ route('dashboard') }}">
                        <button type="button" class="btn btn-primary">Volver</button>
                    </a>
                    <a href="{{ route('supplier.create') }}">
                        <button type="button" class="btn btn-primary">Nuevo Proveedor</button>
                    </a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="" class="table table-bordered table-striped">
                        <tr>
                            <th style="width:10px">Codigo</th>
                            <th>Razon Social o Nombre</th>
                            <th>Nit</th>
                            <th>Telefono</th>
                            <th>Ciudad</th>
                            <th>Departamento</th>
                            <th>Acciones</th>
                        </tr>
                        <tbody>
                            @foreach ($suppliers as $supplier)
                                <tr>
                                    <td>{{ $supplier->id }}</td>
                                    <td>{{ $supplier->full_name }}</td>
                                    <td>{{ $supplier->identification_card }}</td>
                                    <td>{{ $supplier->phone }}</td>
                                    <td>{{ $supplier->city }}</td>
                                    <td>{{ $supplier->Departament }}</td>
                                    <td>
                                        <div class="btn-group">
                                             <a href="{{ route('supplier.show', $supplier) }}" class="btn btn-primary ">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('supplier.edit', $supplier) }}" class="btn btn-warning ">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('supplier.destroy', $supplier) }}" method="post"
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
                        {{ $suppliers->links() }}
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    @endsection
