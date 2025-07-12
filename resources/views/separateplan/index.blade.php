@extends('layouts.app')
@section('title'){{ $title }} @endsection
@section('content')

<a href="{{route('home')}}">
    <button type="button" class="btn btn-primary">Volver</button>
</a>
<a href="{{ route('plansepare.create') }}">
    <button type="button" class="btn btn-primary">Nuevo Registo</button>
</a>

<table id="tableSparetePlan" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Codigo</th>
            <th>Cliente</th>
            <th>fecha factura</th>
            <th>fecha Vencimiento</th>
            <th>valor</th> 
            <th>acciones</th>							
        </tr>
    </thead>
    <tbody>
      @php
          $i = 1;
      @endphp
      @foreach ($listseparateplan as $plan)
          <tr>
            <td>{{ $i++}}</td>
            <td>{{ $plan->sale_number }}</td>
            <td>{{ $plan->customer->full_name }}</td>
            <td>{{ $plan->date_sale }}</td>
            <td>{{ $plan->expiration_date }}</td>
            <td>{{ $plan->total }}</td>
            <td>
              <div class="btn-group">

                <button class="btn btn-info btnImprimirFactura" codesale="">
                    <i class="fa fa-print"></i>
                </button>
                <button class="btn btn-primary btnverfacturaVenta" idsale="">
                    <i class="fa fa-eye"></i>
                </button>
                <a href="{{ route('venta.edit', $plan) }}">
                  <button type="button" class="btn btn-warning"><i class="fa fa-pencil"></i></button>
                 </a>  
                  <button class="btn btn-danger btnEliminarVenta" idVenta="" > <i class="fa fa-times"></i></button>
                </div>
        
            </td>
          </tr>
      @endforeach
    </tbody>
</table>
@endsection
@section('script')
<script>
    $(function () {
      $('#tableSparetePlan').DataTable({
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