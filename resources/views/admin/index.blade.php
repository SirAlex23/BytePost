@extends('layouts.app-blog')
@section('content')
<div class="container">
    <div style="margin-top:2rem;margin-bottom:2rem;display:flex;justify-content:space-between;align-items:center">
        <h1 style="font-size:1.5rem;font-weight:800;color:#fff">⚙️ Panel de Admin</h1>
        <a href="/articles/create"
            style="background:#6366f1;color:#fff;padding:0.5rem 1.2rem;border-radius:8px;font-weight:600;font-size:0.9rem">
            + Nuevo artículo
        </a>
    </div>

    {{-- STATS --}}
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;margin-bottom:2rem">
        @foreach([
            ['label'=>'Total artículos','value'=>$stats['total_articles'],'color'=>'#6366f1'],
            ['label'=>'Publicados','value'=>$stats['published_articles'],'color'=>'#22c55e'],
            ['label'=>'Borradores','value'=>$stats['draft_articles'],'color'=>'#f59e0b'],
            ['label'=>'Usuarios','value'=>$stats['total_users'],'color'=>'#ec4899'],
        ] as $stat)
        <div style="background:#1a1a1a;border:1px solid #222;border-radius:12px;padding:1.5rem;text-align:center">
            <div style="font-size:2rem;font-weight:800;color:{{ $stat['color'] }}">{{ $stat['value'] }}</div>
            <div style="font-size:0.82rem;color:#666;margin-top:0.3rem">{{ $stat['label'] }}</div>
        </div>
        @endforeach
    </div>

    {{-- ÚLTIMOS ARTÍCULOS --}}
    <div style="background:#1a1a1a;border:1px solid #222;border-radius:12px;overflow:hidden">
        <div style="padding:1rem 1.5rem;border-bottom:1px solid #222;font-weight:700;color:#fff">
            Últimos artículos
        </div>
        @forelse($latestArticles as $article)
        <div style="padding:1rem 1.5rem;border-bottom:1px solid #1e1e1e;display:flex;justify-content:space-between;align-items:center">
            <div>
                <div style="font-size:0.92rem;color:#fff;font-weight:600">{{ Str::limit($article->title, 60) }}</div>
                <div style="font-size:0.78rem;color:#555;margin-top:0.2rem">
                    {{ $article->category }} · {{ $article->created_at->diffForHumans() }}
                </div>
            </div>
            <div style="display:flex;align-items:center;gap:0.8rem">
                <span style="font-size:0.75rem;padding:0.2rem 0.6rem;border-radius:20px;background:{{ $article->status === 'published' ? '#14532d' : '#451a03' }};color:{{ $article->status === 'published' ? '#22c55e' : '#f59e0b' }}">
                    {{ $article->status === 'published' ? 'Publicado' : 'Borrador' }}
                </span>
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
        <div style="padding:2rem;text-align:center;color:#555">No hay artículos aún.</div>
        @endforelse
    </div>

    {{-- ACCESOS RÁPIDOS --}}
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1rem;margin-top:1.5rem">
        <a href="/admin/users"
            style="background:#1a1a1a;border:1px solid #222;border-radius:12px;padding:1.2rem;text-align:center;display:block">
            <div style="font-size:1.5rem">👥</div>
            <div style="font-size:0.85rem;color:#aaa;margin-top:0.4rem">Gestionar usuarios</div>
        </a>
        <a href="/articles/create"
            style="background:#1a1a1a;border:1px solid #222;border-radius:12px;padding:1.2rem;text-align:center;display:block">
            <div style="font-size:1.5rem">✍️</div>
            <div style="font-size:0.85rem;color:#aaa;margin-top:0.4rem">Escribir artículo</div>
        </a>
        <a href="/"
            style="background:#1a1a1a;border:1px solid #222;border-radius:12px;padding:1.2rem;text-align:center;display:block">
            <div style="font-size:1.5rem">🌐</div>
            <div style="font-size:0.85rem;color:#aaa;margin-top:0.4rem">Ver el blog</div>
        </a>
        <a href="/admin/articles"
           style="background:#1a1a1a;border:1px solid #222;border-radius:12px;padding:1.2rem;text-align:center;display:block">
           <div style="font-size:1.5rem">📋</div>
           <div style="font-size:0.85rem;color:#aaa;margin-top:0.4rem">Todos los artículos</div>
        </a>
    </div>
</div>
@endsection