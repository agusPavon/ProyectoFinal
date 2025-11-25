@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto bg-white rounded-2xl shadow-lg border border-[#f3e4ce] overflow-hidden my-10">

  <!-- Header -->
  <div class="flex justify-between items-center bg-gradient-to-r from-[#FEF8E0] to-[#FFFDF8] px-6 py-5 border-b border-[#f1e0c5]">
    <h2 class="text-2xl font-trocchi text-[var(--marron-tostado)] flex items-center gap-2">
      ✏ Editar Cafetería
    </h2>
    <a href="{{ route('admin.cafes.index') }}" class="text-[var(--marron-tostado)] hover:text-[#7a4d25] font-medium transition">← Volver</a>
  </div>

  <!-- Formulario -->
  <form action="{{ route('admin.cafes.update', $cafe->id) }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
    @csrf
    @method('PUT')

    <!-- DATOS BÁSICOS -->
    <section>
      <h3 class="text-xl font-trocchi text-[var(--marron-tostado)] mb-3">Información general</h3>

      <div class="grid md:grid-cols-2 gap-5">
        <div>
          <label for="name" class="block font-medium text-[var(--texto-secundario)] mb-1">Nombre</label>
          <input type="text" id="name" name="name" value="{{ $cafe->name }}" class="w-full rounded-lg border border-[#f1e0c5] p-2 focus:ring-2 focus:ring-[#c7a982]">
        </div>

        <div>
          <label for="address" class="block font-medium text-[var(--texto-secundario)] mb-1">Dirección</label>
          <input type="text" id="address" name="address" value="{{ $cafe->address }}" class="w-full rounded-lg border border-[#f1e0c5] p-2 focus:ring-2 focus:ring-[#c7a982]">
        </div>
      </div>

      <label for="description" class="block font-medium text-[var(--texto-secundario)] mt-3 mb-1">Descripción</label>
      <textarea id="description" name="description" rows="3" class="w-full rounded-lg border border-[#f1e0c5] p-2">{{ $cafe->description }}</textarea>

      <div class="grid md:grid-cols-2 gap-5 mt-3">
        <div>
          <label for="average_rating" class="block font-medium text-[var(--texto-secundario)] mb-1">Calificación promedio</label>
          <input type="number" step="0.1" min="0" max="5" id="average_rating" name="average_rating" value="{{ $cafe->average_rating }}" class="w-full rounded-lg border border-[#f1e0c5] p-2">
        </div>
        <div>
          <label for="website" class="block font-medium text-[var(--texto-secundario)] mb-1">Instagram / Web</label>
          <input type="text" id="website" name="website" value="{{ $cafe->website }}" class="w-full rounded-lg border border-[#f1e0c5] p-2">
        </div>
      </div>
    </section>

    <!-- MAPA -->
    <section>
      <h3 class="text-xl font-trocchi text-[var(--marron-tostado)] mb-3">Ubicación en el mapa</h3>
      <input type="hidden" id="latitude" name="lat" value="{{ $cafe->lat }}">
      <input type="hidden" id="longitude" name="lng" value="{{ $cafe->lng }}">
      <div id="edit-map" class="w-full h-64 rounded-xl border border-[#f1e0c5]"></div>
    </section>

    <!-- ATRIBUTOS -->
    <section>
      <h3 class="text-xl font-trocchi text-[var(--marron-tostado)] mb-3">Características del lugar</h3>
      <div class="grid md:grid-cols-3 gap-4">
        @php
          $attrs = json_decode($cafe->attributes ?? '[]', true);
        @endphp

        <label class="flex items-center gap-2"><input type="checkbox" name="attributes[]" value="wifi" {{ in_array('wifi', $attrs) ? 'checked' : '' }}> WiFi</label>
        <label class="flex items-center gap-2"><input type="checkbox" name="attributes[]" value="pet" {{ in_array('pet', $attrs) ? 'checked' : '' }}> Pet Friendly</label>
        <label class="flex items-center gap-2"><input type="checkbox" name="attributes[]" value="terraza" {{ in_array('terraza', $attrs) ? 'checked' : '' }}> Terraza</label>
        <label class="flex items-center gap-2"><input type="checkbox" name="attributes[]" value="musica" {{ in_array('musica', $attrs) ? 'checked' : '' }}> Buena música</label>
        <label class="flex items-center gap-2"><input type="checkbox" name="attributes[]" value="atencion" {{ in_array('atencion', $attrs) ? 'checked' : '' }}> Atención cordial</label>
      </div>
    </section>

    <!-- DATOS DE CAFÉ -->
    <section>
      <h3 class="text-xl font-trocchi text-[var(--marron-tostado)] mb-3">Detalles de café</h3>
      <div class="grid md:grid-cols-3 gap-5">
        <div>
          <label class="block mb-1">Tipo de tostado</label>
          <select name="roasting_type" class="w-full border border-[#f1e0c5] rounded-lg p-2">
            <option value="light" {{ $cafe->roasting_type == 'light' ? 'selected' : '' }}>Claro</option>
            <option value="medium" {{ $cafe->roasting_type == 'medium' ? 'selected' : '' }}>Medio</option>
            <option value="dark" {{ $cafe->roasting_type == 'dark' ? 'selected' : '' }}>Oscuro</option>
          </select>
        </div>

        <div>
          <label class="block mb-1">Origen</label>
          <select name="origin" class="w-full border border-[#f1e0c5] rounded-lg p-2">
            <option value="etiope" {{ $cafe->origin == 'etiope' ? 'selected' : '' }}>Etíope</option>
            <option value="colombiano" {{ $cafe->origin == 'colombiano' ? 'selected' : '' }}>Colombiano</option>
            <option value="guatemalteco" {{ $cafe->origin == 'guatemalteco' ? 'selected' : '' }}>Guatemalteco</option>
            <option value="blend" {{ $cafe->origin == 'blend' ? 'selected' : '' }}>Blend Propietario</option>
          </select>
        </div>

        <div>
          <label class="block mb-1">Leche alternativa</label>
          <select name="milk" class="w-full border border-[#f1e0c5] rounded-lg p-2">
            <option value="">Seleccionar...</option>
            <option value="avena" {{ $cafe->milk == 'avena' ? 'selected' : '' }}>Avena</option>
            <option value="almendra" {{ $cafe->milk == 'almendra' ? 'selected' : '' }}>Almendra</option>
            <option value="soja" {{ $cafe->milk == 'soja' ? 'selected' : '' }}>Soja</option>
            <option value="sin_lactosa" {{ $cafe->milk == 'sin_lactosa' ? 'selected' : '' }}>Sin Lactosa</option>
          </select>
        </div>
      </div>
    </section>

    <!-- IMAGEN -->
    <section>
      <h3 class="text-xl font-trocchi text-[var(--marron-tostado)] mb-3">Imagen destacada</h3>
      @if($cafe->image)
        <img src="{{ asset('storage/'.$cafe->image) }}" alt="{{ $cafe->name }}" class="w-48 rounded-lg mb-3 shadow-md">
      @endif
      <input type="file" name="image" accept="image/*" class="block w-full text-sm text-[var(--texto-secundario)]">
    </section>

    <!-- BOTÓN GUARDAR -->
    <div class="pt-6 border-t border-[#f1e0c5] flex justify-end">
      <button type="submit" class="bg-[var(--marron-tostado)] text-white px-8 py-3 rounded-lg font-medium shadow hover:bg-[#6b3b10] transition">
        Guardar cambios
      </button>
    </div>
  </form>
</div>

<!-- MAPA INTERACTIVO -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
// Eliminar mapa previo si ya existe
if (L.DomUtil.get('edit-map') !== null) {
  L.DomUtil.get('edit-map')._leaflet_id = null;
}

const map = L.map('edit-map').setView(
  [{{ $cafe->lat ?? -34.6037 }}, {{ $cafe->lng ?? -58.3816 }}],
  13
);  L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

  const marker = L.marker([{{ $cafe->lat ?? -34.6037 }}, {{ $cafe->lng ?? -58.3816 }}], { draggable: true }).addTo(map);
  marker.on('dragend', e => {
    const coords = e.target.getLatLng();
    document.getElementById('latitude').value = coords.lat.toFixed(6);
    document.getElementById('longitude').value = coords.lng.toFixed(6);
  });
});
</script>

<!-- MAPA INTERACTIVO -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
  const map = L.map('edit-map').setView(
    [{{ $cafe->latitude ?? -34.6037 }}, {{ $cafe->longitude ?? -58.3816 }}],
    13
  );

  L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

  const marker = L.marker(
    [{{ $cafe->lat ?? -34.6037 }}, {{ $cafe->lng ?? -58.3816 }}],
    { draggable: true }
  ).addTo(map);

  const latInput = document.getElementById('latitude');
  const lngInput = document.getElementById('longitude');
  const addressInput = document.getElementById('address');

  // === Autocompletado con Mapbox ===
  const MAPBOX_KEY = "{{ $mapboxKey }}";
  const suggestionBox = document.createElement('div');
  suggestionBox.className = "search-results";
  suggestionBox.style.position = "absolute";
  suggestionBox.style.background = "#fffaf4";
  suggestionBox.style.border = "1px solid #f1e0c5";
  suggestionBox.style.borderRadius = "0.8rem";
  suggestionBox.style.boxShadow = "0 4px 12px rgba(84,34,1,0.1)";
  suggestionBox.style.zIndex = "1000";
  suggestionBox.style.width = "100%";
  suggestionBox.style.maxHeight = "200px";
  suggestionBox.style.overflowY = "auto";
  suggestionBox.style.display = "none";
  addressInput.parentNode.style.position = "relative";
  addressInput.parentNode.appendChild(suggestionBox);

  addressInput.addEventListener('input', async (e) => {
    const q = e.target.value.trim();
    if (q.length < 3) {
      suggestionBox.style.display = "none";
      return;
    }

    try {
      const response = await fetch(
        `https://api.mapbox.com/geocoding/v5/mapbox.places/${encodeURIComponent(q)}.json?access_token=${MAPBOX_KEY}&country=AR&limit=5`);
      const data = await response.json();
      suggestionBox.innerHTML = "";

      if (!data.features || data.features.length === 0) {
        suggestionBox.innerHTML = `<div class='no-results'>Sin resultados...</div>`;
      } else {
        data.features.forEach((feature) => {
          const item = document.createElement('div');
          item.className = "search-result-item";
          item.textContent = feature.place_name;
          item.addEventListener('click', () => {
            addressInput.value = feature.place_name;
            const [lng, lat] = feature.center;
            map.setView([lat, lng], 15);
            marker.setLatLng([lat, lng]);
            latInput.value = lat.toFixed(6);
            lngInput.value = lng.toFixed(6);
            suggestionBox.style.display = "none";
          });
          suggestionBox.appendChild(item);
        });
      }

      suggestionBox.style.display = "block";
    } catch (err) {
      console.error("Error en autocompletado:", err);
    }
  });

  document.addEventListener('click', (e) => {
    if (!suggestionBox.contains(e.target) && e.target !== addressInput) {
      suggestionBox.style.display = "none";
    }
  });

  // === Actualizar inputs al mover el marcador ===
  marker.on('dragend', e => {
    const coords = e.target.getLatLng();
    latInput.value = coords.lat.toFixed(6);
    lngInput.value = coords.lng.toFixed(6);
  });
});
</script>
@endsection
