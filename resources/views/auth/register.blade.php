<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrate | Bunaster</title>
    <link rel="stylesheet" href="{{ asset('css/bunaster.css') }}" style="width:250px" max-width:"45%">
    <style>
        body {
            background-color: #FEF8E0;
            font-family: 'Poppins', sans-serif;
            color: #542201;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .auth-card {
            padding: 2.5rem 2rem;
            border-radius: 25px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 420px;
            text-align: center;
            animation: fadeIn 0.8s ease;
        }

        .auth-card img {
            width: 200px;
            max-width: 70%;
            margin-bottom: 1rem;
        }

        h1 {
            font-family: 'Trocchi', serif;
            font-size: 1.8rem;
            margin-bottom: 0.3rem;
        }

        .subtitle {
            color: #6B6F58;
            margin-bottom: 1.8rem;
            font-size: 0.95rem;
        }

        label {
            display: block;
            text-align: left;
            font-weight: 600;
            margin-top: 1rem;
            margin-bottom: 0.3rem;
        }

        input {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid rgba(84, 34, 1, 0.3);
            border-radius: 10px;
            background: #FFF8F4;
            transition: 0.2s;
        }

        input:focus {
            border-color: #542201;
            outline: none;
            box-shadow: 0 0 5px rgba(84, 34, 1, 0.25);
        }

        button {
            width: 100%;
            background: #542201;
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 12px;
            margin-top: 1.8rem;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #3b1601;
        }

        .links {
            text-align: center;
            margin-top: 1rem;
            font-size: 0.9rem;
        }

        .links a {
            color: #542201;
            font-weight: 600;
            text-decoration: underline;
            transition: 0.3s;
        }

        .links a:hover {
            color: #EFB2AF;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(15px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 480px) {
            .auth-card {
                padding: 1.5rem;
                border-radius: 20px;
            }

            h1 {
                font-size: 1.5rem;
            }

            .auth-card img {
                width: 150px;
            }
        }


.alert-error {
    background-color: #fde8e8;
    color: #b91c1c;
    border: 1px solid #fca5a5;
    border-radius: 8px;
    padding: 10px;
    font-size: 0.9rem;
    margin-bottom: 10px;
}
    </style>
</head>

<body>


    <div class="auth-card">
        @if ($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
        <div style="text-align:center;">
            <img src="{{ asset('img/marca-principal.svg') }}" alt="Bunaster Logo">
        </div>

        <h1>Creá tu cuenta</h1>
        <p class="subtitle">Sumate a la comunidad cafetera ☕</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <label for="name">Nombre completo</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>

            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required>

            <label for="password">Contraseña</label>
            <input id="password" type="password" name="password" required autocomplete="new-password">
            <small class="password-hint">⚠️ La contraseña debe tener al menos 6 caracteres.</small>


            <label for="password_confirmation">Confirmar contraseña</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required>

            <button type="submit">Registrarme</button>

            <div class="links">
                <p>¿Ya tenés cuenta? <a href="{{ route('login') }}">Iniciá sesión</a></p>
            </div>
        </form>
    </div>
</body>
</html>
