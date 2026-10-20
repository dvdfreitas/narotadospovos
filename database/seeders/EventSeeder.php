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
        Event::truncate();

        Event::create([
            'name' => 'Dia do Voluntário',
            'slug' => 'dia-do-voluntario-2026',
            'starts_at' => '2026-10-31',
        ]);

        // Coloca um magusto no dia 8 de novembro
        Event::create([
            'name' => 'Magusto',
            'slug' => 'magusto-2026',
            'starts_at' => '2026-11-08',
        ]);
    }
}
