@extends('layouts.app')

@section('title', 'Nuevo Usuario')

@section('content')

    <div class="container-fluid px-4 py-4 mt-5">

        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">

            <div>
                <h1 class="h3 mb-1">
                    <i class="bi bi-person-plus me-2"></i>
                    Nuevo usuario
                </h1>

                <p class="text-muted mb-0">
                    Registra un nuevo usuario en el sistema
                </p>
            </div>

            <a href="{{ route('user.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i>
                Volver
            </a>

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

        <form action="{{ route('user.store') }}" method="POST">

            @csrf

            <div class="row g-4">

                <div class="col-lg-8">

                    <div class="card border-0 shadow-sm">

                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">
                                <i class="bi bi-person me-2"></i>
                                Información del usuario
                            </h5>
                        </div>

                        <div class="card-body">

                            <div class="row g-3">

                                <div class="col-md-6">

                                    <label for="name" class="form-label">
                                        Nombre
                                        <span class="text-danger">*</span>
                                    </label>

                                    <input type="text" id="name" name="name"
                                        class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                        placeholder="Nombre completo" required>

                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                                <div class="col-md-6">

                                    <label for="email" class="form-label">
                                        Correo electrónico
                                        <span class="text-danger">*</span>
                                    </label>

                                    <input type="email" id="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}" placeholder="usuario@correo.com" required>

                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                                <div class="col-md-6">

                                    <label for="type" class="form-label">
                                        Tipo de usuario
                                        <span class="text-danger">*</span>
                                    </label>

                                    <select id="type" name="type"
                                        class="form-select @error('type') is-invalid @enderror" required>

                                        <option value="">
                                            Seleccione un tipo
                                        </option>

                                        <option value="admin" {{ old('type') === 'admin' ? 'selected' : '' }}>
                                            Administrador
                                        </option>

                                        <option value="vendor" {{ old('type') === 'vendor' ? 'selected' : '' }}>
                                            Vendedor
                                        </option>

                                        <option value="uservendor" {{ old('type') === 'uservendor' ? 'selected' : '' }}>
                                            Usuario vendedor
                                        </option>

                                    </select>

                                    @error('type')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                                <div class="col-md-6">

                                    <label for="state" class="form-label">
                                        Estado
                                        <span class="text-danger">*</span>
                                    </label>

                                    <select id="state" name="state"
                                        class="form-select @error('state') is-invalid @enderror" required>

                                        <option value="1" {{ old('state', '1') == '1' ? 'selected' : '' }}>
                                            Activo
                                        </option>

                                        <option value="0" {{ old('state') === '0' ? 'selected' : '' }}>
                                            Inactivo
                                        </option>

                                    </select>

                                    @error('state')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                                <div class="col-12">
                                    <hr class="my-2">
                                </div>

                                <div class="col-md-6">

                                    <label for="password" class="form-label">
                                        Contraseña
                                        <span class="text-danger">*</span>
                                    </label>

                                    <input type="password" id="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Mínimo 8 caracteres" required>

                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                                <div class="col-md-6">

                                    <label for="password_confirmation" class="form-label">
                                        Confirmar contraseña
                                        <span class="text-danger">*</span>
                                    </label>

                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                        class="form-control" placeholder="Repita la contraseña" required>

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
                                Rol y permisos
                            </h5>
                        </div>

                        <div class="card-body">

                            <label for="role" class="form-label">
                                Rol
                                <span class="text-danger">*</span>
                            </label>

                            <select id="role" name="role" class="form-select @error('role') is-invalid @enderror"
                                required>

                                <option value="">
                                    Seleccione un rol
                                </option>

                                @isset($roles)

                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}"
                                            {{ old('role') === $role->name ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach

                                @endisset

                            </select>

                            <div class="form-text mt-2">
                                El rol determinará los permisos que tendrá
                                el usuario dentro del sistema.
                            </div>

                        </div>

                    </div>

                    <div class="card border-0 shadow-sm mt-4">

                        <div class="card-body">

                            <div class="d-flex align-items-start">

                                <i class="bi bi-info-circle text-primary fs-4 me-3"></i>

                                <div>
                                    <h6 class="mb-1">
                                        Información
                                    </h6>

                                    <p class="text-muted small mb-0">
                                        El usuario podrá acceder al sistema
                                        de acuerdo con su estado, rol y
                                        permisos asignados.
                                    </p>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">

                <a href="{{ route('user.index') }}" class="btn btn-light border">
                    Cancelar
                </a>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i>
                    Guardar usuario
                </button>

            </div>

        </form>

    </div>

@endsection
