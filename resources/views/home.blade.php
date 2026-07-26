<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SACVAdmin | Sistema de Ventas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <style>
        body {
            background: linear-gradient(135deg, #0f172a, #2563eb, #3b82f6);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .login-card {
            border: none;
            border-radius: 25px;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(0, 0, 0, .25);
        }

        .left-panel {
            background: linear-gradient(160deg, #2563eb, #1d4ed8);
            color: white;
            padding: 60px;
        }

        .left-panel h1 {
            font-size: 45px;
            font-weight: bold;
        }

        .left-panel p {
            opacity: .9;
            font-size: 18px;
        }

        .icon-circle {
            width: 90px;
            height: 90px;
            background: white;
            color: #2563eb;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 45px;
            margin-bottom: 25px;
        }

        .right-panel {
            background: white;
            padding: 60px;
        }

        .form-control {
            height: 55px;
            border-radius: 12px;
        }

        .input-group-text {
            border-radius: 12px 0 0 12px;
        }

        .btn-login {
            height: 55px;
            border-radius: 12px;
            background: #2563eb;
            border: none;
            font-size: 18px;
            font-weight: 600;
            transition: .3s;
        }

        .btn-login:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
        }

        .forgot {
            text-decoration: none;
        }

        .logo {
            font-size: 32px;
            font-weight: bold;
            color: #2563eb;
        }

        @media(max-width:768px) {

            .left-panel {
                display: none;
            }

            .right-panel {
                padding: 40px 30px;
            }
        }
    </style>

</head>

<body>

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-lg-10">

                <div class="card login-card">

                    <div class="row g-0">

                        <div class="col-lg-6 left-panel d-flex flex-column justify-content-center">

                            <div class="icon-circle">
                                <i class="bi bi-shop"></i>
                            </div>

                            <h1>SACVAdmin</h1>

                            <p class="mt-3">
                                Administra tus ventas, inventario, compras, clientes y facturación
                                desde una sola plataforma moderna y segura.
                            </p>

                            <div class="mt-4">

                                <div class="mb-3">
                                    <i class="bi bi-check-circle-fill"></i>
                                    Control de Inventario
                                </div>

                                <div class="mb-3">
                                    <i class="bi bi-check-circle-fill"></i>
                                    Punto de Venta (POS)
                                </div>

                                <div class="mb-3">
                                    <i class="bi bi-check-circle-fill"></i>
                                    Facturación
                                </div>

                                <div class="mb-3">
                                    <i class="bi bi-check-circle-fill"></i>
                                    Reportes Inteligentes
                                </div>

                            </div>

                        </div>

                        <div class="col-lg-6 right-panel">

                            <div class="text-center mb-4">

                                <div class="logo">
                                    SACVAdmin
                                </div>

                                <p class="text-muted">
                                    Inicia sesión para continuar
                                </p>

                            </div>

                            <form action="{{ route('login') }}" method="POST">
                                @csrf

                                <div class="mb-3">

                                    <label class="form-label">
                                        Correo electrónico
                                    </label>

                                    <div class="input-group">

                                        <span class="input-group-text">
                                            <i class="bi bi-envelope"></i>
                                        </span>

                                        <input type="text" name="name" class="form-control"
                                            placeholder="nombre de usuario">

                                    </div>

                                </div>

                                <div class="mb-3">

                                    <label class="form-label">
                                        Contraseña
                                    </label>

                                    <div class="input-group">

                                        <span class="input-group-text">
                                            <i class="bi bi-lock"></i>
                                        </span>

                                        <input type="password" class="form-control" name="password" id="password"
                                            placeholder="********">

                                        <button class="btn btn-outline-secondary" type="button"
                                            onclick="mostrarPassword()">

                                            <i id="icono" class="bi bi-eye"></i>

                                        </button>

                                    </div>

                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-4">

                                    <div class="form-check">

                                        <input class="form-check-input" type="checkbox" name="remember" id="remember">

                                        <label class="form-check-label">
                                            Recordarme
                                        </label>

                                    </div>
                                    @if (Route::has('password.request'))
                                        <a href="#" class="forgot">
                                            ¿Olvidaste tu contraseña?
                                        </a>
                                    @endif
                                </div>

                                <button class="btn btn-primary w-100 btn-login" type="submit">

                                    <i class="bi bi-box-arrow-in-right"></i>

                                    Ingresar

                                </button>

                            </form>

                            <hr>

                            <div class="text-center text-muted">

                                © 2026 SACVAdmin

                                <br>

                                Sistema Profesional de Ventas

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <script>
        function mostrarPassword() {

            let input = document.getElementById('password');
            let icon = document.getElementById('icono');

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("bi-eye");
                icon.classList.add("bi-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("bi-eye-slash");
                icon.classList.add("bi-eye");
            }

        }
    </script>

</body>

</html>
