@extends('layouts.app-blog')
@section('content')
<div class="container" style="max-width:800px">

    {{-- BREADCRUMB --}}
    <div style="margin-top:2rem;margin-bottom:1.5rem;font-size:0.82rem;color:#555">
        <a href="/" style="color:#555">Inicio</a>
        <span style="margin:0 0.5rem">›</span>
        <a href="/categoria/{{ $article->category }}" style="color:#6366f1">{{ ucfirst($article->category) }}</a>
        <span style="margin:0 0.5rem">›</span>
        <span>{{ Str::limit($article->title, 50) }}</span>
    </div>

    {{-- HEADER --}}
    <div style="margin-bottom:2rem">
        <div style="font-size:0.8rem;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:#6366f1;margin-bottom:0.8rem">
            {{ ucfirst($article->category) }}
        </div>
        <h1 style="font-size:2rem;font-weight:800;line-height:1.3;color:#fff;margin-bottom:1rem">
            {{ $article->title }}
        </h1>
        <p style="font-size:1.05rem;color:#888;line-height:1.6;margin-bottom:1.5rem">
            {{ $article->excerpt }}
        </p>
        <div style="display:flex;align-items:center;gap:1.5rem;font-size:0.82rem;color:#555;padding-bottom:1.5rem;border-bottom:1px solid #222">
            <span>✍️ {{ $article->author->name ?? 'BytePost' }}</span>
            <span>🕐 {{ $article->reading_time }} min de lectura</span>
            <span>👁️ {{ $article->views }} vistas</span>
            <span>📅 {{ $article->published_at?->format('d/m/Y') }}</span>
        </div>
    </div>

    {{-- IMAGEN PORTADA --}}
    @if($article->cover_image)
    <img src="{{ $article->cover_image }}" alt="{{ $article->title }}"
        style="width:100%;border-radius:12px;margin-bottom:2rem;max-height:400px;object-fit:cover">
    @endif

    {{-- RESUMEN IA --}}
    @if($article->ai_summary)
    <div style="background:#1a1a2e;border:1px solid #6366f1;border-radius:12px;padding:1.2rem 1.5rem;margin-bottom:2rem">
        <div style="font-size:0.78rem;font-weight:700;color:#6366f1;text-transform:uppercase;letter-spacing:1px;margin-bottom:0.5rem">
            🤖 Resumen IA
        </div>
        <p style="color:#ccc;font-size:0.92rem;line-height:1.6">{{ $article->ai_summary }}</p>
    </div>
    @endif

    {{-- CONTENIDO --}}
    <div style="font-size:1rem;line-height:1.8;color:#ccc;margin-bottom:3rem">
        {!! nl2br(e($article->content)) !!}
    </div>

    {{-- TAGS --}}
    @if($article->tags && count($article->tags) > 0)
    <div style="margin-bottom:2rem;padding-top:1.5rem;border-top:1px solid #222">
        <span style="font-size:0.82rem;color:#555;margin-right:0.5rem">Tags:</span>
        @foreach($article->tags as $tag)
        <span style="background:#1e1e1e;color:#888;padding:0.25rem 0.7rem;border-radius:20px;font-size:0.78rem;margin-right:0.3rem">
            #{{ trim($tag) }}
        </span>
        @endforeach
    </div>
    @endif

    {{-- FUENTE ORIGINAL --}}
    @if($article->source_url)
    <div style="margin-bottom:2rem;padding:1rem 1.5rem;background:#1a1a1a;border:1px solid #222;border-radius:8px;font-size:0.85rem;color:#666">
        📰 Fuente original:
        <a href="{{ $article->source_url }}" target="_blank"
            style="color:#6366f1;margin-left:0.3rem">{{ $article->source ?? $article->source_url }}</a>
    </div>
    @endif

    {{-- ARTÍCULOS RELACIONADOS --}}
    @if($related->count() > 0)
    <div style="padding-top:2rem;border-top:1px solid #222">
        <h3 style="font-size:1rem;font-weight:700;color:#aaa;text-transform:uppercase;letter-spacing:1px;margin-bottom:1.5rem">
            📌 Artículos relacionados
        </h3>
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:1rem">
            @foreach($related as $rel)
            <a href="/articulo/{{ $rel->slug }}"
                style="background:#1a1a1a;border:1px solid #222;border-radius:10px;padding:1rem;display:block;transition:border-color 0.2s"
                onmouseover="this.style.borderColor='#6366f1'"
                onmouseout="this.style.borderColor='#222'">
                <div style="font-size:0.72rem;color:#6366f1;font-weight:700;margin-bottom:0.4rem">
                    {{ ucfirst($rel->category) }}
                </div>
                <div style="font-size:0.9rem;font-weight:700;color:#fff;line-height:1.3">
                    {{ Str::limit($rel->title, 70) }}
                </div>
                <div style="font-size:0.75rem;color:#555;margin-top:0.5rem">
                    {{ $rel->reading_time }} min · {{ $rel->published_at?->diffForHumans() }}
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection