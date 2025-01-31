<?php

use App\Http\Controllers\LanguageController;
use App\Http\Controllers\NeedController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\StoryController;
use Illuminate\Support\Facades\Route;

// Para teste
// auth()->loginUsingId(1);

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/sobre', function () {
    return view('about');
})->name('about');

Route::get('/orgaos_sociais', function () {
    return view('board');
})->name('board');

Route::get('/estatutos', function () {
    return view('statutes');
})->name('statutes');

Route::get('/relatorios', function () {
    return view('reports');
})->name('reports');

Route::get('/educacao', function () {
    return view('projects.education.index');
})->name('projects.education');

Route::get('/casa-da-mame', function () {
    return view('projects.mame.index');
})->name('projects.mame');

Route::get('/ceet', function () {
    return view('projects.ceet.index');
})->name('projects.ceet');

Route::get('/saude', function () {
    return view('projects.health.index');
})->name('projects.health');

Route::get('/academia-desportiva', function () {
    return view('projects.academy.index');
})->name('projects.academy');

Route::get('/ajudar', function () {
    return view('help');
})->name('help');

Route::get('/historias', function () {
    return view('tales.index');
})->name('tales');


Route::get('/stories', [StoryController::class, 'index'])->name('stories.index');
Route::get('/stories/create', [StoryController::class, 'create'])->name('stories.create');
Route::get('/stories/{story:slug}', [StoryController::class, 'show'])->name('stories.show');
Route::post('/stories', [StoryController::class, 'store']);
Route::get('/stories/{story:slug}/edit', [StoryController::class, 'edit'])->name('stories.edit');
Route::patch('/stories/{story:slug}', [StoryController::class, 'update']);
Route::delete('/stories/{story:slug}', [StoryController::class, 'destroy']);

Route::get('/partners', [PartnerController::class, 'index'])->name('partners.index');
Route::get('/partners/create', [PartnerController::class, 'create'])->name('partners.create');
Route::post('/partners', [PartnerController::class, 'store']);

Route::get('/needs', [NeedController::class, 'index'])->name('needs.index');

Route::post('/language-switch', [LanguageController::class, 'switch'])->name('language.switch');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/noticias/{year}/{month}/{title}', function($year, $month, $title) {
    if (view()->exists("/stories/$year/$month/$title"))
        return view("/stories/$year/$month/$title");
    else
        abort(404);
});
