@extends('layouts.master')
@section('subtitle')
    DETALLES PROVEEDOR
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


                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label>Nombre:</label>

                                        <div class="input-group">
                                            <input type="text" class="form-control" name="full_name"
                                                value="{{ $supplier->full_name }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nit - CC:</label>
                                        <div class="input-group">

                                            <input type="text" class="form-control"name="identification_card"
                                                value="{{ $supplier->identification_card }}" readonly>
                                        </div>

                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Direccion:</label>

                                        <div class="input-group">

                                            <input type="text" class="form-control" name="address"
                                                value="{{ $supplier->address }}" readonly>
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                </div>
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label>Departamento:</label>

                                        <div class="input-group">
                                            <input type="text" class="form-control" name="Departament"
                                                value="{{ $supplier->Departament }}" readonly>
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Ciudad:</label>

                                        <div class="input-group">
                                            <input type="text" class="form-control" name="city"
                                                value="{{ $supplier->city }}" readonly>
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Telefono:</label>

                                        <div class="input-group">
                                            <input type="text" class="form-control" name="phone"
                                                value="{{ $supplier->phone }}"
                                                readonly>
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label>Email:</label>

                                        <div class="input-group">
                                            <input type="text" class="form-control" name="email"
                                                value="{{ $supplier->email }}" readonly>
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Cupo de credito:</label>

                                        <div class="input-group">
                                            <input type="number" class="form-control" name="credit_amount"
                                                value="{{ $supplier->credit_amount }}" readonly>
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Descripcion:</label>

                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-bookmark-o"></i>
                                    </div>
                                    <textarea class="form-control" rows="3" name="description" placeholder="Descripcion ..." readonly>{{ $supplier->description }}</textarea>
                                </div>
                                <!-- /.input group -->
                            </div>

                        </div>
                        <br>

                </div>



            </div>
            <!-- /.card-body -->
        </div>
    </div>
@endsection
