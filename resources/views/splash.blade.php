<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bunaster</title>

    <link rel="stylesheet" href="{{ asset('css/bunaster.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Trocchi&display=swap" rel="stylesheet">
    <style>
        .splash-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: var(--bg, #FEF8E0);
            animation: fadeOut 1.5s ease 2.5s forwards;
        }
        .splash-logo {
            width: 120px;
            animation: zoomIn 1.5s ease;
        }
        .splash-text {
            font-family: 'Trocchi', serif;
            color: #542201;
            font-size: 1.5rem;
            margin-top: 20px;
        }
        @keyframes zoomIn {
            from { transform: scale(0); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
        @keyframes fadeOut {
            to { opacity: 0; visibility: hidden; }
        }
    </style>
</head>

<body>
    <div class="splash-container">
        <img src="{{ asset('img/marca-principal.svg') }}" alt="Bunaster Logo" class="splash-logo">
        <p class="splash-text">Café, comunidad y conexión ☕</p>
    </div>

    <script>
        // Redirigir automáticamente al login después de 3 segundos
        setTimeout(() => {
            window.location.href = "{{ route('login') }}";
        }, 3000);
    </script>

   <script>
    // Siempre muestra el splash, y luego redirige según sesión
    setTimeout(() => {
        @if(auth()->check())
            window.location.href = "{{ route('cafemap.mapa') }}";
        @else
            window.location.href = "{{ route('login') }}";
        @endif
    }, 2000);
</script>


</body>
</html>
