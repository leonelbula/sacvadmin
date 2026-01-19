@extends('layouts.guest')

@section('content')
    <section class="container d-flex justify-content-center align-items-center" style="min-height:100vh;">
        <div class="col-md-6">

            <div class="card p-4 card-register">

                <div class="text-center mb-3">
                    <h3 class="brand">SACVADMIN</h3>
                    <p class="text-muted">Crear cuenta — Sistema de Ventas y Facturación POS</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="fw-bold">Nombre</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-bold">Correo</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-bold">Contraseña</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-bold">Confirmar</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                    </div>

                    <div class="mt-3">
                        <input type="checkbox" required> Acepto términos y condiciones
                    </div>

                    <button class="btn btn-main w-100 mt-3">
                        <i class="fa fa-user-check"></i> Crear Cuenta
                    </button>
                </form>

                <p class="text-center mt-3">
                    ¿Ya tienes cuenta?
                    <a href="{{ route('login') }}" class="link">Iniciar sesión</a>
                </p>
            </div>

        </div>
    </section>
@endsection
