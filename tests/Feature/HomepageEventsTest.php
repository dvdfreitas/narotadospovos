<?php

use App\Models\Event;
use App\Models\User;

it('mostra os próximos eventos na homepage com e sem sessão', function (bool $authenticated) {
    $this->travelTo(now()->setDate(2026, 10, 21)->startOfDay());

    foreach (['Dia do Voluntário' => '2026-10-31', 'Magusto' => '2026-11-08'] as $name => $date) {
        $event = Event::create(['name' => $name, 'slug' => str($name)->slug()]);
        $event->dates()->create(['date' => $date]);
    }

    if ($authenticated) {
        $this->actingAs(User::factory()->create());
    }

    $this->get('/')
        ->assertOk()
        ->assertSee('Próximo evento')
        ->assertSee('Dia do Voluntário')
        ->assertSee('Magusto')
        ->assertSee('Evento seguinte')
        ->assertSee('Faltam 10 dias');
})->with([false, true]);
