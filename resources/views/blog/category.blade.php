@extends('layouts.app-blog')
@section('content')
<div class="container">
    <h2 style="font-size:1.3rem;font-weight:700;color:#fff;margin-top:2rem;margin-bottom:0.5rem">
        Categoría: {{ ucfirst($category) }}
    </h2>
    <p style="color:#555;margin-bottom:1.5rem">{{ $articles->total() }} artículos encontrados</p>

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
        <p style="color:#555">No hay artículos en esta categoría aún.</p>
        @endforelse
    </div>

    <div style="margin-top:2rem;display:flex;justify-content:center">
        {{ $articles->links() }}
    </div>
</div>
@endsection