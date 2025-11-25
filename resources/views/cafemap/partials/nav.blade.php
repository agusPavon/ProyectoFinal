<nav class="nav-footer fixed bottom-0 left-0 w-full bg-fondo-suave shadow-2xl rounded-t-xl p-2 z-50">

    <div class="flex justify-around items-center w-full">
        @php $currentTab = $activeTab ?? 'cafemap'; @endphp

        <!-- Inicio -->
        <a href="{{ route('cafemap.home.index') }}" class="nav-item {{ $currentTab === 'inicio' ? 'active' : '' }}">
            <i class="fas fa-home nav-icon"></i>
            <span class="nav-text">Inicio</span>
        </a>

        <!-- Comunidad -->
        <a href="{{ route('cafemap.community.index') }}" class="nav-item {{ $currentTab === 'comunidad' ? 'active' : '' }}">
            <i class="fas fa-users nav-icon"></i>
            <span class="nav-text">Comunidad</span>
        </a>

        <!-- Cafemap -->
        <a href="{{ route('cafemap.mapa') }}" class="nav-item {{ $currentTab === 'cafemap' ? 'active' : '' }}">
            <i class="fas fa-map-marker-alt nav-icon"></i>
            <span class="nav-text">Mapa</span>
        </a>

        <a href="{{ route('cafemap.beans.index') }}" class="nav-item {{ $currentTab === 'beans' ? 'active' : '' }}">
            <i class="fas fa-mug-hot nav-icon"></i>
            <span class="nav-text">Beans</span>
        </a>

        <a href="{{ route('cafemap.config.index') }}" class="nav-item {{ $currentTab === 'config' ? 'active' : '' }}">
            <i class="fas fa-cog nav-icon"></i>
            <span class="nav-text">Configuración</span>
        </a>
    </div>
</nav>
