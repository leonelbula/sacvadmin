@extends('layouts.app')
@section('title')
    {{ $title }}
@endsection
@section('content')
    <div class="card-header">
        <h4>Lista de Clientes</h4>
    </div>
    </dr>
    <div class="card-body">
        <a href="{{ route('home') }}">
            <button type="button" class="btn btn-primary">Volver</button>
        </a>
        <a href="{{ route('cliente.create') }}">
            <button type="button" class="btn btn-primary">Nuevo cliente</button>
        </a>
        <br>
        <br>
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
                        <td>{{ $customer->city }}</td>
                        <td>{{ $customer->department }}</td>
                        <td>
                            <a href="{{ route('cliente.show', $customer) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('cliente.edit', $customer) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <form action="{{ route('cliente.destroy', $customer) }}" method="post"
                                style="display: inline">
                                @method('delete')
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
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
@endsection
