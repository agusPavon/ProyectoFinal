<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sugerir Cafetería | Bunaster</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="{{ asset('css/bunaster.css') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">


</head>

<body>

 <body class="bg-[#FFF9F3]">

<div class="max-w-lg mx-auto mt-6 p-6 bg-white rounded-2xl shadow-soft border border-[#F1E5D2]">

    <header class="mb-6">
        <a href="{{ route('cafemap.mapa') }}" class="inline-flex items-center text-[#6B4A2B] mb-3 hover:text-[#5A3C20] transition">
            <span class="mr-1 text-lg">←</span> Volver
        </a>

        <h1 class="text-2xl font-semibold text-[#5A3C20]">Sugerir Cafetería</h1>
        <p class="text-sm text-[#9A7B5A]">
            Ayudanos a descubrir nuevos cafés de especialidad ☕✨
        </p>
    </header>

    <form id="suggest-form" action="{{ route('cafes.suggest.store') }}" method="POST" class="space-y-4">
        @csrf

        <!-- NOMBRE -->
        <div>
            <label class="label-modern">Nombre</label>
            <input class="input-modern" id="name" name="name" required>
        </div>

        <!-- DIRECCIÓN -->
        <div class="relative">
            <label class="label-modern">Dirección</label>
            <input id="address" name="address" class="input-modern" required>
            <div id="suggestions" class="absolute left-0 right-0 bg-white border border-gray-200 rounded-xl shadow-md mt-1 z-20"></div>
        </div>

        <!-- INSTAGRAM -->
        <div>
            <label class="label-modern">Instagram / Web</label>
            <input id="website" name="website" class="input-modern">
        </div>

        <!-- MAPA -->
        <h2 class="text-lg font-semibold text-[#5A3C20] mt-6">Ubicación</h2>
        <div id="mini-map" class="rounded-xl overflow-hidden h-56 border border-[#F1E5D2] shadow-inner"></div>

        <input type="hidden" id="latitude" name="latitude">
        <input type="hidden" id="longitude" name="longitude">

        <!-- DETALLES -->
        <h2 class="text-lg font-semibold text-[#5A3C20] mt-6">Detalles</h2>

        <select id="roasting_type" name="roasting_type" class="input-modern">
            <option value="">Tipo de tostado…</option>
            <option value="light">Claro</option>
            <option value="medium">Medio</option>
            <option value="dark">Oscuro</option>
        </select>

        <div class="flex flex-col gap-1 text-sm text-[#6B4A2B]">
            <label><input type="checkbox" name="attributes[]" value="wifi"> Wifi</label>
            <label><input type="checkbox" name="attributes[]" value="filter"> Métodos de filtrado</label>
        </div>

        <button type="submit" class="w-full bg-[#6B4A2B] text-white py-3 rounded-xl text-lg font-semibold hover:bg-[#5A3C20] transition">
            Enviar sugerencia
        </button>

    </form>
</div>

  <!-- Modal -->
<div id="thankyou-modal" class="modal-overlay">
  <div class="modal-content text-center px-6 py-4">
    <h2 class="text-xl font-semibold text-[var(--marron-tostado)] mb-2">☕ ¡Gracias por tu aporte!</h2>
    <p class="mb-4">Tu sugerencia será revisada por el equipo de Bunaster.</p>

    <a href="{{ route('cafemap.mapa') }}"
       id="back-to-map"
       class="bg-[#6B4A2B] text-white px-4 py-2 rounded-xl font-semibold hover:bg-[#5A3C20] transition inline-block">
       Volver al mapa
    </a>
  </div>
</div>


  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <script>
  document.addEventListener('DOMContentLoaded', () => {
    const map = L.map('mini-map').setView([-34.6037, -58.3816], 13);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

    const marker = L.marker([-34.6037, -58.3816], {draggable:true}).addTo(map);
    const lat = document.getElementById('latitude');
    const lng = document.getElementById('longitude');
    const addressInput = document.getElementById('address');
    const suggestions = document.getElementById('suggestions');
    const modal = document.getElementById('thankyou-modal');

    function updateInputs(latVal, lngVal) {
      lat.value = latVal.toFixed(6);
      lng.value = lngVal.toFixed(6);
    }
    updateInputs(-34.6037, -58.3816);

    // Autocomplete con Mapbox
    const MAPBOX_KEY = "{{ $mapboxKey }}";
    addressInput.addEventListener('input', async () => {
      const q = addressInput.value.trim();
      if (q.length < 3) { suggestions.innerHTML = ''; return; }
      const res = await fetch(`https://api.mapbox.com/geocoding/v5/mapbox.places/${encodeURIComponent(q)}.json?access_token=${MAPBOX_KEY}&country=AR&limit=5`);
      const data = await res.json();
      suggestions.innerHTML = data.features.map(f => `
        <div class="suggestion-item" data-lat="${f.center[1]}" data-lng="${f.center[0]}">${f.place_name}</div>
      `).join('');
    });

    suggestions.addEventListener('click', e => {
      if (e.target.classList.contains('suggestion-item')) {
        const latVal = e.target.dataset.lat;
        const lngVal = e.target.dataset.lng;
        addressInput.value = e.target.textContent;
        suggestions.innerHTML = '';
        map.setView([latVal, lngVal], 16);
        marker.setLatLng([latVal, lngVal]);
        updateInputs(latVal, lngVal);
      }
    });

    marker.on('dragend', () => {
      const {lat: lt, lng: ln} = marker.getLatLng();
      updateInputs(lt, ln);
    });

    document.getElementById('suggest-form').addEventListener('submit', async (e) => {
    e.preventDefault(); // evita recargar

    const form = e.target;
    const url = form.getAttribute('action');
    const formData = new FormData(form);

    const response = await fetch(url, {
        method: "POST",
        body: formData,
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        }
    });

    const data = await response.json();

    if (data.success) {
        modal.classList.add('is-visible');
    }
    });

  });


  </script>
  <script defer src="{{ asset('js/bunaster-map.js') }}"></script>

</body>
</html>
