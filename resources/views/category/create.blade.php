@extends('layouts.master')
@section('subtitle')
    Categorias Crear
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
                <form action="{{route('category.store')}}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="col-7">


                            <div class="form-group">
                                <label for="exampleInputEmail1">Nombre de la categoria</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Nombre">
                            </div>

                            <div class="form-group">
                                <label>Activar</label>
                                <select class="form-control" name="state">
                                    <option value="active">Si</option>
                                    <option value="disable">No</option>

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
