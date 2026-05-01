@extends('layouts.app-blog')
@section('content')
<div class="container" style="max-width:700px">
    <div style="margin-top:2rem;margin-bottom:1.5rem">
        <a href="/forum" style="color:#555;font-size:0.85rem">← Volver al foro</a>
        <h1 style="font-size:1.5rem;font-weight:800;color:#fff;margin-top:0.8rem">Crear nuevo hilo</h1>
    </div>

    @if($errors->any())
    <div style="background:#2a1a1a;border:1px solid #ef4444;border-radius:8px;padding:0.8rem 1rem;color:#ef4444;font-size:0.85rem;margin-bottom:1.5rem">
        {{ $errors->first() }}
    </div>
    @endif

    <form method="POST" action="/forum"
        style="background:#1a1a1a;border:1px solid #222;border-radius:12px;padding:2rem">
        @csrf

        <div style="margin-bottom:1.2rem">
            <label style="display:block;font-size:0.85rem;color:#aaa;margin-bottom:0.4rem">Categoría</label>
            <select name="category" required
                style="width:100%;background:#111;border:1px solid #333;border-radius:8px;padding:0.7rem 1rem;color:#fff;font-size:0.95rem;outline:none">
                <option value="">Selecciona una categoría</option>
                <option value="inteligencia-artificial">🤖 Inteligencia Artificial</option>
                <option value="ciberseguridad">🛡️ Ciberseguridad</option>
                <option value="tecnologia">💻 Tecnología</option>
                <option value="herramientas-dev">🛠️ Dev Tools</option>
                <option value="alertas-seguridad">🚨 Alertas de Seguridad</option>
                <option value="general">🌐 General</option>
            </select>
        </div>

        <div style="margin-bottom:1.2rem">
            <label style="display:block;font-size:0.85rem;color:#aaa;margin-bottom:0.4rem">Título del hilo</label>
            <input type="text" name="title" value="{{ old('title') }}" required
                placeholder="¿Sobre qué quieres hablar?"
                style="width:100%;background:#111;border:1px solid #333;border-radius:8px;padding:0.7rem 1rem;color:#fff;font-size:0.95rem;outline:none">
        </div>

        <div style="margin-bottom:1.5rem">
            <label style="display:block;font-size:0.85rem;color:#aaa;margin-bottom:0.4rem">Contenido</label>
            <textarea name="content" required rows="8"
                placeholder="Escribe tu mensaje aquí... (mínimo 20 caracteres)"
                style="width:100%;background:#111;border:1px solid #333;border-radius:8px;padding:0.7rem 1rem;color:#fff;font-size:0.95rem;outline:none;resize:vertical">{{ old('content') }}</textarea>
        </div>

        <button type="submit"
            style="background:#14b8a6;color:#fff;border:none;border-radius:8px;padding:0.75rem 2rem;font-size:1rem;font-weight:700;cursor:pointer">
            Publicar hilo
        </button>
    </form>
</div>
@endsection