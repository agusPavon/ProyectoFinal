<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Comunidad - Bunaster')</title>

    {{-- CSS propio en /public --}}
    <link rel="stylesheet" href="{{ asset('css/bunaster.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/@fortawesome/fontawesome-free@6.5.2/css/all.min.css" />

    {{-- Estilos del módulo comunidad --}}
    @include('cafemap.community._styles')

    {{-- VITE (solo resources/, nunca public/) --}}
    @vite(['resources/css/app.css'])
</head>

<body class="bg-fondo-suave">
    <div class="community-view">

        @include('cafemap.community._header')

        @yield('content')

        @include('cafemap.partials.nav', ['activeTab' => 'comunidad'])
    </div>
</body>
</html>
