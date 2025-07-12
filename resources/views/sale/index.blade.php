@extends('layouts.app')
@section('title'){{ $title }} @endsection
@section('subtitle')Lista Venta @endsection
@section('content')
<div class="card-header">
  <a href="{{route('home')}}">
    <button type="button" class="btn btn-primary">Volver</button>
</a>
<a href="{{ route('venta.create') }}">
    <button type="button" class="btn btn-primary">Nueva Venta</button>
</a>
</div>
<div class="card-body">
<table id="tableSales" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Codigo</th>
            <th>Cliente</th>
            <th>fecha factura</th>
            <th>valor</th> 
            <th>Tipo</th>
            <th>acciones</th>							
        </tr>
    </thead>
    <tbody>
      @php
          $i = 1;
      @endphp
      @foreach ($sales as $sale)
          <tr>
            <td>{{ $i++}}</td>
            <td>{{ $sale->sale_number }}</td>
            <td>{{ $sale->customer->full_name }}</td>
            <td>{{ $sale->date_sale }}</td>           
            <td>{{ $sale->total }}</td>
            <td>
              @if($sale->type_sale == '1')
              <button class="btn btn-info btn-xs">
                Credito
              </button>
              @else
                <button class="btn btn-success btn-xs">Contado</button>
             @endif
            </td>
            <td>
              <div class="btn-group">

                <button class="btn btn-info btnImprimirFactura" codesale="">
                    <i class="fa fa-print"></i>
                </button>
                <button class="btn btn-primary btnverfacturaVenta" idsale="">
                    <i class="fa fa-eye"></i>
                </button>
                <a href="{{ route('venta.edit', $sale) }}">
                  <button type="button" class="btn btn-warning"><i class="fa fa-pencil"></i></button>
                 </a>  
                  <button class="btn btn-danger btnEliminarVenta" idVenta="" > <i class="fa fa-times"></i></button>
                </div>
        
            </td>
          </tr>
      @endforeach
    </tbody>
</table>
</div>
@endsection
@section('script')
<script>
    $(function () {
      $('#tableSales').DataTable({
        'paging'      : true,
        'lengthChange': false,
        'searching'   : false,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : false
      })
    })
  </script>
@endsection