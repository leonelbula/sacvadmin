@extends('layouts.app')

@section('title', 'Editar rol')

@section('content')
    @php
        $moduleLabels = [
            'dashboard' => 'Panel principal',
            'category' => 'Categorías',
            'product' => 'Productos',
            'customer' => 'Clientes',
            'supplier' => 'Proveedores',
            'shopping' => 'Compras',
            'purchase' => 'Compras',
            'sale' => 'Ventas',
            'salereturn' => 'Devoluciones',
            'expense' => 'Gastos',
            'report' => 'Reportes',
            'user' => 'Usuarios',
            'role' => 'Roles',
            'permission' => 'Permisos',
            'pos' => 'Caja',
            'kardex' => 'Kardex',
            'company' => 'Empresa',
            'configuration' => 'Configuración',
            'parameter' => 'Parámetros',
            'tax' => 'Impuestos',
        ];

        $actionLabels = [
            'view' => 'Ver',
            'index' => 'Consultar listado',
            'create' => 'Crear',
            'store' => 'Guardar',
            'edit' => 'Editar',
            'update' => 'Actualizar',
            'delete' => 'Eliminar',
            'destroy' => 'Eliminar',
            'show' => 'Ver detalle',
            'manage' => 'Administrar',
            'close' => 'Cerrar caja',
            'open' => 'Abrir caja',
            'pdf' => 'Generar PDF',
            'export' => 'Exportar',
            'search' => 'Buscar',
            'restore' => 'Restaurar',
        ];

        $groupedPermissions = $permissions
            ->sortBy('name')
            ->groupBy(fn($permission) => explode('.', $permission->name)[0]);

        $currentPermissions = $role->permissions->pluck('name')->toArray();
        $oldPermissions = old('permissions', $currentPermissions);
    @endphp

    <div class="container-fluid py-4 mt-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
            <div>
                <h1 class="h3 mb-1">
                    <i class="bi bi-shield-gear me-2 text-primary"></i>
                    Editar rol
                </h1>
                <p class="text-muted mb-0">Modifica el nombre y los permisos del rol.</p>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('role.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Volver
                </a>
                <a href="{{ route('role.show', $role->id) }}" class="btn btn-outline-info">
                    <i class="bi bi-eye me-1"></i>
                    Ver rol
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
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
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
                                <i class="bi bi-shield-check me-2 text-primary"></i>
                                Información del rol
                            </h5>
                        </div>

                        <div class="card-body">
                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">
                                    Nombre del rol <span class="text-danger">*</span>
                                </label>
                                <input type="text" id="name" name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $role->name) }}" maxlength="255" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Guard</label>
                                <input type="text" class="form-control" value="{{ $role->guard_name }}" disabled>
                                <div class="form-text">El guard identifica el sistema de autenticación del rol.</div>
                            </div>

                            <div class="alert alert-info mb-0">
                                <div class="d-flex">
                                    <i class="bi bi-info-circle fs-5 me-2"></i>
                                    <div class="small">
                                        Los usuarios que tengan este rol heredarán los permisos seleccionados.
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
                                    <i class="bi bi-key fs-5"></i>
                                </div>
                                <div>
                                    <div class="text-muted small">Permisos actuales</div>
                                    <div class="fs-4 fw-semibold" id="permissionCount">
                                        {{ count($oldPermissions) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white py-3">
                            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                                <div>
                                    <h5 class="mb-1">
                                        <i class="bi bi-key me-2 text-primary"></i>
                                        Permisos del rol
                                    </h5>
                                    <small class="text-muted">
                                        Selecciona los permisos que tendrá el rol. Los nombres se muestran en español.
                                    </small>
                                </div>
                                <div class="d-flex flex-wrap gap-2">
                                    <button type="button" id="selectAllPermissions" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-check2-all me-1"></i>
                                        Seleccionar todos
                                    </button>
                                    <button type="button" id="clearAllPermissions"
                                        class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-x-lg me-1"></i>
                                        Desmarcar todos
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            @forelse ($groupedPermissions as $module => $modulePermissions)
                                @php
                                    $moduleSlug = 'module_' . $loop->index;
                                    $moduleLabel = $moduleLabels[$module] ?? ucfirst(str_replace('_', ' ', $module));
                                @endphp

                                <div class="border rounded-3 mb-3 permission-module">
                                    <div class="bg-light border-bottom px-3 py-3">
                                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                                            <div class="fw-semibold">
                                                <i class="bi bi-folder2-open text-primary me-2"></i>
                                                {{ $moduleLabel }}
                                                <span class="badge bg-secondary-subtle text-secondary ms-1">
                                                    {{ $modulePermissions->count() }}
                                                </span>
                                            </div>

                                            <div class="form-check mb-0">
                                                <input type="checkbox" class="form-check-input select-module"
                                                    id="{{ $moduleSlug }}" data-module="{{ $moduleSlug }}">
                                                <label class="form-check-label small" for="{{ $moduleSlug }}">
                                                    Seleccionar módulo
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="p-3">
                                        <div class="row g-3">
                                            @foreach ($modulePermissions as $permission)
                                                @php
                                                    $parts = explode('.', $permission->name, 2);
                                                    $action = $parts[1] ?? '';
                                                    $actionParts = explode('.', $action);
                                                    $action = end($actionParts);
                                                    $label =
                                                        $actionLabels[$action] ??
                                                        ucfirst(str_replace(['_', '-'], ' ', $action));
                                                @endphp

                                                <div class="col-sm-6 col-xl-4">
                                                    <div class="form-check">
                                                        <input type="checkbox"
                                                            class="form-check-input permission-checkbox {{ $moduleSlug }}"
                                                            id="permission_{{ $permission->id }}" name="permissions[]"
                                                            value="{{ $permission->name }}" @checked(in_array($permission->name, $oldPermissions, true))>
                                                        <label class="form-check-label"
                                                            for="permission_{{ $permission->id }}">
                                                            {{ $label }}
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
                                    <h5 class="mt-3">No hay permisos registrados</h5>
                                    <p class="text-muted mb-0">
                                        Registra los permisos antes de editar un rol.
                                    </p>
                                </div>
                            @endforelse
                        </div>

                        <div class="card-footer bg-white py-3 d-flex justify-content-end gap-2">
                            <a href="{{ route('role.index') }}" class="btn btn-light border">Cancelar</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-1"></i>
                                Actualizar rol
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAllButton = document.getElementById('selectAllPermissions');
            const clearAllButton = document.getElementById('clearAllPermissions');
            const permissionCheckboxes = document.querySelectorAll('.permission-checkbox');
            const moduleCheckboxes = document.querySelectorAll('.select-module');
            const permissionCount = document.getElementById('permissionCount');

            function updateCount() {
                if (permissionCount) {
                    permissionCount.textContent = document.querySelectorAll(
                        '.permission-checkbox:checked'
                    ).length;
                }

                moduleCheckboxes.forEach(function(moduleCheckbox) {
                    const moduleClass = moduleCheckbox.dataset.module;
                    const checkboxes = document.querySelectorAll('.' + moduleClass);
                    const checkedCount = document.querySelectorAll(
                        '.' + moduleClass + ':checked'
                    ).length;

                    moduleCheckbox.checked = checkboxes.length > 0 &&
                        checkedCount === checkboxes.length;
                    moduleCheckbox.indeterminate = checkedCount > 0 &&
                        checkedCount < checkboxes.length;
                });
            }

            if (selectAllButton) {
                selectAllButton.addEventListener('click', function() {
                    permissionCheckboxes.forEach(function(checkbox) {
                        checkbox.checked = true;
                    });
                    updateCount();
                });
            }

            if (clearAllButton) {
                clearAllButton.addEventListener('click', function() {
                    permissionCheckboxes.forEach(function(checkbox) {
                        checkbox.checked = false;
                    });
                    updateCount();
                });
            }

            moduleCheckboxes.forEach(function(moduleCheckbox) {
                moduleCheckbox.addEventListener('change', function() {
                    const moduleClass = this.dataset.module;

                    document.querySelectorAll('.' + moduleClass).forEach(function(checkbox) {
                        checkbox.checked = moduleCheckbox.checked;
                    });

                    updateCount();
                });
            });

            permissionCheckboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', updateCount);
            });

            updateCount();
        });
    </script>
@endsection
