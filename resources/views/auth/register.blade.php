<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear cuenta — BytePost</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #0f0f0f;
            color: #e5e5e5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .auth-card {
            background: #1a1a1a;
            border: 1px solid #222;
            border-radius: 16px;
            padding: 2.5rem;
            width: 100%;
            max-width: 420px;
        }
        .brand {
            text-align: center;
            font-size: 1.8rem;
            font-weight: 800;
            color: #6366f1;
            margin-bottom: 0.3rem;
        }
        .brand span { color: #fff; }
        .subtitle {
            text-align: center;
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 2rem;
        }
        .form-group { margin-bottom: 1.2rem; }
        label {
            display: block;
            font-size: 0.85rem;
            color: #aaa;
            margin-bottom: 0.4rem;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            background: #111;
            border: 1px solid #333;
            border-radius: 8px;
            padding: 0.7rem 1rem;
            color: #fff;
            font-size: 0.95rem;
            outline: none;
            transition: border-color 0.2s;
        }
        input:focus { border-color: #6366f1; }
        .btn-register {
            width: 100%;
            background: #6366f1;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 0.75rem;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s;
            margin-top: 0.5rem;
        }
        .btn-register:hover { background: #4f46e5; }
        .divider {
            text-align: center;
            color: #444;
            font-size: 0.8rem;
            margin: 1.5rem 0;
            position: relative;
        }
        .divider::before, .divider::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 42%;
            height: 1px;
            background: #333;
        }
        .divider::before { left: 0; }
        .divider::after { right: 0; }
        .btn-login {
            width: 100%;
            background: transparent;
            color: #6366f1;
            border: 1px solid #6366f1;
            border-radius: 8px;
            padding: 0.75rem;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            text-align: center;
            display: block;
            transition: all 0.2s;
            text-decoration: none;
        }
        .btn-login:hover { background: #6366f1; color: #fff; }
        .error {
            background: #2a1a1a;
            border: 1px solid #ef4444;
            border-radius: 8px;
            padding: 0.7rem 1rem;
            color: #ef4444;
            font-size: 0.85rem;
            margin-bottom: 1.2rem;
        }
        .back-home {
            text-align: center;
            margin-top: 1.5rem;
        }
        .back-home a {
            color: #555;
            font-size: 0.82rem;
            text-decoration: none;
        }
        .back-home a:hover { color: #aaa; }
    </style>
</head>
<body>

<div class="auth-card">
    <div class="brand">Byte<span>Post</span></div>
    <p class="subtitle">Crea tu cuenta y empieza a escribir</p>

    @if($errors->any())
    <div class="error">
        {{ $errors->first() }}
    </div>
    @endif

    <form method="POST" action="/register">
        @csrf

        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" id="name" name="name"
                value="{{ old('name') }}" required autofocus>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email"
                value="{{ old('email') }}" required>
        </div>

        <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirmar contraseña</label>
            <input type="password" id="password_confirmation"
                name="password_confirmation" required>
        </div>

        <button type="submit" class="btn-register">Crear cuenta</button>
    </form>

    <div class="divider">¿ya tienes cuenta?</div>

    <a href="/login" class="btn-login">Iniciar Sesión</a>
</div>

<div class="back-home">
    <a href="/">← Volver al blog</a>
</div>

</body>
</html>