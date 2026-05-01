<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    // Página principal del blog
    public function index()
    {
        // Últimas noticias de todas las categorías mezcladas
        $articles = Article::published()
                        ->orderBy('published_at', 'desc')
                        ->paginate(12);
    
        // Destacados
        $featured = Article::published()
                        ->where('featured', true)
                        ->orderBy('published_at', 'desc')
                        ->limit(3)
                        ->get();
    
        // Últimas alertas de seguridad para sección especial
        $alerts = Article::published()
                        ->where('category', 'alertas-seguridad')
                        ->orderBy('published_at', 'desc')
                        ->limit(4)
                        ->get();
    
        $categories = Category::all();
    
        return view('blog.index', compact('articles', 'featured', 'alerts', 'categories'));
    }

    // Ver artículo individual
    public function show(string $slug)
    {
        $article = Article::where('slug', $slug)
                        ->where('status', 'published')
                        ->firstOrFail();

        // Incrementar vistas
        $article->increment('views');

        // Artículos relacionados por categoría
        $related = Article::published()
                        ->where('category', $article->category)
                        ->where('slug', '!=', $slug)
                        ->limit(3)
                        ->get();

        return view('blog.show', compact('article', 'related'));
    }

    // Artículos por categoría
    public function byCategory(string $category)
    {
        $articles = Article::published()
                        ->byCategory($category)
                        ->orderBy('published_at', 'desc')
                        ->paginate(12);

        return view('blog.category', compact('articles', 'category'));
    }

    // Formulario crear artículo
    public function create()
    {
        $categories = Category::all();
        return view('blog.create', compact('categories'));
    }

    // Guardar artículo nuevo
    public function store(Request $request)
    {
        $request->validate([
            'title'      => ['required', 'string', 'max:255'],
            'content'    => ['required', 'string'],
            'category'   => ['required', 'string'],
            'status'     => ['required', 'in:draft,published'],
            'cover_image'=> ['nullable', 'url'],
        ]);

        $slug = Str::slug($request->title);

        // Evitar slugs duplicados
        $count = Article::where('slug', 'like', $slug . '%')->count();
        if ($count > 0) {
            $slug = $slug . '-' . ($count + 1);
        }

        // Calcular tiempo de lectura
        $wordCount   = str_word_count(strip_tags($request->content));
        $readingTime = max(1, ceil($wordCount / 200));

        Article::create([
            'title'            => $request->title,
            'slug'             => $slug,
            'excerpt'          => $request->excerpt ?? Str::limit(strip_tags($request->content), 160),
            'content'          => $request->content,
            'cover_image'      => $request->cover_image,
            'category'         => $request->category,
            'tags'             => $request->tags ? explode(',', $request->tags) : [],
            'author_id'        => auth()->id(),
            'status'           => $request->status,
            'reading_time'     => $readingTime,
            'views'            => 0,
            'featured'         => $request->boolean('featured'),
            'language'         => 'es',
            'meta_description' => $request->meta_description ?? Str::limit(strip_tags($request->content), 160),
            'published_at'     => $request->status === 'published' ? now() : null,
        ]);

        return redirect()->route('dashboard')->with('success', 'Artículo creado correctamente.');
    }

    // Formulario editar artículo
    public function edit(string $id)
    {
        $article    = Article::findOrFail($id);
        $categories = Category::all();

        // Solo el autor o admin puede editar
        if (auth()->id() !== (string) $article->author_id && !auth()->user()->isAdmin()) {
            abort(403);
        }

        return view('blog.edit', compact('article', 'categories'));
    }

    // Actualizar artículo
    public function update(Request $request, string $id)
    {
        $article = Article::findOrFail($id);

        if (auth()->id() !== (string) $article->author_id && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'title'    => ['required', 'string', 'max:255'],
            'content'  => ['required', 'string'],
            'category' => ['required', 'string'],
            'status'   => ['required', 'in:draft,published'],
        ]);

        $wordCount   = str_word_count(strip_tags($request->content));
        $readingTime = max(1, ceil($wordCount / 200));

        $article->update([
            'title'            => $request->title,
            'excerpt'          => $request->excerpt ?? Str::limit(strip_tags($request->content), 160),
            'content'          => $request->content,
            'cover_image'      => $request->cover_image,
            'category'         => $request->category,
            'tags'             => $request->tags ? explode(',', $request->tags) : [],
            'status'           => $request->status,
            'reading_time'     => $readingTime,
            'featured'         => $request->boolean('featured'),
            'meta_description' => $request->meta_description ?? Str::limit(strip_tags($request->content), 160),
            'published_at'     => $request->status === 'published' && !$article->published_at ? now() : $article->published_at,
        ]);

        return redirect()->route('dashboard')->with('success', 'Artículo actualizado correctamente.');
    }

    // Eliminar artículo
    public function destroy(string $id)
    {
        $article = Article::findOrFail($id);

        if (auth()->id() !== (string) $article->author_id && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $article->delete();

        return redirect()->route('dashboard')->with('success', 'Artículo eliminado correctamente.');
    }
}