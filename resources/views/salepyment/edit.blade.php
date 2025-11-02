@extends('layouts.master')
@section('subtitle')
    Cliente Editar
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
                    <form action="{{ route('customer.update', $customer) }}" method="POST">
                        @method('put')
                        @csrf


                         <div class="box box-danger">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col md-6">
                                        <div class="form-group">
                                            <label>Nombre:</label>
                                            <input type="text" class="form-control" name="full_name" value="{{$customer->full_name}}" required>
                                        </div>


                                    </div>
                                    <div class="col md-3">
                                        <div class="form-group">
                                            <label>Tipo de Documento</label>
                                            <select class="form-control " name="identity_document_id"
                                                required>
                                                <option value="">Selecione una opcion</option>
                                                @foreach ($typeDocuments as $type)
                                                    <option value="{{ $type->id }}" {{$customer->identity_document_id == $type->id ? 'selected':''}}>{{ $type->name }}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col md-3">
                                        <div class="form-group">
                                            <label>Nit - CC:</label>
                                            <input type="text" class="form-control"name="identification_card" value="{{$customer->identification_card}}" required>

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col md-6">
                                        <div class="form-group">
                                            <label>Direccion:</label>
                                            <input type="text" class="form-control" name="address" value="{{$customer->address}}" required>

                                        </div>

                                    </div>
                                    <div class="col md-3">
                                        <div class="form-group">
                                            <label>Departamento:</label>
                                            <select class="form-control " name="departament_id"
                                                required>
                                                <option value="">Seleccione un Departamento</option>
                                                @foreach ($departaments as $departament)
                                                    <option value="{{ $departament->id }}" {{$customer->departament_id == $departament->id ? 'selected':''}}>{{ $departament->name }}</option>
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
                                                    <option value="{{ $city->id }}" {{$customer->city_id == $city->id ?'selected':''}}>{{ $city->name }}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col md-4">
                                        <div class="form-group">
                                            <label>Telefono:</label>
                                            <input type="text" class="form-control" name="phone" value="{{$customer->phone}}" required >

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Email:</label>
                                            <input type="text" class="form-control" name="email" value="{{$customer->email}}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">

                                        <div class="form-group">
                                            <label>Cupo de credito:</label>
                                            <input type="number" class="form-control" name="credit_amount" step="1" value="{{$customer->credit_amount}}">
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
                                                    <option value="{{ $tribute->id }}" {{$customer->customer_tribute_id == $tribute->id ?'selected':''}}>{{ $tribute->name }}</option>
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
                                                    <option value="{{ $type->id }}" {{$customer->type_organice_id == $type->id ? 'selected':''}}>{{ $type->name }}</option>
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
                                                    <option value="{{ $tax->id }}" {{$customer->tax_id == $tax->id ? 'selected':''}}>{{ $tax->name }}</option>
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
