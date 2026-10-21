<?php

use App\Models\Partner;
use App\Models\Story;
use Illuminate\Support\Str;

it('abre a página das histórias em /noticias', function () {
    Story::forceCreate(['title' => 'Primeira', 'summary' => 'Resumo A', 'slug' => 'primeira', 'date' => '2026-01-01']);
    Story::forceCreate(['title' => 'Segunda', 'summary' => 'Resumo B', 'slug' => 'segunda', 'date' => '2026-01-02']);

    $this->get(route('stories.index'))
        ->assertOk()
        ->assertSee('Primeira')
        ->assertSee('Segunda');

    // public/stories é a pasta das imagens: o índice não pode viver lá.
    expect(route('stories.index', absolute: false))->toBe('/noticias');
});

it('abre a página das histórias sem histórias', function () {
    $this->get(route('stories.index'))
        ->assertOk()
        ->assertSee('Ainda não há histórias publicadas.');
});

function noticia(string $title, string $date, array $attributes = []): Story
{
    return Story::forceCreate([
        'title' => $title, 'summary' => "Resumo de {$title}", 'slug' => Str::slug($title),
        'date' => $date, 'url' => Str::slug($title), ...$attributes,
    ]);
}

it('põe a mais recente e a marcada em destaque no topo, sem as repetir na lista', function () {
    noticia('Antiga', '2024-01-01');
    noticia('Marcada', '2024-06-01', ['is_featured' => true]);
    noticia('Do meio', '2025-01-01');
    noticia('Recente', '2026-01-01');

    $response = $this->get('/noticias')->assertOk();

    expect($response->viewData('latest')->title)->toBe('Recente')
        ->and($response->viewData('featured')->title)->toBe('Marcada')
        ->and($response->viewData('stories')->pluck('title')->all())->toBe(['Do meio', 'Antiga']);

    $response->assertSee('Mais recente')->assertSee('Em destaque');
});

it('sem nenhuma marcada, põe a segunda mais recente ao lado, sem o rótulo', function () {
    noticia('Antiga', '2024-01-01');
    noticia('Recente', '2026-01-01');

    $this->get('/noticias')
        ->assertViewHas('featured', fn ($story) => $story->title === 'Antiga')
        ->assertDontSee('Em destaque');
});

it('filtra por ano, sem topo', function () {
    noticia('De 2024', '2024-05-01');
    noticia('De 2025', '2025-05-01');
    noticia('Outra de 2025', '2025-07-01');

    $this->get('/noticias?ano=2025')
        ->assertOk()
        ->assertViewHas('latest', null)
        ->assertViewHas('stories', fn ($stories) => $stories->pluck('title')->all() === ['Outra de 2025', 'De 2025'])
        ->assertSee('Notícias de 2025');
});

it('ignora um ano sem notícias', function () {
    noticia('De 2024', '2024-05-01');

    $this->get('/noticias?ano=1999')->assertOk()->assertViewHas('year', null);
});

it('não mostra notícias escondidas', function () {
    noticia('Visível', '2025-01-01');
    noticia('Escondida', '2026-01-01', ['visible' => false]);

    $this->get('/noticias')->assertSee('Visível')->assertDontSee('Escondida');
});

it('mostra cada parceiro visível', function () {
    Partner::forceCreate(['name' => 'Parceiro Visível', 'logo' => 'a.png', 'visible' => true]);
    Partner::forceCreate(['name' => 'Parceiro Escondido', 'logo' => 'b.png', 'visible' => false]);

    $this->get(route('partners.index'))
        ->assertOk()
        ->assertSee('Parceiro Visível')
        ->assertDontSee('Parceiro Escondido');
});

it('abre a página dos parceiros sem parceiros', function () {
    $this->get(route('partners.index'))
        ->assertOk()
        ->assertSee('Ainda não há parceiros para mostrar.');
});

it('as últimas notícias da página inicial levam a todas as notícias', function () {
    $this->withSession(['language' => 'pt'])
        ->blade('<x-stories />')
        ->assertSee('Todas as notícias')
        ->assertSee(route('stories.index'));
});

it('a morada antiga /partners leva a /parceiros', function () {
    $this->get('/partners')->assertRedirect('/parceiros')->assertStatus(301);
});

it('mostra todos os parceiros visíveis numa só página, com o nome e o link do site', function () {
    foreach (range(1, 20) as $n) {
        Partner::forceCreate(['name' => "Parceiro {$n}", 'logo' => "{$n}.png", 'visible' => true]);
    }
    Partner::forceCreate(['name' => 'Com Site', 'logo' => 'c.png', 'visible' => true, 'website' => 'https://com-site.pt']);

    $this->get('/parceiros')
        ->assertOk()
        ->assertSee('21 parceiros')
        ->assertSee('Parceiro 20')
        ->assertSee('href="https://com-site.pt"', false);
});

it('a página inicial mostra uma amostra de 12 visíveis e o link para todos', function () {
    foreach (range(1, 20) as $n) {
        Partner::forceCreate(['name' => "Parceiro {$n}", 'logo' => "{$n}.png", 'visible' => true]);
    }
    Partner::forceCreate(['name' => 'Escondido', 'logo' => 'e.png', 'visible' => false]);

    $view = $this->withSession(['language' => 'pt'])->blade('<x-partners />');

    $view->assertSee('Todos os parceiros')
        ->assertDontSee('Todos os parceiros (20)')
        ->assertSee('Se queres ir rápido, vai sozinho')
        ->assertSee('Se queres ir longe, vai acompanhado.')
        ->assertSee('Provérbio Africano')
        ->assertSee('a cada visita mostramos outros')
        ->assertSee(route('partners.index'))
        ->assertDontSee('Escondido');

    expect(substr_count((string) $view, 'title="Parceiro '))->toBe(12);
});

it('sem mais parceiros do que a amostra, não diz que há outros', function () {
    Partner::forceCreate(['name' => 'Único', 'logo' => 'u.png', 'visible' => true]);

    $this->withSession(['language' => 'pt'])->blade('<x-partners />')
        ->assertSee('Todos os parceiros')
        ->assertDontSee('Todos os parceiros (1)')
        ->assertDontSee('a cada visita');
});
