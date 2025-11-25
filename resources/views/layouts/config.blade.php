<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Configuración | Bunaster</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Fuentes, estilos globales y CSS Bunaster --}}
    <link rel="stylesheet" href="https://unpkg.com/@fortawesome/fontawesome-free@6.5.2/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('css/bunaster.css') }}">
    @vite(['resources/css/app.css', 'public/css/bunaster.css'])

</head>

<body>

    <div id="settings-app">

        {{-- HEADER de Configuración --}}
        <header class="px-4 py-3 bg-cremoso text-center shadow-sm">
                    @include('cafemap.partials.header')

           
        </header>

        {{-- CONTENIDO INYECTADO DESDE CADA VISTA --}}
        <main class="settings-container">
            @yield('content')
        </main>

        {{-- FOOTER DE NAVEGACIÓN BUNASTER --}}
        @include('cafemap.partials.nav', ['activeTab' => 'config'])

    </div>

</body>
</html>