<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Home | Bunaster</title>
@vite(['resources/css/app.css', 'public/css/bunaster.css'])

    <link rel="stylesheet" href="{{ asset('css/bunaster.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/@fortawesome/fontawesome-free@6.5.2/css/all.min.css" />
</head>

<body class="bg-fondo-suave">

    <div id="app-container" class="app-container community-dashboard">

      <header class="community-header">
  @include('cafemap.partials.header')

  <div class="search-bar-container">
    <input
      type="text"
      placeholder="☕ Encontrá tu cafetería..."
      class="search-input"
    />
    <button class="search-icon">
      <i class="fa-solid fa-magnifying-glass"></i>
    </button>
  </div>
</header>

        <section class="featured-route-section">
            <div class="route-banner">
                <img src="https://euskovazza.com/wp-content/uploads/2018/10/ganos-de-cafe-blog.jpg" alt="Granos de café" class="route-bg-image">
                <div class="route-overlay">
                    <span class="route-title font-trocchi">Ruta del expresso</span>
                </div>
            </div>
           <div class="action-buttons-modern">
              <a href="/mapa" class="action-card review-card">
                  <div class="icon-circle">
                      <i class="fas fa-pencil-alt"></i>
                  </div>
                  <span>Dejá tu reseña</span>
              </a>

              <a href="/beans" class="action-card beans-card">
                  <div class="icon-circle">
                      <i class="fas fa-coffee"></i>
                  </div>
                  <span>Sumá Beans</span>
              </a>
          </div>
        </section>

        <section class="roasters-section">
            <h2 class="section-heading font-trocchi text-marron-tostado">Conocé los mejores tostadores del mes!</h2>
            <div class="carrusel-container">
                <button id="carrusel-btn-left" class="carrusel-arrow left">&lt;</button>
                <div id="tostadores-carrusel" class="tostadores-carrusel">
                    @include('cafemap.partials.tostador_card', ['name' => 'Tostador 1', 'img' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQQoYalG0iZwdwwSFMhNL4aDADjcSJFcuo31Y9OY6saF8ZG5dq3lLc8uXw0eJfUwvdwjTw&usqp=CAU'])
                    @include('cafemap.partials.tostador_card', ['name' => 'Tostador 2', 'img' => 'avatar2.png'])
                    @include('cafemap.partials.tostador_card', ['name' => 'Tostador 3', 'img' => 'avatar1.png'])
                    @include('cafemap.partials.tostador_card', ['name' => 'Tostador 4', 'img' => 'avatar2.png'])
                </div>
                <button id="carrusel-btn-right" class="carrusel-arrow right">&gt;</button>
            </div>
        </section>

        <main class="feed-main-content recent-checkins">
             <h3 class="section-heading font-trocchi text-marron-tostado mb-3 ">Actividad Reciente</h3>
            @foreach ($checkins as $checkin)
            
            @php
                $isMine = auth()->id() === $checkin->user_id;
            @endphp
    <article class="checkin-compact-card bg-marron-tostado-light {{ $isMine ? 'post-mine' : '' }}">


              <div class="user-info">

                  <img src="https://www.pngall.com/wp-content/uploads/5/Profile-Avatar-PNG.png"
                      alt="Avatar" class="user-avatar-compact">

                  <div class="checkin-details">
                      <p class="Font-poppins post-user text-texto-principal">
                          {{ $checkin->user->name }} hizo un Check-in en {{ $checkin->cafe->name ?? 'Café eliminado' }}
                      </p>

                      <span class="post-time-compact text-texto-secundario">
                          {{ $checkin->created_at->diffForHumans() }}
                      </span>
                  </div>

              </div>

          </article>
      @endforeach
        </main>
   @include('cafemap.partials.nav', ['activeTab' => $activeTab])

    <script src="{{ asset('js/bunaster-map.js') }}"></script>
        </div>
     
</body>
</html>
