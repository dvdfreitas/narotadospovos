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

        $story = Story::create([
            'title' => 'Construir Pontes: A Jornada de Estudantes da Guiné-Bissau',
            'date' => '2024-12-25',
            'summary' => 'Aproveitando a interrupção letiva de Natal, quisemos conhecer a experiência destes jovens guineenses a estudar em Portugal. Entre desafios de adaptação, sonhos para o futuro e recordações de casa, partilharam connosco um pouco das suas histórias, refletindo sobre o significado de passarem esta época festiva longe das suas famílias.',
            'image' => '2024/12/natal_estudantes/todos_natal.jpg',
            'slug' => 'natal-estudantes',
            'url' => '2024/12/natal_estudantes',
        ]);

        $story = Story::create([
            'title' => 'Campanha de Recolha de Bens Essenciais',
            'date' => '2025-01-31',
            'summary' => 'A NRP está a organizar uma recolha de bens essenciais para enviar para Catió.',
            'image' => '2025/01/recolha.png',
            'slug' => 'recolha-janeiro-2025',
            'url' => 'campanha',
        ]);

    }
}
