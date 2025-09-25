@extends('layouts.master')
@section('subtitle')
    Detalles
@endsection
@section('content')
    <div class="row">

        <div class="col-12">
            <div class="card">

                <div class="card-header">


                    <a href="{{ route('pos.index') }}" type="button" class="btn btn-block btn-success">Volver</a>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                   reporteinventario

                </div>
                <!-- /.card-body -->
            </div>
        </div>
    @endsection
