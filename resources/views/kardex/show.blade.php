@extends('layouts.master')
@section('subtitle')
    Lista de Productos
@endsection
@section('content')
    <div class="row">

        <div class="col-12">
            <div class="card">

                <div class="card-header">

                    <div class="row">
                        <a href="{{ route('product.index') }}" type="button" class="btn btn-block btn-success">Volver</a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">               



                    <table id="tablecategories" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Codigo</th>
                                <th>Fecha</th>
                                <th>Nombre del producto</th>
                                <th>Costo</th>
                                <th>Tipo Movimiento</th>
                                <th>Operacion</th>
                                 <th>Direfencia </th>
                                <th>Cantidad Anterior</th>
                                <th>Cantidad Actual</th>                             
                             
                  
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            {{dd($detail)}}
                            {{die()}}
                            @foreach ($detail as $data)
                           
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $data->date }}</td>
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
                        {{ $detail->links() }}
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    @endsection
