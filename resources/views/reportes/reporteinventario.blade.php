@extends('layouts.master')
@section('title')
    {{ $title }}
@endsection
@section('subtitle')
    Reportes de Inventario
@endsection
@section('content')
    <div class="row">

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('dashboard') }}">
                        <button type="button" class="btn btn-primary">Volver</button>
                    </a>

                </div>
                <div class="card-body">
<div class="card" style="width: 50rem;">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Detalles Venta :: {{ date('Y-m-d') }}</li>
                            <li class="list-group-item">
                                <h3>Inventario Total: {{  number_format($totalInventario, 0, ',', '.') }}   </h3>
                            </li>


                            <li class="list-group-item">


                                <br>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
