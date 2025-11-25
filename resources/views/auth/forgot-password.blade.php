<x-guest-layout>
    <x-authentication-card>
        
        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $value }}
            </div>
        @endsession

        <x-validation-errors class="mb-4" />

        <div class="min-h-screen flex items-center justify-center bg-[#FFF9F3] px-4">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-lg border border-[#F1E5D2] p-8">

        <!-- Logo -->
        <div class="flex flex-col items-center mb-6">
            <img src="{{ asset('img/marca-principal.svg') }}" class="w-50 h-50 mb-2" alt="Bunaster Logo">
            <h1 class="font-trocchi text-2xl text-[#5A3C20]">Recuperar contraseña</h1>
        </div>

        <!-- Descripción -->
        <p class="text-sm text-[#8A6E50] mb-4 leading-relaxed">
            Ingresá tu email y te enviaremos un enlace para que puedas crear una nueva contraseña ☕✨
        </p>

        <!-- Éxito -->
        @if (session('status'))
            <div class="mb-4 p-3 rounded-lg bg-green-100 text-green-700 text-sm">
                {{ session('status') }}
            </div>
        @endif

        <!-- Errores -->
        @if ($errors->any())
            <div class="mb-4 p-3 rounded-lg bg-red-100 text-red-700 text-sm">
                <ul class="list-disc pl-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulario -->
        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <label class="block text-[#6B4A2B] font-medium mb-1">Email</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
                class="w-full px-4 py-3 rounded-xl border border-[#E6D8C7] bg-[#FFFDFC]
                       text-[#5A3C20] placeholder-[#C2A68A] focus:ring-2 focus:ring-[#D9B38C]"
                placeholder="tuemail@ejemplo.com"
            >

            <button
                type="submit"
                class="w-full mt-5 py-3 rounded-xl font-semibold text-white bg-[#6B4A2B]
                       hover:bg-[#5A3C20] transition shadow-md">
                Enviar enlace
            </button>
        </form>

        <!-- Volver al login -->
        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="text-[#6B4A2B] hover:text-[#4B321B] text-sm">
                ← Volver al inicio de sesión
            </a>
        </div>
    </div>
</div>

    </x-authentication-card>
</x-guest-layout>
