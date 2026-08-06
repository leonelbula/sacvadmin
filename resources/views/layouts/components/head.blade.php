<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>

    @yield('title', 'SACVAdmin')

</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">

@vite(['resources/css/dashboard.css', 'resources/css/responsive.css', 'resources/js/dashboard.js','resources/css/app.css', 'resources/js/app.js'])

@stack('styles')
