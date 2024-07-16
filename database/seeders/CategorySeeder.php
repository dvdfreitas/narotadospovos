<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            'slug' => 'casa-de-Acolhimento',
            'name' => 'Casa de Acolhimento',
            'description' => 'Acolher crianças orfão de mãe no parte...',
        ]);

        DB::table('categories')->insert([
            'slug' => 'educacao',
            'name' => 'Educação',
            'description' => 'Apoiar as escolas com materiais escolares...',
        ]);

        DB::table('categories')->insert([
            'slug' => 'saude',
            'name' => 'Saúde',
            'description' => 'Damos apoio a hospital Musna Sambu, com intuito de melhor as condições...',
        ]);
    }
}
