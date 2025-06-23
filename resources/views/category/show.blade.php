@extends('layouts.master')
@section('subtitle')
    Categoria Ver
@endsection
@section('content')
    <div class="row">

        <div class="col-12">
            <div class="card">

                <div class="card-header">


                    <a href="{{ route('category.index') }}" type="button" class="btn btn-block btn-success">Volver</a>
                    <a href="{{ route('category.create') }}" type="button" class="btn btn-block btn-primary">Nueva
                        Categoria</a>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="card" style="width: 18rem;">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Detalles Categoria</li>
                            <li class="list-group-item">
                                <h4>{{ $category->name }}</h4>
                            </li>
                            <li class="list-group-item">
                                @if ($category->state == 'active')
                                    <button type="button" class="btn btn-sm btn-success">Activa</button>
                                @else
                                    <button type="button" class="btn btn-sm btn-warning">Desactivada</button>
                                @endif

                            </li>
                            <li class="list-group-item">
                                <a href="{{ route('category.edit', $category) }}" class="btn btn-warning ">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('category.destroy', $category) }}" method="post"
                                    style="display: inline">
                                    @method('delete')
                                    @csrf
                                    <button type="submit" class="btn btn-danger "> <i class="bi bi-trash3"></i></button>
                                </form>
                                <br>
                            </li>
                        </ul>
                    </div>

                </div>
                <!-- /.card-body -->
            </div>
        </div>
    @endsection
