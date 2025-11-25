@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-lg border border-[#f3e4ce] overflow-hidden my-10">

  <!-- Header -->
  <div class="flex justify-between items-center bg-gradient-to-r from-[#FEF8E0] to-[#FFFDF8] px-6 py-5 border-b border-[#f1e0c5]">
    <h2 class="text-2xl font-trocchi text-[var(--marron-tostado)] flex items-center gap-2">
      ☕ {{ $cafe->name }}
    </h2>
    <a href="{{ route('admin.cafes.index') }}" class="text-[var(--marron-tostado)] hover:text-[#7a4d25] font-medium transition">← Volver</a>
  </div>

  <!-- Contenido -->
  <div class="p-8 space-y-6">

    @if($cafe->image)
      <img src="{{ asset('storage/'.$cafe->image) }}" alt="{{ $cafe->name }}" class="w-full rounded-lg shadow-md mb-4">
    @endif

    <div class="grid md:grid-cols-2 gap-6">
      <div>
        <h3 class="font-trocchi text-lg text-[var(--marron-tostado)] mb-2">📍 Dirección</h3>
        <p class="text-[var(--texto-secundario)]">{{ $cafe->address }}</p>
      </div>

      <div>
        <h3 class="font-trocchi text-lg text-[var(--marron-tostado)] mb-2">⭐ Calificación Promedio</h3>
        <p class="text-[var(--texto-secundario)]">{{ $cafe->average_rating ?? '—' }}</p>
      </div>

      <div>
        <h3 class="font-trocchi text-lg text-[var(--marron-tostado)] mb-2">🌐 Web / Instagram</h3>
        <p>
          @if($cafe->website)
            <a href="{{ $cafe->website }}" target="_blank" class="text-[#7a4d25] hover:underline">{{ $cafe->website }}</a>
          @else
            <span class="text-[var(--texto-secundario)]">Sin enlace</span>
          @endif
        </p>
      </div>

      <div>
        <h3 class="font-trocchi text-lg text-[var(--marron-tostado)] mb-2">🔥 Tostado</h3>
        <p class="capitalize">{{ $cafe->roasting_type ?? 'No especificado' }}</p>
      </div>

      <div>
        <h3 class="font-trocchi text-lg text-[var(--marron-tostado)] mb-2">🌱 Origen</h3>
        <p class="capitalize">{{ $cafe->origin ?? 'No especificado' }}</p>
      </div>

      <div>
        <h3 class="font-trocchi text-lg text-[var(--marron-tostado)] mb-2">🥛 Leche alternativa</h3>
        <p class="capitalize">{{ $cafe->milk ?? 'No especificada' }}</p>
      </div>
    </div>

    <!-- Atributos -->
    <div>
      <h3 class="font-trocchi text-lg text-[var(--marron-tostado)] mb-2">🏡 Características</h3>
      @php $attrs = json_decode($cafe->attributes ?? '[]', true); @endphp
      @if(!empty($attrs))
        <div class="flex flex-wrap gap-2">
          @foreach($attrs as $attr)
            <span class="bg-[#f6ecda] text-[var(--marron-tostado)] px-3 py-1 rounded-full text-sm">{{ ucfirst($attr) }}</span>
          @endforeach
        </div>
      @else
        <p class="text-[var(--texto-secundario)]">Sin información</p>
      @endif
    </div>

    <!-- Descripción -->
    <div>
      <h3 class="font-trocchi text-lg text-[var(--marron-tostado)] mb-2">📝 Descripción</h3>
      <p class="text-[var(--texto-secundario)]">{{ $cafe->description ?? '—' }}</p>
    </div>
    <!-- Horarios -->
    <div>
      <h3 class="font-trocchi text-lg text-[var(--marron-tostado)] mb-2">🕒 Horarios de atención</h3>

      @php
        $hours = json_decode($cafe->opening_hours ?? '{}', true);
      @endphp

      @if(!empty($hours))
        <ul class="list-disc pl-5 text-[var(--texto-secundario)]">
          @foreach($hours as $day => $time)
            @php
              $dayLabel = ucfirst($day); // convierte "lunes" → "Lunes"
              [$open, $close] = explode('-', $time);
            @endphp

            <li>
              <strong>{{ $dayLabel }}:</strong> 
              {{ $open }} — {{ $close }}
            </li>
          @endforeach
        </ul>
      @else
        <p class="text-[var(--texto-secundario)]">Sin horarios cargados.</p>
      @endif
    </div>


    <!-- Mapa -->
    <div>
      <h3 class="font-trocchi text-lg text-[var(--marron-tostado)] mb-2">🗺 Ubicación</h3>
      <div id="view-map" class="w-full h-64 rounded-lg border border-[#f1e0c5]"></div>
    </div>

    <!-- Acciones -->
    <div class="pt-6 border-t border-[#f1e0c5] flex justify-end gap-3">
      <a href="{{ route('admin.cafes.edit', $cafe->id) }}" class="bg-[#c7a982] text-white px-5 py-2 rounded-lg hover:bg-[#b28a66] transition">Editar</a>
      <form action="{{ route('admin.cafes.destroy', $cafe->id) }}" method="POST" onsubmit="return confirm('¿Eliminar esta cafetería?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="bg-red-100 text-red-700 px-5 py-2 rounded-lg hover:bg-red-200 transition">Eliminar</button>
      </form>
    </div>

  </div>
</div>

<!-- Mapa -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
  const map = L.map('view-map').setView(
    [{{ $cafe->lat ?? -34.6037 }}, {{ $cafe->lng ?? -58.3816 }}],
    15
  );
  L.tileLayer(`https://tile.openstreetmap.org/{z}/{x}/{y}.png`).addTo(map);
  L.marker([{{ $cafe->lat ?? -34.6037 }}, {{ $cafe->lng?? -58.3816 }}])
    .addTo(map)
    .bindPopup("{{ $cafe->name }}").openPopup();
});
</script>
@endsection
