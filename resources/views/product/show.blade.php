@extends('layouts.app')

@section('title', 'Detalle del Producto')

@section('content')

    <div class="container-fluid py-4 mt-4">

        <div class="row justify-content-center">

            <div class="col-lg-10">

                <div class="card shadow border-0 rounded-4">

                    <!-- Header -->

                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">

                        <div>

                            <h4 class="mb-0">
                                <i class="bi bi-box-seam"></i>
                                Información del Producto
                            </h4>

                            <small>
                                Detalle completo del producto
                            </small>

                        </div>

                        @if ($product->state)
                            <span class="badge bg-success fs-6">

                                <i class="bi bi-check-circle"></i>

                                Activo

                            </span>
                        @else
                            <span class="badge bg-danger fs-6">

                                <i class="bi bi-x-circle"></i>

                                Inactivo

                            </span>
                        @endif

                    </div>

                    <div class="card-body">

                        <!-- Información General -->

                        <h5 class="border-bottom pb-2 mb-4">

                            <i class="bi bi-info-circle"></i>

                            Información General

                        </h5>

                        <div class="row">

                            <div class="col-md-2 mb-4">

                                <label class="text-muted">
                                    Código
                                </label>

                                <h5>{{ $product->code }}</h5>

                            </div>

                            <div class="col-md-6 mb-4">

                                <label class="text-muted">
                                    Nombre
                                </label>

                                <h5>{{  $product->name }}</h5>

                            </div>

                            <div class="col-md-4 mb-4">

                                <label class="text-muted">
                                    Categoría
                                </label>

                                <h5>

                                    <span class="btn bg-info">

                                        {{ $product->category->name }}

                                    </span>

                                </h5>

                            </div>

                        </div>

                        <hr>

                        <!-- Tarjetas -->

                        <div class="row">

                            <div class="col-md-3">

                                <div class="card border-success">

                                    <div class="card-body text-center">

                                        <i class="bi bi-cash-stack fs-2 text-success"></i>

                                        <p class="mt-2 mb-1 text-muted">

                                            Costo

                                        </p>

                                        <h4>

                                            $ {{ number_format($product->cost, 2) }}

                                        </h4>

                                    </div>

                                </div>

                            </div>

                            <div class="col-md-3">

                                <div class="card border-primary">

                                    <div class="card-body text-center">

                                        <i class="bi bi-currency-dollar fs-2 text-primary"></i>

                                        <p class="mt-2 mb-1 text-muted">

                                            Precio

                                        </p>

                                        <h4>

                                            $ {{ number_format($product->price, 2) }}

                                        </h4>

                                    </div>

                                </div>

                            </div>

                            <div class="col-md-3">

                                <div class="card border-warning">

                                    <div class="card-body text-center">

                                        <i class="bi bi-graph-up-arrow fs-2 text-warning"></i>

                                        <p class="mt-2 mb-1 text-muted">

                                            Utilidad

                                        </p>

                                        <h4>

                                            {{ $product->utility }}%

                                        </h4>

                                    </div>

                                </div>

                            </div>

                            <div class="col-md-3">

                                <div class="card border-info">

                                    <div class="card-body text-center">

                                        <i class="bi bi-boxes fs-2 text-info"></i>

                                        <p class="mt-2 mb-1 text-muted">

                                            Stock

                                        </p>

                                        <h4>

                                            {{ $product->stock }}

                                        </h4>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <hr class="my-4">

                        <!-- Inventario -->

                        <h5 class="border-bottom pb-2 mb-4">

                            <i class="bi bi-box"></i>

                            Inventario

                        </h5>

                        <div class="row">

                            <div class="col-md-6">

                                <label class="text-muted">

                                    Stock Actual

                                </label>

                                <h4>{{ $product->stock }}</h4>

                            </div>

                            <div class="col-md-6">

                                <label class="text-muted">

                                    Stock Mínimo

                                </label>

                                <h4>{{ $product->stock_min }}</h4>

                            </div>

                        </div>

                        <hr class="my-4">

                        <!-- Auditoría -->

                        <h5 class="border-bottom pb-2 mb-4">

                            <i class="bi bi-clock-history"></i>

                            Auditoría

                        </h5>

                        <div class="row">

                            <div class="col-md-6">

                                <label class="text-muted">

                                    Creado

                                </label>

                                <p>

                                    {{ $product->created_at->format('d/m/Y H:i') }}

                                </p>

                            </div>

                            <div class="col-md-6">

                                <label class="text-muted">

                                    Última actualización

                                </label>

                                <p>

                                    {{ $product->updated_at->format('d/m/Y H:i') }}

                                </p>

                            </div>

                        </div>

                    </div>

                    <div class="card-footer bg-white">

                        <div class="d-flex justify-content-end gap-2">

                            <a href="{{ route('product.index') }}" class="btn btn-secondary">

                                <i class="bi bi-arrow-left"></i>

                                Volver

                            </a>

                            <a href="{{ route('product.edit', $product) }}" class="btn btn-primary">

                                <i class="bi bi-pencil-square"></i>

                                Editar Producto

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
