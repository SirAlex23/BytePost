<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ForumController extends Controller
{
    // Listado de hilos
    public function index()
    {
        $threads = Thread::where('status', 'open')
                        ->orderBy('pinned', 'desc')
                        ->orderBy('created_at', 'desc')
                        ->paginate(20);

        $categories = [
            'inteligencia-artificial' => '🤖 IA',
            'ciberseguridad'          => '🛡️ Ciberseguridad',
            'tecnologia'              => '💻 Tecnología',
            'herramientas-dev'        => '🛠️ Dev Tools',
            'alertas-seguridad'       => '🚨 Alertas',
            'general'                 => '🌐 General',
        ];

        return view('forum.index', compact('threads', 'categories'));
    }

    // Ver hilo individual con respuestas
    public function show(string $slug)
    {
        $thread = Thread::where('slug', $slug)->firstOrFail();
        $thread->increment('views');

        $replies = Reply::where('thread_id', (string) $thread->id)
                        ->orderBy('created_at', 'asc')
                        ->get();

        return view('forum.show', compact('thread', 'replies'));
    }

    // Formulario nuevo hilo
    public function create()
    {
        return view('forum.create');
    }

    // Guardar nuevo hilo
    public function store(Request $request)
    {
        $request->validate([
            'title'    => ['required', 'string', 'max:255'],
            'content'  => ['required', 'string', 'min:20'],
            'category' => ['required', 'string'],
        ]);

        $slug  = Str::slug($request->title);
        $count = Thread::where('slug', 'like', $slug . '%')->count();
        if ($count > 0) $slug = $slug . '-' . ($count + 1);

        Thread::create([
            'title'        => $request->title,
            'slug'         => $slug,
            'content'      => $request->content,
            'category'     => $request->category,
            'author_id'    => auth()->id(),
            'author_name'  => auth()->user()->name,
            'status'       => 'open',
            'pinned'       => false,
            'views'        => 0,
            'replies_count'=> 0,
        ]);

        return redirect()->route('forum.index')->with('success', 'Hilo creado correctamente.');
    }

    // Guardar respuesta
    public function reply(Request $request, string $slug)
    {
        $request->validate([
            'content' => ['required', 'string', 'min:5'],
        ]);

        $thread = Thread::where('slug', $slug)->firstOrFail();

        Reply::create([
            'thread_id'   => (string) $thread->id,
            'content'     => $request->content,
            'author_id'   => auth()->id(),
            'author_name' => auth()->user()->name,
        ]);

        $thread->increment('replies_count');

        return back()->with('success', 'Respuesta añadida.');
    }

    // Eliminar hilo (solo admin)
    public function destroy(string $id)
    {
        $thread = Thread::findOrFail($id);

        if (auth()->id() !== (string) $thread->author_id && !auth()->user()->isAdmin()) {
            abort(403);
        }

        Reply::where('thread_id', $id)->delete();
        $thread->delete();

        return redirect()->route('forum.index')->with('success', 'Hilo eliminado.');
    }
}
