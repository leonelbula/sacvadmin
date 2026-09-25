@extends('layouts.app')

@section('title', 'Usuarios')

@section('content')

<div class="container-fluid">

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">
                <i class="bi bi-people me-2"></i>
                Usuarios
            </h1>
            <p class="text-muted mb-0">
                Administración de usuarios del sistema
            </p>
        </div>

        <a href="{{ route('user.create') }}" class="btn btn-primary">
            <i class="bi bi-person-plus me-1"></i>
            Nuevo usuario
        </a>
    </div>

    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white border-0 py-3">

            <div class="row g-3 align-items-center">

                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="bi bi-search"></i>
                        </span>

                        <input
                            type="text"
                            id="searchUser"
                            class="form-control"
                            placeholder="Buscar usuario..."
                            autocomplete="off"
                        >
                    </div>
                </div>

                <div class="col-md-3">
                    <select id="filterState" class="form-select">
                        <option value="">Todos los estados</option>
                        <option value="1">Activos</option>
                        <option value="0">Inactivos</option>
                    </select>
                </div>

                <div class="col-md-3 text-md-end">
                    <span class="text-muted">
                        Total:
                        <strong>{{ $users->total() }}</strong>
                    </span>
                </div>

            </div>

        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">
                        <tr>
                            <th class="px-4">#</th>
                            <th>Usuario</th>
                            <th>Correo</th>
                            <th>Rol</th>
                            <th>Estado</th>
                            <th>Registro</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>

                    <tbody id="usersTable">

                        @forelse ($users as $user)

                            <tr
                                data-state="{{ $user->state ? 1 : 0 }}"
                                data-search="{{ strtolower(
                                    $user->name . ' ' .
                                    $user->email
                                ) }}"
                            >

                                <td class="px-4">
                                    {{ $users->firstItem() + $loop->index }}
                                </td>

                                <td>
                                    <div class="d-flex align-items-center">

                                        <div
                                            class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3"
                                            style="width: 42px; height: 42px;"
                                        >
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>

                                        <div>
                                            <div class="fw-semibold">
                                                {{ $user->name }}
                                            </div>

                                            <small class="text-muted">
                                                ID: {{ $user->id }}
                                            </small>
                                        </div>

                                    </div>
                                </td>

                                <td>
                                    <span>
                                        {{ $user->email }}
                                    </span>
                                </td>

                                <td>

                                    @if ($user->roles->count())

                                        @foreach ($user->roles as $role)

                                            <span class="badge bg-info text-dark me-1">
                                                <i class="bi bi-shield-check me-1"></i>
                                                {{ $role->name }}
                                            </span>

                                        @endforeach

                                    @else

                                        <span class="badge bg-secondary">
                                            Sin rol
                                        </span>

                                    @endif

                                </td>

                                <td>

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

                                </td>

                                <td>
                                    <div>
                                        {{ $user->created_at?->format('d/m/Y') }}
                                    </div>

                                    <small class="text-muted">
                                        {{ $user->created_at?->format('H:i') }}
                                    </small>
                                </td>

                                <td class="text-center">

                                    <div class="btn-group" role="group">

                                        <a
                                            href="{{ route('user.show', $user->id) }}"
                                            class="btn btn-sm btn-outline-info"
                                            title="Ver usuario"
                                        >
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <a
                                            href="{{ route('user.edit', $user->id) }}"
                                            class="btn btn-sm btn-outline-primary"
                                            title="Editar usuario"
                                        >
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <form
                                            action="{{ route('user.destroy', $user->id) }}"
                                            method="POST"
                                            class="d-inline form-delete-user"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                                title="Eliminar usuario"
                                            >
                                                <i class="bi bi-trash"></i>
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="7" class="text-center py-5">

                                    <div class="mb-3">
                                        <i
                                            class="bi bi-people text-muted"
                                            style="font-size: 3rem;"
                                        ></i>
                                    </div>

                                    <h5 class="text-muted">
                                        No hay usuarios registrados
                                    </h5>

                                    <p class="text-muted mb-3">
                                        Comienza creando el primer usuario.
                                    </p>

                                    <a
                                        href="{{ route('user.create') }}"
                                        class="btn btn-primary"
                                    >
                                        <i class="bi bi-person-plus me-1"></i>
                                        Crear usuario
                                    </a>

                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        @if ($users->hasPages())

            <div class="card-footer bg-white border-0 py-3">

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

                    <small class="text-muted">
                        Mostrando
                        <strong>{{ $users->firstItem() }}</strong>
                        -
                        <strong>{{ $users->lastItem() }}</strong>
                        de
                        <strong>{{ $users->total() }}</strong>
                        usuarios
                    </small>

                    <div>
                        {{ $users->links() }}
                    </div>

                </div>

            </div>

        @endif

    </div>

</div>

@endsection



<script>
document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('searchUser');
    const filterState = document.getElementById('filterState');
    const rows = document.querySelectorAll('#usersTable tr[data-search]');

    function filterUsers() {

        const search = searchInput.value
            .toLowerCase()
            .trim();

        const state = filterState.value;

        rows.forEach(row => {

            const text = row.dataset.search;
            const rowState = row.dataset.state;

            const matchesSearch =
                search === '' || text.includes(search);

            const matchesState =
                state === '' || rowState === state;

            row.style.display =
                matchesSearch && matchesState
                    ? ''
                    : 'none';

        });
    }

    searchInput.addEventListener('input', filterUsers);
    filterState.addEventListener('change', filterUsers);

    document.querySelectorAll('.form-delete-user').forEach(form => {

        form.addEventListener('submit', function (event) {

            const confirmed = confirm(
                '¿Está seguro de eliminar este usuario?'
            );

            if (!confirmed) {
                event.preventDefault();
            }

        });

    });

});
</script>
