<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
     <link rel="stylesheet" href="https://unpkg.com/@fortawesome/fontawesome-free@6.5.2/css/all.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <script src='https://api.mapbox.com/mapbox-gl-js/v3.0.1/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v3.0.1/mapbox-gl.css' rel='stylesheet' />


@vite(['resources/css/app.css', 'resources/css/bunaster.css'])
    <link rel="stylesheet" href="{{ asset('css/bunaster.css') }}">
    <style>
        #address-suggestions{
            z-index: 10000;
        }
    </style>

</head>
<body class="bg-gray-100">

    <nav class="bg-marron-tostado text-white p-4 mb-6">
        <h1 class="text-xl font-bold">Panel de Administración</h1>
    </nav>

    <main class="container mx-auto px-4">
        <script defer>
            const MAPBOX_KEY = "{{ config('services.mapbox.key') }}";
        </script>

        @yield('content')
        @stack('scripts')

    </main>

</body>
</html>
