@extends('layouts.app-blog')
@section('content')
<div class="container" style="max-width:800px">
    <div style="margin-top:2rem;margin-bottom:1.5rem">
        <a href="/dashboard" style="color:#555;font-size:0.85rem">← Volver al dashboard</a>
        <h1 style="font-size:1.5rem;font-weight:800;color:#fff;margin-top:0.8rem">✏️ Editar artículo</h1>
    </div>

    @if($errors->any())
    <div style="background:#2a1a1a;border:1px solid #ef4444;border-radius:8px;padding:0.8rem 1rem;color:#ef4444;font-size:0.85rem;margin-bottom:1.5rem">
        {{ $errors->first() }}
    </div>
    @endif

    @if(session('success'))
    <div style="background:#14532d;border:1px solid #22c55e;border-radius:8px;padding:0.8rem 1rem;color:#22c55e;font-size:0.85rem;margin-bottom:1.5rem">
        {{ session('success') }}
    </div>
    @endif

    <form method="POST" action="/articles/{{ $article->id }}"
        style="background:#1a1a1a;border:1px solid #222;border-radius:12px;padding:2rem">
        @csrf
        @method('PUT')

        <div style="margin-bottom:1.2rem">
            <label style="display:block;font-size:0.85rem;color:#aaa;margin-bottom:0.4rem">Título *</label>
            <input type="text" name="title" value="{{ old('title', $article->title) }}" required
                style="width:100%;background:#111;border:1px solid #333;border-radius:8px;padding:0.7rem 1rem;color:#fff;font-size:0.95rem;outline:none">
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1.2rem">
            <div>
                <label style="display:block;font-size:0.85rem;color:#aaa;margin-bottom:0.4rem">Categoría *</label>
                <select name="category" required
                    style="width:100%;background:#111;border:1px solid #333;border-radius:8px;padding:0.7rem 1rem;color:#fff;font-size:0.95rem;outline:none">
                    @foreach($categories as $cat)
                    <option value="{{ $cat->slug }}" {{ $article->category == $cat->slug ? 'selected' : '' }}>
                        {{ $cat->icon }} {{ $cat->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label style="display:block;font-size:0.85rem;color:#aaa;margin-bottom:0.4rem">Estado *</label>
                <select name="status" required
                    style="width:100%;background:#111;border:1px solid #333;border-radius:8px;padding:0.7rem 1rem;color:#fff;font-size:0.95rem;outline:none">
                    <option value="draft" {{ $article->status == 'draft' ? 'selected' : '' }}>Borrador</option>
                    <option value="published" {{ $article->status == 'published' ? 'selected' : '' }}>Publicado</option>
                    <option value="archived" {{ $article->status == 'archived' ? 'selected' : '' }}>Archivado</option>
                </select>
            </div>
        </div>

        <div style="margin-bottom:1.2rem">
            <label style="display:block;font-size:0.85rem;color:#aaa;margin-bottom:0.4rem">URL imagen de portada</label>
            <input type="url" name="cover_image" value="{{ old('cover_image', $article->cover_image) }}"
                style="width:100%;background:#111;border:1px solid #333;border-radius:8px;padding:0.7rem 1rem;color:#fff;font-size:0.95rem;outline:none">
        </div>

        <div style="margin-bottom:1.2rem">
            <label style="display:block;font-size:0.85rem;color:#aaa;margin-bottom:0.4rem">Resumen corto</label>
            <textarea name="excerpt" rows="2"
                style="width:100%;background:#111;border:1px solid #333;border-radius:8px;padding:0.7rem 1rem;color:#fff;font-size:0.95rem;outline:none;resize:vertical">{{ old('excerpt', $article->excerpt) }}</textarea>
        </div>

        <div style="margin-bottom:1.2rem">
            <label style="display:block;font-size:0.85rem;color:#aaa;margin-bottom:0.4rem">Contenido *</label>
            <textarea name="content" required rows="16"
                style="width:100%;background:#111;border:1px solid #333;border-radius:8px;padding:0.7rem 1rem;color:#fff;font-size:0.95rem;outline:none;resize:vertical;font-family:monospace">{{ old('content', $article->content) }}</textarea>
        </div>

        <div style="margin-bottom:1.2rem">
            <label style="display:block;font-size:0.85rem;color:#aaa;margin-bottom:0.4rem">Tags (separados por comas)</label>
            <input type="text" name="tags" value="{{ old('tags', implode(', ', $article->tags ?? [])) }}"
                style="width:100%;background:#111;border:1px solid #333;border-radius:8px;padding:0.7rem 1rem;color:#fff;font-size:0.95rem;outline:none">
        </div>

        <div style="margin-bottom:1.5rem;display:flex;align-items:center;gap:0.8rem">
            <input type="checkbox" id="featured" name="featured" value="1"
                {{ $article->featured ? 'checked' : '' }}
                style="width:16px;height:16px;accent-color:#6366f1">
            <label for="featured" style="font-size:0.88rem;color:#aaa;margin:0">
                ⭐ Artículo destacado
            </label>
        </div>

        <div style="display:flex;gap:1rem;flex-wrap:wrap">
            <button type="submit"
                style="background:#6366f1;color:#fff;border:none;border-radius:8px;padding:0.75rem 2rem;font-size:1rem;font-weight:700;cursor:pointer">
                Actualizar artículo
            </button>
            <a href="/articulo/{{ $article->slug }}"
                style="background:#1e1e1e;color:#aaa;border:1px solid #333;border-radius:8px;padding:0.75rem 1.5rem;font-size:1rem;font-weight:600;text-decoration:none">
                Ver artículo
            </a>
            <form method="POST" action="/articles/{{ $article->id }}" style="display:inline">
                @csrf @method('DELETE')
                <button type="submit"
                    onclick="return confirm('¿Seguro que quieres eliminar este artículo?')"
                    style="background:#2a1a1a;color:#ef4444;border:1px solid #ef4444;border-radius:8px;padding:0.75rem 1.5rem;font-size:1rem;font-weight:600;cursor:pointer">
                    Eliminar
                </button>
            </form>
        </div>
    </form>
</div>
@endsection