@extends('layouts.app')
@section('title'){{ $title }} @endsection
@section('content')

<a href="{{route('home')}}">
    <button type="button" class="btn btn-primary">Volver</button>
</a>
<a href="{{ route('gasto.create') }}">
    <button type="button" class="btn btn-primary">Nuevo Gasto</button>
</a>

<table id="productTable" class="table table-bordered table-striped">
    <th>#</th>
    <th>Valor</th>
    <th>Descripcion</th>
    <th>Fecha</th>
    <th>Aciones</th>
    <tbody>
        @foreach ($spents as $spent)
            <tr>
                <td>{{ $spent->id }}</td>
                <td>{{ $spent->total }}</td>
                <td>{{ $spent->description }}</td>
                <td>{{ $spent->date_spent }}</td>
                    <td>
                        <div class="btn-group">
                           <a href="{{ route('gasto.edit', $spent)}}">
                              <button class="btn btn-warning ">
                                 <i class="fa fa-pencil"></i>
                              </button>
                           </a>
                           
                            <form action="{{route('gasto.destroy',$spent)}}" method="post">
                                @method('delete')
                                @csrf
                                <button class="btn btn-danger">
                                    <i class="fa fa-times"></i>
                                 </button>
                            </form>
                             
                           </a>
                        </div>
                </td>
            </tr>            
        @endforeach
    </tbody>
</table>
@endsection