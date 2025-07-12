@extends('layouts.app')
@section('title'){{ $title }} @endsection
@section('content')
<div class="card-header">
   <h4>Nuevo Clientes</h4>
</div>
<div class="card-body">
   <a href="{{route('cliente.index')}}">
      <button type="button" class="btn btn-primary">Volver</button>
   </a>
   <br><br>
   <form action="{{ route('cliente.store') }}" method="POST">
      @csrf
      <div class="col-md-6">


         <div class="box-body">
            <div class="form-group">
               <label>Nombre:</label>
               <input type="text" class="form-control" name="full_name" value="{{ old('full_name') }}" required>
            </div>

            <div class="form-group">
               <label>Nit - CC:</label>
               <input type="text" class="form-control" name="identification_card" value="{{old('identification_card')}}" required>
            </div>

            <div class="form-group">
               <label>Direccion:</label>
               <input type="text" class="form-control" name="address" value="{{old('address')}}" required>
            </div>
            <div class="form-group">
               <label>Departamento:</label>
               <input type="text" class="form-control" name="department" value="{{old('department')}}">
            </div>
            <div class="form-group">
               <label>Ciudad:</label>

               <div class="input-group">
                  <input type="text" class="form-control" name="city" value="{{old('city')}}" required>
               </div>
               <div class="form-group">
                  <label>Telefono:</label>

                  <div class="input-group">
                     <input type="text" class="form-control" name="phone" data-inputmask='"mask": "(999) 999-9999"' value="{{old('phone')}}" data-mask>

                  </div>

                  <div class="form-group">
                     <label>Email:</label>

                     <input type="text" class="form-control" name="email" value="{{old('email')}}">

                  </div>
                  <div class="form-group">
                     <label>Cupo de credito:</label>
                        <input type="number" class="form-control" name="credit_amount" value="{{old('credit_amount')}}">
                  </div>

               </div>
               <button class="btn btn-primary" type="submit">

                  Guardar

               </button>

            </div>


   </form>
</div>
@endsection
