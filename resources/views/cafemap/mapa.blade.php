<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#542201">
    <link rel="apple-touch-icon" href="{{ asset('icons/icon-192.png') }}">
    <title>Cafemap | Bunaster</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://unpkg.com/@fortawesome/fontawesome-free@6.5.2/css/all.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <link rel="stylesheet" href="{{ asset('css/bunaster.css') }}">
@vite(['resources/css/app.css', 'public/css/bunaster.css'])

   

    </head>

<body class="bg-fondo-suave">

    <!-- <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/service-worker.js');
        }
    </script> -->

    <div id="app-container" class="app-container">
       <header class="cafe-header">
  @include('cafemap.partials.header')

 <div class="search-bar-container" style="position:relative">
  <input
    id="searchCafeInput"
    type="text"
    placeholder="☕ Encontrá tu cafetería..."
    class="search-input"
  />
  <button id="searchCafeBtn" class="search-icon" type="button">
    <i class="fa-solid fa-magnifying-glass"></i>
  </button>
</div>

<div class="filters-row">
    <button class="filter-btn" data-filter="openNow">
        <i class="fa-solid fa-clock"></i> Abierto ahora
    </button>

    <button class="filter-btn" data-filter="topRated">
        <i class="fa-solid fa-star"></i> Mejores calificados
    </button>

    <button class="filter-btn" id="btn-open-filters">
        <i class="fa-solid fa-sliders"></i> Filtros
    </button>
</div>
</header>



        <div id="map" class="map-view"></div>

        @include('cafemap.partials.list')

    </div>


    <button id="add-cafe-button" class="add-cafe-btn">
        <span class="plus-icon">+</span>
    </button>

    @include('cafemap.suggest-cafe-modal')
<div id="cafe-modal" class="modal-overlay">
  <div class="modal-content bg-cremoso">
    <button id="btn-close-cafe-modal" class="close-btn">x</button>
    <h2 class="cafe-name font-trocchi text-marron-tostado"></h2>
    <p class="cafe-address text-texto-secundario"></p>
    <p class="cafe-rating text-marron-tostado"></p>
    <p id="cafe-open-status" class="cafe-status text-marron-tostado font-semibold mt-2"></p>
    <p id="cafe-today-hours" class="text-texto-secundario text-sm"></p>

    <div id="cafe-week-hours"
        class="weekly-hours text-sm text-texto-secundario mt-3">
    </div>

    <p class="cafe-description"></p>

<button id="btn-review-cafe" class="bg-marron-tostado text-white rounded-md mt-3 px-3 py-2">
    ✍ Dejar reseña
</button>

<button id="btn-checkin-cafe" class="bg-marron-tostado text-white rounded-md mt-3 px-3 py-2">
    📍 Hacer Check-In
</button>
</div>
</div>

<div id="review-modal" class="modal-overlay">
  <div class="modal-content bg-cremoso">
    <button id="btn-close-review-modal" class="close-btn">x</button>
    <h2 class="font-trocchi text-white">Dejar reseña</h2>
    <form id="reviewFormMap" method="POST" action="{{ route('reviews.store') }}" class="review-form-extended">
  @csrf
  <input type="hidden" name="cafe_id" id="reviewCafeId">

  <h3 class="font-trocchi text-marron-tostado mb-2">
    ¿Qué te pareció especial de esta cafetería?
  </h3>

  <!-- ⭐ Calificación general -->
 <div class="rating-stars">
  @for ($i = 5; $i >= 1; $i--)
    <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" required>
    <label for="star{{ $i }}">★</label>
  @endfor
</div>

<!-- ☕ Origen del café -->
<div class="review-section bg-cremoso">
  <h4 class="section-subtitle font-trocchi">Grano único (Single Origin)</h4>
  <div class="tag-group">
    <input type="checkbox" id="grain_etiope" name="attributes[]" value="etiope">
    <label for="grain_etiope">Etíope</label>

    <input type="checkbox" id="grain_colombiano" name="attributes[]" value="colombiano">
    <label for="grain_colombiano">Colombiano</label>

    <input type="checkbox" id="grain_guatemalteco" name="attributes[]" value="guatemalteco">
    <label for="grain_guatemalteco">Guatemalteco</label>

    <input type="checkbox" id="grain_blend" name="attributes[]" value="blend">
    <label for="grain_blend">Blend Propietario</label>
  </div>

</div>

<!-- 🥛 Leches alternativas -->
<div class="review-section bg-cremoso">
  <h4 class="section-subtitle font-trocchi">Leche alternativa</h4>
  <div class="tag-group">
  <input type="checkbox" id="milk_almendra" name="milk[]" value="almendra">
  <label for="milk_almendra">Almendra</label>

  <input type="checkbox" id="milk_avena" name="milk[]" value="avena">
  <label for="milk_avena">Avena</label>

  <input type="checkbox" id="milk_soja" name="milk[]" value="soja">
  <label for="milk_soja">Soja</label>

  <input type="checkbox" id="milk_sinlactosa" name="milk[]" value="sin_lactosa">
  <label for="milk_sinlactosa">Sin lactosa</label>
</div>
</div>

  <!-- 💻 WiFi -->
  <div class="review-section bg-cremoso flex items-center justify-between">
    <span>WiFi de calidad</span>
    <label class="switch">
      <input type="checkbox" name="wifi" value="1">
      <span class="slider"></span>
    </label>
  </div>

  <!-- 🌿 Ambiente -->
  <div class="review-section bg-cremoso">
    <h4 class="section-subtitle font-trocchi">Atmósfera</h4>
    <div class="toggle-list">
      <label>Silencioso para trabajar <input type="checkbox" name="ambiente[]" value="trabajo"></label>
      <label>Pet Friendly <input type="checkbox" name="ambiente[]" value="pet"></label>
      <label>Buena música <input type="checkbox" name="ambiente[]" value="musica"></label>
      <label>Terraza / Exterior <input type="checkbox" name="ambiente[]" value="terraza"></label>
      <label>Atención cordial <input type="checkbox" name="ambiente[]" value="atencion"></label>
    </div>
  </div>

  <!-- 📝 Comentarios -->
  <div class="review-section bg-cremoso">
    <h4 class="section-subtitle font-trocchi">Otras observaciones o reseñas</h4>
    <textarea name="comment" placeholder="Contanos tu experiencia..." rows="3" required></textarea>
  </div>

  <!-- 💬 Recomendación -->
  <div class="review-section bg-cremoso">
    <h4 class="section-subtitle font-trocchi">¿Cuál fue tu bebida elegida?</h4>
    <textarea name="bebida_favorita" placeholder="Flat white, capuccino, pour over..." rows="2"></textarea>
  </div>

  <button type="submit" class="bg-marron-tostado text-white mt-3">Publicar reseña</button>
</form>

    <div id="reviewSuccessMap" class="success-message hidden">
      🌟 ¡Tu reseña fue publicada con éxito!
    </div>
  </div>
</div>

<div id="checkin-modal" class="modal-overlay checkin-modern">
    <div class="modal-card">

        <button id="btn-close-checkin-modal" class="modal-close-btn">x</button>

        <div class="modal-header-modern">
            <span class="modal-icon">📍</span>
            <h2 class="modal-title-modern font-trocchi">Hacer Check-In</h2>
            <p class="modal-subtitle-modern">Compartí tu momento en esta cafetería</p>
        </div>

        <form id="checkinForm"
              action="{{ route('checkin.store') }}"
              method="POST"
              enctype="multipart/form-data"
              class="checkin-form-modern">
            @csrf

            <input type="hidden" name="cafe_id" id="checkinCafeId">

            <!-- Comentario -->
            <div class="input-group-modern">
                <label class="input-label-modern">Comentario</label>
                <textarea name="comment" rows="2" class="input-modern"
                placeholder="¿Qué te gustó del lugar? (opcional)"></textarea>
            </div>

            <!-- Imagen -->
            <div class="input-group-modern">
                <label class="input-label-modern">Foto del momento</label>

                <label class="image-upload-modern">
                    <input type="file" name="image" accept="image/*">
                    <div class="upload-box">
                        <i class="fa-solid fa-camera"></i>
                        <span>Subir foto</span>
                    </div>
                </label>
            </div>

            <!-- Botón -->
            <button type="submit" class="btn-modern">
                Confirmar Check-In
            </button>
        </form>
    </div>
</div>
<!-- Modal de error de reseña repetida -->
<div id="review-error-modal" class="modal-overlay">
  <div class="modal-content bg-cremoso text-center">
      <button class="close-btn" id="close-review-error">x</button>

      <h2 class="font-trocchi text-marron-tostado mb-2">Ya dejaste una reseña ☕</h2>

      <p class="text-texto-secundario mb-4">
          Solo podés dejar una reseña por cafetería.
      </p>

      <button id="review-error-ok"
              class="bg-marron-tostado text-white px-4 py-2 rounded-lg">
          Entendido
      </button>
  </div>
</div>
<div id="filters-modal" class="modal-overlay">
    <div class="modal-content filters-modal bg-cremoso">
        
        <button id="btn-close-filters" class="close-btn">x</button>
        <h2 class="font-trocchi text-marron-tostado mb-4">
            🔍 Filtros de búsqueda
        </h2>

        <!-- Grupo 1: Características -->
        <h3 class="filters-title">Características</h3>
        <div class="filters-group">
            <label><input type="checkbox" data-filter="wifi"> WiFi</label>
            <label><input type="checkbox" data-filter="pet"> Pet Friendly</label>
            <label><input type="checkbox" data-filter="terrace"> Terraza</label>
            <label><input type="checkbox" data-filter="music"> Música</label>

        </div>

        <!-- Grupo 2: Café -->
        <h3 class="filters-title">Café</h3>
        <div class="filters-group">
            <label><input type="checkbox" data-filter="singleOrigin"> Single Origin</label>
            <label><input type="checkbox" data-filter="altMilk"> Leche Alternativa</label>
        </div>

        <!-- Grupo 3: Filtrado por distancia -->
        <h3 class="filters-title">Distancia</h3>
        <select id="filter-distance" class="filter-select">
            <option value="">Cualquier distancia</option>
            <option value="1000">Menos de 1 km</option>
            <option value="3000">Menos de 3 km</option>
            <option value="5000">Menos de 5 km</option>
        </select>

        <!-- Acciones -->
        <div class="filters-actions">
            <button id="btn-reset-filters" class="btn-secondary">Restablecer</button>
            <button id="btn-apply-filters" class="btn-secondary">Aplicar</button>
        </div>
    </div>
</div>
@include('cafemap.partials.nav', ['activeTab' => 'cafemap'])
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script defer>
  const cafes = @json($cafes);
  const MAPBOX_KEY = "{{ $mapboxKey }}";
  const SUGGEST_URL = "{{ route('cafemap.suggest-new') }}";
</script>


        <!-- @include('cafemap.partials.cafe-info-modal') -->
        <!-- <form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="btn-logout">
        Cerrar sesión
    </button>
</form> -->
<script src="{{ asset('js/bunaster-map.js') }}"></script>
<script>
console.log("CAFES =>", @json($cafes));
</script>

</body>
</html>
