@extends('layouts.master')
@section('subtitle')
    {{ $title }}
@endsection
@section('content')
    <div class="row">

        <div class="col-12">
            <div class="card">

                <div class="card-header">

                    <ul class="nav nav-pills">
                        <li class="nav-item"><a href="{{ route('customer.index') }}" type="button"
                                class="btn btn-block btn-primary">Volver</a></li>
                    </ul>
                </div>

                <div class="card-body">
                    <form action="{{ route('customer.store') }}" method="POST">
                        @csrf

                        <div class="box box-danger">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col md-6">
                                        <div class="form-group">
                                            <label>Nombre:</label>
                                            <input type="text" class="form-control" name="full_name" required>
                                        </div>


                                    </div>
                                    <div class="col md-3">
                                        <div class="form-group">
                                            <label>Tipo de Documento</label>
                                            <select class="form-control " name="identity_document_id"
                                                required>
                                                <option value="">Selecione una opcion</option>
                                                @foreach ($typeDocuments as $type)
                                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col md-3">
                                        <div class="form-group">
                                            <label>Nit - CC:</label>
                                            <input type="text" class="form-control"name="identification_card" required>

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col md-6">
                                        <div class="form-group">
                                            <label>Direccion:</label>
                                            <input type="text" class="form-control" name="address" required>

                                        </div>

                                    </div>
                                    <div class="col md-3">
                                        <div class="form-group">
                                            <label>Departamento:</label>
                                            <select class="form-control " name="departament_id"
                                                required>
                                                <option value="">Seleccione un Departamento</option>
                                                @foreach ($departaments as $departament)
                                                    <option value="{{ $departament->id }}">{{ $departament->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col md-3">
                                        <div class="form-group">
                                            <label>Ciudad:</label>

                                            <select class="form-control " name="city_id" required>
                                                <option value="">Seleccione una opcion</option>
                                                @foreach ($citys as $city)
                                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col md-4">
                                        <div class="form-group">
                                            <label>Telefono:</label>
                                            <input type="text" class="form-control" name="phone"
                                                data-inputmask='"mask": "(999) 999-9999"' data-mask>

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Email:</label>
                                            <input type="text" class="form-control" name="email" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">

                                        <div class="form-group">
                                            <label>Cupo de credito:</label>
                                            <input type="number" class="form-control" name="credit_amount" value="0">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col md-4">
                                        <div class="form-group">
                                            <label>Tipo de contribuyente:</label>
                                            <select class="form-control " name="customer_tribute_id" required>
                                                <option value="">Seleccione una opcion</option>
                                                @foreach ($customerTribute as $tribute)
                                                    <option value="{{ $tribute->id }}">{{ $tribute->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Tipo de Empresa:</label>
                                            <select class="form-control " name="type_organice_id"
                                                required>
                                                <option value="">Seleccione una opcion</option>
                                                @foreach ($organization_types as $type)
                                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-md-4">

                                        <div class="form-group">
                                            <label>Responsable de Impuesto:</label>
                                            <select class="form-control " name="tax_id" required>
                                                <option value="">Seleccione una opcion</option>
                                                @foreach ($taxes as $tax)
                                                    <option value="{{ $tax->id }}">{{ $tax->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <br>
                            <button class="btn btn-primary" type="submit">

                                Guardar

                            </button>
                        </div>
                        <!-- /.box -->

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
