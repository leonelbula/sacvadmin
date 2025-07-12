@extends('layouts.app')
@section('title'){{ $title }} @endsection
@section('content')
<?php  date_default_timezone_set('America/Bogota'); ?>

<a href="{{route('home')}}">
    <button type="button" class="btn btn-primary">Volver</button>
</a>
<div class="row">
    <form action="{{route('gasto.update',$spent)}}" method="POST" >
        @method('put')
       @csrf
       <div class="col-md-8">

          <div class="box box-danger">
             <div class="box-header">
                <h3 class="box-title">Informacion de Gasto</h3>
             </div>
             <div class="box-body">
                <div class="col-md-6">
                   <!-- Date dd/mm/yyyy -->

                   <div class="form-group">
                      <label>Fecha del gasto:</label>

                      <div class="input-group">
                         <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                         </div>
                         <input type="date" class="form-control" name="date" value="{{ $spent->date_spent}}" required>
                      </div>
                      <!-- /.input group -->
                   </div>
                </div>


                <div class="form-group">
                   <label>Valor gasto:</label>
                   <div class="input-group">
                      <div class="input-group-addon">
                         <i class="fa fa-tag"></i>
                      </div>
                      <input type="number" class="form-control" name="total" value="{{$spent->total}}" required>
                   </div>
                   <!-- /.input group -->
                </div>
                <!-- /.form group -->

                <!-- phone mask -->
                <div class="form-group">
                   <label>Descripcion:</label>

                   <div class="input-group">
                      <div class="input-group-addon">
                         <i class="fa fa-bookmark-o"></i>
                      </div>
                      <textarea class="form-control" rows="3" name="description" placeholder="Descripcion ..." required>{{ $spent->description }}</textarea>
                   </div>
                   <!-- /.input group -->
                </div>


             </div>
             <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <button class="btn btn-primary" type="submit">

             Guardar 
          </button>
          <!-- /.box -->

       </div>
       <!-- /.col (left) -->

       <!-- /.col (right) -->
    </form>
 </div>

@endsection