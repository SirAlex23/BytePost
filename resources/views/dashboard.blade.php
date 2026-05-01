@extends('layouts.app-blog')
@section('content')
<div class="container">
    <div style="margin-top:2rem;margin-bottom:2rem;display:flex;justify-content:space-between;align-items:center">
        <div>
            <h1 style="font-size:1.5rem;font-weight:800;color:#fff">
                Hola, {{ auth()->user()->name }} 👋
            </h1>
            <p style="color:#555;font-size:0.9rem;margin-top:0.3rem">
                Rol: <span style="color:#6366f1;font-weight:600">{{ auth()->user()->role }}</span>
            </p>
        </div>
        <a href="/articles/create"
            style="background:#6366f1;color:#fff;padding:0.5rem 1.2rem;border-radius:8px;font-weight:600;font-size:0.9rem">
            + Nuevo artículo
        </a>
    </div>

    {{-- Acceso admin --}}
    @if(auth()->user()->isAdmin())
    <div style="background:#1a1a2e;border:1px solid #6366f1;border-radius:12px;padding:1rem 1.5rem;margin-bottom:1.5rem;display:flex;justify-content:space-between;align-items:center">
        <span style="color:#aaa;font-size:0.9rem">Tienes acceso al panel de administración</span>
        <a href="/admin" style="background:#6366f1;color:#fff;padding:0.4rem 1rem;border-radius:6px;font-size:0.85rem;font-weight:600">
            Ir al Admin ⚙️
        </a>
    </div>
    @endif

    <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:1rem">
        <a href="/articles/create"
            style="background:#1a1a1a;border:1px solid #222;border-radius:12px;padding:1.5rem;display:block">
            <div style="font-size:1.5rem">✍️</div>
            <div style="font-size:1rem;font-weight:700;color:#fff;margin-top:0.5rem">Escribir artículo</div>
            <div style="font-size:0.82rem;color:#555;margin-top:0.3rem">Crea y publica nuevo contenido</div>
        </a>
        <a href="/"
            style="background:#1a1a1a;border:1px solid #222;border-radius:12px;padding:1.5rem;display:block">
            <div style="font-size:1.5rem">🌐</div>
            <div style="font-size:1rem;font-weight:700;color:#fff;margin-top:0.5rem">Ver el blog</div>
            <div style="font-size:0.82rem;color:#555;margin-top:0.3rem">Visita BytePost como lector</div>
        </a>
    </div>
</div>
@endsection