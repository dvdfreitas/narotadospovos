<?php

use App\Http\Controllers\LanguageController;
use App\Http\Controllers\NeedController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\StoryController;
use App\Models\Donation;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

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


// Campanha de Natal — DESACTIVADA.
// O modal cria donativos sem pedir pagamento. Reactivar quando o MB Way
// estiver a funcionar. Ver documentation/backlog.md
//
// Volt::route('/natal', 'campaigns.christmas25.board')
//     ->name('christmas.board');
//
// Volt::route('/cards/christmas/{code}', 'campaigns.christmas25.card')
//     ->name('cards.christmas');


// Política de privacidade — cobre os donativos, a Loja Solidária e as campanhas.
Volt::route('/privacidade', 'privacy-policy')
    ->name('privacy');

// A morada antiga circulou nos donativos de Natal.
Route::redirect('/natal/privacidade', '/privacidade', 301);


// Loja Solidária — acessível por link directo, fora do menu.
Volt::route('/loja-solidaria', 'shop.index')
    ->name('shop.index');


// Histórias e parceiros — ler é público, escrever exige sessão.
//
// O índice vive em /noticias e não em /stories: public/stories é a pasta
// das imagens das notícias, e o servidor web serve a pasta antes de o
// pedido chegar ao Laravel — /stories dava 404. O resto (/stories/{slug},
// /stories/create) não colide, porque não há pastas com esses nomes.
Route::get('/noticias', [StoryController::class, 'index'])->name('stories.index');
Route::get('/parceiros', [PartnerController::class, 'index'])->name('partners.index');
Route::redirect('/partners', '/parceiros', 301);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
])->group(function () {
    Route::get('/stories/create', [StoryController::class, 'create'])->name('stories.create');
    Route::post('/stories', [StoryController::class, 'store']);
    Route::get('/stories/{story:slug}/edit', [StoryController::class, 'edit'])->name('stories.edit');
    Route::patch('/stories/{story:slug}', [StoryController::class, 'update']);
    Route::delete('/stories/{story:slug}', [StoryController::class, 'destroy']);

});

// Acrescentar parceiros passou para o painel de /admin/parceiros. A morada
// antiga abre-o directamente, para os links que ainda apontam para cá.
Route::redirect('/partners/create', '/admin/parceiros?novo=1')->name('partners.create');

// Declarada depois do /stories/create: o {story:slug} aceita qualquer
// segmento, e a primeira rota que casa é a que ganha.
Route::get('/stories/{story:slug}', [StoryController::class, 'show'])->name('stories.show');

Route::get('/campanha', [NeedController::class, 'index'])->name('needs.index');

Route::post('/language-switch', [LanguageController::class, 'switch'])->name('language.switch');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Volt::route('/dashboard', 'dashboard')->name('dashboard');

    // Encomendas da Loja Solidária, com os dados do formulário. Ver o Gate
    // 'admin' no AppServiceProvider e ADMIN_EMAILS no .env.
    Volt::route('/admin/pagamentos', 'admin.orders-index')
        ->middleware('can:admin')
        ->name('admin.orders');

    // Lista de todos os parceiros, para os mostrar ou esconder no site.
    Volt::route('/admin/parceiros', 'admin.partners-index')
        ->middleware('can:admin')
        ->name('admin.partners');
});

Route::get('/noticias/{year}/{month}/{title}', function ($year, $month, $title) {
    if (view()->exists("/stories/$year/$month/$title"))
        return view("/stories/$year/$month/$title");
    else
        abort(404);
});
