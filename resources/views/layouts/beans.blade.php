<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Beans | Bunaster</title>

    {{-- Manifest & PWA --}}
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#542201">

    {{-- Icono para iOS --}}
    <link rel="apple-touch-icon" href="{{ asset('icons/icon-192.png') }}">

    {{-- CSRF --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Estilos globales --}}
    @vite(['resources/css/app.css', 'public/css/bunaster.css'])

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

    {{-- Estilos exclusivos Beans --}}
    <style>

       
    </style>

    @stack('styles')

</head>

<body>

    {{-- HEADER --}}
    <header class="beans-header">
        
        @include('cafemap.partials.header')

    </header>

    {{-- CONTENIDO PRINCIPAL --}}
    <main class="beans-container">
        @yield('content')
    </main>

    {{-- NAV FOOTER --}}
    @include('cafemap.partials.nav', ['activeTab' => 'beans'])

    @stack('scripts')

</body>
</html>