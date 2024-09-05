<?php

use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\StoryController;
use App\Http\Middleware\LocaleMiddleware;
use App\Models\Category;
use App\Models\Story;
use Illuminate\Support\Facades\Route;

// Para teste
auth()->loginUsingId(1);

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::middleware([LocaleMiddleware::class])->group(function () {
    Route::get('/change-language/{lang}', [LanguageController::class, 'changeLanguage'])->name('changeLanguage');
});

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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
