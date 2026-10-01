@extends('layouts.app')

@section('title', 'Detalle del Usuario')

@section('content')

    <div class="container-fluid px-4 py-4 mt-5">

        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">

            <div>
                <h1 class="h3 mb-1">
                    <i class="bi bi-person-vcard me-2"></i>
                    Detalle del usuario
                </h1>

                <p class="text-muted mb-0">
                    Información y permisos asignados
                </p>
            </div>

            <div class="d-flex gap-2">

                <a href="{{ route('user.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Volver
                </a>
                @can('user.edit')
                    <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary">
                        <i class="bi bi-pencil me-1"></i>
                        Editar
                    </a>
                @endcan


            </div>

        </div>

        <div class="row g-4">

            <div class="col-lg-8">

                <div class="card border-0 shadow-sm">

                    <div class="card-body">

                        <div class="d-flex align-items-center">

                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3"
                                style="width: 70px; height: 70px; font-size: 1.7rem;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>

                            <div>

                                <h4 class="mb-1">
                                    {{ $user->name }}
                                </h4>

                                <div class="text-muted">
                                    {{ $user->email }}
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="card border-0 shadow-sm mt-4">

                    <div class="card-header bg-white py-3">

                        <h5 class="mb-0">
                            <i class="bi bi-person-lines-fill me-2"></i>
                            Información del usuario
                        </h5>

                    </div>

                    <div class="card-body">

                        <div class="row g-4">

                            <div class="col-md-6">

                                <small class="text-muted d-block">
                                    ID
                                </small>

                                <span class="fw-semibold">
                                    #{{ $user->id }}
                                </span>

                            </div>

                            <div class="col-md-6">

                                <small class="text-muted d-block">
                                    Nombre
                                </small>

                                <span class="fw-semibold">
                                    {{ $user->name }}
                                </span>

                            </div>

                            <div class="col-md-6">

                                <small class="text-muted d-block">
                                    Correo electrónico
                                </small>

                                <span class="fw-semibold">
                                    {{ $user->email }}
                                </span>

                            </div>

                            <div class="col-md-6">

                                <small class="text-muted d-block">
                                    Tipo de usuario
                                </small>

                                @switch($user->type)
                                    @case('admin')
                                        <span class="badge bg-primary">
                                            Administrador
                                        </span>
                                    @break

                                    @case('vendor')
                                        <span class="badge bg-info text-dark">
                                            Vendedor
                                        </span>
                                    @break

                                    @case('uservendor')
                                        <span class="badge bg-secondary">
                                            Usuario vendedor
                                        </span>
                                    @break

                                    @default
                                        <span class="badge bg-secondary">
                                            {{ $user->type }}
                                        </span>
                                @endswitch

                            </div>

                            <div class="col-md-6">

                                <small class="text-muted d-block">
                                    Estado
                                </small>

                                @if ($user->state)
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle me-1"></i>
                                        Activo
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        <i class="bi bi-x-circle me-1"></i>
                                        Inactivo
                                    </span>
                                @endif

                            </div>

                            <div class="col-md-6">

                                <small class="text-muted d-block">
                                    Fecha de registro
                                </small>

                                <span class="fw-semibold">
                                    {{ $user->created_at?->format('d/m/Y H:i') }}
                                </span>

                            </div>

                            <div class="col-md-6">

                                <small class="text-muted d-block">
                                    Última actualización
                                </small>

                                <span class="fw-semibold">
                                    {{ $user->updated_at?->format('d/m/Y H:i') }}
                                </span>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-lg-4">

                <div class="card border-0 shadow-sm">

                    <div class="card-header bg-white py-3">

                        <h5 class="mb-0">
                            <i class="bi bi-shield-check me-2"></i>
                            Rol asignado
                        </h5>

                    </div>

                    <div class="card-body">

                        @forelse ($user->roles as $role)
                            <div class="d-flex align-items-center mb-3">

                                <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center me-3"
                                    style="width: 45px; height: 45px;">
                                    <i class="bi bi-shield-check"></i>
                                </div>

                                <div>
                                    <div class="fw-semibold">
                                        {{ $role->name }}
                                    </div>

                                    <small class="text-muted">
                                        Rol del sistema
                                    </small>
                                </div>

                            </div>

                        @empty

                            <div class="text-center py-3">

                                <i class="bi bi-shield-x text-muted fs-1"></i>

                                <p class="text-muted mb-0 mt-2">
                                    No tiene un rol asignado.
                                </p>

                            </div>
                        @endforelse

                    </div>

                </div>

                <div class="card border-0 shadow-sm mt-4">

                    <div class="card-header bg-white py-3">

                        <div class="d-flex justify-content-between align-items-center">

                            <h5 class="mb-0">
                                <i class="bi bi-key me-2"></i>
                                Permisos
                            </h5>

                            <span class="badge bg-primary">
                                {{ $user->getAllPermissions()->count() }}
                            </span>

                        </div>

                    </div>

                    <div class="card-body">

                        @php
                            $permissions = $user->getAllPermissions()->sortBy('name');
                        @endphp

                        @forelse ($permissions as $permission)
                            <div class="d-flex align-items-center mb-2">

                                <i class="bi bi-check-circle text-success me-2"></i>

                                <span class="small">
                                    {{ $permission->name }}
                                </span>

                            </div>

                        @empty

                            <div class="text-center py-3">

                                <i class="bi bi-key text-muted fs-2"></i>

                                <p class="text-muted mb-0 mt-2">
                                    No tiene permisos asignados.
                                </p>

                            </div>
                        @endforelse

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
