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
        DB::table('categories')->delete();

        DB::table('categories')->insert([
            'name' => 'Caminhada',
            'slug' => 'caminhada',
            'description' => 'Caminhadas e passeios pedestres.',
        ]);

        DB::table('categories')->insert([
            'name' => 'Mercados',
            'slug' => 'mercados',
            'description' => 'Mercados e feiras.',
        ]);

        DB::table('categories')->insert([
            'name' => 'Viagens',
            'slug' => 'viagens',
            'description' => 'Viagens.',
        ]);

        DB::table('categories')->insert([
            'name' => 'Tito Baião',
            'slug' => 'tito',
            'description' => 'Relatos das viagens do Tito Baião.',
        ]);
    }
}
