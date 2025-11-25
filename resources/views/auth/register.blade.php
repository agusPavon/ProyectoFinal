<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrate | Bunaster</title>

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

        .register-wrapper {
            max-width: 420px;
            width: 100%;
        }

        .register-card {
            background: #FFFFFF;
            padding: 2.2rem 2rem;
            border-radius: 24px;
            box-shadow: 0 8px 30px rgba(84, 34, 1, 0.15);
            border: 1px solid #F1E5D2;
            text-align: center;
            animation: fadeUp .4s ease;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .logo-container img {
            width: 200px;
            margin-bottom: .6rem;
        }

        h1 {
             font-family: 'Poppins', sans-serif;
            font-size: 1.7rem;
            margin-bottom: .4rem;
            color: #5A3C20;
        }

        .subtitle {
            color: #7a6a59;
            margin-bottom: 1.8rem;
            font-size: 0.92rem;
        }

        label {
            ont-family: 'Trocchi', serif;
            text-align: left;
            font-size: .9rem;
            font-weight: 600;
            display: block;
            margin-bottom: 4px;
        }

        .input-modern {
            width: 90%;
            padding: 12px;
            background: #FFF8F4;
            border: 1px solid #E6D8C7;
            border-radius: 14px;
            font-size: .95rem;
            color: #5A3C20;
            transition: .2s;
        }

        .input-modern:focus {
            outline: none;
            border-color: #D2A97C;
            box-shadow: 0 0 0 3px rgba(210,169,124,.25);
        }

        .btn-primary-modern {
            width: 100%;
            background: linear-gradient(135deg, #7A4D25, #542201);
            padding: 12px;
            color: white;
            border: none;
            border-radius: 14px;
            margin-top: 1.6rem;
            font-weight: 600;
            font-size: 1rem;
            box-shadow: 0 4px 12px rgba(84, 34, 1, 0.3);
            transition: .2s;
        }

        .btn-primary-modern:hover {
            transform: translateY(-2px);
            background: linear-gradient(135deg, #8c6237, #69340c);
        }

        .alert-error {
            background-color: #fde8e8;
            color: #b91c1c;
            border: 1px solid #fca5a5;
            border-radius: 12px;
            padding: 12px;
            font-size: 0.85rem;
            margin-bottom: 12px;
        }

        small.password-hint {
            display: block;
            text-align: left;
            font-size: 0.8rem;
            color: #8a7662;
            margin-top: 4px;
        }

        .extras {
            margin-top: 1.2rem;
            text-align: center;
            font-size: .9rem;
        }

        .extras a {
            color: #744621;
            font-weight: 600;
            text-decoration: underline;
        }

        @media (max-width: 460px) {
            .register-card {
                padding: 1.6rem 1.4rem;
            }

            .logo-container img {
                width: 160px;
            }
        }
    </style>
</head>

<body>

<div class="register-wrapper">
    <div class="register-card">

        @if ($errors->any())
            <div class="alert-error">
                <ul style="margin-left: 16px; list-style: disc;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="logo-container">
            <img src="{{ asset('img/marca-principal.svg') }}" alt="Bunaster Logo">
        </div>

        <h1>Crear cuenta</h1>
        <p class="subtitle">Uníte a la comunidad que vive el café ☕✨</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <label for="name">Nombre completo</label>
            <input id="name" class="input-modern" type="text" name="name" value="{{ old('name') }}" required>

            <label for="email" class="mt-3">Email</label>
            <input id="email" class="input-modern" type="email" name="email" value="{{ old('email') }}" required>

            <label for="password" class="mt-3">Contraseña</label>
            <input id="password" class="input-modern" type="password" name="password" required autocomplete="new-password">
            <small class="password-hint">Debe tener al menos 6 caracteres.</small>

            <label for="password_confirmation" class="mt-3">Confirmar contraseña</label>
            <input id="password_confirmation" class="input-modern" type="password" name="password_confirmation" required>

            <button type="submit" class="btn-primary-modern">
                Registrarme
            </button>

            <div class="extras">
                <p>¿Ya tenés cuenta? <a href="{{ route('login') }}">Iniciar sesión</a></p>
            </div>
        </form>
    </div>
</div>

</body>
</html>
