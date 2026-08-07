@extends('layouts.app')

@section('title', 'Detalle del Cliente')

@section('content')

    <div class="container-fluid py-4 mt-4">

        <div class="row justify-content-center">

            <div class="col-xl-10">

                <div class="card shadow-lg border-0 rounded-4">

                    <!-- Header -->

                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">

                        <div>

                            <h3 class="mb-0">

                                <i class="bi bi-person-vcard-fill me-2"></i>

                                Detalle del Cliente

                            </h3>

                            <small>Información completa del cliente</small>

                        </div>

                        @if ($customer->state)
                            <span class="badge bg-success fs-6">

                                <i class="bi bi-check-circle-fill me-1"></i>

                                Cliente Activo

                            </span>
                        @else
                            <span class="badge bg-danger fs-6">

                                <i class="bi bi-x-circle-fill me-1"></i>

                                Cliente Inactivo

                            </span>
                        @endif

                    </div>

                    <div class="card-body">

                        <!-- Información Personal -->

                        <h5 class="border-bottom pb-2 mb-4">

                            <i class="bi bi-person-fill me-2"></i>

                            Información Personal

                        </h5>

                        <div class="row">

                            <div class="col-md-6 mb-4">

                                <label class="text-muted">Nombre Completo</label>

                                <h5>{{ $customer->full_name }}</h5>

                            </div>

                            <div class="col-md-6 mb-4">

                                <label class="text-muted">Documento</label>

                                <h5>{{ $customer->identification }}</h5>

                            </div>

                            <div class="col-md-6 mb-4">

                                <label class="text-muted">Teléfono</label>

                                <h5>{{ $customer->phone }}</h5>

                            </div>

                            <div class="col-md-6 mb-4">

                                <label class="text-muted">Correo Electrónico</label>

                                <h5>{{ $customer->email }}</h5>

                            </div>

                        </div>

                        <hr>

                        <!-- Dirección -->

                        <h5 class="border-bottom pb-2 mb-4">

                            <i class="bi bi-geo-alt-fill me-2"></i>

                            Dirección

                        </h5>

                        <div class="row">

                            <div class="col-md-4 mb-4">

                                <label class="text-muted">Departamento</label>

                                <h5>{{ $customer->departament->name }}</h5>

                            </div>

                            <div class="col-md-4 mb-4">

                                <label class="text-muted">Ciudad</label>

                                <h5>{{ $customer->city->name }}</h5>

                            </div>

                            <div class="col-md-4 mb-4">

                                <label class="text-muted">Dirección</label>

                                <h5>{{ $customer->address }}</h5>

                            </div>

                        </div>

                        <hr>

                        <!-- Información Comercial -->

                        <h5 class="border-bottom pb-2 mb-4">

                            <i class="bi bi-wallet2 me-2"></i>

                            Información Comercial

                        </h5>

                        <div class="row">

                            <div class="col-md-6">

                                <div class="card border-success shadow-sm">

                                    <div class="card-body text-center">

                                        <i class="bi bi-cash-stack text-success fs-1"></i>

                                        <p class="text-muted mt-2 mb-1">

                                            Cupo de Crédito

                                        </p>

                                        <h3>

                                            $ {{ number_format($customer->credit_amount, 0, ',', '.') }}

                                        </h3>

                                    </div>

                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="card border-primary shadow-sm">

                                    <div class="card-body text-center">

                                        <i class="bi bi-person-check text-primary fs-1"></i>

                                        <p class="text-muted mt-2 mb-1">

                                            Estado

                                        </p>

                                        @if ($customer->state)
                                            <span class="btn bg-success fs-6 text-white">

                                                Activo

                                            </span>
                                        @else
                                            <span class="btn bg-danger fs-6 text-white">

                                                Inactivo

                                            </span>
                                        @endif

                                    </div>

                                </div>

                            </div>

                        </div>

                        <hr class="my-4">

                        <!-- Auditoría -->

                        <h5 class="border-bottom pb-2 mb-4">

                            <i class="bi bi-clock-history me-2"></i>

                            Auditoría

                        </h5>

                        <div class="row">

                            <div class="col-md-6">

                                <label class="text-muted">

                                    Fecha de Registro

                                </label>

                                <h6>

                                    {{ $customer->created_at->format('d/m/Y H:i') }}

                                </h6>

                            </div>

                            <div class="col-md-6">

                                <label class="text-muted">

                                    Última Actualización

                                </label>

                                <h6>

                                    {{ $customer->updated_at->format('d/m/Y H:i') }}

                                </h6>

                            </div>

                        </div>

                    </div>

                    <!-- Footer -->

                    <div class="card-footer bg-white">

                        <div class="d-flex justify-content-end gap-2">

                            <a href="{{ route('customer.index') }}" class="btn btn-outline-secondary">

                                <i class="bi bi-arrow-left"></i>

                                Volver

                            </a>

                            <a href="{{ route('customer.edit', $customer) }}" class="btn btn-primary">

                                <i class="bi bi-pencil-square"></i>

                                Editar Cliente

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
