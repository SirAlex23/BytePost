@extends('layouts.app-blog')
@section('content')
<div class="container" style="max-width:800px">

    <div style="margin-top:2rem;margin-bottom:1.5rem;font-size:0.82rem;color:#555">
        <a href="/forum" style="color:#555">Forum</a>
        <span style="margin:0 0.5rem">›</span>
        <span style="color:#14b8a6">{{ $thread->category }}</span>
    </div>

    {{-- HILO PRINCIPAL --}}
    <div style="background:#1a1a1a;border:1px solid #222;border-radius:12px;padding:1.5rem;margin-bottom:1.5rem">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:1rem">
            <div>
                <span style="font-size:0.75rem;color:#14b8a6;font-weight:700;text-transform:uppercase">
                    {{ $thread->category }}
                </span>
                <h1 style="font-size:1.4rem;font-weight:800;color:#fff;margin-top:0.3rem">
                    {{ $thread->title }}
                </h1>
            </div>
            @if(auth()->check() && auth()->user()->isAdmin())
            <form method="POST" action="/forum/{{ $thread->id }}" style="display:inline">
                @csrf @method('DELETE')
                <button type="submit"
                    style="background:#2a1a1a;border:1px solid #ef4444;color:#ef4444;padding:0.3rem 0.7rem;border-radius:6px;font-size:0.78rem;cursor:pointer">
                    Eliminar
                </button>
            </form>
            @endif
        </div>

        <div style="font-size:0.95rem;color:#ccc;line-height:1.7;margin-bottom:1rem">
            {!! nl2br(e($thread->content)) !!}
        </div>

        <div style="font-size:0.78rem;color:#555;display:flex;gap:1rem">
            <span>✍️ {{ $thread->author_name }}</span>
            <span>📅 {{ $thread->created_at->diffForHumans() }}</span>
            <span>👁️ {{ $thread->views }} vistas</span>
            <span>💬 {{ $thread->replies_count }} respuestas</span>
        </div>
    </div>

    {{-- RESPUESTAS --}}
    @if($replies->count() > 0)
    <h3 style="font-size:0.9rem;font-weight:700;color:#aaa;text-transform:uppercase;letter-spacing:1px;margin-bottom:1rem">
        💬 {{ $replies->count() }} Respuestas
    </h3>
    @foreach($replies as $reply)
    <div style="background:#1a1a1a;border:1px solid #1e1e1e;border-radius:10px;padding:1.2rem;margin-bottom:0.8rem;border-left:3px solid #14b8a6">
        <div style="font-size:0.95rem;color:#ccc;line-height:1.7;margin-bottom:0.8rem">
            {!! nl2br(e($reply->content)) !!}
        </div>
        <div style="font-size:0.75rem;color:#555">
            ✍️ {{ $reply->author_name }} · {{ $reply->created_at->diffForHumans() }}
        </div>
    </div>
    @endforeach
    @endif

    {{-- FORMULARIO RESPUESTA --}}
    @auth
    <div style="background:#1a1a1a;border:1px solid #222;border-radius:12px;padding:1.5rem;margin-top:1.5rem">
        <h3 style="font-size:1rem;font-weight:700;color:#fff;margin-bottom:1rem">💬 Añadir respuesta</h3>

        @if(session('success'))
        <div style="background:#14532d;border:1px solid #22c55e;border-radius:8px;padding:0.7rem 1rem;color:#22c55e;font-size:0.85rem;margin-bottom:1rem">
            {{ session('success') }}
        </div>
        @endif

        <form method="POST" action="/forum/{{ $thread->slug }}/reply">
            @csrf
            <textarea name="content" required rows="4"
                placeholder="Escribe tu respuesta..."
                style="width:100%;background:#111;border:1px solid #333;border-radius:8px;padding:0.7rem 1rem;color:#fff;font-size:0.95rem;outline:none;resize:vertical;margin-bottom:1rem"></textarea>
            <button type="submit"
                style="background:#14b8a6;color:#fff;border:none;border-radius:8px;padding:0.6rem 1.5rem;font-size:0.9rem;font-weight:700;cursor:pointer">
                Responder
            </button>
        </form>
    </div>
    @else
    <div style="background:#1a1a1a;border:1px solid #222;border-radius:12px;padding:1.5rem;margin-top:1.5rem;text-align:center;color:#555">
        <a href="/login" style="color:#14b8a6;font-weight:600">Inicia sesión</a> para participar en la conversación
    </div>
    @endauth

</div>
@endsection