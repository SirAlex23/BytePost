@extends('layouts.app-blog')
@section('content')
<div class="container" style="max-width:800px">
    <div style="margin-top:2rem;margin-bottom:1.5rem">
        <a href="/dashboard" style="color:#555;font-size:0.85rem">← Volver al dashboard</a>
        <h1 style="font-size:1.5rem;font-weight:800;color:#fff;margin-top:0.8rem">✍️ Nuevo artículo</h1>
    </div>

    @if($errors->any())
    <div style="background:#2a1a1a;border:1px solid #ef4444;border-radius:8px;padding:0.8rem 1rem;color:#ef4444;font-size:0.85rem;margin-bottom:1.5rem">
        {{ $errors->first() }}
    </div>
    @endif

    <form method="POST" action="/articles"
        style="background:#1a1a1a;border:1px solid #222;border-radius:12px;padding:2rem">
        @csrf

        {{-- TÍTULO --}}
        <div style="margin-bottom:1.2rem">
            <label style="display:block;font-size:0.85rem;color:#aaa;margin-bottom:0.4rem">Título *</label>
            <input type="text" name="title" value="{{ old('title') }}" required
                placeholder="Título del artículo"
                style="width:100%;background:#111;border:1px solid #333;border-radius:8px;padding:0.7rem 1rem;color:#fff;font-size:0.95rem;outline:none">
        </div>

        {{-- CATEGORÍA Y ESTADO --}}
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1.2rem">
            <div>
                <label style="display:block;font-size:0.85rem;color:#aaa;margin-bottom:0.4rem">Categoría *</label>
                <select name="category" required
                    style="width:100%;background:#111;border:1px solid #333;border-radius:8px;padding:0.7rem 1rem;color:#fff;font-size:0.95rem;outline:none">
                    <option value="">Selecciona categoría</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->slug }}" {{ old('category') == $cat->slug ? 'selected' : '' }}>
                        {{ $cat->icon }} {{ $cat->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label style="display:block;font-size:0.85rem;color:#aaa;margin-bottom:0.4rem">Estado *</label>
                <select name="status" required
                    style="width:100%;background:#111;border:1px solid #333;border-radius:8px;padding:0.7rem 1rem;color:#fff;font-size:0.95rem;outline:none">
                    <option value="draft">Borrador</option>
                    <option value="published">Publicar ahora</option>
                </select>
            </div>
        </div>

        {{-- IMAGEN PORTADA --}}
        <div style="margin-bottom:1.2rem">
            <label style="display:block;font-size:0.85rem;color:#aaa;margin-bottom:0.4rem">URL imagen de portada</label>
            <input type="url" name="cover_image" value="{{ old('cover_image') }}"
                placeholder="https://ejemplo.com/imagen.jpg"
                style="width:100%;background:#111;border:1px solid #333;border-radius:8px;padding:0.7rem 1rem;color:#fff;font-size:0.95rem;outline:none">
        </div>

        {{-- EXCERPT --}}
        <div style="margin-bottom:1.2rem">
            <label style="display:block;font-size:0.85rem;color:#aaa;margin-bottom:0.4rem">
                Resumen corto <span style="color:#555">(si lo dejas vacío se genera automáticamente)</span>
            </label>
            <textarea name="excerpt" rows="2"
                placeholder="Breve descripción del artículo..."
                style="width:100%;background:#111;border:1px solid #333;border-radius:8px;padding:0.7rem 1rem;color:#fff;font-size:0.95rem;outline:none;resize:vertical">{{ old('excerpt') }}</textarea>
        </div>

        {{-- CONTENIDO --}}
        <div style="margin-bottom:1.2rem">
            <label style="display:block;font-size:0.85rem;color:#aaa;margin-bottom:0.4rem">Contenido *</label>
            <textarea name="content" required rows="16"
                placeholder="Escribe el contenido del artículo aquí..."
                style="width:100%;background:#111;border:1px solid #333;border-radius:8px;padding:0.7rem 1rem;color:#fff;font-size:0.95rem;outline:none;resize:vertical;font-family:monospace">{{ old('content') }}</textarea>
        </div>

        {{-- TAGS --}}
        <div style="margin-bottom:1.2rem">
            <label style="display:block;font-size:0.85rem;color:#aaa;margin-bottom:0.4rem">
                Tags <span style="color:#555">(separados por comas)</span>
            </label>
            <input type="text" name="tags" value="{{ old('tags') }}"
                placeholder="laravel, mongodb, ciberseguridad"
                style="width:100%;background:#111;border:1px solid #333;border-radius:8px;padding:0.7rem 1rem;color:#fff;font-size:0.95rem;outline:none">
        </div>

        {{-- META DESCRIPTION --}}
        <div style="margin-bottom:1.2rem">
            <label style="display:block;font-size:0.85rem;color:#aaa;margin-bottom:0.4rem">
                Meta descripción SEO <span style="color:#555">(opcional)</span>
            </label>
            <input type="text" name="meta_description" value="{{ old('meta_description') }}"
                placeholder="Descripción para buscadores (max 160 caracteres)"
                maxlength="160"
                style="width:100%;background:#111;border:1px solid #333;border-radius:8px;padding:0.7rem 1rem;color:#fff;font-size:0.95rem;outline:none">
        </div>

        {{-- DESTACADO --}}
        <div style="margin-bottom:1.5rem;display:flex;align-items:center;gap:0.8rem">
            <input type="checkbox" id="featured" name="featured" value="1"
                style="width:16px;height:16px;accent-color:#6366f1">
            <label for="featured" style="font-size:0.88rem;color:#aaa;margin:0">
                ⭐ Marcar como artículo destacado (aparece en portada)
            </label>
        </div>

        {{-- BOTONES --}}
        <div style="display:flex;gap:1rem">
            <button type="submit"
                style="background:#6366f1;color:#fff;border:none;border-radius:8px;padding:0.75rem 2rem;font-size:1rem;font-weight:700;cursor:pointer">
                Guardar artículo
            </button>
            <a href="/dashboard"
                style="background:#1e1e1e;color:#aaa;border:1px solid #333;border-radius:8px;padding:0.75rem 1.5rem;font-size:1rem;font-weight:600">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection