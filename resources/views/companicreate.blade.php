<!doctype html>
<html lang="es">

<head>
    <!-- Meta obligatorios -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Mi Sistema</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Ícono del sitio (opcional) -->
    <link rel="icon" href="favicon.ico">
</head>

<body class="bg-ligh">

    <!-- 🔹 Navbar Bootstrap -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">SACADMIN</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
                aria-controls="mainNavbar" aria-expanded="false" aria-label="Alternar navegación">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('createcompany') }}">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Planes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Informacion de contacto</a>
                    </li>

                </ul>

                <ul class="navbar-nav mb-2 mb-lg-0">

                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">

                            @csrf
                            <button type="submit" class="btn btn-outline-light btn-sm">Cerrar sesión</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- 🔹 Contenido principal -->

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h2 class="mb-4 text-center">Registrar Nueva Empresa</h2>
                        <form action="{{route('homecompanydata.store')}}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Nombre de la empresa</label>
                                <input type="text" name="full_name" id="full_name" value="{{old('full_name')}}" class="form-control"
                                    placeholder="Ej: Mi Empresa S.A.S" required>
                            </div>

                            <div class="mb-3">
                                <label for="nit" class="form-label">NIT o RUT</label>
                                <input type="text" name="identification_card" id="identification_card" value="{{old('identifivation_card')}}" class="form-control"
                                    placeholder="Ej: 900123456-7" required>
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">Teléfono</label>
                                <input type="tel" name="phone" id="phone" value="{{old('phone')}}" class="form-control"
                                    placeholder="Ej: +57 3001234567" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Correo electrónico</label>
                                <input type="email" name="email" id="email" value="{{old('email')}}" class="form-control"
                                    placeholder="Ej: contacto@empresa.com" required>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Dirección</label>
                                <input type="text" name="address" id="address" value="{{old('address')}}" class="form-control"
                                    placeholder="Ej: Calle 123 #45-67" required>
                            </div>
                             <div class="mb-3">
                                <label for="Departament" class="form-label">Departamento</label>
                                <input type="text" name="Departament" id="Departament" value="{{old('Departament')}}" class="form-control"
                                    placeholder="Ej: Cordoba" required>
                            </div>
                            <div class="mb-3">
                                <label for="city" class="form-label">Ciudad</label>
                                <input type="text" name="city" id="city" value="{{old('city')}}" class="form-control"
                                    placeholder="Ej: contacto@empresa.com" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Registrar Empresa</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Bootstrap 5 JS (para navbar funcional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
