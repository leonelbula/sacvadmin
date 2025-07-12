@extends('layouts.app')
@section('title'){{ $title }} @endsection
@section('content')
<a href="{{route('home')}}">
    <button type="button" class="btn btn-primary">Volver</button>
</a>
<a href="{{route('plazo.create')}}">
    <button type="button" class="btn btn-primary">Nueva Plazo</button>
</a>

<table id="termsTable" class="table table-bordered table-striped">
    <thead>
    <tr>
      <th>Id</th>
      <th>N° de dias</th>
      <th>Descripcion</th>
      <th>Opciones</th>
    </tr>
    </thead>
    <tbody>
        @foreach($terms as $term)
        <tr>
            <td>{{ $term->id}}</td>
            <td>{{ $term->value}}</td>
            <td>{{ $term->description}}</td>
            <td>
                <a href="{{ route('plazo.edit', $term) }}">
                    <button type="button" class="btn btn-warning">Editar</button>
                </a>
                <form action="{{route('plazo.destroy', $term)}}" method="post">
                    @method('delete')
                    @csrf
                    <input type="submit"  class="btn btn-danger" value="Eliminar">
                </form>

            </td>
        </tr>
        @endforeach

    </tbody>
  </table>
@endsection

@section('script')
<script>
    $(function () {
      $('#termsTable').DataTable({
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