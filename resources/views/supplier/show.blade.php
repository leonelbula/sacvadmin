@extends('layouts.app')

@section('title', 'Detalle del proveedor')

@section('content')

    <div class="container-fluid px-4 py-4 m-5">

        {{-- Encabezado --}}
        <div class="d-flex flex-column flex-md-row justify-content-between
                align-items-md-center gap-3 mb-4">

            <div>
                <div class="d-flex align-items-center gap-2 mb-1">

                    <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-2">
                        <i class="bi bi-truck fs-4"></i>
                    </div>

                    <div>
                        <h4 class="fw-bold mb-0">
                            Detalle del proveedor
                        </h4>

                        <small class="text-muted">
                            Información completa del proveedor
                        </small>
                    </div>

                </div>
            </div>

            <div class="d-flex gap-2">

                <a href="{{ route('supplier.index') }}" class="btn btn-light border">

                    <i class="bi bi-arrow-left me-1"></i>
                    Volver
                </a>

                <a href="{{ route('supplier.edit', $supplier->id) }}" class="btn btn-primary">

                    <i class="bi bi-pencil me-1"></i>
                    Editar
                </a>

            </div>

        </div>


        {{-- Perfil --}}
        <div class="card border-0 shadow-sm mb-4">

            <div class="card-body p-4">

                <div class="row align-items-center">

                    <div class="col-12 col-md-auto mb-3 mb-md-0">

                        <div class="rounded-circle bg-primary bg-opacity-10
                                text-primary d-flex align-items-center
                                justify-content-center"
                            style="width: 90px; height: 90px;">

                            <i class="bi bi-building fs-1"></i>

                        </div>

                    </div>

                    <div class="col">

                        <h3 class="fw-bold mb-1">
                            {{ $supplier->full_name }}
                        </h3>

                        <div class="d-flex flex-wrap gap-2 mt-2">

                            <span class="badge bg-light text-dark border">
                                <i class="bi bi-card-text me-1"></i>
                                {{ $supplier->identification }}
                            </span>

                            @if ($supplier->phone)
                                <span class="badge bg-light text-dark border">
                                    <i class="bi bi-telephone me-1"></i>
                                    {{ $supplier->phone }}
                                </span>
                            @endif

                            @if ($supplier->email)
                                <span class="badge bg-light text-dark border">
                                    <i class="bi bi-envelope me-1"></i>
                                    {{ $supplier->email }}
                                </span>
                            @endif

                        </div>

                    </div>

                    <div class="col-12 col-lg-auto mt-3 mt-lg-0">

                        @if ($supplier->credit_amount > 0)
                            <div class="text-lg-end">

                                <small class="text-muted d-block">
                                    Crédito registrado
                                </small>

                                <span class="fs-4 fw-bold text-danger">
                                    ${{ number_format($supplier->credit_amount, 0, ',', '.') }}
                                </span>

                            </div>
                        @else
                            <div class="text-lg-end">

                                <small class="text-muted d-block">
                                    Crédito
                                </small>

                                <span
                                    class="badge bg-success bg-opacity-10
                                         text-success fs-6">

                                    <i class="bi bi-check-circle me-1"></i>
                                    Sin crédito

                                </span>

                            </div>
                        @endif

                    </div>

                </div>

            </div>

        </div>


        <div class="row g-4">

            {{-- Información personal --}}
            <div class="col-12 col-xl-8">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-header bg-white border-0 p-4">

                        <div class="d-flex align-items-center">

                            <div
                                class="bg-primary bg-opacity-10 text-primary
                                    rounded-3 p-2 me-3">

                                <i class="bi bi-person-vcard fs-5"></i>

                            </div>

                            <div>

                                <h5 class="fw-bold mb-1">
                                    Información general
                                </h5>

                                <small class="text-muted">
                                    Datos de identificación y contacto
                                </small>

                            </div>

                        </div>

                    </div>


                    <div class="card-body px-4 pb-4">

                        <div class="row g-4">

                            {{-- Nombre --}}
                            <div class="col-12">

                                <small class="text-muted d-block mb-1">
                                    Nombre completo / Razón social
                                </small>

                                <div class="fw-semibold fs-6">
                                    {{ $supplier->full_name ?: 'No registrado' }}
                                </div>

                            </div>


                            {{-- Identificación --}}
                            <div class="col-12 col-md-6">

                                <small class="text-muted d-block mb-1">
                                    Identificación
                                </small>

                                <div class="fw-semibold">
                                    <i class="bi bi-card-text text-primary me-1"></i>
                                    {{ $supplier->identification ?: 'No registrada' }}
                                </div>

                            </div>


                            {{-- Teléfono --}}
                            <div class="col-12 col-md-6">

                                <small class="text-muted d-block mb-1">
                                    Teléfono
                                </small>

                                @if ($supplier->phone)
                                    <a href="tel:{{ $supplier->phone }}" class="text-decoration-none fw-semibold">

                                        <i class="bi bi-telephone text-primary me-1"></i>
                                        {{ $supplier->phone }}

                                    </a>
                                @else
                                    <span class="text-muted">
                                        No registrado
                                    </span>
                                @endif

                            </div>


                            {{-- Email --}}
                            <div class="col-12">

                                <small class="text-muted d-block mb-1">
                                    Correo electrónico
                                </small>

                                @if ($supplier->email)
                                    <a href="mailto:{{ $supplier->email }}" class="text-decoration-none fw-semibold">

                                        <i class="bi bi-envelope text-primary me-1"></i>
                                        {{ $supplier->email }}

                                    </a>
                                @else
                                    <span class="text-muted">
                                        No registrado
                                    </span>
                                @endif

                            </div>


                            {{-- Dirección --}}
                            <div class="col-12">

                                <small class="text-muted d-block mb-1">
                                    Dirección
                                </small>

                                <div class="fw-semibold">

                                    <i class="bi bi-geo-alt text-primary me-1"></i>

                                    {{ $supplier->address ?: 'No registrada' }}

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Ubicación --}}
            <div class="col-12 col-xl-4">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-header bg-white border-0 p-4">

                        <div class="d-flex align-items-center">

                            <div
                                class="bg-info bg-opacity-10 text-info
                                    rounded-3 p-2 me-3">

                                <i class="bi bi-geo-alt fs-5"></i>

                            </div>

                            <div>

                                <h5 class="fw-bold mb-1">
                                    Ubicación
                                </h5>

                                <small class="text-muted">
                                    Localización del proveedor
                                </small>

                            </div>

                        </div>

                    </div>


                    <div class="card-body px-4 pb-4">

                        <div class="mb-4">

                            <small class="text-muted d-block mb-1">
                                Departamento
                            </small>

                            <div class="fw-semibold">

                                <i class="bi bi-map text-info me-2"></i>

                                {{ $supplier->department ?: 'No registrado' }}

                            </div>

                        </div>


                        <div>

                            <small class="text-muted d-block mb-1">
                                Ciudad
                            </small>

                            <div class="fw-semibold">

                                <i class="bi bi-building text-info me-2"></i>

                                {{ $supplier->city ?: 'No registrada' }}

                            </div>

                        </div>


                        @if ($supplier->address)
                            <hr>

                            <div>

                                <small class="text-muted d-block mb-1">
                                    Dirección
                                </small>

                                <span>
                                    {{ $supplier->address }}
                                </span>

                            </div>
                        @endif

                    </div>

                </div>

            </div>


            {{-- Crédito --}}
            <div class="col-12 col-lg-6">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-header bg-white border-0 p-4">

                        <div class="d-flex align-items-center">

                            <div
                                class="bg-warning bg-opacity-10 text-warning
                                    rounded-3 p-2 me-3">

                                <i class="bi bi-credit-card fs-5"></i>

                            </div>

                            <div>

                                <h5 class="fw-bold mb-1">
                                    Información financiera
                                </h5>

                                <small class="text-muted">
                                    Estado del crédito
                                </small>

                            </div>

                        </div>

                    </div>


                    <div class="card-body p-4">

                        <div class="d-flex justify-content-between
                                align-items-center mb-3">

                            <span class="text-muted">
                                Crédito registrado
                            </span>

                            <span class="fs-4 fw-bold">
                                ${{ number_format($supplier->credit_amount ?? 0, 0, ',', '.') }}
                            </span>

                        </div>


                        @if (($supplier->credit_amount ?? 0) > 0)
                            <div
                                class="alert alert-warning border-0
                                    bg-warning bg-opacity-10 mb-0">

                                <i class="bi bi-info-circle me-2"></i>

                                Este proveedor tiene crédito registrado.

                            </div>
                        @else
                            <div
                                class="alert alert-success border-0
                                    bg-success bg-opacity-10 mb-0">

                                <i class="bi bi-check-circle me-2"></i>

                                Este proveedor no tiene crédito registrado.

                            </div>
                        @endif

                    </div>

                </div>

            </div>


            {{-- Descripción --}}
            <div class="col-12 col-lg-6">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-header bg-white border-0 p-4">

                        <div class="d-flex align-items-center">

                            <div
                                class="bg-secondary bg-opacity-10
                                    text-secondary rounded-3 p-2 me-3">

                                <i class="bi bi-card-text fs-5"></i>

                            </div>

                            <div>

                                <h5 class="fw-bold mb-1">
                                    Descripción
                                </h5>

                                <small class="text-muted">
                                    Observaciones del proveedor
                                </small>

                            </div>

                        </div>

                    </div>


                    <div class="card-body p-4">

                        @if ($supplier->description)
                            <p class="text-muted mb-0" style="white-space: pre-line;">
                                {{ $supplier->description }}
                            </p>
                        @else
                            <div class="text-center py-3">

                                <i class="bi bi-chat-square-text fs-2 text-muted"></i>

                                <p class="text-muted mb-0 mt-2">
                                    No hay observaciones registradas.
                                </p>

                            </div>
                        @endif

                    </div>

                </div>

            </div>

        </div>


        {{-- Acciones inferiores --}}
        <div class="card border-0 shadow-sm mt-4">

            <div class="card-body p-4">

                <div
                    class="d-flex flex-column flex-md-row
                        justify-content-between align-items-md-center gap-3">

                    <div>

                        <h6 class="fw-bold mb-1">
                            Acciones del proveedor
                        </h6>

                        <small class="text-muted">
                            Administra la información registrada.
                        </small>

                    </div>

                    <div class="d-flex flex-wrap gap-2">

                        <a href="{{ route('supplier.index') }}" class="btn btn-light border">

                            <i class="bi bi-list me-1"></i>
                            Ver proveedores

                        </a>

                        <a href="{{ route('supplier.edit', $supplier->id) }}" class="btn btn-primary">

                            <i class="bi bi-pencil me-1"></i>
                            Editar proveedor

                        </a>

                        <form action="{{ route('supplier.destroy', $supplier->id) }}" method="POST"
                            class="delete-supplier-form">

                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-outline-danger">

                                <i class="bi bi-trash me-1"></i>
                                Eliminar

                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection



<script>
    document.addEventListener('DOMContentLoaded', function() {

        document.querySelectorAll('.delete-supplier-form').forEach(function(form) {

            form.addEventListener('submit', function(event) {

                const confirmed = confirm(
                    '¿Está seguro de eliminar este proveedor?'
                );

                if (!confirmed) {
                    event.preventDefault();
                }

            });

        });

    });
</script>
