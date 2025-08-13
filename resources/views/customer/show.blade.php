@extends('layouts.master')
@section('title')
    {{ $title }}
@endsection
@section('content')
    <div class="row">

        <div class="col-12">
            <div class="card">

                <div class="card-header">

                    <a href="{{ route('customer.index') }}">
                        <button type="button" class="btn btn-primary">Volver</button>
                    </a>
                    <a href="{{ route('customer.edit', $customer) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="{{ route('customer.destroy', $customer) }}" method="post" style="display: inline">
                        @method('delete')
                        @csrf
                        <button type="submit" class="btn btn-danger "><i class="bi bi-trash"></i></button>
                    </form>
                    <br><br>
                </div>
                <div class="card-body">
                    <form>
                        <div class="box box-danger">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nombre:</label>
                                            <input type="text" class="form-control" name="full_name"
                                                value="{{ $customer->full_name }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nit - CC:</label>
                                            <input type="text" class="form-control"name="identification_card"
                                                value="{{ $customer->identification_card }}" disabled>

                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Direccion:</label>
                                            <input type="text" class="form-control" name="address"
                                                value="{{ $customer->address }}" disabled>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Departamento:</label>
                                            <input type="text" class="form-control" name="Departament"
                                                value="{{ $customer->Departament->name }}" disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Ciudad:</label>
                                            <input type="text" class="form-control" name="city"
                                                value="{{ $customer->city->name }}" disabled>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Telefono:</label>
                                            <input type="text" class="form-control" name="phone"
                                                data-inputmask='"mask": "(999) 999-9999"' value="{{ $customer->phone }}"
                                                data-mask disabled>

                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Email:</label>
                                            <input type="text" class="form-control" name="email"
                                                value="{{ $customer->email }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Cupo de credito:</label>
                                            <input type="number" class="form-control" name="credit_amount"
                                                value="{{ $customer->credit_amount }}" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    @endsection
