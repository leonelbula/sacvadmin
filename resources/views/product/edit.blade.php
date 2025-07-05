@extends('layouts.master')
@section('subtitle')
    Categoria Editar
@endsection
@section('content')
    <div class="row">

        <div class="col-12">
            <div class="card">

                <div class="card-header">

                    <ul class="nav nav-pills">
                        <li class="nav-item"><a href="{{ route('category.index') }}" type="button"
                                class="btn btn-block btn-primary">Volver</a></li>
                    </ul>
                </div>
                <!-- /.card-header -->
                <form action="{{route('category.update', $category)}}" method="POST">
                   @method('put')
                    @csrf
                    <div class="card-body">
                        <div class="col-7">


                            <div class="form-group">
                                <label for="exampleInputEmail1">Nombre de la categoria</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{$category->name}}"
                                    placeholder="Nombre">
                            </div>

                            <div class="form-group">
                                <label>Activar</label>
                                <select class="form-control" name="state" required>
                                    <option value="">Seleciones una opcion</option>
                                    <option value="active" {{$category->state == 'active' ? 'selected' : '' }} >Si</option>
                                    <option value="disable" {{$category->state == 'disable' ? 'selected' : '' }}>No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
                <!-- /.card-body -->
            </div>
        </div>
    @endsection
