<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Story;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('stories')->delete();

        $caminhada = Category::where('slug', 'caminhada')->first();
        $mercados = Category::where('slug', 'mercados')->first();
        $viagens = Category::where('slug', 'viagens')->first();
        $tito = Category::where('slug', 'tito')->first();

        $story = Story::create([
            'title' => 'Caminhada com a Rota',
            'date' => '2024-10-06',
            'summary' => 'No próximo dia 20 de outubro pelas 9h vem participar numa caminhada solidária, com o objetivo de angariar fundos para a nova "Casa da Mamé".',
            'image' => '2024/10/caminhada.jpg',
            'slug' => '2024/10/caminhada-com-a-rota',
            'url' => '2024/10/caminhada_com_a_rota',
        ]);

        $story->categories()->attach($caminhada);

        $story = Story::create([
            'title' => 'Mercado para Catió',
            'date' => '2024-11-08',
            'summary' => 'Nos próximos dias 16 e 17 de novembro, entre as 11h e as 18h realizar-se-á o Mercado para Catió, com o objectivo de angariar fundos para a nova "Casa da Mamé".',
            'image' => '2024/11/mercado.jpg',
            'slug' => 'mercado-para-catio',
            'url' => '2024/11/mercado',
        ]);

        $story->categories()->attach($mercados);

        $story = Story::create([
            'title' => 'Mercado para Catió 2',
            'subtitle' => 'Nova data',
            'date' => '2024-11-25',
            'summary' => 'Depois do grande sucesso que foi o mercado dos dias 16 e 17 de novembro, a feirinha de natal será realizad.',
            'image' => '2024/11/mercado2.jpg',
            'slug' => 'mercado-para-catio-2',
            'url' => '2024/11/mercado2',
        ]);

        $story->categories()->attach($mercados);

        $story = Story::create([
            'title' => 'Irão 1998',
            'date' => '2024-11-25',
            'summary' => 'Relato da viagem ao Irão em 1998 realizada por dois fundadores da "Rota", Tito Baião e João Pedro Pereira.',
            'image' => '2024/11/irao1998.jpg',
            'slug' => 'irao1998',
            'url' => '2024/11/irao1998',
        ]);

        $story->categories()->attach($viagens);
        $story->categories()->attach($tito);

    }
}
