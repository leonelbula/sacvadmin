@extends('layouts.app')

@section('title', 'Configuración del sistema')

@section('content')
<div class="container-fluid py-4 mt-4">

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">
                <i class="bi bi-gear me-2 text-primary"></i>
                Configuración del sistema
            </h3>
            <p class="text-muted mb-0">
                Administra los datos de tu empresa y los parámetros de SisVenta.
            </p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Revisa los siguientes campos:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('configuration.update') }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-4">

            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="fw-bold mb-1">
                            <i class="bi bi-building text-primary me-2"></i>
                            Datos de la empresa
                        </h5>
                        <small class="text-muted">
                            Información comercial y de contacto.
                        </small>
                    </div>

                    <div class="card-body p-4">
                        <div class="row g-3">

                            <div class="col-md-6">
                                <label for="full_name" class="form-label fw-semibold">
                                    Nombre de la empresa
                                </label>
                                <input
                                    type="text"
                                    class="form-control @error('full_name') is-invalid @enderror"
                                    id="full_name"
                                    name="full_name"
                                    maxlength="150"
                                    value="{{ old('full_name', $company->full_name ?? '') }}"
                                    required
                                >
                                @error('full_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="identification_card" class="form-label fw-semibold">
                                    NIT / Identificación
                                </label>
                                <input
                                    type="text"
                                    class="form-control @error('identification_card') is-invalid @enderror"
                                    id="identification_card"
                                    name="identification_card"
                                    maxlength="20"
                                    value="{{ old('identification_card', $company->identification_card ?? '') }}"
                                    required
                                >
                                @error('identification_card')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="phone" class="form-label fw-semibold">
                                    Teléfono
                                </label>
                                <input
                                    type="text"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    id="phone"
                                    name="phone"
                                    maxlength="50"
                                    value="{{ old('phone', $company->phone ?? '') }}"
                                    required
                                >
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold">
                                    Correo electrónico
                                </label>
                                <input
                                    type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    id="email"
                                    name="email"
                                    maxlength="50"
                                    value="{{ old('email', $company->email ?? '') }}"
                                    required
                                >
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label for="address" class="form-label fw-semibold">
                                    Dirección
                                </label>
                                <input
                                    type="text"
                                    class="form-control @error('address') is-invalid @enderror"
                                    id="address"
                                    name="address"
                                    maxlength="50"
                                    value="{{ old('address', $company->address ?? '') }}"
                                    required
                                >
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="departament" class="form-label fw-semibold">
                                    Departamento
                                </label>
                                <input
                                    type="text"
                                    class="form-control @error('departament') is-invalid @enderror"
                                    id="departament"
                                    name="departament"
                                    maxlength="50"
                                    value="{{ old('departament', $company->departament ?? '') }}"
                                    required
                                >
                                @error('departament')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="city" class="form-label fw-semibold">
                                    Ciudad
                                </label>
                                <input
                                    type="text"
                                    class="form-control @error('city') is-invalid @enderror"
                                    id="city"
                                    name="city"
                                    maxlength="50"
                                    value="{{ old('city', $company->city ?? '') }}"
                                    required
                                >
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="logo" class="form-label fw-semibold">
                                    Logo de la empresa
                                </label>
                                <input
                                    type="file"
                                    class="form-control @error('logo') is-invalid @enderror"
                                    id="logo"
                                    name="logo"
                                    accept=".jpg,.jpeg,.png,.webp"
                                >
                                <div class="form-text">
                                    Formatos JPG, PNG o WEBP. Máximo recomendado: 2 MB.
                                </div>
                                @error('logo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                @if(!empty($company?->logo))
                                    <div class="mt-3">
                                        <p class="small text-muted mb-2">Logo actual</p>
                                        <img
                                            src="{{ asset('storage/' . $company->logo) }}"
                                            alt="Logo de la empresa"
                                            class="img-thumbnail"
                                            style="max-width: 180px; max-height: 100px; object-fit: contain;"
                                        >
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="fw-bold mb-1">
                            <i class="bi bi-sliders text-primary me-2"></i>
                            Parámetros del sistema
                        </h5>
                        <small class="text-muted">
                            Configura los consecutivos y la creación automática de productos.
                        </small>
                    </div>

                    <div class="card-body p-4">
                        <div class="row g-4">

                            <div class="col-md-6">
                                <label for="sale_code" class="form-label fw-semibold">
                                    Código consecutivo de ventas
                                </label>
                                <input
                                    type="number"
                                    class="form-control @error('sale_code') is-invalid @enderror"
                                    id="sale_code"
                                    name="sale_code"
                                    min="0"
                                    step="1"
                                    value="{{ old('sale_code', $parameters->sale_code ?? 1) }}"
                                    required
                                >
                                <div class="form-text">
                                    Número desde el que continuará el consecutivo de ventas.
                                </div>
                                @error('sale_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="product_code" class="form-label fw-semibold">
                                    Código consecutivo de productos
                                </label>
                                <input
                                    type="number"
                                    class="form-control @error('product_code') is-invalid @enderror"
                                    id="product_code"
                                    name="product_code"
                                    min="0"
                                    step="1"
                                    value="{{ old('product_code', $parameters->product_code ?? 1) }}"
                                    required
                                >
                                <div class="form-text">
                                    Número desde el que continuará el consecutivo de productos.
                                </div>
                                @error('product_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <div class="border rounded-3 p-3">
                                    <div class="form-check form-switch">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            role="switch"
                                            id="automatic_product"
                                            name="automatic_product"
                                            value="1"
                                            @checked(old(
                                                'automatic_product',
                                                $parameters->automatic_product ?? false
                                            ))
                                        >
                                        <label
                                            class="form-check-label fw-semibold"
                                            for="automatic_product">
                                            Generar automáticamente el código del producto
                                        </label>
                                    </div>
                                    <p class="text-muted small mb-0 mt-2">
                                        Activa esta opción si deseas que el sistema gestione
                                        automáticamente los códigos consecutivos de productos.
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ url()->previous() }}"
                       class="btn btn-light border">
                        <i class="bi bi-arrow-left me-1"></i>
                        Volver
                    </a>

                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-floppy me-1"></i>
                        Guardar configuración
                    </button>
                </div>
            </div>

        </div>
    </form>

</div>
@endsection
