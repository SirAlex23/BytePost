<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_articles'     => Article::count(),
            'published_articles' => Article::where('status', 'published')->count(),
            'draft_articles'     => Article::where('status', 'draft')->count(),
            'total_users'        => User::count(),
        ];

        $latestArticles = Article::orderBy('created_at', 'desc')->limit(5)->get();

        return view('admin.index', compact('stats', 'latestArticles'));
    }

    public function users()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.users', compact('users'));
    }

    public function updateRole(Request $request, string $id)
    {
        $request->validate([
            'role' => ['required', 'in:author,editor,admin'],
        ]);

        $user = User::findOrFail($id);
        $user->update(['role' => $request->role]);

        return back()->with('success', 'Rol actualizado correctamente.');
    }

    public function articles()
{
    $articles = Article::orderBy('created_at', 'desc')->paginate(30);
    return view('admin.articles', compact('articles'));
}
}

