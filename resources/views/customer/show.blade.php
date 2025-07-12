@extends('layouts.app')
@section('title'){{ $title }} @endsection
@section('content')
<div class="card-header">
  <h4>Detalles Clientes</h4>
</div>
</dr>
<div class="card-body">
<a href="{{route('cliente.index')}}">
    <button type="button" class="btn btn-primary">Volver</button>
</a>
 <a href="{{ route('cliente.edit', $customer) }}" class="btn btn-warning">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <form action="{{ route('cliente.destroy', $customer) }}" method="post"
                                style="display: inline">
                                @method('delete')
                                @csrf
                                <button type="submit" class="btn btn-danger "><i class="fas fa-trash"></i></button>
                            </form>
<br><br>
<form >

   <div class="col-md-6">

      <div class="box box-danger">
         <div class="box-body">
            <div class="form-group">
               <label>Nombre:</label>
                  <input type="text" class="form-control" name="full_name" value="{{ $customer->full_name }}" disabled>
            </div>

            <div class="form-group">
               <label>Nit - CC:</label>
                <input type="text" class="form-control"name="identification_card"  value="{{$customer->identification_card }}" disabled>

            </div>

            <div class="form-group">
               <label>Direccion:</label>
                  <input type="text" class="form-control" name="address" value="{{$customer->address}}" disabled>

            </div>
            <div class="form-group">
               <label>Departamento:</label>
                  <input type="text" class="form-control" name="department"  value="{{$customer->department}}" disabled>
            </div>
            <div class="form-group">
               <label>Ciudad:</label>
                  <input type="text" class="form-control" name="city" value="{{$customer->city}}" disabled>

            </div>
            <div class="form-group">
               <label>Telefono:</label>
                  <input type="text" class="form-control" name="phone" data-inputmask='"mask": "(999) 999-9999"' value="{{$customer->phone}}" data-mask disabled>

            </div>

            <div class="form-group">
               <label>Email:</label>
                  <input type="text" class="form-control" name="email" value="{{$customer->email}}" disabled>
            </div>
            <div class="form-group">
                <label>Cupo de credito:</label>
                   <input type="number" class="form-control" name="credit_amount" value="{{$customer->credit_amount}}"  disabled>
             </div>

         </div>
      </div>
      <!-- /.box -->


      <!-- /.box -->

   </div>


</form>
</div>
@endsection
