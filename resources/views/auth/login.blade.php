<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión | Bunaster</title>

    <link rel="stylesheet" href="{{ asset('css/bunaster.css') }}">
      <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600|trocchi:400" rel="stylesheet" />

    <style>
        body {
            background: linear-gradient(180deg, #FFF9F2 0%, #F6EEE4 100%);
            font-family: 'Poppins', sans-serif;
            color: #542201;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .login-card {
            width: 100%;
            max-width: 340px; /* MÁS CHICO */
            background: white;
            padding: 1.7rem 1.4rem;
            border-radius: 18px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
            text-align: center;
        }

        .login-card img {
            width: 160px; /* LOGO REDUCIDO */
            margin-bottom: 0.6rem;
        }

        h1 {
            font-family: 'Trocchi', serif;
            font-size: 1.5rem; /* Más chico */
            margin-bottom: 0.2rem;
        }

        .subtitle {
            font-size: 0.8rem;
            color: #6B6F58;
            margin-bottom: 1rem;
        }

        label {
            display: block;
            text-align: left;
            font-size: 0.85rem;
            font-weight: 600;
            margin-top: 0.8rem;
        }

        input {
            width: 80%;
            padding: 9px;
            margin-top: 0.25rem;
            border-radius: 8px;
            border: 1px solid rgba(84,34,1,0.3);
            background: #FFF8F4;
            font-size: 0.9rem;
        }

        button {
            width: 100%;
            padding: 10px;
            margin-top: 1rem;
            background: #542201;
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: 0.2s;
        }

        button:hover {
            background: #3b1601;
        }

        .links {
            margin-top: 1rem;
            font-size: 0.8rem;
        }

        .links a {
            color: #542201;
            font-weight: 600;
            text-decoration: underline;
        }

        .alert-error {
            background-color: #fde8e8;
            color: #b91c1c;
            border: 1px solid #fca5a5;
            border-radius: 8px;
            padding: 8px;
            font-size: 0.8rem;
            text-align: left;
            margin-bottom: 10px;
        }
.remember-wrapper {
    margin-top: 0.8rem;
    display: flex;
    justify-content: flex-start;
}

.remember-label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.9rem;
    color: #542201;
    font-weight: 600;
    cursor: pointer;
}

.remember-checkbox {
    width: 18px;
    height: 18px;
    accent-color: #542201; /* color Bunaster */
    cursor: pointer;
}

    </style>
</head>

<body>
    <div class="login-card">

        @if ($errors->any())
            <div class="alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <img src="{{ asset('img/marca-principal.svg') }}" alt="Bunaster">

        <h1 class='bienvenido'>Bienvenido</h1>
        <p class="subtitle">Descubrí. Compartí. Disfrutá ☕✨</p>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required>

            <label for="password">Contraseña</label>
            <input id="password" type="password" name="password" required>

            <div class="remember-wrapper">
            <label class="remember-label">
                <input type="checkbox" name="remember" class="remember-checkbox">
                Recordarme
            </label>
            </div>


            <button type="submit">Iniciar sesión</button>

            <div class="links">
                <p><a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a></p>
                <p>¿No tenés cuenta? <a href="{{ route('register') }}">Crear cuenta</a></p>
            </div>
        </form>
    </div>
</body>
</html>
