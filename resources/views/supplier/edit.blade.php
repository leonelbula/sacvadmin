@extends('layouts.master')
@section('subtitle')
    Editar Proveedor
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

                    <form action="{{ route('supplier.update', $supplier) }}" method="POST">
                        @method('put')
                        @csrf
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label>Nombre:</label>

                                        <div class="input-group">
                                            <input type="text" class="form-control" name="full_name"
                                                value="{{ $supplier->full_name }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nit - CC:</label>
                                        <div class="input-group">

                                            <input type="text" class="form-control"name="identification_card"
                                                value="{{ $supplier->identification_card }}" required>
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
                                                value="{{ $supplier->address }}" required>
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                </div>
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label>Departamento:</label>

                                        <div class="input-group">
                                            <input type="text" class="form-control" name="department"
                                                value="{{ $supplier->department }}">
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
                                                value="{{ $supplier->city }}" required>
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Telefono:</label>

                                        <div class="input-group">
                                            <input type="text" class="form-control" name="phone"
                                                data-inputmask='"mask": "(999) 999-9999"' value="{{ $supplier->phone }}"
                                                data-mask>
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
                                                value="{{ $supplier->email }}">
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Cupo de credito:</label>

                                        <div class="input-group">
                                            <input type="number" class="form-control" name="credit_amount"
                                                value="{{ $supplier->credit_amount }}">
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
                                    <textarea class="form-control" rows="3" name="description" placeholder="Descripcion ..." required>{{ $supplier->description }}</textarea>
                                </div>
                                <!-- /.input group -->
                            </div>

                        </div>
                        <br>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">

                                Guardar

                            </button>
                        </div>

                </div>


                </form>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
@endsection
