@extends('layouts.master')
@section('title')
    {{ $title }}
@endsection
@section('subtitle')
    Nuevo inicio de ventas
@endsection
@section('content')
    <div class="row">

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('pos.index') }}">
                        <button type="button" class="btn btn-primary">Volver</button>
                    </a>


                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <form method="POST" action="{{ route('pos.store') }}">
                                @csrf

                                {{-- Campo Fecha --}}
                                <div class="mb-4">
                                    <label for="fecha" class="form-label fw-bold">Fecha</label>
                                    <input type="date" id="fecha" name="start_date" class="form-control form-control-lg"
                                        required>
                                </div>

                                {{-- Campo Valor Base de Caja --}}
                                <div class="mb-4">
                                    <label for="valor_base" class="form-label fw-bold">Valor Base de Caja</label>
                                    <input type="number" id="box_base" name="box_base" step="0"
                                        placeholder="Ingrese el valor base" class="form-control form-control-lg" required>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-success btn-lg">
                                        Iniciar Caja
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
