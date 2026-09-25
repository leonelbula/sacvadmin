@extends('layouts.app')
@section('content')

    <div class="container-fluid px-4 py-4 mt-4">

        {{-- Encabezado --}}
        <div class="d-flex flex-column flex-md-row justify-content-between
                align-items-md-center gap-3 mb-4">

            <div>

                <div class="d-flex align-items-center gap-2 mb-1">

                    <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-2">
                        <i class="bi bi-truck fs-4"></i>
                    </div>

                    <div>
                        <h4 class="fw-bold mb-0">Nuevo proveedor</h4>

                        <small class="text-muted">
                            Registra la información del proveedor
                        </small>
                    </div>

                </div>

            </div>

            <a href="{{ route('supplier.index') }}" class="btn btn-light border">

                <i class="bi bi-arrow-left me-1"></i>
                Volver
            </a>

        </div>


        {{-- Errores --}}
        @if ($errors->any())
            <div class="alert alert-danger border-0 shadow-sm">

                <div class="d-flex">

                    <i class="bi bi-exclamation-triangle-fill fs-5 me-2"></i>

                    <div>

                        <strong>Revisa los siguientes campos:</strong>

                        <ul class="mb-0 mt-2">

                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach

                        </ul>

                    </div>

                </div>

            </div>
        @endif


        <form action="{{ route('supplier.store') }}" method="POST">

            @csrf

            @include('supplier._form')

        </form>

    </div>

@endsection
