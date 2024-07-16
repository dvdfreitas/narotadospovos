<?php

use App\Http\Controllers\LanguageController;
use App\Http\Controllers\StoryController;
use App\Http\Middleware\LocaleMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([LocaleMiddleware::class])->group(function () {
    Route::get('/change-language/{lang}', [LanguageController::class, 'changeLanguage'])->name('changeLanguage');
});


Route::get('/stories', [StoryController::class, 'index'])->name('stories.index');
Route::get('/stories/create', [StoryController::class, 'showCreateForm'])->name('stories.create');
Route::post('/stories', [StoryController::class, 'store']);
Route::get('/stories/{story}', [StoryController::class, 'show'])->name('stories.show');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
