@extends('layouts.app')
@section('title'){{ $title }} @endsection
@section('content')

<div class="col-md-6">
    <a href="{{route('plazo.index')}}">
        <button type="button" class="btn btn-primary">Volver</button>
    </a>
    <br>
<form role="form" action="{{route('plazo.update',$term)}}" method="post">
    @method('put')
    @csrf 
    <div class="box-body">
      <div class="form-group">
        <label for="exampleInputEmail1">Descripcion</label>
        <input type="text" class="form-control" name="description" id="description" value="{{ $term->description }}" placeholder="Descripcion del plazo">
      </div>
      @error('description')
    <small>El campo nombre no puede estar vacio</small>
     @enderror
            
     <div class="form-group">
        <label for="exampleInputEmail1">Numero de dias</label>
        <input type="number" class="form-control" name="value" id="value" value="{{$term->value}}"  placeholder="Nombre">
      </div>
      @error('value')
    <small>El campo nombre no puede estar vacio</small>
     @enderror
    </div>
    <!-- /.box-body -->

    <div class="box-footer">
      <button type="submit" class="btn btn-primary">Guardar</button>
    </div>
  </form>
  
</div>
@endsection