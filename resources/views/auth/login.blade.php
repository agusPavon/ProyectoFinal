<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión | Bunaster</title>
    <link rel="stylesheet" href="{{ asset('css/bunaster.css') }}">
    <style>
        body {
            background-color: #FEF8E0;
            font-family: 'Poppins', sans-serif;
            color: #542201;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .login-card {
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }
        .login-card img {
            width: 80px;
            margin-bottom: 1rem;
        }
        h1 {
            font-family: 'Trocchi', serif;
            text-align: center;
            margin-bottom: .5rem;
        }
        .subtitle {
            text-align: center;
            color: #6B6F58;
            font-size: .9rem;
            margin-bottom: 1.5rem;
        }
        label {
            font-weight: 600;
            margin-top: 1rem;
        }
        input {
            width: 100%;
            padding: 10px;
            margin-top: .3rem;
            border-radius: 10px;
            border: 1px solid rgba(84,34,1,0.3);
            background: #FFF8F4;
        }
        button {
            width: 100%;
            background: #542201;
            color: #FFF;
            border: none;
            border-radius: 12px;
            padding: 10px;
            margin-top: 1.5rem;
            font-weight: bold;
            cursor: pointer;
            transition: .3s;
        }
        button:hover {
            background: #3b1601;
        }
        .links {
            text-align: center;
            margin-top: 1rem;
            font-size: .9rem;
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
            padding: 10px;
            font-size: 0.9rem;
            margin-bottom: 10px;
}
    </style>
</head>
<body>
    <div class="login-card">
        <div style="text-align:center;">
            <img src="{{ asset('img/marca-principal.svg') }}" alt="Bunaster Logo" style="width:250px" max-width:"45%">
        </div>

        <h1>Bienvenido a Bunaster</h1>
        <p class="subtitle">Conectá. Compartí. Disfrutá.</p>

        <form method="POST" action="{{ route('login') }}">
            @if ($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
            @csrf

            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>

            <label for="password">Contraseña</label>
            <input id="password" type="password" name="password" required>

            <div style="margin-top: .6rem;">
                <label>
                    <input type="checkbox" name="remember"> Recordarme
                </label>
            </div>

            <button type="submit">Iniciar sesión</button>

            <div class="links">
                <p><a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a></p>
                <p>¿No tenés cuenta? <a href="{{ route('register') }}">Registrate acá</a></p>
            </div>
        </form>
    </div>
</body>
</html>
