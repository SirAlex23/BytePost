@extends('layouts.app-blog')
@section('content')
<div class="container">
    <div style="margin-top:2rem;margin-bottom:1.5rem;display:flex;justify-content:space-between;align-items:center">
        <div>
            <a href="/admin" style="color:#555;font-size:0.85rem">← Volver al admin</a>
            <h1 style="font-size:1.5rem;font-weight:800;color:#fff;margin-top:0.5rem">👥 Gestión de usuarios</h1>
        </div>
        <div style="font-size:0.85rem;color:#555">{{ $users->count() }} usuarios registrados</div>
    </div>

    @if(session('success'))
    <div style="background:#14532d;border:1px solid #22c55e;border-radius:8px;padding:0.8rem 1rem;color:#22c55e;font-size:0.85rem;margin-bottom:1.5rem">
        {{ session('success') }}
    </div>
    @endif

    <div style="background:#1a1a1a;border:1px solid #222;border-radius:12px;overflow:hidden">

        {{-- CABECERA --}}
        <div style="display:grid;grid-template-columns:2fr 1fr 1fr 1fr;padding:0.8rem 1.5rem;border-bottom:1px solid #2a2a2a;font-size:0.78rem;color:#555;font-weight:700;text-transform:uppercase;letter-spacing:0.5px">
            <span>Usuario</span>
            <span>Rol actual</span>
            <span>Registrado</span>
            <span>Cambiar rol</span>
        </div>

        @forelse($users as $user)
        <div style="display:grid;grid-template-columns:2fr 1fr 1fr 1fr;padding:1rem 1.5rem;border-bottom:1px solid #1e1e1e;align-items:center">

            {{-- INFO USUARIO --}}
            <div>
                <div style="font-size:0.92rem;font-weight:600;color:#fff">{{ $user->name }}</div>
                <div style="font-size:0.78rem;color:#555;margin-top:0.2rem">{{ $user->email }}</div>
            </div>

            {{-- ROL BADGE --}}
            <div>
                @php
                    $colors = [
                        'admin'  => ['bg'=>'#1a1a3e','border'=>'#6366f1','text'=>'#6366f1'],
                        'editor' => ['bg'=>'#1a2e1a','border'=>'#22c55e','text'=>'#22c55e'],
                        'author' => ['bg'=>'#1a1a1a','border'=>'#555','text'=>'#aaa'],
                    ];
                    $c = $colors[$user->role] ?? $colors['author'];
                @endphp
                <span style="background:{{ $c['bg'] }};border:1px solid {{ $c['border'] }};color:{{ $c['text'] }};padding:0.2rem 0.7rem;border-radius:20px;font-size:0.75rem;font-weight:700">
                    {{ ucfirst($user->role) }}
                </span>
            </div>

            {{-- FECHA --}}
            <div style="font-size:0.78rem;color:#555">
                {{ $user->created_at->format('d/m/Y') }}
            </div>

            {{-- CAMBIAR ROL --}}
            <div>
                @if($user->id !== auth()->id())
                <form method="POST" action="/admin/users/{{ $user->id }}/role"
                    style="display:flex;gap:0.5rem;align-items:center">
                    @csrf @method('PATCH')
                    <select name="role"
                        style="background:#111;border:1px solid #333;border-radius:6px;padding:0.3rem 0.5rem;color:#fff;font-size:0.8rem;outline:none">
                        <option value="author"  {{ $user->role == 'author'  ? 'selected' : '' }}>Author</option>
                        <option value="editor"  {{ $user->role == 'editor'  ? 'selected' : '' }}>Editor</option>
                        <option value="admin"   {{ $user->role == 'admin'   ? 'selected' : '' }}>Admin</option>
                    </select>
                    <button type="submit"
                        style="background:#6366f1;color:#fff;border:none;border-radius:6px;padding:0.3rem 0.7rem;font-size:0.78rem;font-weight:600;cursor:pointer">
                        ✓
                    </button>
                </form>
                @else
                <span style="font-size:0.78rem;color:#555">Tú mismo</span>
                @endif
            </div>
        </div>
        @empty
        <div style="padding:3rem;text-align:center;color:#555">No hay usuarios registrados.</div>
        @endforelse
    </div>

    {{-- LEYENDA DE ROLES --}}
    <div style="margin-top:1.5rem;background:#1a1a1a;border:1px solid #222;border-radius:12px;padding:1.2rem 1.5rem">
        <div style="font-size:0.82rem;color:#555;font-weight:700;margin-bottom:0.8rem;text-transform:uppercase;letter-spacing:0.5px">
            Permisos por rol
        </div>
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1rem;font-size:0.8rem">
            <div>
                <span style="color:#aaa;font-weight:700">👤 Author</span>
                <div style="color:#555;margin-top:0.3rem">Crea y edita sus propios artículos y hilos del foro</div>
            </div>
            <div>
                <span style="color:#22c55e;font-weight:700">✏️ Editor</span>
                <div style="color:#555;margin-top:0.3rem">Todo lo de Author + puede editar artículos de otros</div>
            </div>
            <div>
                <span style="color:#6366f1;font-weight:700">⚙️ Admin</span>
                <div style="color:#555;margin-top:0.3rem">Acceso total — gestión de usuarios, artículos y foro</div>
            </div>
        </div>
    </div>
</div>
@endsection