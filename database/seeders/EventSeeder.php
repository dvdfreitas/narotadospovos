<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // delete e não truncate: a chave estrangeira de event_dates aponta
        // para esta tabela, e o cascade leva os dias atrás de cada evento.
        Event::query()->delete();

        $volunteers = Event::create([
            'name' => 'Dia do Voluntário',
            'slug' => 'dia-do-voluntario-2026',
        ]);

        $volunteers->dates()->create(['date' => '2026-10-31']);

        // Coloca um magusto no dia 8 de novembro
        $magusto = Event::create([
            'name' => 'Magusto',
            'slug' => 'magusto-2026',
        ]);

        $magusto->dates()->create(['date' => '2026-11-08']);

        // A feirinha abre no sábado e no domingo, salta a segunda-feira
        // e volta no feriado de terça.
        $fair = Event::create([
            'name' => 'Feirinha de Natal',
            'slug' => 'feirinha-de-natal-2026',
        ]);

        foreach (['2026-12-05', '2026-12-06', '2026-12-08'] as $date) {
            $fair->dates()->create(['date' => $date]);
        }
    }
}
