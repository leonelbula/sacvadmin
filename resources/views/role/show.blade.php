@extends('layouts.app')

@section('title', 'Detalle del Rol')

@section('content')

    <div class="container-fluid py-4 mt-4">

        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">

            <div>

                <h1 class="h3 mb-1">
                    <i class="bi bi-shield-check me-2"></i>
                    Detalle del rol
                </h1>

                <p class="text-muted mb-0">
                    Información, usuarios y permisos asignados
                </p>

            </div>

            <div class="d-flex gap-2">

                <a href="{{ route('role.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Volver
                </a>

                @can('role.edit')
                    <a href="{{ route('role.edit', $role->id) }}" class="btn btn-primary">
                        <i class="bi bi-pencil me-1"></i>
                        Editar
                    </a>
                @endcan

            </div>

        </div>

        <div class="row g-4">

            <div class="col-lg-4">

                <div class="card border-0 shadow-sm">

                    <div class="card-body text-center py-4">

                        <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center mx-auto mb-3"
                            style="width: 80px; height: 80px; font-size: 2rem;">
                            <i class="bi bi-shield-check"></i>
                        </div>

                        <h4 class="mb-1">
                            {{ $role->name }}
                        </h4>

                        <p class="text-muted mb-3">
                            Rol del sistema
                        </p>

                        @if ($role->name === 'Administrador')
                            <span class="badge bg-primary">
                                <i class="bi bi-star-fill me-1"></i>
                                Rol principal
                            </span>
                        @else
                            <span class="badge bg-light text-dark border">
                                {{ $role->guard_name }}
                            </span>
                        @endif

                    </div>

                </div>

                <div class="card border-0 shadow-sm mt-4">

                    <div class="card-header bg-white py-3">

                        <h5 class="mb-0">
                            <i class="bi bi-bar-chart me-2"></i>
                            Resumen
                        </h5>

                    </div>

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center mb-3">

                            <div class="d-flex align-items-center">

                                <i class="bi bi-key text-primary fs-5 me-3"></i>

                                <span>
                                    Permisos
                                </span>

                            </div>

                            <span class="badge bg-primary rounded-pill">
                                {{ $role->permissions->count() }}
                            </span>

                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">

                            <div class="d-flex align-items-center">

                                <i class="bi bi-people text-success fs-5 me-3"></i>

                                <span>
                                    Usuarios
                                </span>

                            </div>

                            <span class="badge bg-success rounded-pill">
                                {{ $usersCount }}
                            </span>

                        </div>

                        <div class="d-flex justify-content-between align-items-center">

                            <div class="d-flex align-items-center">

                                <i class="bi bi-calendar3 text-secondary fs-5 me-3"></i>

                                <span>
                                    Creado
                                </span>

                            </div>

                            <small>
                                {{ $role->created_at?->format('d/m/Y') }}
                            </small>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-lg-8">

                <div class="card border-0 shadow-sm">

                    <div class="card-header bg-white py-3">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <h5 class="mb-1">
                                    <i class="bi bi-key me-2"></i>
                                    Permisos asignados
                                </h5>

                                <small class="text-muted">
                                    Permisos disponibles para los usuarios
                                    que tengan este rol
                                </small>

                            </div>

                            <span class="badge bg-primary">
                                {{ $role->permissions->count() }}
                            </span>

                        </div>

                    </div>

                    <div class="card-body">

                        @php

                            $moduleLabels = [
                                'dashboard' => 'Panel principal',
                                'user' => 'Usuarios',
                                'role' => 'Roles',
                                'category' => 'Categorías',
                                'product' => 'Productos',
                                'customer' => 'Clientes',
                                'supplier' => 'Proveedores',
                                'shopping' => 'Compras',
                                'sale' => 'Ventas',
                                'sale-return' => 'Devoluciones',
                                'expense' => 'Gastos',
                                'pos' => 'Punto de venta',
                                'kardex' => 'Kardex',
                                'inventory-adjustment' => 'Ajustes de inventario',
                                'report' => 'Reportes',
                                'company' => 'Empresa',
                            ];

                            $actionLabels = [
                                'view' => 'Ver',
                                'create' => 'Crear',
                                'edit' => 'Editar',
                                'delete' => 'Eliminar',
                                'close' => 'Cerrar caja',
                                'sales' => 'Ventas',
                                'shopping' => 'Compras',
                                'expenses' => 'Gastos',
                                'inventory' => 'Inventario',
                                'kardex' => 'Kardex',
                            ];

                            $groupedPermissions = $role->permissions->sortBy('name')->groupBy(function ($permission) {
                                return explode('.', $permission->name)[0];
                            });

                        @endphp

                        @forelse ($groupedPermissions as $module => $modulePermissions)

                            <div class="border rounded mb-3">

                                <div class="bg-light border-bottom px-3 py-2">

                                    <div class="d-flex justify-content-between align-items-center">

                                        <div>

                                            <i class="bi bi-folder2-open me-2"></i>

                                            <span class="fw-semibold">

                                                {{ $moduleLabels[$module] ?? ucfirst($module) }}

                                            </span>

                                        </div>

                                        <span class="badge bg-secondary">
                                            {{ $modulePermissions->count() }}
                                        </span>

                                    </div>

                                </div>

                                <div class="p-3">

                                    <div class="row g-2">

                                        @foreach ($modulePermissions as $permission)
                                            @php

                                                $parts = explode('.', $permission->name);

                                                $action = $parts[1] ?? $permission->name;

                                                $label = $actionLabels[$action] ?? ucfirst($action);

                                            @endphp

                                            <div class="col-md-6">

                                                <div class="d-flex align-items-center">

                                                    <i class="bi bi-check-circle-fill text-success me-2"></i>

                                                    <div>

                                                        <span class="fw-medium">
                                                            {{ $label }}
                                                        </span>

                                                        <small class="text-muted d-block">
                                                            {{ $permission->name }}
                                                        </small>

                                                    </div>

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
                                    Sin permisos
                                </h5>

                                <p class="text-muted mb-3">
                                    Este rol todavía no tiene permisos asignados.
                                </p>

                                @can('role.edit')
                                    <a href="{{ route('role.edit', $role->id) }}" class="btn btn-primary">
                                        <i class="bi bi-pencil me-1"></i>
                                        Asignar permisos
                                    </a>
                                @endcan

                            </div>

                        @endforelse

                    </div>

                </div>

                <div class="card border-0 shadow-sm mt-4">

                    <div class="card-header bg-white py-3">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <h5 class="mb-1">
                                    <i class="bi bi-people me-2"></i>
                                    Usuarios con este rol
                                </h5>

                                <small class="text-muted">
                                    Usuarios actualmente asociados al rol
                                </small>

                            </div>

                            <span class="badge bg-success">
                                {{ $usersCount }}
                            </span>

                        </div>

                    </div>

                    <div class="card-body">

                        @php

                            $roleUsers = \App\Models\User::role($role->name)->orderBy('name')->get();

                        @endphp

                        @forelse ($roleUsers as $user)
                            <div class="d-flex align-items-center border-bottom py-3">

                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3"
                                    style="width: 42px; height: 42px;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>

                                <div class="flex-grow-1">

                                    <div class="fw-semibold">
                                        {{ $user->name }}
                                    </div>

                                    <small class="text-muted">
                                        {{ $user->email }}
                                    </small>

                                </div>

                                @can('user.view')
                                    <a href="{{ route('user.show', $user->id) }}" class="btn btn-sm btn-outline-info"
                                        title="Ver usuario">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                @endcan

                            </div>

                        @empty

                            <div class="text-center py-4">

                                <i class="bi bi-people fs-2 text-muted"></i>

                                <p class="text-muted mb-0 mt-2">
                                    No hay usuarios asignados a este rol.
                                </p>

                            </div>
                        @endforelse

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
