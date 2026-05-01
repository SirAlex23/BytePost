@extends('layouts.app-blog')
@section('content')

    {{-- DESTACADOS --}}
    @if($featured->count() > 0)
    <div class="container">
        <div class="featured-section">
            <h2>⚡ Destacados</h2>
            <div class="featured-grid">
                {{-- Artículo principal --}}
                <a href="/articulo/{{ $featured[0]->slug }}" class="featured-main">
                    @if($featured[0]->cover_image)
                        <img src="{{ $featured[0]->cover_image }}" alt="{{ $featured[0]->title }}">
                    @endif
                    <div class="body">
                        <div class="article-category">{{ $featured[0]->category }}</div>
                        <div class="article-title" style="font-size:1.2rem">{{ $featured[0]->title }}</div>
                        <div class="article-excerpt">{{ $featured[0]->excerpt }}</div>
                        <div class="article-meta">
                            <span>{{ $featured[0]->reading_time }} min lectura</span>
                            <span>{{ $featured[0]->views }} vistas</span>
                        </div>
                    </div>
                </a>

                {{-- Artículos secundarios --}}
                <div class="featured-side">
                    @foreach($featured->skip(1) as $feat)
                    <a href="/articulo/{{ $feat->slug }}" class="featured-small">
                        @if($feat->cover_image)
                            <img src="{{ $feat->cover_image }}" alt="{{ $feat->title }}">
                        @endif
                        <div class="body">
                            <div class="article-category">{{ $feat->category }}</div>
                            <div class="article-title" style="font-size:0.9rem">{{ $feat->title }}</div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- TODOS LOS ARTÍCULOS --}}
    
    {{-- ALERTAS DE SEGURIDAD --}}
@if($alerts->count() > 0)
<div class="container" style="margin-top:2rem">
    <h2 style="font-size:1.1rem;font-weight:700;color:#ef4444;text-transform:uppercase;letter-spacing:1px;margin-bottom:1rem">
        🚨 Alertas de Seguridad
    </h2>
    <div class="articles-grid">
        @foreach($alerts as $alert)
        <a href="/articulo/{{ $alert->slug }}" class="article-card" style="border-color:#2a1a1a">
            @if($alert->cover_image)
                <img src="{{ $alert->cover_image }}" alt="{{ $alert->title }}">
            @endif
            <div class="article-card-body">
                <div class="article-category" style="color:#ef4444">🚨 Alerta</div>
                <div class="article-title">{{ $alert->title }}</div>
                <div class="article-excerpt">{{ Str::limit($alert->excerpt, 100) }}</div>
                <div class="article-meta">
                    <span>{{ $alert->reading_time }} min</span>
                    <span>{{ $alert->published_at?->diffForHumans() }}</span>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endif

    <div class="container">
        <h2 style="font-size:1.1rem;font-weight:700;color:#aaa;text-transform:uppercase;letter-spacing:1px;margin-top:2rem">
            🗞️ Últimas Noticias
        </h2>
        <div class="articles-grid">
            @forelse($articles as $article)
            <a href="/articulo/{{ $article->slug }}" class="article-card">
                @if($article->cover_image)
                    <img src="{{ $article->cover_image }}" alt="{{ $article->title }}">
                @endif
                <div class="article-card-body">
                    <div class="article-category">{{ $article->category }}</div>
                    <div class="article-title">{{ $article->title }}</div>
                    <div class="article-excerpt">{{ Str::limit($article->excerpt, 120) }}</div>
                    <div class="article-meta">
                        <span>{{ $article->reading_time }} min</span>
                        <span>{{ $article->views }} vistas</span>
                        <span>{{ $article->published_at?->diffForHumans() }}</span>
                    </div>
                </div>
            </a>
            @empty
            <p style="color:#555">No hay artículos publicados aún.</p>
            @endforelse
        </div>

        {{-- PAGINACIÓN --}}
        <div style="margin-top:2rem;display:flex;justify-content:center">
            {{ $articles->links() }}
        </div>
    </div>

    @endsection