@extends('layouts.app')

@section('title', 'Roles')

@section('content')

    <div class="container-fluid py-4 mt-4">

        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">

            <div>
                <h1 class="h3 mb-1">
                    <i class="bi bi-shield-lock me-2"></i>
                    Roles
                </h1>

                <p class="text-muted mb-0">
                    Administra los roles y permisos del sistema
                </p>
            </div>
            @can('role.create')
                <a href="{{ route('role.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1"></i>
                    Nuevo rol
                </a>
            @endcan


        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>
                {{ session('success') }}

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                {{ session('error') }}

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif

        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white py-3">

                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <h5 class="mb-1">
                            Lista de roles
                        </h5>

                        <small class="text-muted">
                            Roles registrados en el sistema
                        </small>
                    </div>

                    <span class="badge bg-primary">
                        {{ $roles->total() }} roles
                    </span>

                </div>

            </div>

            <div class="card-body p-0">

                @if ($roles->count())

                    <div class="table-responsive">

                        <table class="table table-hover align-middle mb-0">

                            <thead class="table-light">

                                <tr>

                                    <th class="px-4">
                                        #
                                    </th>

                                    <th>
                                        Rol
                                    </th>

                                    <th>
                                        Guard
                                    </th>

                                    <th class="text-center">
                                        Permisos
                                    </th>

                                    <th>
                                        Creado
                                    </th>

                                    <th class="text-end px-4">
                                        Acciones
                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                @foreach ($roles as $role)
                                    <tr>

                                        <td class="px-4">
                                            {{ $role->id }}
                                        </td>

                                        <td>

                                            <div class="d-flex align-items-center">

                                                <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center me-3"
                                                    style="width: 42px; height: 42px;">
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

                                        </td>

                                        <td>

                                            <span class="badge bg-light text-dark border">
                                                {{ $role->guard_name }}
                                            </span>

                                        </td>

                                        <td class="text-center">

                                            <span class="badge bg-primary rounded-pill">
                                                {{ $role->permissions_count }}
                                            </span>

                                        </td>

                                        <td>

                                            <small>
                                                {{ $role->created_at?->format('d/m/Y H:i') }}
                                            </small>

                                        </td>

                                        <td class="text-end px-4">

                                            <div class="btn-group">
                                                @can('role.view')
                                                    <a href="{{ route('role.show', $role->id) }}"
                                                        class="btn btn-sm btn-outline-info" title="Ver">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                @endcan

                                                @can('role.edit')
                                                    <a href="{{ route('role.edit', $role->id) }}"
                                                        class="btn btn-sm btn-outline-primary" title="Editar">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                @endcan

                                                @can('role.delete')
                                                    @if ($role->name !== 'Administrador')
                                                        <form action="{{ route('role.destroy', $role->id) }}" method="POST"
                                                            class="d-inline">

                                                            @csrf
                                                            @method('DELETE')

                                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                                title="Eliminar"
                                                                onclick="return confirm('¿Está seguro de eliminar este rol?')">
                                                                <i class="bi bi-trash"></i>
                                                            </button>

                                                        </form>
                                                    @else
                                                        <button type="button" class="btn btn-sm btn-outline-secondary" disabled
                                                            title="El rol Administrador no puede eliminarse">
                                                            <i class="bi bi-lock"></i>
                                                        </button>
                                                    @endif
                                                @endcan


                                            </div>

                                        </td>

                                    </tr>
                                @endforeach

                            </tbody>

                        </table>

                    </div>
                @else
                    <div class="text-center py-5">

                        <div class="mb-3">
                            <i class="bi bi-shield-x fs-1 text-muted"></i>
                        </div>

                        <h5>
                            No hay roles registrados
                        </h5>

                        <p class="text-muted mb-4">
                            Crea el primer rol para comenzar a administrar
                            los permisos del sistema.
                        </p>

                        <a href="{{ route('role.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-lg me-1"></i>
                            Crear primer rol
                        </a>

                    </div>

                @endif

            </div>

            @if ($roles->hasPages())
                <div class="card-footer bg-white">

                    <div class="d-flex justify-content-center">
                        {{ $roles->links() }}
                    </div>

                </div>
            @endif

        </div>

    </div>

@endsection
