@extends('layouts.master')
@section('subtitle')
    Categorias
@endsection
@section('content')
    <div class="row">

        <div class="col-12">
            <div class="card">

                <div class="card-header">

                    <ul class="nav nav-pills">
                        <li class="nav-item"><a href="{{ route('category.create') }}" type="button"
                                class="btn btn-block btn-primary">Nueva Categoria</a></li>
                    </ul>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                    <table id="tablecategories" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Estado</th>
                                <th>Accion</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        @if ($category->state == 'active')
                                            <button type="button" class="btn btn-sm btn-success btn-sm">Activada</button>
                                        @else
                                            <button type="button" class="btn btn-warning btn-sm">Desactivada</button>
                                        @endif

                                    </td>
                                    <td>
                                        <div class="btn-group">

                                            <a href="{{ route('category.show', $category) }}" class="btn btn-primary ">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('category.edit', $category) }}" class="btn btn-warning ">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('category.destroy', $category) }}" method="post"
                                                style="display: inline">
                                                @method('delete')
                                                @csrf
                                                <button type="submit" class="btn btn-danger "> <i class="bi bi-trash3"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach



                        </tbody>
                    </table>
                    {{ $categories->links() }}
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    @endsection
