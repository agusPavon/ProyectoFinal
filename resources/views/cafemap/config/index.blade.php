@extends('layouts.config')

@section('content')
<div class="settings-wrapper">

    <h1 class="settings-title">Configuración</h1>

    <!-- ======================= -->
    <!--      PERFIL / CUENTA    -->
    <!-- ======================= -->
    <div class="settings-card">
        <h2 class="card-title">Tu Cuenta</h2>

        <div class="setting-row">
            <span class="label">Nombre</span>
            <span class="value">{{ auth()->user()->name }}</span>
        </div>

        <div class="setting-row">
            <span class="label">Email</span>
            <span class="value">{{ auth()->user()->email }}</span>
        </div>

        <a class="settings-link" href="#">
            Editar información
            <i class="fas fa-chevron-right"></i>
        </a>
    </div>

    <!-- ======================= -->
    <!--     PREFERENCIAS        -->
    <!-- ======================= -->
    <div class="settings-card">
        <h2 class="card-title">Preferencias</h2>
        <p class="card-desc">Configurá tus gustos del café, notificaciones y más.</p>

        <a class="settings-link" href="#">
            Editar preferencias
            <i class="fas fa-chevron-right"></i>
        </a>
    </div>

    <!-- ======================= -->
    <!--   SUSCRIPCIÓN BOX       -->
    <!-- ======================= -->
    <div class="settings-card">
        <h2 class="card-title">Suscripción Bunaster Box ☕📦</h2>
        <p class="card-desc">
            Recibí una box mensual con cafés de especialidad seleccionados especialmente para vos.
        </p>

        @if(!$activePlan)
            <div class="no-plan">No tenés una suscripción activa.</div>

            <a href="{{ route('cafemap.config.subscriptions.plans') }}" class="btn-primary">
                Ver planes
            </a>
        @else
            <div class="active-plan">
                <strong>Plan activo:</strong> {{ $activePlan->name }}  
                <span class="price">{{ $activePlan->price }} / mes</span>
            </div>

            <a class="settings-link" href="{{ route('subscriptions.manage') }}">
                Administrar suscripción
                <i class="fas fa-chevron-right"></i>
            </a>
        @endif
    </div>

    <!-- ======================= -->
    <!--      SEGURIDAD          -->
    <!-- ======================= -->
    <div class="settings-card">
        <h2 class="card-title">Seguridad</h2>

        <a class="settings-link" href="#">
            Cambiar contraseña
            <i class="fas fa-chevron-right"></i>
        </a>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="btn-secondary w-full" type="submit">
                Cerrar sesión
            </button>
        </form>
    </div>

</div>
@endsection