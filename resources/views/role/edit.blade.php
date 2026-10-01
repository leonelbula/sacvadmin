@extends('layouts.app')

@section('title', 'Editar Rol')

@section('content')

    <div class="container-fluid py-4 mt-4">

        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">

            <div>
                <h1 class="h3 mb-1">
                    <i class="bi bi-shield-gear me-2"></i>
                    Editar rol
                </h1>

                <p class="text-muted mb-0">
                    Modifica el nombre y los permisos del rol
                </p>
            </div>

            <div class="d-flex gap-2">

                <a href="{{ route('role.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Volver
                </a>

                <a href="{{ route('role.show', $role->id) }}" class="btn btn-outline-info">
                    <i class="bi bi-eye me-1"></i>
                    Ver
                </a>

            </div>

        </div>

        @if ($errors->any())

            <div class="alert alert-danger alert-dismissible fade show" role="alert">

                <div class="fw-semibold mb-2">
                    <i class="bi bi-exclamation-triangle me-1"></i>
                    Se encontraron los siguientes errores:
                </div>

                <ul class="mb-0">

                    @foreach ($errors->all() as $error)
                        <li>
                            {{ $error }}
                        </li>
                    @endforeach

                </ul>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

            </div>

        @endif

        <form action="{{ route('role.update', $role->id) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="row g-4">

                <div class="col-lg-4">

                    <div class="card border-0 shadow-sm">

                        <div class="card-header bg-white py-3">

                            <h5 class="mb-0">
                                <i class="bi bi-shield-check me-2"></i>
                                Información del rol
                            </h5>

                        </div>

                        <div class="card-body">

                            <div class="mb-3">

                                <label for="name" class="form-label">
                                    Nombre del rol
                                    <span class="text-danger">*</span>
                                </label>

                                <input type="text" id="name" name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $role->name) }}" maxlength="255" required>

                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                            <div class="mb-3">

                                <label class="form-label">
                                    Guard
                                </label>

                                <input type="text" class="form-control" value="{{ $role->guard_name }}" disabled>

                            </div>

                            <div class="alert alert-info mb-0">

                                <div class="d-flex">

                                    <i class="bi bi-info-circle fs-5 me-2"></i>

                                    <div class="small">
                                        Los usuarios que tengan este rol
                                        heredarán los permisos seleccionados.
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="card border-0 shadow-sm mt-4">

                        <div class="card-body">

                            <div class="d-flex align-items-center">

                                <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center me-3"
                                    style="width: 48px; height: 48px;">
                                    <i class="bi bi-key"></i>
                                </div>

                                <div>

                                    <div class="text-muted small">
                                        Permisos actuales
                                    </div>

                                    <div class="fs-4 fw-semibold">
                                        {{ $role->permissions->count() }}
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="col-lg-8">

                    <div class="card border-0 shadow-sm">

                        <div class="card-header bg-white py-3">

                            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">

                                <div>

                                    <h5 class="mb-1">
                                        <i class="bi bi-key me-2"></i>
                                        Permisos
                                    </h5>

                                    <small class="text-muted">
                                        Selecciona los permisos que tendrá el rol
                                    </small>

                                </div>

                                <div class="d-flex gap-2">

                                    <button type="button" id="selectAllPermissions" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-check2-all me-1"></i>
                                        Seleccionar todos
                                    </button>

                                    <button type="button" id="clearAllPermissions"
                                        class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-x-lg me-1"></i>
                                        Limpiar
                                    </button>

                                </div>

                            </div>

                        </div>

                        <div class="card-body">

                            @php

                                $groupedPermissions = $permissions->sortBy('name')->groupBy(function ($permission) {
                                    return explode('.', $permission->name)[0];
                                });

                                $currentPermissions = $role->permissions->pluck('name')->toArray();

                                $oldPermissions = old('permissions', $currentPermissions);

                            @endphp

                            @forelse ($groupedPermissions as $module => $modulePermissions)

                                <div class="border rounded mb-3 permission-module">

                                    <div class="bg-light border-bottom px-3 py-2">

                                        <div class="d-flex justify-content-between align-items-center">

                                            <div>

                                                <i class="bi bi-folder2-open me-2"></i>

                                                <span class="fw-semibold text-uppercase">
                                                    {{ $module }}
                                                </span>

                                            </div>

                                            <button type="button" class="btn btn-sm btn-outline-primary select-module"
                                                data-module="{{ $module }}">
                                                Seleccionar módulo
                                            </button>

                                        </div>

                                    </div>

                                    <div class="p-3">

                                        <div class="row g-2">

                                            @foreach ($modulePermissions as $permission)
                                                @php

                                                    $parts = explode('.', $permission->name);

                                                    $action = $parts[1] ?? $permission->name;

                                                    $actionLabels = [
                                                        'view' => 'Ver',
                                                        'create' => 'Crear',
                                                        'edit' => 'Editar',
                                                        'delete' => 'Eliminar',
                                                    ];

                                                    $label = $actionLabels[$action] ?? ucfirst($action);

                                                @endphp

                                                <div class="col-md-6">

                                                    <div class="form-check">

                                                        <input type="checkbox"
                                                            class="form-check-input permission-checkbox permission-{{ $module }}"
                                                            id="permission_{{ $permission->id }}" name="permissions[]"
                                                            value="{{ $permission->name }}"
                                                            {{ in_array($permission->name, $oldPermissions) ? 'checked' : '' }}>

                                                        <label class="form-check-label"
                                                            for="permission_{{ $permission->id }}">
                                                            {{ $label }}

                                                            <small class="text-muted ms-1">
                                                                ({{ $permission->name }})
                                                            </small>

                                                        </label>

                                                    </div>

                                                </div>
                                            @endforeach

                                        </div>

                                    </div>

                                </div>

                            @empty

                                <div class="text-center py-5">

                                    <i class="bi bi-key fs-1 text-muted"></i>

                                    <h5 class="mt-3">
                                        No hay permisos registrados
                                    </h5>

                                    <p class="text-muted mb-0">
                                        Ejecuta el seeder de permisos antes
                                        de editar un rol.
                                    </p>

                                </div>
                            @endforelse

                        </div>

                    </div>

                </div>

            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">

                <a href="{{ route('role.index') }}" class="btn btn-light border">
                    Cancelar
                </a>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i>
                    Actualizar rol
                </button>

            </div>

        </form>

    </div>

@endsection


<script>
    document.addEventListener('DOMContentLoaded', function() {

        const selectAllButton = document.getElementById(
            'selectAllPermissions'
        );

        const clearAllButton = document.getElementById(
            'clearAllPermissions'
        );

        const permissionCheckboxes = document.querySelectorAll(
            '.permission-checkbox'
        );

        const moduleButtons = document.querySelectorAll(
            '.select-module'
        );

        if (selectAllButton) {

            selectAllButton.addEventListener('click', function() {

                permissionCheckboxes.forEach(function(checkbox) {
                    checkbox.checked = true;
                });

            });

        }

        if (clearAllButton) {

            clearAllButton.addEventListener('click', function() {

                permissionCheckboxes.forEach(function(checkbox) {
                    checkbox.checked = false;
                });

            });

        }

        moduleButtons.forEach(function(button) {

            button.addEventListener('click', function() {

                const module = this.dataset.module;

                const checkboxes = document.querySelectorAll(
                    '.permission-' + module
                );

                checkboxes.forEach(function(checkbox) {
                    checkbox.checked = true;
                });

            });

        });

    });
</script>
