@extends('layouts.app')
@section('title'){{ $title }} @endsection
@section('content')

<a href="{{route('home')}}">
    <button type="button" class="btn btn-primary">Volver</button>
</a>

<table id="stateproductTable" class="table table-bordered table-striped">
    <tr>
        <th style="width:10px">Codigo</th>
        <th>Razon Social o Nombre</th>
        <th>Nit</th> 
        <th>Compras</th>
        <th>Saldo</th> 
        <th>Acciones</th>
     </tr>
    <tbody>
       
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>
              <div class="btn-group">
                <a href="">
                    <button class="btn btn-primary btnverfacturaVenta" idsale="">
                        <i class="fa fa-eye"></i>
                    </button>
                </a>
              </div>
            </td>
            </tr>
            
    </tbody>
</table>
@endsection


@section('script')
<script>
    $(function () {
      $('#statecustomerTable').DataTable({
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