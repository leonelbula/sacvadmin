@extends('layouts.master')
@section('subtitle')
    Nuevo Proveedor
@endsection
@section('content')
    <div class="row">

        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <a href="{{ route('supplier.index') }}">
                        <button type="button" class="btn btn-primary">Volver</button>
                    </a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ route('supplier.store') }}" method="POST">
                        @csrf
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>
                                            Nombre o Rason social:
                                        </label>
                                        <input type="text" class="form-control" name="full_name"
                                            value="{{ old('full_name') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nit - CC:</label>
                                        <input type="text" class="form-control"name="identification_card"
                                            value="{{ old('identification_card') }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Direccion:</label>
                                        <input type="text" class="form-control" name="address"
                                            value="{{ old('address') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Departamento:</label>
                                        <input type="text" class="form-control" name="Departament"
                                            value="{{ old('Departament') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Ciudad:</label>
                                        <input type="text" class="form-control" name="city"
                                            value="{{ old('city') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Telefono:</label>
                                        <input type="text" class="form-control" name="phone"
                                            data-inputmask='"mask": "(999) 999-9999"' value="{{ old('phone') }}" data-mask>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email:</label>
                                        <input type="text" class="form-control" name="email"
                                            value="{{ old('email') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Cupo de credito:</label>
                                        <input type="number" class="form-control" name="credit_amount"
                                            value="{{ old('credit_amount') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Descripcion:</label>
                                <textarea class="form-control" rows="3" name="description" placeholder="Descripcion ..."></textarea>
                            </div>
                            <br>
                            <div class="form-group">
                                <button class="btn btn-primary" type="submit"> Guardar</button>
                            </div>

                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    @endsection
