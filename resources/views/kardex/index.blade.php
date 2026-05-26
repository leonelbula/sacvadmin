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
                                class="btn btn-block btn-primary">Buscar Por Producto</a></li>
                    </ul>
                </div>
                <!-- /.card-header -->
                <div class="card-body">               



                    <table id="tablecategories" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Codigo</th>
                                <th>date</th>
                                <th>Nombre del producto</th>
                                <th>Costo</th>
                                <th>Operacion</th>
                                <th>Tipo Movimiento</th>
                                 <th>Direfencia </th>
                                <th>Cantidad Anterior</th>
                                <th>Cantidad Actual</th>                             
      
                  
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($all as $data)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $data->id }}</td>
                                    <td>{{ $data->date }}</td>
                                    <td>{{ $data->product->name }}</td>
                                    <td>{{ $data->unit_cost }}</td>
                                    <td>{{ $data->movement_type }}</td>
                                    <td>{{ $data->origin }}</td>
                                    <td>{{ $data->quantity }}</td>
                                    <td>{{ $data->stock_before }}</td>                                    
                                    <td>{{ $data->stock_after }}</td>
                                    
                                </tr>
                            @endforeach



                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center mt-4">
                        {{ $all->links() }}
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    @endsection
