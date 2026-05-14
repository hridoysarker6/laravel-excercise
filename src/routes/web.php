<?php

use App\Http\Controllers\ProfileController;
use App\Models\KnowledgeArticle;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('kb/search',function () {
    $query = request('query');
    $results = KnowledgeArticle::whereVectorSimilarTo('embedding', $query)
        ->limit(3)
        ->get();
        return $results->map(function ($article) {
            return [
                'title' => $article->title,
                'category' => $article->category,
                'content' => str($article->content)->limit(100),
            ];
        });
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
