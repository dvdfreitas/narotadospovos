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
        $mercado = Category::where('slug', 'mercado')->first();

        $story = Story::create([
            'title' => 'Caminhada com a Rota',
            'date' => '2024-10-06',
            'summary' => 'No próximo dia 20 de outubro pelas 9h vem participar numa caminhada solidária, com o objetivo de angariar fundos para a nova "Casa da Mamé".',
            'image' => '2024/10/caminhada.jpg',
            'slug' => '2024/10/caminhada-com-a-rota',
            'www' => '/stories/2024/10/caminhada_com_a_rota',
        ]);

        $story->categories()->attach($caminhada);

        $story = Story::create([
            'title' => 'Mercado para Catió',
            'date' => '2024-11-08',
            'summary' => 'Nos próximos dias 16 e 17 de novembro, entre as 11h e as 18h realizar-se-á o Mercado para Catió, com o objectivo de angariar fundos para a nova "Casa da Mamé".',
            'image' => '2024/11/mercado.jpg',
            'slug' => '2024/11/mercado-para-catio',
            'www' => '/stories/2024/11/mercado_para_catio',
        ]);

        $story->categories()->attach($mercado);

    }
}
