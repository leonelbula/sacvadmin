@extends('layouts.app')
@section('title'){{ $title }} @endsection
@section('content')
<div class="card-header">
  <h4>Editar Clientes</h4>
</div>
</dr>
<div class="card-body">
<a href="{{route('cliente.index')}}">
    <button type="button" class="btn btn-primary">Volver</button>
</a>
<br><br>
<form action="{{ route('cliente.update', $customer) }}" method="POST" >
    @method('put')
   @csrf
   <div class="col-md-6">

      <div class="box box-danger">
         <div class="box-body">
            <div class="form-group">
               <label>Nombre:</label>
                  <input type="text" class="form-control" name="full_name" value="{{ $customer->full_name }}" required>
            </div>

            <div class="form-group">
               <label>Nit - CC:</label>
                <input type="text" class="form-control"name="identification_card"  value="{{$customer->identification_card }}" required>

            </div>

            <div class="form-group">
               <label>Direccion:</label>
                  <input type="text" class="form-control" name="address" value="{{$customer->address}}" required>

            </div>
            <div class="form-group">
               <label>Departamento:</label>
                  <input type="text" class="form-control" name="department"  value="{{$customer->department}}">
            </div>
            <div class="form-group">
               <label>Ciudad:</label>
                  <input type="text" class="form-control" name="city" value="{{$customer->city}}" required>

            </div>
            <div class="form-group">
               <label>Telefono:</label>
                  <input type="text" class="form-control" name="phone" data-inputmask='"mask": "(999) 999-9999"' value="{{$customer->phone}}" data-mask>

            </div>

            <div class="form-group">
               <label>Email:</label>
                  <input type="text" class="form-control" name="email" value="{{$customer->email}}" >
            </div>
            <div class="form-group">
                <label>Cupo de credito:</label>
                   <input type="number" class="form-control" name="credit_amount" value="{{$customer->credit_amount}}" >
             </div>

         </div>
         <button class="btn btn-primary" type="submit">

            Guardar

         </button>
      </div>
      <!-- /.box -->


      <!-- /.box -->

   </div>


</form>
</div>
@endsection
