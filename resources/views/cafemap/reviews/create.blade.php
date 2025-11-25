<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Dejar reseña | Bunaster</title>
  <link rel="stylesheet" href="{{ asset('css/bunaster.css') }}">
</head>
<body class="bg-fondo-suave">
  <div class="review-form-container">
    <h2 class="font-trocchi text-marron-tostado">Dejar reseña para {{ $cafe->name }}</h2>

<form method="POST" action="{{ route('reviews.store', $cafe->id) }}">
      @csrf

      <label for="rating">Puntuación:</label>
      <select name="rating" id="rating" required>
        <option value="5">⭐⭐⭐⭐⭐</option>
        <option value="4">⭐⭐⭐⭐</option>
        <option value="3">⭐⭐⭐</option>
        <option value="2">⭐⭐</option>
        <option value="1">⭐</option>
      </select>

      <label for="comment">Comentario:</label>
      <textarea name="comment" id="comment" rows="4" placeholder="Contanos tu experiencia..."></textarea>

      <button type="submit" class="bg-marron-tostado text-white">Publicar reseña</button>
    </form>

    <a href="{{ route('cafemap.mapa') }}" class="text-marron-tostado">← Volver al mapa</a>
  </div>
</body>
</html>
