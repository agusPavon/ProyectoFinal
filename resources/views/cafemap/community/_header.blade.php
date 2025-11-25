<header class="community-header">
    @include('cafemap.partials.header')

    <h2 class="text-marron-tostado font-trocchi">
        Hola {{ auth()->user()->name }}
    </h2>

    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        Cerrar sesión
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>
</header