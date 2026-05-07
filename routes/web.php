<?php

use App\Http\Controllers\ForumController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AdminController;

// Rutas públicas del blog
Route::get('/', [ArticleController::class, 'index'])->name('home');
Route::get('/articulo/{slug}', [ArticleController::class, 'show'])->name('article.show');
Route::get('/categoria/{category}', [ArticleController::class, 'byCategory'])->name('article.category');

// Rutas para usuarios autenticados (authors, editors, admins)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Gestión de artículos propios
    Route::resource('articles', ArticleController::class)
        ->except(['index', 'show']);
});

// Rutas solo para admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::patch('/users/{id}/role', [AdminController::class, 'updateRole'])->name('admin.users.role');
    Route::get('/articles', [AdminController::class, 'articles'])->name('admin.articles');
  
});

// Foro — lectura pública
Route::get('/forum', [ForumController::class, 'index'])->name('forum.index');
Route::get('/forum/{slug}', [ForumController::class, 'show'])->name('forum.show');

// Foro — requiere login
Route::middleware(['auth'])->group(function () {
    Route::get('/forum/nuevo/hilo', [ForumController::class, 'create'])->name('forum.create');
    Route::post('/forum', [ForumController::class, 'store'])->name('forum.store');
    Route::post('/forum/{slug}/reply', [ForumController::class, 'reply'])->name('forum.reply');
    Route::delete('/forum/{id}', [ForumController::class, 'destroy'])->name('forum.destroy');
});

require __DIR__.'/auth.php';

// Cron job para actualizar noticias (protegido por clave secreta)
Route::get('/fetch-news-secret', function() {
    if (request('key') !== env('CRON_SECRET_KEY')) {
        abort(403);
    }
    // Solo una categoría por llamada para no agotar créditos
    $categories = ['inteligencia-artificial', 'ciberseguridad', 'tecnologia', 'herramientas-dev', 'alertas-seguridad'];
    $hour = now()->hour;
    $category = $categories[$hour % 5];
    
    Artisan::call('bytepost:fetch-news', ['--category' => $category]);
    return 'OK - ' . $category . ' - ' . now();
});