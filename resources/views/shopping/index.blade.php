@extends('layouts.master')
@section('subtitle')
    Lista de Compras
@endsection
@section('content')
    <div class="row">

        <div class="col-12">
            <div class="card">

                <div class="card-header">

                    <ul class="nav nav-pills">
                        <li class="nav-item"><a href="{{ route('shopping.create') }}" type="button"
                                class="btn btn-block btn-primary">Nueva compra</a></li>
                    </ul>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                    <table id="tablecategories" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Codigo</th>
                                <th>Proveedor</th>
                                <th>fecha</th>
                                <th>valor</th>
                                <th>tipo</th>
                                <th>saldo</th>
                                <th>Accion</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($shopping as $shopp)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $shopp->invoice_number }}</td>
                                    <td>{{ $shopp->supplier->full_name }}</td>
                                    <td>{{ $shopp->created_at }}</td>
                                    <td>{{ $shopp->total }}</td>
                                    <td>
                                        @if ($shopp->purchase_type == 'counted')
                                            <button type="button" class="btn btn-sm btn-success btn-sm">Contado</button>
                                        @else
                                            <button type="button" class="btn btn-warning btn-sm">Credito</button>
                                        @endif

                                    </td>
                                    <td>{{ $shopp->balance }}</td>

                                    <td>
                                        <div class="btn-group">

                                            <a href="{{ route('shopping.show', $shopp) }}" class="btn btn-primary ">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('shopping.edit', $shopp) }}" class="btn btn-warning ">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('shopping.destroy', $shopp) }}" method="post"
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
                        {{ $shopping->links() }}
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    @endsection
