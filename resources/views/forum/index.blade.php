@extends('layouts.app-blog')
@section('content')
<div class="container">

    <div style="margin-top:2rem;margin-bottom:1.5rem;display:flex;justify-content:space-between;align-items:center">
        <div>
            <h1 style="font-size:1.5rem;font-weight:800;color:#fff">🌐 Forum</h1>
            <p style="color:#555;font-size:0.85rem;margin-top:0.3rem">Debate, pregunta y comparte con la comunidad</p>
        </div>
        @auth
        <a href="/forum/nuevo/hilo"
            style="background:#14b8a6;color:#fff;padding:0.5rem 1.2rem;border-radius:8px;font-weight:600;font-size:0.9rem">
            + Nuevo hilo
        </a>
        @else
        <a href="/login"
            style="background:#1e1e1e;color:#aaa;padding:0.5rem 1.2rem;border-radius:8px;font-size:0.9rem;border:1px solid #333">
            Inicia sesión para participar
        </a>
        @endauth
    </div>

    {{-- Categorías filtro --}}
    <div style="display:flex;gap:0.5rem;flex-wrap:wrap;margin-bottom:1.5rem">
        <a href="/forum" style="background:#1e1e1e;color:#aaa;padding:0.3rem 0.8rem;border-radius:20px;font-size:0.78rem;font-weight:600">
            Todos
        </a>
        @foreach($categories as $slug => $label)
        <a href="/forum?categoria={{ $slug }}"
            style="background:#1e1e1e;color:#aaa;padding:0.3rem 0.8rem;border-radius:20px;font-size:0.78rem;font-weight:600">
            {{ $label }}
        </a>
        @endforeach
    </div>

    {{-- Lista de hilos --}}
    <div style="background:#1a1a1a;border:1px solid #222;border-radius:12px;overflow:hidden">
        @forelse($threads as $thread)
        <a href="/forum/{{ $thread->slug }}"
            style="display:flex;justify-content:space-between;align-items:center;padding:1rem 1.5rem;border-bottom:1px solid #1e1e1e;transition:background 0.2s"
            onmouseover="this.style.background='#222'"
            onmouseout="this.style.background='transparent'">
            <div style="flex:1">
                @if($thread->pinned)
                <span style="font-size:0.7rem;background:#451a03;color:#f59e0b;padding:0.15rem 0.5rem;border-radius:4px;margin-right:0.5rem;font-weight:700">
                    📌 FIJADO
                </span>
                @endif
                <span style="font-size:0.72rem;color:#14b8a6;font-weight:700;text-transform:uppercase;margin-right:0.5rem">
                    {{ $thread->category }}
                </span>
                <div style="font-size:0.95rem;font-weight:600;color:#fff;margin-top:0.3rem">
                    {{ $thread->title }}
                </div>
                <div style="font-size:0.78rem;color:#555;margin-top:0.2rem">
                    por {{ $thread->author_name }} · {{ $thread->created_at->diffForHumans() }}
                </div>
            </div>
            <div style="text-align:right;min-width:80px">
                <div style="font-size:0.85rem;color:#aaa;font-weight:700">{{ $thread->replies_count }}</div>
                <div style="font-size:0.72rem;color:#555">respuestas</div>
                <div style="font-size:0.72rem;color:#444;margin-top:0.2rem">{{ $thread->views }} vistas</div>
            </div>
        </a>
        @empty
        <div style="padding:3rem;text-align:center;color:#555">
            No hay hilos aún. ¡Sé el primero en crear uno!
        </div>
        @endforelse
    </div>

    <div style="margin-top:1.5rem;display:flex;justify-content:center">
        {{ $threads->links() }}
    </div>
</div>
@endsection