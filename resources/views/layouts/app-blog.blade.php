<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'BytePost' }} — Tech News</title>
    <meta name="description" content="{{ $description ?? 'Las últimas noticias en IA, Ciberseguridad y Tecnología' }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #0f0f0f; color: #e5e5e5; }
        a { text-decoration: none; color: inherit; }

        /* NAVBAR */
        .navbar {
            background: #111; border-bottom: 1px solid #222;
            padding: 0 2rem; display: flex;
            justify-content: space-between; align-items: center;
            height: 64px; position: sticky; top: 0; z-index: 100;
        }
        .navbar-brand {
            font-size: 1.5rem; font-weight: 800;
            color: #6366f1; letter-spacing: -0.5px;
        }
        .navbar-brand span { color: #fff; }
        .navbar-links { display: flex; gap: 1.5rem; align-items: center; }
        .navbar-links a {
            color: #aaa; font-size: 0.9rem;
            transition: color 0.2s;
        }
        .navbar-links a:hover { color: #fff; }
        .btn-primary {
            background: #6366f1; color: #fff !important;
            padding: 0.4rem 1rem; border-radius: 6px;
            font-size: 0.85rem; font-weight: 600;
        }
        .btn-primary:hover { background: #4f46e5; }

        /* CATEGORÍAS BAR */
        .categories-bar {
            background: #111; border-bottom: 1px solid #1e1e1e;
            padding: 0.6rem 2rem; display: flex;
            gap: 0.5rem; overflow-x: auto;
        }
        .cat-pill {
            padding: 0.3rem 0.8rem; border-radius: 20px;
            font-size: 0.78rem; font-weight: 600;
            white-space: nowrap; background: #1e1e1e;
            color: #aaa; transition: all 0.2s;
        }
        .cat-pill:hover { color: #fff; background: #2a2a2a; }

        /* MAIN LAYOUT */
        .container { max-width: 1200px; margin: 0 auto; padding: 2rem; }

        /* CARDS */
        .articles-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
            gap: 1.5rem; margin-top: 2rem;
        }
        .article-card {
            background: #1a1a1a; border: 1px solid #222;
            border-radius: 12px; overflow: hidden;
            transition: transform 0.2s, border-color 0.2s;
        }
        .article-card:hover {
            transform: translateY(-4px);
            border-color: #6366f1;
        }
        .article-card img {
            width: 100%; height: 180px;
            object-fit: cover;
        }
        .article-card-body { padding: 1.2rem; }
        .article-category {
            font-size: 0.72rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.5px;
            color: #6366f1; margin-bottom: 0.5rem;
        }
        .article-title {
            font-size: 1rem; font-weight: 700;
            line-height: 1.4; margin-bottom: 0.5rem;
            color: #fff;
        }
        .article-excerpt {
            font-size: 0.83rem; color: #888;
            line-height: 1.5; margin-bottom: 1rem;
        }
        .article-meta {
            font-size: 0.75rem; color: #555;
            display: flex; gap: 1rem;
        }

        /* FEATURED */
        .featured-section { margin-top: 2rem; }
        .featured-section h2 {
            font-size: 1.1rem; font-weight: 700;
            color: #aaa; margin-bottom: 1rem;
            text-transform: uppercase; letter-spacing: 1px;
        }
        .featured-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 1rem;
        }
        .featured-main {
            background: #1a1a1a; border: 1px solid #222;
            border-radius: 12px; overflow: hidden;
        }
        .featured-main img { width: 100%; height: 260px; object-fit: cover; }
        .featured-main .body { padding: 1.2rem; }
        .featured-side {
            display: flex; flex-direction: column; gap: 1rem;
        }
        .featured-small {
            background: #1a1a1a; border: 1px solid #222;
            border-radius: 12px; overflow: hidden; flex: 1;
        }
        .featured-small img { width: 100%; height: 100px; object-fit: cover; }
        .featured-small .body { padding: 0.8rem; }

        /* FOOTER */
        footer {
            background: #111; border-top: 1px solid #222;
            text-align: center; padding: 2rem;
            color: #555; font-size: 0.82rem; margin-top: 4rem;
        }
        footer span { color: #6366f1; }
    </style>
</head>
<body>

<nav class="navbar">
    <a href="/" class="navbar-brand">Byte<span>Post</span></a>
    <div class="navbar-links">
    <a href="/categoria/inteligencia-artificial">🤖 IA</a>
    <a href="/categoria/ciberseguridad">🛡️ Ciberseguridad</a>
    <a href="/categoria/tecnologia">💻 Tecnología</a>
    <a href="/categoria/herramientas-dev">🛠️ Dev Tools</a>
    <a href="/categoria/alertas-seguridad" style="color:#ef4444;font-weight:700">🚨 Alertas</a>
    <a href="/forum" style="color:#14b8a6;font-weight:600">🌐 Forum</a>
        @auth
            <a href="/dashboard">Dashboard</a>
            <form method="POST" action="/logout" style="display:inline">
                @csrf
                <button type="submit" style="background:none;border:none;color:#aaa;cursor:pointer;font-size:0.9rem">Salir</button>
            </form>
        @else
            <a href="/login" class="btn-primary">Iniciar Sesión</a>
        @endauth
    </div>
</nav>

<main>
@yield('content')
</main>

<footer>
    <p>© {{ date('Y') }} <span>BytePost</span> — Tecnología, IA y Ciberseguridad</p>
</footer>

</body>
</html>