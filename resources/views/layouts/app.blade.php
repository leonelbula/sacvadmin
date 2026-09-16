<!doctype html>

<html lang="es">

<head>

    @include('layouts.components.head')

</head>

<body>

    <div class="wrapper">

        @include('layouts.components.sidebar')
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <div class="main">

            @include('layouts.components.navbar')

            @include('layouts.components.flash-message')

            <main class="content">

                @yield('content')

            </main>

            @include('layouts.components.footer')

        </div>

    </div>
    @yield('script')


    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: '¡Operación exitosa!',
                text: @json(session('success')),
                confirmButtonText: 'Aceptar'
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: @json(session('error')),
                confirmButtonText: 'Aceptar'
            });
        @endif

        @if (session('warning'))
            Swal.fire({
                icon: 'warning',
                title: 'Advertencia',
                text: @json(session('warning')),
                confirmButtonText: 'Aceptar'
            });
        @endif

        @if (session('info'))
            Swal.fire({
                icon: 'info',
                title: 'Información',
                text: @json(session('info')),
                confirmButtonText: 'Aceptar'
            });
        @endif
    </script>
</body>

</html>
