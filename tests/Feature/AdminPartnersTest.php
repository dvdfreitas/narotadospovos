<?php

use App\Models\Partner;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Volt\Volt;

beforeEach(function () {
    config(['app.admin_emails' => ['admin@exemplo.pt']]);
});

function parceiro(string $name, bool $visible = true): Partner
{
    return Partner::forceCreate(['name' => $name, 'logo' => 'x.png', 'visible' => $visible]);
}

function admin(): User
{
    return User::factory()->create(['email' => 'admin@exemplo.pt']);
}

it('manda quem não tem sessão para o login', function () {
    $this->get('/admin/parceiros')->assertRedirect('/login');
});

it('recusa contas que não são de administrador', function () {
    $this->actingAs(User::factory()->create(['email' => 'outro@exemplo.pt']))
        ->get('/admin/parceiros')
        ->assertForbidden();
});

it('lista todos os parceiros, visíveis e escondidos', function () {
    parceiro('Parceiro Visível');
    parceiro('Parceiro Escondido', visible: false);

    $this->actingAs(admin())
        ->get('/admin/parceiros')
        ->assertOk()
        ->assertSee('Parceiro Visível')
        ->assertSee('Parceiro Escondido')
        ->assertSee('1 de 2 visíveis');
});

it('esconde e volta a mostrar', function () {
    $partner = parceiro('Curtes');

    $this->actingAs(admin());

    Volt::test('admin.partners-index')->call('toggle', $partner->id);
    expect($partner->refresh()->visible)->toBeFalse();

    Volt::test('admin.partners-index')->call('toggle', $partner->id);
    expect($partner->refresh()->visible)->toBeTrue();
});

it('não deixa quem não é administrador mudar a visibilidade', function () {
    $partner = parceiro('Curtes');

    $this->actingAs(User::factory()->create(['email' => 'outro@exemplo.pt']));

    Volt::test('admin.partners-index')->call('toggle', $partner->id)->assertForbidden();
    expect($partner->refresh()->visible)->toBeTrue();
});

it('filtra os escondidos', function () {
    parceiro('Parceiro Visível');
    parceiro('Parceiro Escondido', visible: false);

    $this->actingAs(admin());

    Volt::test('admin.partners-index')
        ->set('filter', 'hidden')
        ->assertSee('Parceiro Escondido')
        ->assertDontSee('Parceiro Visível');
});

it('um parceiro escondido sai da página inicial', function () {
    parceiro('Parceiro Visível');
    parceiro('Parceiro Escondido', visible: false);

    $this->blade('<x-partners />')
        ->assertSee('Parceiro Visível')
        ->assertDontSee('Parceiro Escondido');
});

it('a morada antiga de acrescentar abre o painel', function () {
    $this->get('/partners/create')->assertRedirect('/admin/parceiros?novo=1');

    $this->actingAs(admin())
        ->get('/admin/parceiros?novo=1')
        ->assertOk()
        ->assertSee('Acrescentar parceiro')
        ->assertSee('Mostrar no site');
});

it('acrescenta um parceiro com logótipo', function () {
    Storage::fake('partners');
    $this->actingAs(admin());

    Volt::test('admin.partners-index')
        ->call('create')
        ->set('name', 'Padaria Nova')
        ->set('website', 'https://padaria.pt')
        ->set('logo', UploadedFile::fake()->image('logo.png', 300, 200))
        ->call('save')
        ->assertHasNoErrors()
        ->assertSet('showForm', false);

    $partner = Partner::firstWhere('name', 'Padaria Nova');

    expect($partner->visible)->toBeTrue()
        ->and($partner->slug)->toBe('padaria-nova')
        ->and($partner->website)->toBe('https://padaria.pt')
        ->and($partner->facebook)->toBeNull()
        ->and($partner->logo)->toEndWith('-padaria-nova.png');

    Storage::disk('partners')->assertExists($partner->logo);
});

it('pede o logótipo e recusa nomes repetidos ao acrescentar', function () {
    parceiro('Curtes');
    $this->actingAs(admin());

    Volt::test('admin.partners-index')
        ->call('create')
        ->set('name', 'Curtes')
        ->call('save')
        ->assertHasErrors(['name' => 'unique', 'logo' => 'required']);
});

it('recusa SVG', function () {
    Storage::fake('partners');
    $this->actingAs(admin());

    Volt::test('admin.partners-index')
        ->call('create')
        ->set('name', 'Com SVG')
        ->set('logo', UploadedFile::fake()->create('logo.svg', 10, 'image/svg+xml'))
        ->call('save')
        ->assertHasErrors('logo');
});

it('edita sem obrigar a trocar o logótipo', function () {
    $partner = parceiro('Curtes');
    $this->actingAs(admin());

    Volt::test('admin.partners-index')
        ->call('edit', $partner->id)
        ->assertSet('name', 'Curtes')
        ->set('name', 'Curtes Lda')
        ->set('visible', false)
        ->call('save')
        ->assertHasNoErrors();

    $partner->refresh();
    expect($partner->name)->toBe('Curtes Lda')
        ->and($partner->visible)->toBeFalse()
        ->and($partner->logo)->toBe('x.png');
});

it('não deixa quem não é administrador gravar', function () {
    $this->actingAs(User::factory()->create(['email' => 'outro@exemplo.pt']));

    Volt::test('admin.partners-index')
        ->set('name', 'Intruso')
        ->call('save')
        ->assertForbidden();

    expect(Partner::where('name', 'Intruso')->exists())->toBeFalse();
});
