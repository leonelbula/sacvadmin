@extends('layouts.master')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">

            {{-- Información del Usuario --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Editar Perfil</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')

                        {{-- Nombre --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name"
                                   value="{{ old('name', auth()->user()->name) }}" required autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo electrónico</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email"
                                   value="{{ old('email', auth()->user()->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Botón --}}
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                        @if (session('status') === 'profile-updated')
                            <span class="text-success ms-2">Guardado.</span>
                        @endif
                    </form>
                </div>
            </div>

            {{-- Cambio de Contraseña --}}
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Actualizar Contraseña</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @method('PUT')

                        {{-- Contraseña actual --}}
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Contraseña actual</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                   id="current_password" name="current_password" required>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Nueva contraseña --}}
                        <div class="mb-3">
                            <label for="password" class="form-label">Nueva contraseña</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Confirmación --}}
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmar nueva contraseña</label>
                            <input type="password" class="form-control"
                                   id="password_confirmation" name="password_confirmation" required>
                        </div>

                        {{-- Botón --}}
                        <button type="submit" class="btn btn-warning">Actualizar contraseña</button>
                        @if (session('status') === 'password-updated')
                            <span class="text-success ms-2">Contraseña actualizada.</span>
                        @endif
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
