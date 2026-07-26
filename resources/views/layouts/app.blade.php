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

            <main class="content">

                @yield('content')

            </main>

            @include('layouts.components.footer')

        </div>

    </div>
 @yield('script')
   
</body>

</html>
