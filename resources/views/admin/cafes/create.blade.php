@extends('layouts.admin')

@section('content')
<div class="admin-card">
  <h2 class="admin-title">Agregar nueva cafetería</h2>

  <form id="cafe-form" method="POST" action="{{ route('admin.cafes.store') }}" enctype="multipart/form-data" class="space-y-6">
    @csrf

    <!-- Nombre -->
    <div class="form-group">
      <label>Nombre</label>
      <div class="input-icon">
        <i class="fa-solid fa-mug-saucer"></i>
        <input type="text" name="name" required>
      </div>
    </div>

    <!-- Dirección + Autocompletado -->
    <div class="form-group relative" id="address-group">
      <label>Dirección</label>

      <div class="input-icon">
        <i class="fa-solid fa-location-dot"></i>

        <div class="relative w-full">
          <input
            type="text"
            id="address-input"
            name="address"
            placeholder="Buscar dirección…"
            class="w-full border rounded p-2"
            autocomplete="off"
          />

          <div
            id="address-suggestions"
            class="absolute left-0 right-0 bg-white border rounded shadow-lg hidden z-1000 max-h-56 overflow-auto"
          ></div>
        </div>
      </div>

      <div id="mini-map" class="w-full h-56 rounded-lg shadow mt-3"></div>
    </div>

    <input type="hidden" name="lat" id="lat-hidden">
    <input type="hidden" name="lng" id="lng-hidden">

    <!-- Coordenadas visibles -->
    <div class="grid-2">
      <div class="form-group">
        <label>Latitud</label>
        <div class="input-icon">
          <i class="fa-solid fa-globe"></i>
            <input type="number" id="lat-visible" step="0.00000001" readonly>
        </div>
      </div>
      <div class="form-group">
        <label>Longitud</label>
        <div class="input-icon">
          <i class="fa-solid fa-globe"></i>
            <input type="number" id="lng-visible" step="0.00000001" readonly>
        </div>
      </div>
    </div>

    <!-- Descripción -->
    <div class="form-group">
      <label>Descripción</label>
      <textarea name="description" class="textarea"></textarea>
    </div>

    <!-- Rating -->
    <div class="form-group">
      <label>Calificación promedio</label>
      <div class="input-icon">
        <i class="fa-solid fa-star"></i>
        <input type="number" step="0.1" name="average_rating">
      </div>
    </div>

    <!-- TIPOS DE CAFÉ -->
    <div class="chip-group">
      <h3>Tipos de grano</h3>
      <div class="chips">
        @foreach(['Etíope','Colombiano','Guatemalteco','Blend Propietario'] as $type)
          <label class="chip">
            <input type="checkbox" name="coffee_types[]" value="{{ $type }}">
            <span>{{ $type }}</span>
          </label>
        @endforeach
      </div>
    </div>

    <!-- LECHES -->
    <div class="chip-group">
      <h3>Leches alternativas</h3>
      <div class="chips">
        @foreach(['Avena','Almendra','Soja','Sin lactosa'] as $milk)
          <label class="chip">
            <input type="checkbox" name="milk_options[]" value="{{ $milk }}">
            <span>{{ $milk }}</span>
          </label>
        @endforeach
      </div>
    </div>

    <!-- CARACTERÍSTICAS -->
    <div class="chip-group">
      <h3>Características</h3>
      <div class="chips">
        @foreach(['wifi','pet','terraza','musica','atencion'] as $feature)
          <label class="chip">
            <input type="checkbox" name="features[]" value="{{ $feature }}">
            <span>{{ ucfirst($feature) }}</span>
          </label>
        @endforeach
      </div>
    </div>

    <!-- TOSTADO / ORIGEN / LECHE -->
    <div class="chip-group">
      <h3>Tipo de tostado</h3>
      <select name="roasting_type" class="w-full border rounded p-2">
        <option value="">Seleccionar...</option>
        <option value="light">Claro</option>
        <option value="medium">Medio</option>
        <option value="dark">Oscuro</option>
      </select>
    </div>

    <div class="chip-group">
      <h3>Origen del café</h3>
      <select name="origin" class="w-full border rounded p-2">
        <option value="">Seleccionar...</option>
        <option value="etiope">Etíope</option>
        <option value="colombiano">Colombiano</option>
        <option value="guatemalteco">Guatemalteco</option>
        <option value="blend">Blend Propietario</option>
      </select>
    </div>

    <div class="chip-group">
      <h3>Leche alternativa</h3>
      <select name="milk" class="w-full border rounded p-2">
        <option value="">Seleccionar…</option>
        <option value="avena">Avena</option>
        <option value="almendra">Almendra</option>
        <option value="soja">Soja</option>
        <option value="sin_lactosa">Sin lactosa</option>
      </select>
    </div>

    <!-- HORARIOS -->
    <h3 class="font-semibold text-marron-tostado mt-4">Horarios de atención</h3>

    <div id="opening-hours-container" class="space-y-3">
      @foreach(['lunes','martes','miercoles','jueves','viernes','sabado','domingo'] as $day)
        <div class="grid grid-cols-3 gap-3 items-center bg-cremoso p-3 rounded-lg shadow-sm border border-[#ecdcc4]">
            <span class="capitalize font-medium">{{ $day }}</span>
            <input type="time" id="open-{{ $day }}" class="border rounded p-2">
            <input type="time" id="close-{{ $day }}" class="border rounded p-2">
        </div>
      @endforeach
    </div>

    <input type="hidden" name="opening_hours" id="opening_hours_json">

    <!-- IMAGEN -->
    <div class="form-group">
      <label>Imagen destacada</label>
      <input type="file" name="image" class="block w-full">
    </div>

    <button type="submit" class="btn-primary">Guardar cafetería</button>

  </form>
</div>
@endsection


@push('scripts')
<script>
// ================== MAPA + AUTOCOMPLETE ==================
document.addEventListener('DOMContentLoaded', () => {
  const input = document.getElementById('address-input');
  const suggestBox = document.getElementById('address-suggestions');
  const group = document.getElementById('address-group');
  const latEl = document.getElementById('lat-hidden');
  const lngEl = document.getElementById('lng-hidden');
  const latVisible = document.getElementById('lat-visible');
  const lngVisible = document.getElementById('lng-visible');

  const miniMap = L.map('mini-map').setView([-34.6037, -58.3816], 13);
  L.tileLayer(`https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png`).addTo(miniMap);

  let marker = null;

  function updateCoords(lat, lng) {
    latEl.value = latVisible.value = Number(lat).toFixed(8);
    lngEl.value = lngVisible.value = Number(lng).toFixed(8);
  }

  function setMarker(lat, lng) {
    if (!marker) {
      marker = L.marker([lat, lng], { draggable: true }).addTo(miniMap);

      marker.on('dragend', () => {
        const { lat, lng } = marker.getLatLng();
        updateCoords(lat, lng);
      });
    } else {
      marker.setLatLng([lat, lng]);
    }

    updateCoords(lat, lng);
  }

  // Autocomplete
  async function searchAddress(q) {
    const url = `https://api.mapbox.com/geocoding/v5/mapbox.places/${encodeURIComponent(q)}.json?access_token={{ config('services.mapbox.key') }}&country=AR&limit=6&language=es`;
    const res = await fetch(url);
    const data = await res.json();
    return data.features || [];
  }

  let debounceTimer;
  const debounce = (fn, wait = 350) => {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(fn, wait);
  };

  input.addEventListener('input', () => {
    debounce(async () => {
      const q = input.value.trim();
      if (q.length < 3) return suggestBox.classList.add('hidden');

      const results = await searchAddress(q);
      suggestBox.innerHTML = '';
      suggestBox.classList.remove('hidden');

      results.forEach(f => {
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.textContent = f.place_name;
        btn.className = 'w-full px-3 py-2 text-left hover:bg-gray-100';
        btn.onclick = () => {
          input.value = f.place_name;
          const [lng, lat] = f.center;
          setMarker(lat, lng);
          miniMap.setView([lat, lng], 15);
          suggestBox.classList.add('hidden');
        };
        suggestBox.appendChild(btn);
      });
    });
  });

  document.addEventListener('click', e => {
    if (!group.contains(e.target)) suggestBox.classList.add('hidden');
  });
});

// ================== HORARIOS JSON ==================
document.getElementById("cafe-form").addEventListener("submit", function () {
    const days = ['lunes','martes','miercoles','jueves','viernes','sabado','domingo'];
    let data = {};

    days.forEach(day => {
        const open = document.getElementById(`open-${day}`).value;
        const close = document.getElementById(`close-${day}`).value;

        if (open && close) {
            data[day] = `${open}-${close}`;
        }
    });

    document.getElementById("opening_hours_json").value = JSON.stringify(data);
});
</script>
@endpush
