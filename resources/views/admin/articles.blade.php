@extends('layouts.app-blog')
@section('content')
<div class="container">
    <div style="margin-top:2rem;margin-bottom:1.5rem;display:flex;justify-content:space-between;align-items:center">
        <div>
            <a href="/admin" style="color:#555;font-size:0.85rem">← Volver al admin</a>
            <h1 style="font-size:1.5rem;font-weight:800;color:#fff;margin-top:0.5rem">📋 Todos los artículos</h1>
        </div>
        <a href="/articles/create"
            style="background:#6366f1;color:#fff;padding:0.5rem 1.2rem;border-radius:8px;font-weight:600;font-size:0.9rem">
            + Nuevo artículo
        </a>
    </div>

    @if(session('success'))
    <div style="background:#14532d;border:1px solid #22c55e;border-radius:8px;padding:0.8rem 1rem;color:#22c55e;font-size:0.85rem;margin-bottom:1.5rem">
        {{ session('success') }}
    </div>
    @endif

    <div style="background:#1a1a1a;border:1px solid #222;border-radius:12px;overflow:hidden">
        <div style="padding:0.8rem 1.5rem;border-bottom:1px solid #2a2a2a;display:grid;grid-template-columns:3fr 1fr 1fr 1fr;font-size:0.78rem;color:#555;font-weight:700;text-transform:uppercase">
            <span>Artículo</span>
            <span>Categoría</span>
            <span>Estado</span>
            <span>Acciones</span>
        </div>

        @forelse($articles as $article)
        <div style="padding:0.9rem 1.5rem;border-bottom:1px solid #1e1e1e;display:grid;grid-template-columns:3fr 1fr 1fr 1fr;align-items:center">
            <div>
                <div style="font-size:0.88rem;font-weight:600;color:#fff">
                    {{ Str::limit($article->title, 70) }}
                </div>
                <div style="font-size:0.75rem;color:#555;margin-top:0.2rem">
                    {{ $article->created_at->diffForHumans() }}
                    @if($article->source)
                    · <span style="color:#444">{{ $article->source }}</span>
                    @endif
                </div>
            </div>
            <div style="font-size:0.78rem;color:#6366f1;font-weight:600">
                {{ $article->category }}
            </div>
            <div>
                <span style="font-size:0.75rem;padding:0.2rem 0.6rem;border-radius:20px;
                    background:{{ $article->status === 'published' ? '#14532d' : ($article->status === 'draft' ? '#451a03' : '#1a1a1a') }};
                    color:{{ $article->status === 'published' ? '#22c55e' : ($article->status === 'draft' ? '#f59e0b' : '#666') }}">
                    {{ $article->status === 'published' ? 'Publicado' : ($article->status === 'draft' ? 'Borrador' : 'Archivado') }}
                </span>
            </div>
            <div style="display:flex;gap:0.8rem;align-items:center">
                <a href="/articulo/{{ $article->slug }}"
                    style="font-size:0.78rem;color:#aaa">Ver</a>
                <a href="/articles/{{ $article->id }}/edit"
                    style="font-size:0.78rem;color:#6366f1">Editar</a>
                <form method="POST" action="/articles/{{ $article->id }}" style="display:inline">
                    @csrf @method('DELETE')
                    <button type="submit"
                        onclick="return confirm('¿Eliminar este artículo?')"
                        style="font-size:0.78rem;color:#ef4444;background:none;border:none;cursor:pointer">
                        Eliminar
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div style="padding:3rem;text-align:center;color:#555">No hay artículos.</div>
        @endforelse
    </div>

    <div style="margin-top:1.5rem;display:flex;justify-content:center">
        {{ $articles->links() }}
    </div>
</div>
@endsection