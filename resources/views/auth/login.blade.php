@extends('layouts.guest')

@section('content')
    <section class="container d-flex justify-content-center align-items-center" style="min-height:100vh;">
        <div class="col-md-5">

            <div class="card p-4 card-login">
                <div class="text-center mb-3">
                    <h3 class="brand">SACVADMIN</h3>
                    <p class="text-muted">Sistema de Ventas · POS · Facturación</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="fw-bold">Correo electrónico</label>
                        <input type="email" name="email" class="form-control" required autofocus>
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold">Contraseña</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="d-flex justify-content-between mb-3">
                        <label>
                            <input type="checkbox" name="remember"> Recordarme
                        </label>

                        @if (Route::has('password.request'))
                            <a class="link" href="{{ route('password.request') }}">
                                ¿Olvidaste tu contraseña?
                            </a>
                        @endif
                    </div>

                    <button class="btn btn-main w-100">
                        <i class="fa fa-lock"></i> Iniciar Sesión
                    </button>
                </form>

                <p class="text-center mt-3">
                    ¿No tienes cuenta?
                    <a href="{{ route('register') }}" class="link">Crear cuenta</a>
                </p>
            </div>

        </div>
    </section>
@endsection
